<?php

namespace App\Http\Controllers;

use App\Models\Entrega;
use App\Models\OrdenTrabajo;
use App\Models\Cliente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class EntregaController extends Controller
{
    public function __construct()
    {
        // No se necesita middleware aquí, se maneja en las rutas
    }

    public function index(Request $request)
    {
        $query = Entrega::with(['ordenTrabajo', 'cliente', 'user']);

        // Búsqueda
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('numero_entrega', 'like', "%{$search}%")
                  ->orWhere('nombre_receptor', 'like', "%{$search}%")
                  ->orWhere('observaciones', 'like', "%{$search}%")
                  ->orWhereHas('ordenTrabajo', function($subQ) use ($search) {
                      $subQ->where('numero_ot', 'like', "%{$search}%");
                  })
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

        if ($request->filled('metodo_entrega')) {
            $query->where('metodo_entrega', $request->metodo_entrega);
        }

        if ($request->filled('tipo_entrega')) {
            $query->where('tipo_entrega', $request->tipo_entrega);
        }

        if ($request->filled('orden_trabajo_id')) {
            $query->where('orden_trabajo_id', $request->orden_trabajo_id);
        }

        if ($request->filled('cliente_id')) {
            $query->where('cliente_id', $request->cliente_id);
        }

        if ($request->filled('fecha_desde')) {
            $query->whereDate('fecha_entrega', '>=', $request->fecha_desde);
        }

        if ($request->filled('fecha_hasta')) {
            $query->whereDate('fecha_entrega', '<=', $request->fecha_hasta);
        }

        // Ordenamiento
        $orden = $request->input('orden', 'desc');
        $campo = $request->input('campo', 'created_at');
        $query->orderBy($campo, $orden);

        $entregas = $query->paginate(15);

        // Estadísticas
        $stats = [
            'total' => Entrega::count(),
            'pendientes' => Entrega::where('estado', 'pendiente')->count(),
            'en_camino' => Entrega::where('estado', 'en_camino')->count(),
            'entregadas' => Entrega::where('estado', 'entregado')->count(),
            'vencidas' => Entrega::where('estado', '!=', 'entregado')
                ->where('estado', '!=', 'cancelado')
                ->where('fecha_entrega', '<', now())->count(),
        ];

        // Datos para filtros
        $clientes = Cliente::orderBy('contacto_nombre')->get();
        $ordenesTrabajo = OrdenTrabajo::orderBy('numero_ot')->get();
        $estados = Entrega::ESTADOS;
        $metodosEntrega = Entrega::METODOS_ENTREGA;
        $tiposEntrega = Entrega::TIPOS_ENTREGA;

        return view('entregas.index', compact(
            'entregas',
            'stats',
            'clientes',
            'ordenesTrabajo',
            'estados',
            'metodosEntrega',
            'tiposEntrega'
        ));
    }

    public function create()
    {
        $ordenesTrabajo = OrdenTrabajo::with('cliente')->orderBy('numero_ot')->get();
        $clientes = Cliente::orderBy('contacto_nombre')->get();
        $usuarios = User::orderBy('name')->get();
        $estados = Entrega::ESTADOS;
        $metodosEntrega = Entrega::METODOS_ENTREGA;
        $tiposEntrega = Entrega::TIPOS_ENTREGA;

        // Generar número de entrega automático
        $ultimoNumero = Entrega::max('numero_entrega');
        if ($ultimoNumero) {
            $num = intval(substr($ultimoNumero, 4)) + 1;
        } else {
            $num = 1;
        }
        $nuevoNumero = 'ENT-' . str_pad($num, 5, '0', STR_PAD_LEFT);

        return view('entregas.create', compact(
            'ordenesTrabajo',
            'clientes',
            'usuarios',
            'estados',
            'metodosEntrega',
            'tiposEntrega',
            'nuevoNumero'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'numero_entrega' => 'required|string|max:20|unique:entregas,numero_entrega',
            'orden_trabajo_id' => 'nullable|exists:\App\Models\OrdenTrabajo,id',
            'cliente_id' => 'nullable|exists:clientes,id',
            'user_id' => 'nullable|exists:users,id',
            'fecha_entrega' => 'required|date',
            'nombre_receptor' => 'required|string|max:255',
            'documento_receptor' => 'nullable|string|max:50',
            'direccion_entrega' => 'nullable|string|max:500',
            'telefono_receptor' => 'nullable|string|max:20',
            'estado' => 'required|in:' . implode(',', array_keys(Entrega::ESTADOS)),
            'observaciones' => 'nullable|string|max:2000',
            'evidencia_foto' => 'nullable|array',
            'evidencia_foto.*' => 'image|mimes:jpeg,png,jpg,gif|max:5120',
            'tipo_entrega' => 'required|in:' . implode(',', array_keys(Entrega::TIPOS_ENTREGA)),
            'metodo_entrega' => 'required|in:' . implode(',', array_keys(Entrega::METODOS_ENTREGA)),
            'notas_internas' => 'nullable|string|max:2000',
        ]);

        $data = $request->except(['evidencia_foto']);

        // Procesar fotos de evidencia
        if ($request->hasFile('evidencia_foto')) {
            $fotos = [];
            foreach ($request->file('evidencia_foto') as $foto) {
                $path = $foto->store('evidencias/entregas', 'public');
                $fotos[] = [
                    'path' => $path,
                    'url' => Storage::url($path),
                    'name' => $foto->getClientOriginalName(),
                    'size' => $foto->getSize(),
                    'uploaded_at' => now()->toISOString()
                ];
            }
            $data['evidencia_foto'] = $fotos;
        }

        // Si no se especifica cliente, tomarlo de la orden de trabajo
        if (!$data['cliente_id'] && $data['orden_trabajo_id']) {
            $ordenTrabajo = OrdenTrabajo::find($data['orden_trabajo_id']);
            if ($ordenTrabajo) {
                $data['cliente_id'] = $ordenTrabajo->cliente_id;
            }
        }

        $entrega = Entrega::create($data);

        return redirect()
            ->route('entregas.show', $entrega)
            ->with('success', 'Entrega creada correctamente.');
    }

    public function show(Entrega $entrega)
    {
        $entrega->load([
            'ordenTrabajo',
            'cliente',
            'user'
        ]);

        // Timeline de estados
        $timeline = [
            ['estado' => 'pendiente', 'fecha' => $entrega->created_at, 'activo' => $entrega->estado === 'pendiente'],
            ['estado' => 'en_camino', 'fecha' => $entrega->updated_at, 'activo' => $entrega->estado === 'en_camino'],
            ['estado' => 'entregado', 'fecha' => $entrega->updated_at, 'activo' => $entrega->estado === 'entregado'],
        ];

        return view('entregas.show', compact('entrega', 'timeline'));
    }

    public function edit(Entrega $entrega)
    {
        $ordenesTrabajo = OrdenTrabajo::with('cliente')->orderBy('numero_ot')->get();
        $clientes = Cliente::orderBy('contacto_nombre')->get();
        $usuarios = User::orderBy('name')->get();
        $estados = Entrega::ESTADOS;
        $metodosEntrega = Entrega::METODOS_ENTREGA;
        $tiposEntrega = Entrega::TIPOS_ENTREGA;

        return view('entregas.edit', compact(
            'entrega',
            'ordenesTrabajo',
            'clientes',
            'usuarios',
            'estados',
            'metodosEntrega',
            'tiposEntrega'
        ));
    }

    public function update(Request $request, Entrega $entrega)
    {
        $request->validate([
            'numero_entrega' => 'required|string|max:20|unique:entregas,numero_entrega,' . $entrega->id,
            'orden_trabajo_id' => 'nullable|exists:\App\Models\OrdenTrabajo,id',
            'cliente_id' => 'nullable|exists:clientes,id',
            'user_id' => 'nullable|exists:users,id',
            'fecha_entrega' => 'required|date',
            'nombre_receptor' => 'required|string|max:255',
            'documento_receptor' => 'nullable|string|max:50',
            'direccion_entrega' => 'nullable|string|max:500',
            'telefono_receptor' => 'nullable|string|max:20',
            'estado' => 'required|in:' . implode(',', array_keys(Entrega::ESTADOS)),
            'observaciones' => 'nullable|string|max:2000',
            'tipo_entrega' => 'required|in:' . implode(',', array_keys(Entrega::TIPOS_ENTREGA)),
            'metodo_entrega' => 'required|in:' . implode(',', array_keys(Entrega::METODOS_ENTREGA)),
            'notas_internas' => 'nullable|string|max:2000',
        ]);

        $data = $request->all();

        // Procesar nuevas fotos de evidencia
        if ($request->hasFile('evidencia_foto')) {
            $fotosExistentes = $entrega->evidencia_foto ?: [];
            $fotosNuevas = [];

            foreach ($request->file('evidencia_foto') as $foto) {
                $path = $foto->store('evidencias/entregas', 'public');
                $fotosNuevas[] = [
                    'path' => $path,
                    'url' => Storage::url($path),
                    'name' => $foto->getClientOriginalName(),
                    'size' => $foto->getSize(),
                    'uploaded_at' => now()->toISOString()
                ];
            }

            $data['evidencia_foto'] = array_merge($fotosExistentes, $fotosNuevas);
        }

        $entrega->update($data);

        return redirect()
            ->route('entregas.show', $entrega)
            ->with('success', 'Entrega actualizada correctamente.');
    }

    public function destroy(Entrega $entrega)
    {
        // Eliminar fotos de evidencia
        if ($entrega->evidencia_foto && is_array($entrega->evidencia_foto)) {
            foreach ($entrega->evidencia_foto as $foto) {
                if (isset($foto['path'])) {
                    Storage::disk('public')->delete($foto['path']);
                }
            }
        }

        $entrega->delete();

        return redirect()
            ->route('entregas.index')
            ->with('success', 'Entrega eliminada correctamente.');
    }

    // Métodos adicionales

    public function cambiarEstado(Request $request, Entrega $entrega)
    {
        $request->validate([
            'estado' => 'required|in:' . implode(',', array_keys(Entrega::ESTADOS)),
            'notas' => 'nullable|string|max:2000',
        ]);

        $estadoAnterior = $entrega->estado;
        $entrega->estado = $request->estado;

        // Agregar notas si se proporcionaron
        if ($request->filled('notas')) {
            $notasExistentes = $entrega->notas_internas ? $entrega->notas_internas . "\n\n" : '';
            $entrega->notas_internas = $notasExistentes . "[" . now()->format('d/m/Y H:i') . "] Cambio de estado: " .
                Entrega::ESTADOS[$estadoAnterior] . " → " .
                Entrega::ESTADOS[$request->estado] . "\n" .
                $request->notas;
        }

        $entrega->save();

        return redirect()
            ->route('entregas.show', $entrega)
            ->with('success', 'Estado de la entrega actualizado correctamente.');
    }

    public function eliminarFoto(Entrega $entrega, $index)
    {
        if (!$entrega->evidencia_foto || !is_array($entrega->evidencia_foto)) {
            return response()->json(['error' => 'No hay fotos para eliminar'], 404);
        }

        $fotos = $entrega->evidencia_foto;

        if (!isset($fotos[$index])) {
            return response()->json(['error' => 'Foto no encontrada'], 404);
        }

        // Eliminar archivo del storage
        if (isset($fotos[$index]['path'])) {
            Storage::disk('public')->delete($fotos[$index]['path']);
        }

        // Eliminar del array
        array_splice($fotos, $index, 1);

        $entrega->evidencia_foto = $fotos;
        $entrega->save();

        return response()->json(['success' => true, 'fotos_restantes' => count($fotos)]);
    }

    public function dashboard()
    {
        $estadisticas = [
            'total' => Entrega::count(),
            'pendientes' => Entrega::where('estado', 'pendiente')->count(),
            'en_camino' => Entrega::where('estado', 'en_camino')->count(),
            'entregadas' => Entrega::where('estado', 'entregado')->count(),
            'vencidas' => Entrega::where('estado', '!=', 'entregado')
                ->where('estado', '!=', 'cancelado')
                ->where('fecha_entrega', '<', now())->count(),
        ];

        $entregasHoy = Entrega::with(['ordenTrabajo', 'cliente'])
            ->whereDate('fecha_entrega', today())
            ->orderBy('hora_entrega')
            ->limit(10)
            ->get();

        $entregasCriticas = Entrega::with(['ordenTrabajo', 'cliente'])
            ->where('estado', '!=', 'entregado')
            ->where('estado', '!=', 'cancelado')
            ->where('fecha_entrega', '<=', now()->addDays(3))
            ->orderBy('fecha_entrega', 'asc')
            ->limit(5)
            ->get();

        $entregasEnCamino = Entrega::with(['ordenTrabajo', 'cliente'])
            ->where('estado', 'en_camino')
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        return view('entregas.dashboard', compact(
            'estadisticas',
            'entregasHoy',
            'entregasCriticas',
            'entregasEnCamino'
        ));
    }
}