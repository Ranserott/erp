@extends('layouts.app')

@section('title', $cliente->nombre_empresa)

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8 flex items-center justify-between">
        <div>
            <nav class="flex items-center space-x-2 text-sm text-gray-500 mb-4">
                <a href="{{ route('clientes.index') }}" class="hover:text-gray-700">Clientes</a>
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
                <span>{{ $cliente->nombre_empresa }}</span>
            </nav>
            <h1 class="text-3xl font-bold text-gray-900">{{ $cliente->nombre_empresa }}</h1>
            <p class="text-gray-600 mt-1">Información detallada del cliente</p>
        </div>
        <div class="flex items-center space-x-3">
            <a href="{{ route('clientes.edit', $cliente) }}"
               class="inline-flex items-center px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                </svg>
                Editar
            </a>
            <a href="{{ route('clientes.create') }}"
               class="inline-flex items-center px-4 py-2 bg-gradient-to-r from-primary-600 to-primary-700 text-white rounded-lg hover:from-primary-700 hover:to-primary-800 transition-all duration-200">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Nuevo Cliente
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Información Principal -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Datos del Cliente -->
            <x-card title="Información del Cliente">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 mb-1">RUT</h4>
                        <p class="text-lg font-mono text-gray-900">{{ $cliente->rut_cliente }}</p>
                    </div>
                    <div>
                        <h4 class="text-sm font-medium text-gray-500 mb-1">Dirección</h4>
                        <p class="text-lg text-gray-900">{{ $cliente->direccion }}</p>
                    </div>
                </div>

                <div class="mt-6 pt-6 border-t border-gray-200">
                    <h4 class="text-sm font-medium text-gray-500 mb-3">Información de Contacto</h4>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 mb-1">Nombre Contacto</h4>
                            <p class="text-lg text-gray-900">{{ $cliente->contacto_nombre }}</p>
                        </div>
                        <div>
                            <h4 class="text-sm font-medium text-gray-500 mb-1">Teléfono</h4>
                            <a href="tel:{{ $cliente->contacto_telefono }}" class="text-lg text-primary-600 hover:text-primary-900">
                                {{ $cliente->contacto_telefono }}
                            </a>
                        </div>
                    </div>
                    <div class="mt-4">
                        <h4 class="text-sm font-medium text-gray-500 mb-1">Email</h4>
                        <a href="mailto:{{ $cliente->contacto_email }}" class="text-lg text-primary-600 hover:text-primary-900">
                            {{ $cliente->contacto_email }}
                        </a>
                    </div>
                </div>

                @if($cliente->notas)
                    <div class="mt-6 pt-6 border-t border-gray-200">
                        <h4 class="text-sm font-medium text-gray-500 mb-2">Notas</h4>
                        <p class="text-gray-900 bg-gray-50 p-3 rounded-lg">{{ $cliente->notas }}</p>
                    </div>
                @endif
            </x-card>

            <!-- Estadísticas -->
            <x-card title="Resumen de Actividad">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    <div class="text-center">
                        <div class="text-3xl font-bold text-blue-600">{{ $cliente->cotizaciones->count() }}</div>
                        <div class="text-sm text-gray-500 mt-1">Cotizaciones</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-green-600">{{ $cliente->ordenesTrabajo->count() }}</div>
                        <div class="text-sm text-gray-500 mt-1">Órdenes de Trabajo</div>
                    </div>
                    <div class="text-center">
                        <div class="text-3xl font-bold text-yellow-600">{{ $cliente->facturas->count() }}</div>
                        <div class="text-sm text-gray-500 mt-1">Facturas</div>
                    </div>
                </div>
            </x-card>
        </div>

        <!-- Sidebar -->
        <div class="space-y-6">
            <!-- Acciones Rápidas -->
            <x-card title="Acciones Rápidas">
                <div class="space-y-3">
                    <a href="{{ route('cotizaciones.create') }}?cliente_id={{ $cliente->id }}"
                       class="w-full inline-flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Nueva Cotización
                    </a>

                    <a href="{{ route('ordenes-trabajo.create') }}?cliente_id={{ $cliente->id }}"
                       class="w-full inline-flex items-center justify-center px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                        </svg>
                        Nueva Orden
                    </a>

                    <a href="{{ route('facturas.create') }}?cliente_id={{ $cliente->id }}"
                       class="w-full inline-flex items-center justify-center px-4 py-2 bg-yellow-600 text-white rounded-lg hover:bg-yellow-700 transition-colors">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                        </svg>
                        Nueva Factura
                    </a>
                </div>
            </x-card>

            <!-- Información del Sistema -->
            <x-card title="Información del Sistema">
                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">ID Cliente</span>
                        <span class="text-sm font-medium text-gray-900">#{{ $cliente->id }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Fecha de Creación</span>
                        <span class="text-sm font-medium text-gray-900">{{ $cliente->created_at->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm text-gray-500">Última Actualización</span>
                        <span class="text-sm font-medium text-gray-900">{{ $cliente->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
            </x-card>
        </div>
    </div>

    <!-- Actividad Reciente -->
    <div class="mt-8">
        <x-card title="Actividad Reciente">
            <div class="space-y-6">
                @if($cliente->cotizaciones->count() > 0)
                    <div>
                        <h4 class="text-sm font-medium text-gray-900 mb-3">Últimas Cotizaciones</h4>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th class="text-left text-xs font-medium text-gray-500 uppercase">Fecha</th>
                                        <th class="text-left text-xs font-medium text-gray-500 uppercase">Total</th>
                                        <th class="text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($cliente->cotizaciones->take(5) as $cotizacion)
                                        <tr class="hover:bg-gray-50">
                                            <td class="py-2 text-sm">{{ $cotizacion->fecha->format('d/m/Y') }}</td>
                                            <td class="py-2 text-sm">${{ number_format($cotizacion->total, 0, ',', '.') }}</td>
                                            <td class="py-2">
                                                @switch($cotizacion->estado)
                                                    @case('aprobada')
                                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Aprobada</span>
                                                        @break
                                                    @case('pendiente')
                                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pendiente</span>
                                                        @break
                                                    @case('rechazada')
                                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-red-100 text-red-800">Rechazada</span>
                                                        @break
                                                @endswitch
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

                @if($cliente->ordenesTrabajo->count() > 0)
                    <div>
                        <h4 class="text-sm font-medium text-gray-900 mb-3">Órdenes de Trabajo Recientes</h4>
                        <div class="overflow-x-auto">
                            <table class="min-w-full divide-y divide-gray-200">
                                <thead>
                                    <tr>
                                        <th class="text-left text-xs font-medium text-gray-500 uppercase">OT</th>
                                        <th class="text-left text-xs font-medium text-gray-500 uppercase">Inicio</th>
                                        <th class="text-left text-xs font-medium text-gray-500 uppercase">Estado</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200">
                                    @foreach($cliente->ordenesTrabajo->take(5) as $orden)
                                        <tr class="hover:bg-gray-50">
                                            <td class="py-2 text-sm font-medium">{{ $orden->numero_ot }}</td>
                                            <td class="py-2 text-sm">{{ $orden->fecha_inicio->format('d/m/Y') }}</td>
                                            <td class="py-2">
                                                @switch($orden->estado)
                                                    @case('terminada')
                                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-green-100 text-green-800">Terminada</span>
                                                        @break
                                                    @case('en progreso')
                                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-blue-100 text-blue-800">En Progreso</span>
                                                        @break
                                                    @case('pausada')
                                                        <span class="inline-flex px-2 py-1 text-xs font-semibold rounded-full bg-yellow-100 text-yellow-800">Pausada</span>
                                                        @break
                                                @endswitch
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                @endif

                @if($cliente->cotizaciones->count() == 0 && $cliente->ordenesTrabajo->count() == 0)
                    <div class="text-center py-8">
                        <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/>
                        </svg>
                        <p class="mt-2 text-gray-500">No hay actividad registrada para este cliente</p>
                    </div>
                @endif
            </div>
        </x-card>
    </div>
</div>
@endsection