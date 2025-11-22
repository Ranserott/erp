<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cliente;
use App\Models\Cotizacion;
use App\Models\OrdenTrabajo;
use App\Models\Factura;
use App\Models\CalendarioPago;

class DashboardController extends Controller
{
    public function index()
    {
        // KPIs
        $totalClientes = Cliente::count();
        $totalCotizaciones = Cotizacion::count();
        $ordenesActivas = OrdenTrabajo::where('estado', 'en progreso')->count();
        $pagosPorVencer = CalendarioPago::where('estado', 'pendiente')
            ->where('fecha_vencimiento', '<=', now()->addDays(7))
            ->count();

        // Últimos movimientos
        $ultimasCotizaciones = Cotizacion::with('cliente')
            ->latest()
            ->take(5)
            ->get();

        $ultimasOrdenes = OrdenTrabajo::with('cliente')
            ->latest()
            ->take(5)
            ->get();

        $ultimasFacturas = Factura::with('cliente')
            ->latest()
            ->take(5)
            ->get();

        // Pagos próximos
        $pagosProximos = CalendarioPago::with('proveedor')
            ->where('estado', 'pendiente')
            ->where('fecha_vencimiento', '<=', now()->addDays(30))
            ->orderBy('fecha_vencimiento')
            ->take(5)
            ->get();

        return view('dashboard.index', compact(
            'totalClientes',
            'totalCotizaciones',
            'ordenesActivas',
            'pagosPorVencer',
            'ultimasCotizaciones',
            'ultimasOrdenes',
            'ultimasFacturas',
            'pagosProximos'
        ));
    }
}
