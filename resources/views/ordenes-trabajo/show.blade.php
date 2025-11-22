@extends('layouts.app')

@section('title', 'Orden de Trabajo: ' . $ordenTrabajo->numero_ot)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('ordenes-trabajo.index') }}"
                   class="text-gray-600 hover:text-gray-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <div>
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center">
                            <span class="text-sm font-medium text-primary-600">
                                OT
                            </span>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ $ordenTrabajo->numero_ot }}</h1>
                            <div class="flex items-center space-x-2 mt-1">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $ordenTrabajo->estado_color }}-100 text-{{ $ordenTrabajo->estado_color }}-800">
                                    {{ $ordenTrabajo->estado_label }}
                                </span>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $ordenTrabajo->prioridad_color }}-100 text-{{ $ordenTrabajo->prioridad_color }}-800">
                                    {{ $ordenTrabajo->prioridad_label }}
                                </span>
                                @if($ordenTrabajo->esta_atrasada)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        ⚠️ Atrasada
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex items-center space-x-3 mt-4 sm:mt-0">
                <!-- Editar -->
                <a href="{{ route('ordenes-trabajo.edit', $ordenTrabajo) }}"
                   class="inline-flex items-center px-3 py-2 text-blue-700 bg-blue-100 rounded-lg hover:bg-blue-200 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Editar
                </a>

                <!-- Cambiar Estado -->
                @if($ordenTrabajo->estado !== 'completada')
                    <button onclick="mostrarModalCambiarEstado()"
                            class="inline-flex items-center px-3 py-2 text-orange-700 bg-orange-100 rounded-lg hover:bg-orange-200 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                        </svg>
                        Cambiar Estado
                    </button>
                @endif

                <!-- Eliminar -->
                <form action="{{ route('ordenes-trabajo.destroy', $ordenTrabajo) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="inline-flex items-center px-3 py-2 text-red-700 bg-red-100 rounded-lg hover:bg-red-200 transition-colors duration-200"
                            onclick="return confirm('¿Estás seguro de eliminar esta orden de trabajo? Esta acción no se puede deshacer.')">
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
            <!-- Detalles de la Orden -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Detalles de la Orden</h2>

                <div class="space-y-4">
                    <div>
                        <h3 class="text-sm font-medium text-gray-700">Descripción del Trabajo</h3>
                        <p class="mt-1 text-sm text-gray-900 whitespace-pre-wrap">{{ $ordenTrabajo->descripcion }}</p>
                    </div>

                    @if($ordenTrabajo->notas)
                        <div>
                            <h3 class="text-sm font-medium text-gray-700">Notas</h3>
                            <p class="mt-1 text-sm text-gray-900 whitespace-pre-wrap">{{ $ordenTrabajo->notas }}</p>
                        </div>
                    @endif

                    @if($ordenTrabajo->cotizacion_id && $ordenTrabajo->cotizacion)
                        <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                            <h3 class="text-sm font-medium text-gray-700 mb-2">Cotización Asociada</h3>
                            <div class="text-sm text-gray-900">
                                <p><strong>Código:</strong> {{ $ordenTrabajo->cotizacion->codigo }}</p>
                                <p><strong>Asunto:</strong> {{ $ordenTrabajo->cotizacion->asunto }}</p>
                                <p><strong>Monto:</strong> ${{ number_format($ordenTrabajo->cotizacion->total, 2) }}</p>
                            </div>
                            <a href="{{ route('cotizaciones.show', $ordenTrabajo->cotizacion) }}"
                               class="mt-2 inline-flex items-center text-sm text-primary-600 hover:text-primary-800">
                                Ver cotización
                                <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                </svg>
                            </a>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Timeline del Proyecto -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Timeline del Proyecto</h2>

                <div class="space-y-4">
                    @foreach($timeline as $item)
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0 mt-1">
                                @if($item['activo'])
                                    <div class="w-3 h-3 bg-{{ $ordenTrabajo->estado_color }}-500 rounded-full"></div>
                                @else
                                    <div class="w-3 h-3 bg-gray-300 rounded-full"></div>
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center justify-between">
                                    <p class="text-sm font-medium text-gray-900">
                                        {{ ucfirst(str_replace('_', ' ', $item['estado'])) }}
                                    </p>
                                    @if($item['fecha'])
                                        <p class="text-sm text-gray-500">
                                            {{ $item['fecha']->format('d/m/Y H:i') }}
                                        </p>
                                    @endif
                                </div>
                                @if($item['activo'])
                                    <p class="text-xs text-{{ $ordenTrabajo->estado_color }}-600 mt-1">Estado actual</p>
                                @endif
                            </div>
                        </div>
                        @if(!$loop->last)
                            <div class="flex items-center space-x-3">
                                <div class="flex-shrink-0">
                                    <div class="w-0.5 h-6 bg-gray-300 ml-1"></div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>
            </div>

            <!-- Documentos Relacionados -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Documentos Relacionados</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Facturas -->
                    <div>
                        <h3 class="text-sm font-medium text-gray-700 mb-3">Facturas</h3>
                        @if($ordenTrabajo->facturas->count() > 0)
                            <div class="space-y-2">
                                @foreach($ordenTrabajo->facturas as $factura)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $factura->numero_factura }}</p>
                                            <p class="text-xs text-gray-500">${{ number_format($factura->total, 2) }}</p>
                                        </div>
                                        <a href="{{ route('facturas.show', $factura) }}"
                                           class="text-primary-600 hover:text-primary-800 text-sm">
                                            Ver
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-gray-500">No hay facturas asociadas</p>
                        @endif
                    </div>

                    <!-- Entregas -->
                    <div>
                        <h3 class="text-sm font-medium text-gray-700 mb-3">Entregas</h3>
                        @if($ordenTrabajo->entregas->count() > 0)
                            <div class="space-y-2">
                                @foreach($ordenTrabajo->entregas as $entrega)
                                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                                        <div>
                                            <p class="text-sm font-medium text-gray-900">{{ $entrega->numero_entrega }}</p>
                                            <p class="text-xs text-gray-500">{{ $entrega->fecha_entrega?->format('d/m/Y') }}</p>
                                        </div>
                                        <a href="{{ route('entregas.show', $entrega) }}"
                                           class="text-primary-600 hover:text-primary-800 text-sm">
                                            Ver
                                        </a>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <p class="text-sm text-gray-500">No hay entregas asociadas</p>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <!-- Información Lateral -->
        <div class="space-y-6">
            <!-- Información del Cliente -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Cliente</h2>

                @if($ordenTrabajo->cliente)
                    <div class="text-sm text-gray-900">
                        <p class="font-medium">{{ $ordenTrabajo->cliente->nombre }}</p>
                        <p class="text-gray-500">{{ $ordenTrabajo->cliente->email }}</p>
                        @if($ordenTrabajo->cliente->telefono)
                            <p class="text-gray-500">{{ $ordenTrabajo->cliente->telefono }}</p>
                        @endif
                    </div>
                    <a href="{{ route('clientes.show', $ordenTrabajo->cliente) }}"
                       class="mt-3 inline-flex items-center text-sm text-primary-600 hover:text-primary-800">
                        Ver cliente
                        <svg class="w-4 h-4 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </a>
                @else
                    <p class="text-sm text-gray-500">No hay cliente asignado</p>
                @endif
            </div>

            <!-- Fechas y Duración -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Fechas</h2>

                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">Creación:</span>
                        <span class="text-gray-900">{{ $ordenTrabajo->created_at->format('d/m/Y') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Inicio:</span>
                        <span class="text-gray-900">{{ $ordenTrabajo->fecha_inicio?->format('d/m/Y') ?: '-' }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Fin Estimado:</span>
                        <span class="text-gray-900">{{ $ordenTrabajo->fecha_fin_estimada?->format('d/m/Y') ?: '-' }}</span>
                    </div>
                    @if($ordenTrabajo->fecha_fin_real)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Fin Real:</span>
                            <span class="text-gray-900">{{ $ordenTrabajo->fecha_fin_real->format('d/m/Y') }}</span>
                        </div>
                    @endif
                    @if($ordenTrabajo->duracion_estimada)
                        <div class="flex justify-between">
                            <span class="text-gray-600">Duración:</span>
                            <span class="text-gray-900">{{ $ordenTrabajo->duracion_estimada }} días</span>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Asignado y Costos -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Asignación y Costos</h2>

                <div class="space-y-4">
                    <div>
                        <h3 class="text-sm font-medium text-gray-700">Asignado a</h3>
                        <p class="mt-1 text-sm text-gray-900">
                            {{ $ordenTrabajo->user ? $ordenTrabajo->user->name : 'Sin asignar' }}
                        </p>
                    </div>

                    @if($ordenTrabajo->costo_estimado)
                        <div>
                            <h3 class="text-sm font-medium text-gray-700">Costo Estimado</h3>
                            <p class="mt-1 text-sm font-medium text-gray-900">${{ number_format($ordenTrabajo->costo_estimado, 2) }}</p>
                        </div>
                    @endif

                    @if($ordenTrabajo->costo_real)
                        <div>
                            <h3 class="text-sm font-medium text-gray-700">Costo Real</h3>
                            <p class="mt-1 text-sm font-medium text-gray-900">${{ number_format($ordenTrabajo->costo_real, 2) }}</p>
                        </div>
                    @endif
                </div>
            </div>

            <!-- Acciones Rápidas -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Acciones Rápidas</h2>

                <div class="space-y-3">
                    <!-- Generar Factura -->
                    <button onclick="alert('Función en desarrollo')"
                            class="w-full px-4 py-2 text-green-700 bg-green-100 rounded-lg hover:bg-green-200 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Generar Factura
                    </button>

                    <!-- Crear Entrega -->
                    <button onclick="alert('Función en desarrollo')"
                            class="w-full px-4 py-2 text-purple-700 bg-purple-100 rounded-lg hover:bg-purple-200 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"/>
                        </svg>
                        Crear Entrega
                    </button>

                    <!-- Imprimir -->
                    <button onclick="window.print()"
                            class="w-full px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                        </svg>
                        Imprimir
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal para cambiar estado -->
<div id="modalCambiarEstado" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-lg bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Cambiar Estado de la Orden</h3>
            <form action="{{ route('ordenes-trabajo.cambiar-estado', $ordenTrabajo) }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nuevo Estado</label>
                        <select name="estado" required class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500">
                            @foreach(App\Models\OrdenTrabajo::ESTADOS as $key => $label)
                                <option value="{{ $key }}">{{ $label }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Notas del Cambio</label>
                        <textarea name="notas" rows="3" class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500" placeholder="Describe el motivo del cambio..."></textarea>
                    </div>
                </div>
                <div class="flex justify-end space-x-3 mt-6">
                    <button type="button" onclick="ocultarModalCambiarEstado()" class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200">Cancelar</button>
                    <button type="submit" class="px-4 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700">Cambiar Estado</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function mostrarModalCambiarEstado() {
    document.getElementById('modalCambiarEstado').classList.remove('hidden');
}

function ocultarModalCambiarEstado() {
    document.getElementById('modalCambiarEstado').classList.add('hidden');
}

// Cerrar modal al hacer clic fuera
document.getElementById('modalCambiarEstado').addEventListener('click', function(e) {
    if (e.target === this) {
        ocultarModalCambiarEstado();
    }
});
</script>
@endsection