<?php

namespace App\Http\Controllers;

use App\Models\OrdenTrabajo;
use App\Models\Cliente;
use App\Models\Cotizacion;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class OrdenTrabajoController extends Controller
{
    public function __construct()
    {
        // No se necesita middleware aquí, se maneja en las rutas
    }

    public function index(Request $request)
    {
        $query = OrdenTrabajo::with(['cliente', 'cotizacion', 'user']);

        // Búsqueda
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('numero_ot', 'like', "%{$search}%")
                  ->orWhere('descripcion', 'like', "%{$search}%")
                  ->orWhereHas('cliente', function($subQ) use ($search) {
                      $subQ->where('contacto_nombre', 'like', "%{$search}%")
                           ->orWhere('nombre_empresa', 'like', "%{$search}%");
                  });
            });
        }

        // Filtros
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('prioridad')) {
            $query->where('prioridad', $request->prioridad);
        }

        if ($request->filled('cliente_id')) {
            $query->where('cliente_id', $request->cliente_id);
        }

        if ($request->filled('fecha_inicio')) {
            $query->whereDate('fecha_inicio', '>=', $request->fecha_inicio);
        }

        if ($request->filled('fecha_fin')) {
            $query->whereDate('fecha_fin_estimada', '<=', $request->fecha_fin);
        }

        // Ordenamiento
        $orden = $request->input('orden', 'desc');
        $campo = $request->input('campo', 'created_at');
        $query->orderBy($campo, $orden);

        $ordenesTrabajo = $query->paginate(15);

        // Estadísticas
        $stats = [
            'total' => OrdenTrabajo::count(),
            'pendientes' => OrdenTrabajo::where('estado', 'pendiente')->count(),
            'en_progreso' => OrdenTrabajo::where('estado', 'en_progreso')->count(),
            'completadas' => OrdenTrabajo::where('estado', 'completada')->count(),
            'atrasadas' => OrdenTrabajo::where('estado', 'en_progreso')
                ->where('fecha_fin_estimada', '<', now())->count(),
        ];

        // Datos para filtros
        $clientes = Cliente::orderBy('contacto_nombre')->get();
        $estados = OrdenTrabajo::ESTADOS;
        $prioridades = OrdenTrabajo::PRIORIDADES;

        return view('ordenes-trabajo.index', compact(
            'ordenesTrabajo',
            'stats',
            'clientes',
            'estados',
            'prioridades'
        ));
    }

    public function create()
    {
        $clientes = Cliente::orderBy('contacto_nombre')->get();
        $cotizaciones = Cotizacion::where('estado', 'aceptada')
            ->orWhere('estado', 'pendiente')
            ->orderBy('created_at', 'desc')
            ->get();
        $usuarios = User::orderBy('name')->get();
        $estados = OrdenTrabajo::ESTADOS;
        $prioridades = OrdenTrabajo::PRIORIDADES;

        // Generar número de OT automático
        $ultimoNumero = OrdenTrabajo::max('numero_ot');
        $nuevoNumero = 'OT-' . str_pad((intval(substr($ultimoNumero, 3)) + 1), 4, '0', STR_PAD_LEFT);

        return view('ordenes-trabajo.create', compact(
            'clientes',
            'cotizaciones',
            'usuarios',
            'estados',
            'prioridades',
            'nuevoNumero'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'numero_ot' => 'required|string|max:20|unique:ordenes_trabajo,numero_ot',
            'cliente_id' => 'required|exists:clientes,id',
            'cotizacion_id' => 'nullable|exists:cotizaciones,id',
            'user_id' => 'required|exists:users,id',
            'descripcion' => 'required|string|max:1000',
            'fecha_inicio' => 'required|date',
            'fecha_fin_estimada' => 'required|date|after_or_equal:fecha_inicio',
            'prioridad' => 'required|in:' . implode(',', array_keys(OrdenTrabajo::PRIORIDADES)),
            'estado' => 'required|in:' . implode(',', array_keys(OrdenTrabajo::ESTADOS)),
            'notas' => 'nullable|string|max:2000',
            'costo_estimado' => 'nullable|numeric|min:0|max:99999999.99',
        ]);

        $ordenTrabajo = OrdenTrabajo::create($request->all());

        return redirect()
            ->route('ordenes-trabajo.show', $ordenTrabajo)
            ->with('success', 'Orden de trabajo creada correctamente.');
    }

    public function show(OrdenTrabajo $ordenTrabajo)
    {
        $ordenTrabajo->load([
            'cliente',
            'cotizacion',
            'user',
            'facturas',
            'entregas'
        ]);

        // Timeline de estados
        $timeline = [
            ['estado' => 'pendiente', 'fecha' => $ordenTrabajo->created_at, 'activo' => $ordenTrabajo->estado === 'pendiente'],
            ['estado' => 'en_progreso', 'fecha' => $ordenTrabajo->fecha_inicio, 'activo' => $ordenTrabajo->estado === 'en_progreso'],
            ['estado' => 'completada', 'fecha' => $ordenTrabajo->fecha_fin_real, 'activo' => $ordenTrabajo->estado === 'completada'],
        ];

        return view('ordenes-trabajo.show', compact('ordenTrabajo', 'timeline'));
    }

    public function edit(OrdenTrabajo $ordenTrabajo)
    {
        $clientes = Cliente::orderBy('contacto_nombre')->get();
        $cotizaciones = Cotizacion::orderBy('created_at', 'desc')->get();
        $usuarios = User::orderBy('name')->get();
        $estados = OrdenTrabajo::ESTADOS;
        $prioridades = OrdenTrabajo::PRIORIDADES;

        return view('ordenes-trabajo.edit', compact(
            'ordenTrabajo',
            'clientes',
            'cotizaciones',
            'usuarios',
            'estados',
            'prioridades'
        ));
    }

    public function update(Request $request, OrdenTrabajo $ordenTrabajo)
    {
        $request->validate([
            'numero_ot' => 'required|string|max:20|unique:ordenes_trabajo,numero_ot,' . $ordenTrabajo->id,
            'cliente_id' => 'required|exists:clientes,id',
            'cotizacion_id' => 'nullable|exists:cotizaciones,id',
            'user_id' => 'required|exists:users,id',
            'descripcion' => 'required|string|max:1000',
            'fecha_inicio' => 'required|date',
            'fecha_fin_estimada' => 'required|date|after_or_equal:fecha_inicio',
            'fecha_fin_real' => 'nullable|date',
            'prioridad' => 'required|in:' . implode(',', array_keys(OrdenTrabajo::PRIORIDADES)),
            'estado' => 'required|in:' . implode(',', array_keys(OrdenTrabajo::ESTADOS)),
            'notas' => 'nullable|string|max:2000',
            'costo_estimado' => 'nullable|numeric|min:0|max:99999999.99',
            'costo_real' => 'nullable|numeric|min:0|max:99999999.99',
        ]);

        // Si se cambia a completada, establecer fecha fin real
        if ($request->estado === 'completada' && !$ordenTrabajo->fecha_fin_real) {
            $request->merge(['fecha_fin_real' => now()]);
        }

        $ordenTrabajo->update($request->all());

        return redirect()
            ->route('ordenes-trabajo.show', $ordenTrabajo)
            ->with('success', 'Orden de trabajo actualizada correctamente.');
    }

    public function destroy(OrdenTrabajo $ordenTrabajo)
    {
        // Verificar si tiene facturas o entregas relacionadas
        if ($ordenTrabajo->facturas()->count() > 0) {
            return redirect()
                ->route('ordenes-trabajo.show', $ordenTrabajo)
                ->with('error', 'No se puede eliminar la orden de trabajo porque tiene facturas asociadas.');
        }

        if ($ordenTrabajo->entregas()->count() > 0) {
            return redirect()
                ->route('ordenes-trabajo.show', $ordenTrabajo)
                ->with('error', 'No se puede eliminar la orden de trabajo porque tiene entregas asociadas.');
        }

        $ordenTrabajo->delete();

        return redirect()
            ->route('ordenes-trabajo.index')
            ->with('success', 'Orden de trabajo eliminada correctamente.');
    }

    // Métodos adicionales

    public function cambiarEstado(Request $request, OrdenTrabajo $ordenTrabajo)
    {
        $request->validate([
            'estado' => 'required|in:' . implode(',', array_keys(OrdenTrabajo::ESTADOS)),
            'notas' => 'nullable|string|max:2000',
        ]);

        $estadoAnterior = $ordenTrabajo->estado;
        $ordenTrabajo->estado = $request->estado;

        // Si se cambia a completada, establecer fecha fin real
        if ($request->estado === 'completada' && !$ordenTrabajo->fecha_fin_real) {
            $ordenTrabajo->fecha_fin_real = now();
        }

        // Si se cambia de completada a otro estado, limpiar fecha fin real
        if ($estadoAnterior === 'completada' && $request->estado !== 'completada') {
            $ordenTrabajo->fecha_fin_real = null;
        }

        // Agregar notas si se proporcionaron
        if ($request->filled('notas')) {
            $notasExistentes = $ordenTrabajo->notas ? $ordenTrabajo->notas . "\n\n" : '';
            $ordenTrabajo->notas = $notasExistentes . "[" . now()->format('d/m/Y H:i') . "] Cambio de estado: " .
                OrdenTrabajo::ESTADOS[$estadoAnterior] . " → " .
                OrdenTrabajo::ESTADOS[$request->estado] . "\n" .
                $request->notas;
        }

        $ordenTrabajo->save();

        return redirect()
            ->route('ordenes-trabajo.show', $ordenTrabajo)
            ->with('success', 'Estado de la orden de trabajo actualizado correctamente.');
    }

    public function dashboard()
    {
        $estadisticas = [
            'total' => OrdenTrabajo::count(),
            'pendientes' => OrdenTrabajo::where('estado', 'pendiente')->count(),
            'en_progreso' => OrdenTrabajo::where('estado', 'en_progreso')->count(),
            'completadas' => OrdenTrabajo::where('estado', 'completada')->count(),
            'atrasadas' => OrdenTrabajo::where('estado', 'en_progreso')
                ->where('fecha_fin_estimada', '<', now())->count(),
        ];

        $ordenesRecientes = OrdenTrabajo::with(['cliente', 'user'])
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();

        $ordenesCriticas = OrdenTrabajo::with(['cliente', 'user'])
            ->where('prioridad', 'urgente')
            ->where('estado', '!=', 'completada')
            ->orderBy('fecha_fin_estimada', 'asc')
            ->limit(5)
            ->get();

        $ordenesAtrasadas = OrdenTrabajo::with(['cliente', 'user'])
            ->where('estado', 'en_progreso')
            ->where('fecha_fin_estimada', '<', now())
            ->orderBy('fecha_fin_estimada', 'asc')
            ->limit(5)
            ->get();

        return view('ordenes-trabajo.dashboard', compact(
            'estadisticas',
            'ordenesRecientes',
            'ordenesCriticas',
            'ordenesAtrasadas'
        ));
    }
}