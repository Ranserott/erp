@extends('layouts.app')

@section('title', 'Proveedor: ' . $proveedor->nombre)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('proveedores.index') }}"
                   class="text-gray-600 hover:text-gray-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <div>
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center">
                            <span class="text-sm font-medium text-primary-600">
                                {{ strtoupper(substr($proveedor->nombre, 0, 2)) }}
                            </span>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ $proveedor->nombre }}</h1>
                            <p class="text-gray-600 mt-1">{{ $proveedor->rut }}</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex items-center space-x-3 mt-4 sm:mt-0">
                <!-- Editar -->
                <a href="{{ route('proveedores.edit', $proveedor) }}"
                   class="inline-flex items-center px-3 py-2 text-blue-700 bg-blue-100 rounded-lg hover:bg-blue-200 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Editar
                </a>

                <!-- Eliminar -->
                <form action="{{ route('proveedores.destroy', $proveedor) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="inline-flex items-center px-3 py-2 text-red-700 bg-red-100 rounded-lg hover:bg-red-200 transition-colors duration-200"
                            onclick="return confirm('¿Estás seguro de eliminar este proveedor? Esta acción no se puede deshacer.')">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3m4 6h2m-6 0h6"/>
                        </svg>
                        Eliminar
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Información Detallada -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Información Principal -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Detalles del Proveedor -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Información del Proveedor</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Información de Contacto -->
                    <div class="space-y-3">
                        <div>
                            <h3 class="text-sm font-medium text-gray-700">Correo Electrónico</h3>
                            <p class="text-sm text-gray-900">{{ $proveedor->email }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-700">Teléfono</h3>
                            <p class="text-sm text-gray-900">{{ $proveedor->telefono }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-700">Tipo de Rubro</h3>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                {{ $proveedor->tipo_rubro }}
                            </span>
                        </div>
                    </div>

                    <!-- Información de Ubicación -->
                    <div class="space-y-3">
                        <div>
                            <h3 class="text-sm font-medium text-gray-700">Dirección</h3>
                            <p class="text-sm text-gray-900">{{ $proveedor->direccion }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-700">Estado</h3>
                            @if($stats['pagos_pendientes'] > 0)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                    ⚠️ Tiene {{ $stats['pagos_pendientes'] }} pagos pendientes
                                </span>
                            @else
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    ✅ Al día con pagos
                                </span>
                            @endif
                        </div>
                    </div>
                </div>

                @if($proveedor->notas)
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h3 class="text-sm font-medium text-gray-700 mb-2">Notas Adicionales</h3>
                        <p class="text-sm text-gray-900 bg-gray-50 p-3 rounded-lg">{{ $proveedor->notas }}</p>
                    </div>
                @endif
            </div>

            <!-- Estadísticas de Pagos -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Estadísticas de Pagos</h2>

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                    <div class="text-center">
                        <div class="text-2xl font-bold text-gray-900">{{ $stats['total_pagos'] }}</div>
                        <div class="text-sm text-gray-500">Total Pagos</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-yellow-600">{{ $stats['pagos_pendientes'] }}</div>
                        <div class="text-sm text-gray-500">Pendientes</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-red-600">${{ number_format($stats['monto_total_pendiente'], 0, ',', '.') }}</div>
                        <div class="text-sm text-gray-500">Monto Pendiente</div>
                    </div>
                    <div class="text-center">
                        <div class="text-2xl font-bold text-blue-600">{{ $stats['proximos_pagos'] }}</div>
                        <div class="text-sm text-gray-500">Próximos 30 días</div>
                    </div>
                </div>
            </div>

            <!-- Pagos Recientes -->
            @if($calendarioPagos->count() > 0)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <div class="flex items-center justify-between mb-4">
                        <h2 class="text-lg font-semibold text-gray-900">Pagos Recientes</h2>
                        <a href="{{ route('calendario-pagos.index', ['proveedor_id' => $proveedor->id]) }}"
                           class="text-sm text-blue-600 hover:text-blue-800">
                            Ver todos →
                        </a>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="min-w-full divide-y divide-gray-200">
                            <thead class="bg-gray-50">
                                <tr>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Descripción</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Monto</th>
                                    <th class="px-4 py-2 text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                                </tr>
                            </thead>
                            <tbody class="bg-white divide-y divide-gray-200">
                                @foreach($calendarioPagos as $pago)
                                    <tr>
                                        <td class="px-4 py-2 text-sm text-gray-900">
                                            {{ $pago->fecha_pago->format('d/m/Y') }}
                                        </td>
                                        <td class="px-4 py-2 text-sm text-gray-900">
                                            {{ $pago->descripcion ?? 'Sin descripción' }}
                                        </td>
                                        <td class="px-4 py-2 text-sm text-gray-900">
                                            ${{ number_format($pago->monto, 0, ',', '.') }}
                                        </td>
                                        <td class="px-4 py-2">
                                            @if($pago->estado === 'pagado')
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                                    Pagado
                                                </span>
                                            @elseif($pago->fecha_pago < now())
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                                    Vencido
                                                </span>
                                            @else
                                                <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                                    Pendiente
                                                </span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        </div>

        <!-- Panel Derecho -->
        <div class="space-y-6">
            <!-- Información Actual -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-sm font-medium text-gray-900 mb-4">Información Actual</h3>
                <div class="space-y-3 text-sm">
                    <div>
                        <span class="text-gray-700">Creado:</span>
                        <p class="text-gray-900">{{ $proveedor->created_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <span class="text-gray-700">Última Actualización:</span>
                        <p class="text-gray-900">{{ $proveedor->updated_at->format('d/m/Y H:i') }}</p>
                    </div>
                    <div>
                        <span class="text-gray-700">ID Interno:</span>
                        <p class="text-gray-900">#{{ $proveedor->id }}</p>
                    </div>
                </div>
            </div>

            <!-- Acciones Rápidas -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-sm font-medium text-gray-900 mb-4">Acciones Rápidas</h3>
                <div class="space-y-3">
                    <!-- Agregar Pago -->
                    <a href="{{ route('calendario-pagos.create') }}?proveedor_id={{ $proveedor->id }}"
                       class="w-full inline-flex items-center justify-center px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                        </svg>
                        Agregar Pago
                    </a>

                    <!-- Ver Pagos -->
                    <a href="{{ route('calendario-pagos.index', ['proveedor_id' => $proveedor->id]) }}"
                       class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-100 text-blue-700 rounded-lg hover:bg-blue-200 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        Ver Todos los Pagos
                    </a>

                    <!-- Exportar Datos -->
                    <button onclick="exportarProveedor({{ $proveedor->id }})"
                            class="w-full inline-flex items-center justify-center px-4 py-2 bg-green-100 text-green-700 rounded-lg hover:bg-green-200 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Exportar Datos
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function exportarProveedor(proveedorId) {
    window.open(`/proveedores/${proveedorId}/exportar`, '_blank');
}
</script>
@endsection