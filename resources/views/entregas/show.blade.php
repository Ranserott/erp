@extends('layouts.app')

@section('title', 'Entrega: ' . $entrega->numero_entrega)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div class="flex items-center space-x-4">
                <a href="{{ route('entregas.index') }}"
                   class="text-gray-600 hover:text-gray-900">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                    </svg>
                </a>
                <div>
                    <div class="flex items-center space-x-3">
                        <div class="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center">
                            <span class="text-sm font-medium text-primary-600">
                                ENT
                            </span>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-gray-900">{{ $entrega->numero_entrega }}</h1>
                            <div class="flex items-center space-x-2 mt-1">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-{{ $entrega->estado_color }}-100 text-{{ $entrega->estado_color }}-800">
                                    {{ $entrega->estado_label }}
                                </span>
                                @if($entrega->tipo_entrega)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                        {{ $entrega->tipo_entrega_label }}
                                    </span>
                                @endif
                                @if($entrega->esta_vencida)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                        ⚠️ Vencida
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex items-center space-x-3 mt-4 sm:mt-0">
                <!-- Editar -->
                <a href="{{ route('entregas.edit', $entrega) }}"
                   class="inline-flex items-center px-3 py-2 text-blue-700 bg-blue-100 rounded-lg hover:bg-blue-200 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Editar
                </a>

                <!-- Cambiar Estado -->
                <button onclick="mostrarModalCambiarEstado()"
                        class="inline-flex items-center px-3 py-2 text-orange-700 bg-orange-100 rounded-lg hover:bg-orange-200 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"/>
                    </svg>
                    Cambiar Estado
                </button>

                <!-- Eliminar -->
                <form action="{{ route('entregas.destroy', $entrega) }}" method="POST" class="inline">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="inline-flex items-center px-3 py-2 text-red-700 bg-red-100 rounded-lg hover:bg-red-200 transition-colors duration-200"
                            onclick="return confirm('¿Estás seguro de eliminar esta entrega? Esta acción no se puede deshacer.')">
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
            <!-- Detalles de la Entrega -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Detalles de la Entrega</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <!-- Información General -->
                    <div class="space-y-3">
                        <div>
                            <h3 class="text-sm font-medium text-gray-700">Fecha de Entrega</h3>
                            <p class="text-sm text-gray-900">
                                {{ $entrega->fecha_entrega?->format('d/m/Y') ?: '-' }}
                            </p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-700">Método de Entrega</h3>
                            <p class="text-sm text-gray-900">{{ $entrega->metodo_entrega_label ?? 'No especificado' }}</p>
                        </div>
                        <div>
                            <h3 class="text-sm font-medium text-gray-700">Tipo de Entrega</h3>
                            <p class="text-sm text-gray-900">{{ $entrega->tipo_entrega_label ?? 'No especificado' }}</p>
                        </div>
                    </div>

                    <!-- Información de Entrega -->
                    <div class="space-y-3">
                        <div>
                            <h3 class="text-sm font-medium text-gray-700">Dirección de Entrega</h3>
                            <p class="text-sm text-gray-900">{{ $entrega->direccion_entrega ?: 'No especificada' }}</p>
                        </div>
                    </div>
                </div>

                @if($entrega->observaciones)
                    <div class="mt-6">
                        <h3 class="text-sm font-medium text-gray-700 mb-2">Observaciones</h3>
                        <p class="text-sm text-gray-900 whitespace-pre-wrap">{{ $entrega->observaciones }}</p>
                    </div>
                @endif
            </div>

            <!-- Información del Receptor -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Información del Receptor</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="space-y-3">
                        <div>
                            <h3 class="text-sm font-medium text-gray-700">Nombre</h3>
                            <p class="text-sm text-gray-900">{{ $entrega->nombre_receptor }}</p>
                        </div>
                        @if($entrega->documento_receptor)
                            <div>
                                <h3 class="text-sm font-medium text-gray-700">Documento</h3>
                                <p class="text-sm text-gray-900">{{ $entrega->documento_receptor }}</p>
                            </div>
                        @endif
                    </div>
                    <div class="space-y-3">
                        @if($entrega->telefono_receptor)
                            <div>
                                <h3 class="text-sm font-medium text-gray-700">Teléfono</h3>
                                <p class="text-sm text-gray-900">{{ $entrega->telefono_receptor }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Evidencia Fotográfica -->
            @if($entrega->evidencia_foto && count($entrega->evidencia_foto) > 0)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Evidencia Fotográfica</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($entrega->evidencia_foto as $index => $foto)
                            <div class="relative group">
                                <img src="{{ $foto['url'] }}"
                                     alt="{{ $foto['name'] }}"
                                     class="w-full h-48 object-cover rounded-lg">
                                <div class="absolute top-2 right-2 opacity-0 group-hover:opacity-100 transition-opacity">
                                    <button onclick="window.open('{{ $foto['url'] }}', '_blank')"
                                            class="bg-white rounded-full p-1 shadow-md hover:bg-gray-100">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>
                                    </button>
                                </div>
                                <div class="mt-2">
                                    <p class="text-xs text-gray-600 truncate">{{ $foto['name'] }}</p>
                                    <p class="text-xs text-gray-500">{{ number_format($foto['size'] / 1024, 1) }} KB</p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Timeline del Proceso -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Timeline del Proceso</h2>

                <div class="space-y-4">
                    @foreach($timeline as $item)
                        <div class="flex items-start space-x-3">
                            <div class="flex-shrink-0 mt-1">
                                @if($item['activo'])
                                    <div class="w-3 h-3 bg-{{ $entrega->estado_color }}-500 rounded-full"></div>
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
                                    <p class="text-xs text-{{ $entrega->estado_color }}-600 mt-1">Estado actual</p>
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
        </div>

        <!-- Información Lateral -->
        <div class="space-y-6">
            <!-- Cliente y Orden -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Relacionado Con</h2>

                @if($entrega->cliente)
                    <div class="mb-4">
                        <h3 class="text-sm font-medium text-gray-700 mb-2">Cliente</h3>
                        <div class="text-sm text-gray-900">
                            <p class="font-medium">{{ $entrega->cliente->nombre }}</p>
                            <p class="text-gray-500">{{ $entrega->cliente->email }}</p>
                        </div>
                        <a href="{{ route('clientes.show', $entrega->cliente) }}"
                           class="text-xs text-blue-600 hover:text-blue-800">
                            Ver cliente
                        </a>
                    </div>
                @endif

                @if($entrega->ordenTrabajo)
                    <div>
                        <h3 class="text-sm font-medium text-gray-700 mb-2">Orden de Trabajo</h3>
                        <div class="text-sm text-gray-900">
                            <p class="font-medium">{{ $entrega->ordenTrabajo->numero_ot }}</p>
                            <p class="text-gray-500">{{ Str::limit($entrega->ordenTrabajo->descripcion, 50) }}</p>
                        </div>
                        <a href="{{ route('ordenes-trabajo.show', $entrega->ordenTrabajo) }}"
                           class="text-xs text-blue-600 hover:text-blue-800">
                            Ver orden de trabajo
                        </a>
                    </div>
                @endif
            </div>

            <!-- Asignación -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Asignación</h2>

                <div>
                    <h3 class="text-sm font-medium text-gray-700">Asignado a</h3>
                    <p class="mt-1 text-sm text-gray-900">
                        {{ $entrega->user ? $entrega->user->name : 'Sin asignar' }}
                    </p>
                </div>
            </div>

            <!-- Información del Sistema -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Información del Sistema</h2>

                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">ID del Sistema:</span>
                        <span class="text-gray-900">#{{ $entrega->id }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Creación:</span>
                        <span class="text-gray-900">{{ $entrega->created_at->format('d/m/Y H:i') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Última Actualización:</span>
                        <span class="text-gray-900">{{ $entrega->updated_at->format('d/m/Y H:i') }}</span>
                    </div>
                </div>
            </div>

            <!-- Acciones Rápidas -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Acciones Rápidas</h2>

                <div class="space-y-3">
                    <!-- Imprimir -->
                    <button onclick="window.print()"
                            class="w-full px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/>
                        </svg>
                        Imprimir
                    </button>

                    <!-- Descargar PDF -->
                    <button onclick="alert('Función en desarrollo')"
                            class="w-full px-4 py-2 text-red-700 bg-red-100 rounded-lg hover:bg-red-200 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                        </svg>
                        Descargar PDF
                    </button>

                    <!-- Enviar Email -->
                    <button onclick="alert('Función en desarrollo')"
                            class="w-full px-4 py-2 text-blue-700 bg-blue-100 rounded-lg hover:bg-blue-200 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 2.2l5.64-5.64a2 2 0 012.22-2.2L3 8m0 0l5.64 5.64a2 2 0 002.22 2.2l-5.64 5.64a2 2 0 01-2.22-2.2L3 8z"/>
                        </svg>
                        Enviar Email
                    </button>
                </div>
            </div>

            <!-- Notas Internas -->
            @if($entrega->notas_internas)
                <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                    <h2 class="text-lg font-semibold text-gray-900 mb-4">Notas Internas</h2>
                    <div class="text-sm text-gray-900 whitespace-pre-wrap">{{ $entrega->notas_internas }}</div>
                </div>
            @endif
        </div>
    </div>
</div>

<!-- Modal para cambiar estado -->
<div id="modalCambiarEstado" class="hidden fixed inset-0 bg-gray-600 bg-opacity-50 overflow-y-auto h-full w-full z-50">
    <div class="relative top-20 mx-auto p-5 border w-96 shadow-lg rounded-lg bg-white">
        <div class="mt-3">
            <h3 class="text-lg font-medium text-gray-900 mb-4">Cambiar Estado de la Entrega</h3>
            <form action="{{ route('entregas.cambiar-estado', $entrega) }}" method="POST">
                @csrf
                <div class="space-y-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Nuevo Estado</label>
                        <select name="estado" required class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500">
                            @foreach(App\Models\Entrega::ESTADOS as $key => $label)
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