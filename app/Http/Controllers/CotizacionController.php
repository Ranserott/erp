<?php

namespace App\Http\Controllers;

use App\Models\Cotizacion;
use App\Models\Cliente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CotizacionController extends Controller
{
    public function __construct()
    {
        // El middleware se define en routes/web.php, no aquí
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Cotizacion::with(['cliente', 'user']);

        // Búsqueda
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('codigo', 'like', "%{$search}%")
                  ->orWhere('asunto', 'like', "%{$search}%")
                  ->orWhereHas('cliente', function($q) use ($search) {
                      $q->where('nombre', 'like', "%{$search}%")
                        ->orWhere('email', 'like', "%{$search}%");
                  });
            });
        }

        // Filtro por estado
        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        // Ordenamiento
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $cotizaciones = $query->paginate(10);

        // Estadísticas
        $stats = [
            'total' => Cotizacion::count(),
            'pendientes' => Cotizacion::where('estado', 'pendiente')->count(),
            'aprobadas' => Cotizacion::where('estado', 'aprobada')->count(),
            'rechazadas' => Cotizacion::where('estado', 'rechazada')->count(),
        ];

        return view('cotizaciones.index', compact('cotizaciones', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $clientes = Cliente::orderBy('nombre')->get();
        $codigo = $this->generarCodigo();
        return view('cotizaciones.create', compact('clientes', 'codigo'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'asunto' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'monto' => 'required|numeric|min:0',
            'vigencia' => 'required|date|after:today',
            'condiciones' => 'nullable|string',
        ]);

        $cotizacion = Cotizacion::create([
            'codigo' => $this->generarCodigo(),
            'cliente_id' => $request->cliente_id,
            'user_id' => Auth::id(),
            'asunto' => $request->asunto,
            'descripcion' => $request->descripcion,
            'monto' => $request->monto,
            'vigencia' => $request->vigencia,
            'condiciones' => $request->condiciones,
            'estado' => 'pendiente',
            // Campos existentes con valores por defecto
            'fecha' => now(),
            'subtotal' => $request->monto,
            'iva' => 0,
            'total' => $request->monto,
        ]);

        return redirect()->route('cotizaciones.show', $cotizacion)
            ->with('success', 'Cotización creada exitosamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cotizacion $cotizacion)
    {
        $cotizacion->load(['cliente', 'user']);
        return view('cotizaciones.show', compact('cotizacion'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cotizacion $cotizacion)
    {
        $clientes = Cliente::orderBy('nombre')->get();
        return view('cotizaciones.edit', compact('cotizacion', 'clientes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cotizacion $cotizacion)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'asunto' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'monto' => 'required|numeric|min:0',
            'vigencia' => 'required|date|after:today',
            'condiciones' => 'nullable|string',
            'estado' => 'required|in:pendiente,aprobada,rechazada,vencida',
        ]);

        $cotizacion->update([
            'cliente_id' => $request->cliente_id,
            'asunto' => $request->asunto,
            'descripcion' => $request->descripcion,
            'monto' => $request->monto,
            'vigencia' => $request->vigencia,
            'condiciones' => $request->condiciones,
            'estado' => $request->estado,
            // Actualizar campos de cálculo
            'subtotal' => $request->monto,
            'total' => $request->monto,
        ]);

        return redirect()->route('cotizaciones.show', $cotizacion)
            ->with('success', 'Cotización actualizada exitosamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cotizacion $cotizacion)
    {
        // No eliminar si está aprobada
        if ($cotizacion->estado === 'aprobada') {
            return redirect()->route('cotizaciones.index')
                ->with('error', 'No se puede eliminar una cotización aprobada.');
        }

        $cotizacion->delete();

        return redirect()->route('cotizaciones.index')
            ->with('success', 'Cotización eliminada exitosamente.');
    }

    /**
     * Generar código único de cotización
     */
    private function generarCodigo()
    {
        $prefix = 'COT-' . date('Y-m');

        // Buscar el último código con el prefijo actual
        $last = Cotizacion::where('codigo', 'like', $prefix . '%')
            ->orderBy('codigo', 'desc')
            ->first();

        if ($last) {
            // Extraer el número del código (últimos 4 caracteres después del guión)
            $codeParts = explode('-', $last->codigo);
            if (count($codeParts) >= 3) {
                $lastNumber = intval(end($codeParts));
                $newNumber = $lastNumber + 1;
            } else {
                // Si el formato es diferente, extraer los últimos 4 dígitos
                $lastNumber = intval(substr($last->codigo, -4));
                $newNumber = $lastNumber + 1;
            }
        } else {
            $newNumber = 1;
        }

        $newCode = $prefix . '-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);

        // Asegurar que el código sea único (doble verificación)
        while (Cotizacion::where('codigo', $newCode)->exists()) {
            $newNumber++;
            $newCode = $prefix . '-' . str_pad($newNumber, 4, '0', STR_PAD_LEFT);
        }

        return $newCode;
    }

    /**
     * Generar PDF de la cotización
     */
    public function generarPDF(Cotizacion $cotizacion)
    {
        // Por ahora, redirigir a la vista show
        // TODO: Implementar generación de PDF real con dompdf o similar
        return view('cotizaciones.pdf', compact('cotizacion'));
    }

    /**
     * Duplicar cotización
     */
    public function duplicar(Cotizacion $cotizacion)
    {
        $nuevaCotizacion = $cotizacion->replicate();
        $nuevaCotizacion->codigo = $this->generarCodigo();
        $nuevaCotizacion->estado = 'pendiente';
        $nuevaCotizacion->save();

        return redirect()->route('cotizaciones.edit', $nuevaCotizacion)
            ->with('success', 'Cotización duplicada exitosamente.');
    }
}
