<?php

namespace App\Http\Controllers;

use App\Models\Proveedor;
use App\Models\CalendarioPago;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProveedorController extends Controller
{
    public function __construct()
    {
        // No se necesita middleware aquí, se maneja en las rutas
    }

    public function index(Request $request)
    {
        $query = Proveedor::query();

        // Búsqueda
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nombre', 'like', "%{$search}%")
                  ->orWhere('rut', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('telefono', 'like', "%{$search}%")
                  ->orWhere('tipo_rubro', 'like', "%{$search}%");
            });
        }

        // Filtros
        if ($request->filled('tipo_rubro')) {
            $query->where('tipo_rubro', $request->tipo_rubro);
        }

        // Ordenamiento
        $orden = $request->input('orden', 'desc');
        $campo = $request->input('campo', 'created_at');
        $query->orderBy($campo, $orden);

        $proveedores = $query->paginate(15);

        // Estadísticas
        $stats = [
            'total' => Proveedor::count(),
            'con_pagos_pendientes' => CalendarioPago::where('estado', '!=', 'pagado')
                ->whereIn('proveedor_id', Proveedor::pluck('id'))
                ->distinct('proveedor_id')
                ->count(),
            'tipos_rubro' => Proveedor::distinct('tipo_rubro')
                ->pluck('tipo_rubro')
                ->filter()
                ->values(),
        ];

        // Datos para filtros
        $tiposRubro = $stats['tipos_rubro'];

        return view('proveedores.index', compact(
            'proveedores',
            'stats',
            'tiposRubro'
        ));
    }

    public function create()
    {
        // Lista de tipos de rubro sugeridos
        $tiposRubro = [
            'Materials/Suministros',
            'Servicios',
            'Equipamiento',
            'Software',
            'Consultoría',
            'Mantenimiento',
            'Transporte',
            'Seguros',
            'Otro'
        ];

        return view('proveedores.create', compact('tiposRubro'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'rut' => 'required|string|max:20|unique:proveedores,rut',
            'telefono' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'direccion' => 'required|string|max:500',
            'tipo_rubro' => 'required|string|max:255',
            'notas' => 'nullable|string|max:2000',
        ]);

        $proveedor = Proveedor::create($request->all());

        return redirect()
            ->route('proveedores.show', $proveedor)
            ->with('success', 'Proveedor creado correctamente.');
    }

    public function show($proveedore)
    {
        $proveedor = Proveedor::findOrFail($proveedore);

        // Cargar pagos relacionados
        $calendarioPagos = $proveedor->calendarioPagos()
            ->orderBy('fecha_pago', 'desc')
            ->limit(10)
            ->get();

        // Estadísticas del proveedor
        $stats = [
            'total_pagos' => $proveedor->calendarioPagos()->count(),
            'pagos_pendientes' => $proveedor->calendarioPagos()
                ->where('estado', '!=', 'pagado')
                ->count(),
            'monto_total_pendiente' => $proveedor->calendarioPagos()
                ->where('estado', '!=', 'pagado')
                ->sum('monto'),
            'proximos_pagos' => $proveedor->calendarioPagos()
                ->where('estado', '!=', 'pagado')
                ->where('fecha_pago', '>=', now())
                ->where('fecha_pago', '<=', now()->addDays(30))
                ->count(),
        ];

        return view('proveedores.show', compact(
            'proveedor',
            'calendarioPagos',
            'stats'
        ));
    }

    public function edit($proveedore)
    {
        $proveedor = Proveedor::findOrFail($proveedore);

        // Lista de tipos de rubro sugeridos
        $tiposRubro = [
            'Materials/Suministros',
            'Servicios',
            'Equipamiento',
            'Software',
            'Consultoría',
            'Mantenimiento',
            'Transporte',
            'Seguros',
            'Otro'
        ];

        return view('proveedores.edit', compact(
            'proveedor',
            'tiposRubro'
        ));
    }

    public function update(Request $request, $proveedore)
    {
        $proveedor = Proveedor::findOrFail($proveedore);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'rut' => 'required|string|max:20|unique:proveedores,rut,' . $proveedor->id,
            'telefono' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'direccion' => 'required|string|max:500',
            'tipo_rubro' => 'required|string|max:255',
            'notas' => 'nullable|string|max:2000',
        ]);

        $proveedor->update($request->all());

        return redirect()
            ->route('proveedores.show', $proveedor)
            ->with('success', 'Proveedor actualizado correctamente.');
    }

    public function destroy($proveedore)
    {
        $proveedor = Proveedor::findOrFail($proveedore);

        // Verificar si hay pagos asociados
        $pagosCount = $proveedor->calendarioPagos()->count();

        if ($pagosCount > 0) {
            return redirect()
                ->route('proveedores.show', $proveedor)
                ->with('error', "No se puede eliminar el proveedor porque tiene {$pagosCount} pagos asociados.");
        }

        $proveedor->delete();

        return redirect()
            ->route('proveedores.index')
            ->with('success', 'Proveedor eliminado correctamente.');
    }

    // Métodos adicionales

    public function dashboard()
    {
        $estadisticas = [
            'total' => Proveedor::count(),
            'con_pagos_pendientes' => CalendarioPago::where('estado', '!=', 'pagado')
                ->whereIn('proveedor_id', Proveedor::pluck('id'))
                ->distinct('proveedor_id')
                ->count(),
            'monto_total_pendiente' => CalendarioPago::where('estado', '!=', 'pagado')
                ->whereIn('proveedor_id', Proveedor::pluck('id'))
                ->sum('monto'),
        ];

        $proveedoresRecientes = Proveedor::orderBy('created_at', 'desc')
            ->limit(5)
            ->get();

        $proveedoresConPagosCriticos = Proveedor::whereHas('calendarioPagos', function($query) {
                $query->where('estado', '!=', 'pagado')
                      ->where('fecha_pago', '<=', now()->addDays(7));
            })
            ->with(['calendarioPagos' => function($query) {
                $query->where('estado', '!=', 'pagado')
                      ->where('fecha_pago', '<=', now()->addDays(7))
                      ->orderBy('fecha_pago');
            }])
            ->limit(5)
            ->get();

        return view('proveedores.dashboard', compact(
            'estadisticas',
            'proveedoresRecientes',
            'proveedoresConPagosCriticos'
        ));
    }
}
