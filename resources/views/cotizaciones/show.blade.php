@extends('layouts.app')

@section('title', 'Cotización ' . $cotizacion->codigo)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('cotizaciones.index') }}"
                       class="text-gray-600 hover:text-gray-900">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                        </svg>
                    </a>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $cotizacion->codigo }}</h1>
                    @switch($cotizacion->estado)
                        @case('pendiente')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Pendiente
                            </span>
                            @break
                        @case('aprobada')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Aprobada
                            </span>
                            @break
                        @case('rechazada')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Rechazada
                            </span>
                            @break
                        @case('vencida')
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                <svg class="w-4 h-4 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                                Vencida
                            </span>
                            @break
                    @endswitch
                </div>
                <p class="text-gray-600 mt-1">
    Creada el {{ $cotizacion->created_at ? $cotizacion->created_at->format('d/m/Y') : 'N/A' }}
    por {{ $cotizacion->user ? $cotizacion->user->name : 'Sistema' }}
</p>
            </div>
            <div class="flex items-center space-x-3 mt-4 sm:mt-0">
                <!-- Editar -->
                @if($cotizacion->estado !== 'aprobada')
                    <a href="{{ route('cotizaciones.edit', $cotizacion) }}"
                       class="inline-flex items-center px-3 py-2 text-blue-700 bg-blue-100 rounded-lg hover:bg-blue-200 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                        </svg>
                        Editar
                    </a>
                @endif

                <!-- Duplicar -->
                <form action="{{ route('cotizaciones.duplicar', $cotizacion) }}" method="POST" class="inline">
                    @csrf
                    <button type="submit"
                            class="inline-flex items-center px-3 py-2 text-purple-700 bg-purple-100 rounded-lg hover:bg-purple-200 transition-colors duration-200"
                            onclick="return confirm('¿Deseas duplicar esta cotización?')">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                        </svg>
                        Duplicar
                    </button>
                </form>

                <!-- PDF -->
                <a href="{{ route('cotizaciones.pdf', $cotizacion) }}"
                   class="inline-flex items-center px-3 py-2 text-green-700 bg-green-100 rounded-lg hover:bg-green-200 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    PDF
                </a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Información Principal -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Detalles de la Cotización -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Detalles de la Cotización</h2>

                <!-- Asunto -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Asunto</label>
                    <div class="text-gray-900">{{ $cotizacion->asunto }}</div>
                </div>

                <!-- Descripción -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Descripción del Proyecto</label>
                    <div class="prose prose-sm max-w-none text-gray-900">
                        {!! nl2br(e($cotizacion->descripcion)) !!}
                    </div>
                </div>

                <!-- Condiciones -->
                @if($cotizacion->condiciones)
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Condiciones Comerciales</label>
                        <div class="prose prose-sm max-w-none text-gray-900">
                            {!! nl2br(e($cotizacion->condiciones)) !!}
                        </div>
                    </div>
                @endif
            </div>

            <!-- Timeline de Estados -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Historial</h2>

                <div class="space-y-4">
                    <!-- Creación -->
                    <div class="flex items-start space-x-3">
                        <div class="flex-shrink-0 w-8 h-8 bg-blue-100 rounded-full flex items-center justify-center">
                            <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <div class="text-sm font-medium text-gray-900">Cotización creada</div>
                            <div class="text-sm text-gray-500">{{ $cotizacion->created_at->format('d/m/Y H:i') }} por {{ $cotizacion->user->name }}</div>
                        </div>
                    </div>

                    <!-- Última actualización -->
                    @if($cotizacion->updated_at != $cotizacion->created_at)
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0 w-8 h-8 bg-gray-100 rounded-full flex items-center justify-center">
                                <svg class="w-4 h-4 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <div class="text-sm font-medium text-gray-900">Última actualización</div>
                                <div class="text-sm text-gray-500">{{ $cotizacion->updated_at->format('d/m/Y H:i') }}</div>
                            </div>
                        </div>
                    @endif

                    <!-- Cambio de estado (si no está pendiente) -->
                    @if($cotizacion->estado !== 'pendiente')
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0 w-8 h-8 {{ $cotizacion->estado === 'aprobada' ? 'bg-green-100' : 'bg-red-100' }} rounded-full flex items-center justify-center">
                                @if($cotizacion->estado === 'aprobada')
                                    <svg class="w-4 h-4 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                @else
                                    <svg class="w-4 h-4 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                @endif
                            </div>
                            <div class="flex-1">
                                <div class="text-sm font-medium text-gray-900">
                                    Cotización {{ $cotizacion->estado === 'aprobada' ? 'aprobada' : 'rechazada' }}
                                </div>
                                <div class="text-sm text-gray-500">
                                    @if($cotizacion->estado === 'aprobada')
                                        El cliente aprobó la cotización
                                    @else
                                        El cliente rechazó la cotización
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Sidebar Derecha -->
        <div class="space-y-6">
            <!-- Información del Cliente -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Cliente</h3>

                <div class="space-y-3">
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Nombre</label>
                        <div class="text-gray-900">{{ $cotizacion->cliente->nombre }}</div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Email</label>
                        <div class="text-gray-900">{{ $cotizacion->cliente->email }}</div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Teléfono</label>
                        <div class="text-gray-900">{{ $cotizacion->cliente->telefono ?: 'No especificado' }}</div>
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-gray-700">Dirección</label>
                        <div class="text-gray-900">{{ $cotizacion->cliente->direccion ?: 'No especificada' }}</div>
                    </div>
                </div>

                <div class="mt-4 pt-4 border-t border-gray-200">
                    <a href="{{ route('clientes.show', $cotizacion->cliente) }}"
                       class="text-primary-600 hover:text-primary-700 text-sm font-medium">
                        Ver detalles del cliente →
                    </a>
                </div>
            </div>

            <!-- Información Financiera -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h3 class="text-lg font-semibold text-gray-900 mb-4">Información Financiera</h3>

                <div class="space-y-4">
                    <!-- Monto -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Monto Total</label>
                        <div class="text-2xl font-bold text-gray-900">
                            ${{ number_format($cotizacion->monto, 2, ',', '.') }}
                        </div>
                    </div>

                    <!-- Vigencia -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Fecha de Vigencia</label>
                        <div class="text-gray-900">
                            {{ $cotizacion->vigencia->format('d/m/Y') }}
                        </div>
                        @if($cotizacion->vigencia->isPast())
                            <div class="text-xs text-red-600 mt-1">⚠️ Vencida</div>
                        @else
                            <div class="text-xs text-green-600 mt-1">
                                Vence en {{ $cotizacion->vigencia->diffInDays(now()) }} días
                            </div>
                        @endif
                    </div>

                    <!-- Estado actual -->
                    <div>
                        <label class="block text-sm font-medium text-gray-700">Estado Actual</label>
                        @switch($cotizacion->estado)
                            @case('pendiente')
                                <div class="text-yellow-700">⏳ En espera de respuesta del cliente</div>
                                @break
                            @case('aprobada')
                                <div class="text-green-700">✅ Aprobada por el cliente</div>
                                @break
                            @case('rechazada')
                                <div class="text-red-700">❌ Rechazada por el cliente</div>
                                @break
                            @case('vencida')
                                <div class="text-gray-700">⏰ Vencida</div>
                                @break
                        @endswitch
                    </div>
                </div>
            </div>

            <!-- Acciones Rápidas -->
            @if($cotizacion->estado === 'pendiente')
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Actualizar Estado</h3>

                    <div class="space-y-2">
                        <form action="{{ route('cotizaciones.update', $cotizacion) }}" method="POST" class="inline">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="estado" value="aprobada">
                            <input type="hidden" name="cliente_id" value="{{ $cotizacion->cliente_id }}">
                            <input type="hidden" name="asunto" value="{{ $cotizacion->asunto }}">
                            <input type="hidden" name="descripcion" value="{{ $cotizacion->descripcion }}">
                            <input type="hidden" name="monto" value="{{ $cotizacion->monto }}">
                            <input type="hidden" name="vigencia" value="{{ $cotizacion->vigencia->format('Y-m-d') }}">
                            <input type="hidden" name="condiciones" value="{{ $cotizacion->condiciones }}">

                            <button type="submit"
                                    class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors duration-200"
                                    onclick="return confirm('¿Marcar esta cotización como aprobada?')">
                                ✅ Marcar como Aprobada
                            </button>
                        </form>

                        <form action="{{ route('cotizaciones.update', $cotizacion) }}" method="POST" class="inline">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="estado" value="rechazada">
                            <input type="hidden" name="cliente_id" value="{{ $cotizacion->cliente_id }}">
                            <input type="hidden" name="asunto" value="{{ $cotizacion->asunto }}">
                            <input type="hidden" name="descripcion" value="{{ $cotizacion->descripcion }}">
                            <input type="hidden" name="monto" value="{{ $cotizacion->monto }}">
                            <input type="hidden" name="vigencia" value="{{ $cotizacion->vigencia->format('Y-m-d') }}">
                            <input type="hidden" name="condiciones" value="{{ $cotizacion->condiciones }}">

                            <button type="submit"
                                    class="w-full px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors duration-200"
                                    onclick="return confirm('¿Marcar esta cotización como rechazada?')">
                                ❌ Marcar como Rechazada
                            </button>
                        </form>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
@endsection