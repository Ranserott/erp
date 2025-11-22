@extends('layouts.app')

@section('title', 'Editar Entrega: ' . $entrega->numero_entrega)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <a href="{{ route('entregas.show', $entrega) }}"
               class="text-gray-600 hover:text-gray-900 mr-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-primary-100 rounded-full flex items-center justify-center">
                        <span class="text-sm font-medium text-primary-600">
                            ENT
                        </span>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Editar Entrega</h1>
                        <p class="text-gray-600 mt-1">{{ $entrega->numero_entrega }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulario -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <form action="{{ route('entregas.update', $entrega) }}" method="POST" id="entregaForm" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Información Básica -->
            <div class="space-y-6">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Información de la Entrega</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Número Entrega -->
                        <div>
                            <label for="numero_entrega" class="block text-sm font-medium text-gray-700 mb-1">
                                Número de Entrega <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   name="numero_entrega"
                                   id="numero_entrega"
                                   value="{{ old('numero_entrega', $entrega->numero_entrega) }}"
                                   required
                                   maxlength="20"
                                   placeholder="Ej: ENT-00001"
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 @error('numero_entrega') border-red-500 @enderror">
                            @error('numero_entrega')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Orden de Trabajo -->
                        <div>
                            <label for="orden_trabajo_id" class="block text-sm font-medium text-gray-700 mb-1">
                                Orden de Trabajo
                            </label>
                            <select name="orden_trabajo_id"
                                    id="orden_trabajo_id"
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 @error('orden_trabajo_id') border-red-500 @enderror">
                                <option value="">Seleccionar orden (opcional)</option>
                                @foreach($ordenesTrabajo as $ot)
                                    <option value="{{ $ot->id }}"
                                            {{ old('orden_trabajo_id', $entrega->orden_trabajo_id) == $ot->id ? 'selected' : '' }}
                                            data-cliente-id="{{ $ot->cliente_id }}">
                                        {{ $ot->numero_ot }} - {{ $ot->descripcion ? Str::limit($ot->descripcion, 50) : '' }}
                                    </option>
                                @endforeach
                            </select>
                            @error('orden_trabajo_id')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Cliente -->
                        <div>
                            <label for="cliente_id" class="block text-sm font-medium text-gray-700 mb-1">
                                Cliente
                            </label>
                            <select name="cliente_id"
                                    id="cliente_id"
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 @error('cliente_id') border-red-500 @enderror">
                                <option value="">Seleccionar cliente (se autocompleta con la OT)</option>
                                @foreach($clientes as $cliente)
                                    <option value="{{ $cliente->id }}" {{ old('cliente_id', $entrega->cliente_id) == $cliente->id ? 'selected' : '' }}>
                                        {{ $cliente->nombre }}
                                    </option>
                                @endforeach
                            </select>
                            @error('cliente_id')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Asignado a -->
                        <div>
                            <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">
                                Asignado a
                            </label>
                            <select name="user_id"
                                    id="user_id"
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 @error('user_id') border-red-500 @enderror">
                                <option value="">Seleccionar responsable</option>
                                @foreach($usuarios as $usuario)
                                    <option value="{{ $usuario->id }}" {{ old('user_id', $entrega->user_id) == $usuario->id ? 'selected' : '' }}>
                                        {{ $usuario->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Fechas y Tiempos -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Fechas y Tiempos</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Fecha Entrega -->
                        <div>
                            <label for="fecha_entrega" class="block text-sm font-medium text-gray-700 mb-1">
                                Fecha de Entrega <span class="text-red-500">*</span>
                            </label>
                            <input type="date"
                                   name="fecha_entrega"
                                   id="fecha_entrega"
                                   value="{{ old('fecha_entrega', $entrega->fecha_entrega?->format('Y-m-d')) }}"
                                   required
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 @error('fecha_entrega') border-red-500 @enderror">
                            @error('fecha_entrega')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Información del Receptor -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Información del Receptor</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nombre Receptor -->
                        <div>
                            <label for="nombre_receptor" class="block text-sm font-medium text-gray-700 mb-1">
                                Nombre del Receptor <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   name="nombre_receptor"
                                   id="nombre_receptor"
                                   value="{{ old('nombre_receptor', $entrega->nombre_receptor) }}"
                                   required
                                   maxlength="255"
                                   placeholder="Nombre completo de la persona que recibe"
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 @error('nombre_receptor') border-red-500 @enderror">
                            @error('nombre_receptor')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Documento Receptor -->
                        <div>
                            <label for="documento_receptor" class="block text-sm font-medium text-gray-700 mb-1">
                                Documento del Receptor
                            </label>
                            <input type="text"
                                   name="documento_receptor"
                                   id="documento_receptor"
                                   value="{{ old('documento_receptor', $entrega->documento_receptor) }}"
                                   maxlength="50"
                                   placeholder="DNI, Cédula, etc."
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 @error('documento_receptor') border-red-500 @enderror">
                            @error('documento_receptor')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Teléfono Receptor -->
                        <div>
                            <label for="telefono_receptor" class="block text-sm font-medium text-gray-700 mb-1">
                                Teléfono del Receptor
                            </label>
                            <input type="tel"
                                   name="telefono_receptor"
                                   id="telefono_receptor"
                                   value="{{ old('telefono_receptor', $entrega->telefono_receptor) }}"
                                   maxlength="20"
                                   placeholder="Teléfono de contacto"
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 @error('telefono_receptor') border-red-500 @enderror">
                            @error('telefono_receptor')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Dirección Entrega -->
                        <div>
                            <label for="direccion_entrega" class="block text-sm font-medium text-gray-700 mb-1">
                                Dirección de Entrega
                            </label>
                            <textarea name="direccion_entrega"
                                      id="direccion_entrega"
                                      rows="2"
                                      maxlength="500"
                                      placeholder="Dirección completa donde se realizará la entrega"
                                      class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 @error('direccion_entrega') border-red-500 @enderror">{{ old('direccion_entrega', $entrega->direccion_entrega) }}</textarea>
                            @error('direccion_entrega')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Estado y Tipo -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Estado y Tipo de Entrega</h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Estado -->
                        <div>
                            <label for="estado" class="block text-sm font-medium text-gray-700 mb-1">
                                Estado <span class="text-red-500">*</span>
                            </label>
                            <select name="estado"
                                    id="estado"
                                    required
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 @error('estado') border-red-500 @enderror">
                                <option value="">Seleccionar estado</option>
                                @foreach($estados as $key => $label)
                                    <option value="{{ $key }}" {{ old('estado', $entrega->estado) == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('estado')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tipo Entrega -->
                        <div>
                            <label for="tipo_entrega" class="block text-sm font-medium text-gray-700 mb-1">
                                Tipo de Entrega <span class="text-red-500">*</span>
                            </label>
                            <select name="tipo_entrega"
                                    id="tipo_entrega"
                                    required
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 @error('tipo_entrega') border-red-500 @enderror">
                                <option value="">Seleccionar tipo</option>
                                @foreach($tiposEntrega as $key => $label)
                                    <option value="{{ $key }}" {{ old('tipo_entrega', $entrega->tipo_entrega) == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tipo_entrega')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Método Entrega -->
                        <div>
                            <label for="metodo_entrega" class="block text-sm font-medium text-gray-700 mb-1">
                                Método de Entrega <span class="text-red-500">*</span>
                            </label>
                            <select name="metodo_entrega"
                                    id="metodo_entrega"
                                    required
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 @error('metodo_entrega') border-red-500 @enderror">
                                <option value="">Seleccionar método</option>
                                @foreach($metodosEntrega as $key => $label)
                                    <option value="{{ $key }}" {{ old('metodo_entrega', $entrega->metodo_entrega) == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('metodo_entrega')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Evidencia -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Evidencia</h3>

                    <div class="grid grid-cols-1 gap-6">
                        <!-- Evidencia Fotográfica Existente -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">
                                Evidencia Fotográfica
                            </label>
                            @if($entrega->evidencia_foto && count($entrega->evidencia_foto) > 0)
                                <div class="space-y-2 mb-3">
                                    @foreach($entrega->evidencia_foto as $index => $foto)
                                        <div class="flex items-center justify-between p-2 bg-gray-50 rounded">
                                            <div class="flex items-center">
                                                <img src="{{ $foto['url'] }}" alt="{{ $foto['name'] }}" class="w-8 h-8 object-cover rounded mr-2">
                                                <div class="text-sm">
                                                    <p class="truncate">{{ $foto['name'] }}</p>
                                                    <p class="text-xs text-gray-500">{{ number_format($foto['size'] / 1024, 1) }} KB</p>
                                                </div>
                                            </div>
                                            <button type="button" onclick="eliminarFoto({{ $index }})" class="text-red-500 hover:text-red-700">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                                </svg>
                                            </button>
                                        </div>
                                    @endforeach
                                </div>
                            @endif
                            <div class="space-y-2">
                                <input type="file"
                                       name="evidencia_foto[]"
                                       multiple
                                       accept="image/*"
                                       class="block w-full text-sm text-gray-500
                                              file:mr-4 file:py-2 file:px-4
                                              file:rounded-full file:border-0
                                              file:text-sm file:font-semibold
                                              file:bg-primary-50 file:text-primary-700
                                              hover:file:bg-primary-100">
                                <p class="text-xs text-gray-500">Puedes agregar más imágenes (máx. 5MB por imagen)</p>
                            </div>
                            @error('evidencia_foto')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Observaciones -->
                <div>
                    <label for="observaciones" class="block text-sm font-medium text-gray-700 mb-1">
                        Observaciones
                    </label>
                    <textarea name="observaciones"
                              id="observaciones"
                              rows="3"
                              maxlength="2000"
                              placeholder="Observaciones especiales sobre la entrega..."
                              class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 @error('observaciones') border-red-500 @enderror">{{ old('observaciones', $entrega->observaciones) }}</textarea>
                    @error('observaciones')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Notas Internas -->
                <div>
                    <label for="notas_internas" class="block text-sm font-medium text-gray-700 mb-1">
                        Notas Internas
                    </label>
                    <textarea name="notas_internas"
                              id="notas_internas"
                              rows="2"
                              maxlength="2000"
                              placeholder="Notas internas para el seguimiento..."
                              class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 @error('notas_internas') border-red-500 @enderror">{{ old('notas_internas', $entrega->notas_internas) }}</textarea>
                    @error('notas_internas')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @endif
                </div>

                <!-- Información Actual -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <h3 class="text-sm font-medium text-blue-800 mb-2">Información Actual</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 text-sm">
                        <div>
                            <span class="text-blue-700">Creado:</span>
                            <p class="text-blue-900">{{ $entrega->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <span class="text-blue-700">Última Actualización:</span>
                            <p class="text-blue-900">{{ $entrega->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                        @if($entrega->esta_vencida)
                            <div>
                                <span class="text-blue-700">Estado:</span>
                                <p class="text-red-700 font-medium">⚠️ Vencida</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Botones -->
            <div class="flex items-center justify-between mt-8 pt-6 border-t border-gray-200">
                <div class="flex items-center space-x-3">
                    <!-- Ver -->
                    <a href="{{ route('entregas.show', $entrega) }}"
                       class="inline-flex items-center px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        Ver Detalles
                    </a>

                    <!-- Volver al Listado -->
                    <a href="{{ route('entregas.index') }}"
                       class="inline-flex items-center px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-7-7 7-7m8 14l-4-4m0 0L3 15m-3 0l-4-4m0 0l4 4m-4-4v6m0 0h6"/>
                        </svg>
                        Entregas
                    </a>
                </div>

                <div class="flex items-center space-x-3">
                    <a href="{{ route('entregas.show', $entrega) }}"
                       class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                        Cancelar
                    </a>
                    <button type="submit"
                            class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Guardar Cambios
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('entregaForm');
    const ordenTrabajoSelect = document.getElementById('orden_trabajo_id');
    const clienteSelect = document.getElementById('cliente_id');

    // Auto-completar cliente al seleccionar orden de trabajo
    ordenTrabajoSelect.addEventListener('change', function() {
        const selectedOption = this.options[this.selectedIndex];
        const clienteId = selectedOption.getAttribute('data-cliente-id');

        if (clienteId) {
            clienteSelect.value = clienteId;
        }
    });

    // Confirmar antes de enviar si hay cambios importantes
    form.addEventListener('submit', function(e) {
        const estadoActual = '{{ $entrega->estado }}';
        const estadoNuevo = document.getElementById('estado').value;

        if (estadoActual === 'entregado' && estadoNuevo !== 'entregado') {
            if (!confirm('¿Está seguro de cambiar el estado de "entregado" a otro estado? Esto podría afectar informes y estadísticas.')) {
                e.preventDefault();
            }
        }
    });
});


function eliminarFoto(index) {
    if (confirm('¿Estás seguro de eliminar esta foto?')) {
        fetch('{{ route("entregas.eliminar-foto", $entrega) }}/' + index, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('Error al eliminar la foto: ' + data.error);
            }
        })
        .catch(error => {
            alert('Error al eliminar la foto: ' + error.message);
        });
    }
}
</script>
@endsection