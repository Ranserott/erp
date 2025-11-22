<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\CotizacionController;
use App\Http\Controllers\OrdenTrabajoController;
use App\Http\Controllers\FacturaController;
use App\Http\Controllers\EntregaController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\CalendarioPagoController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

// Rutas públicas (login, registro, etc.)
require __DIR__.'/auth.php';

// Healthcheck
Route::get('/health', function () {
    return response()->json(['status' => 'ok', 'timestamp' => now()]);
});

// Ruta principal - Redirigir al login si no está autenticado
Route::get('/', function () {
    return redirect()->route('login');
});

// Rutas protegidas con autenticación
Route::middleware(['auth', 'verified'])->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Página de prueba responsive
    Route::get('/test-responsive', function() {
        return view('test-responsive');
    })->name('test-responsive');

    // Rutas de recursos del ERP
    Route::resource('clientes', ClienteController::class);

    // Cotizaciones con parámetros explícitos para evitar pluralización incorrecta
    Route::get('cotizaciones', [CotizacionController::class, 'index'])->name('cotizaciones.index');
    Route::post('cotizaciones', [CotizacionController::class, 'store'])->name('cotizaciones.store');
    Route::get('cotizaciones/create', [CotizacionController::class, 'create'])->name('cotizaciones.create');
    Route::get('cotizaciones/{cotizacion}', [CotizacionController::class, 'show'])->name('cotizaciones.show');
    Route::get('cotizaciones/{cotizacion}/edit', [CotizacionController::class, 'edit'])->name('cotizaciones.edit');
    Route::put('cotizaciones/{cotizacion}', [CotizacionController::class, 'update'])->name('cotizaciones.update');
    Route::delete('cotizaciones/{cotizacion}', [CotizacionController::class, 'destroy'])->name('cotizaciones.destroy');

    // Órdenes de Trabajo con rutas explícitas
    Route::get('ordenes-trabajo', [OrdenTrabajoController::class, 'index'])->name('ordenes-trabajo.index');
    Route::post('ordenes-trabajo', [OrdenTrabajoController::class, 'store'])->name('ordenes-trabajo.store');
    Route::get('ordenes-trabajo/create', [OrdenTrabajoController::class, 'create'])->name('ordenes-trabajo.create');
    Route::get('ordenes-trabajo/{ordenTrabajo}', [OrdenTrabajoController::class, 'show'])->name('ordenes-trabajo.show');
    Route::get('ordenes-trabajo/{ordenTrabajo}/edit', [OrdenTrabajoController::class, 'edit'])->name('ordenes-trabajo.edit');
    Route::put('ordenes-trabajo/{ordenTrabajo}', [OrdenTrabajoController::class, 'update'])->name('ordenes-trabajo.update');
    Route::delete('ordenes-trabajo/{ordenTrabajo}', [OrdenTrabajoController::class, 'destroy'])->name('ordenes-trabajo.destroy');

    // Ruta adicional para cambiar estado
    Route::post('ordenes-trabajo/{ordenTrabajo}/cambiar-estado', [OrdenTrabajoController::class, 'cambiarEstado'])->name('ordenes-trabajo.cambiar-estado');
    Route::get('ordenes-trabajo/dashboard', [OrdenTrabajoController::class, 'dashboard'])->name('ordenes-trabajo.dashboard');
    Route::resource('facturas', FacturaController::class);
    Route::resource('entregas', EntregaController::class);

    // Rutas adicionales para entregas
    Route::post('entregas/{entrega}/cambiar-estado', [EntregaController::class, 'cambiarEstado'])->name('entregas.cambiar-estado');
    Route::delete('entregas/{entrega}/eliminar-foto/{index}', [EntregaController::class, 'eliminarFoto'])->name('entregas.eliminar-foto');
    Route::get('entregas/dashboard', [EntregaController::class, 'dashboard'])->name('entregas.dashboard');
    Route::resource('proveedores', ProveedorController::class)->parameters([
        'proveedore' => 'proveedor'
    ]);
    Route::get('proveedores/dashboard', [ProveedorController::class, 'dashboard'])->name('proveedores.dashboard');
    // Rutas de calendario de pagos
    Route::get('calendario-pagos/calendario', [CalendarioPagoController::class, 'calendario'])->name('calendario-pagos.calendario');
    Route::get('calendario-pagos/dia', [CalendarioPagoController::class, 'pagosDelDia'])->name('calendario-pagos.dia');
    Route::get('calendario-pagos/dashboard', [CalendarioPagoController::class, 'dashboard'])->name('calendario-pagos.dashboard');
    Route::get('calendario-pagos/recordatorios', [CalendarioPagoController::class, 'recordatorios'])->name('calendario-pagos.recordatorios');
    Route::post('calendario-pagos/{calendario_pago}/marcar-pagado', [CalendarioPagoController::class, 'marcarPagado'])->name('calendario-pagos.marcar-pagado');

    Route::resource('calendario-pagos', CalendarioPagoController::class)->parameters([
        'calendario_pago' => 'calendario_pago'
    ]);

    // Gestión de usuarios (solo admin)
    Route::middleware(['admin'])->group(function () {
        Route::resource('users', UserController::class);
    });

    // Rutas adicionales de cotizaciones
    Route::get('/cotizaciones/{cotizacion}/pdf', [CotizacionController::class, 'generarPDF'])->name('cotizaciones.pdf');
    Route::post('/cotizaciones/{cotizacion}/duplicar', [CotizacionController::class, 'duplicar'])->name('cotizaciones.duplicar');

    // Profile
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
