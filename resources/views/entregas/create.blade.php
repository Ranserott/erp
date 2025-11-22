@extends('layouts.app')

@section('title', 'Nueva Entrega')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <a href="{{ route('entregas.index') }}"
               class="text-gray-600 hover:text-gray-900 mr-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Nueva Entrega</h1>
                <p class="text-gray-600 mt-1">Crea una nueva entrega en el sistema</p>
            </div>
        </div>
    </div>

    <!-- Formulario -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <form action="{{ route('entregas.store') }}" method="POST" id="entregaForm" enctype="multipart/form-data">
            @csrf

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
                                   value="{{ old('numero_entrega', $nuevoNumero) }}"
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
                                            {{ old('orden_trabajo_id') == $ot->id ? 'selected' : '' }}
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
                                    <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
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
                                    <option value="{{ $usuario->id }}" {{ old('user_id') == $usuario->id ? 'selected' : '' }}>
                                        {{ $usuario->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Fechas y Tiempos -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Fechas y Tiempos</h3>

                    <!-- Fecha Entrega -->
                    <div>
                        <label for="fecha_entrega" class="block text-sm font-medium text-gray-700 mb-1">
                            Fecha de Entrega <span class="text-red-500">*</span>
                        </label>
                        <input type="date"
                               name="fecha_entrega"
                               id="fecha_entrega"
                               value="{{ old('fecha_entrega') }}"
                               required
                               class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 @error('fecha_entrega') border-red-500 @enderror">
                        @error('fecha_entrega')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
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
                                   value="{{ old('nombre_receptor') }}"
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
                                   value="{{ old('documento_receptor') }}"
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
                                   value="{{ old('telefono_receptor') }}"
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
                                      class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 @error('direccion_entrega') border-red-500 @enderror">{{ old('direccion_entrega') }}</textarea>
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
                                    <option value="{{ $key }}" {{ old('estado', 'pendiente') == $key ? 'selected' : '' }}>
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
                                    <option value="{{ $key }}" {{ old('tipo_entrega', 'completa') == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('tipo_entrega')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @endif
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
                                    <option value="{{ $key }}" {{ old('metodo_entrega', 'propia') == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('metodo_entrega')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Evidencia Fotográfica -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Evidencia Fotográfica</h3>

                    <div class="space-y-2">
                        <input type="file"
                               name="evidencia_foto[]"
                               id="evidencia_foto"
                               multiple
                               accept="image/*"
                               class="block w-full text-sm text-gray-500
                                      file:mr-4 file:py-2 file:px-4
                                      file:rounded-full file:border-0
                                      file:text-sm file:font-semibold
                                      file:bg-primary-50 file:text-primary-700
                                      hover:file:bg-primary-100">
                        <p class="text-xs text-gray-500">Puedes seleccionar múltiples imágenes (máx. 5MB por imagen)</p>
                    </div>
                    @error('evidencia_foto')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
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
                              class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 @error('observaciones') border-red-500 @enderror">{{ old('observaciones') }}</textarea>
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
                              class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 @error('notas_internas') border-red-500 @enderror">{{ old('notas_internas') }}</textarea>
                    @error('notas_internas')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @endif
                </div>

                <!-- Alerta de Información -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <div class="flex items-start">
                        <div class="flex-shrink-0">
                            <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                            </svg>
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-blue-800">Importante</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <ul class="list-disc list-inside space-y-1">
                                    <li>El número de entrega debe ser único en el sistema</li>
                                    <li>Si seleccionas una orden de trabajo, el cliente se autocompletará automáticamente</li>
                                    <li>Las fotos de evidencia son importantes para validar la entrega</li>
                                    <li>El método de entrega afecta la logística asociada</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botones -->
            <div class="flex items-center justify-end space-x-4 mt-8 pt-6 border-t border-gray-200">
                <a href="{{ route('entregas.index') }}"
                   class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                    Cancelar
                </a>
                <button type="button"
                        onclick="guardarBorrador()"
                        class="px-4 py-2 text-gray-700 bg-yellow-100 rounded-lg hover:bg-yellow-200 transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V7a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                    </svg>
                    Guardar Borrador
                </button>
                <button type="submit"
                        class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Crear Entrega
                </button>
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

    // Auto-guardado en localStorage
    function autoGuardar() {
        const formData = new FormData(form);
        const data = {};
        for (let [key, value] of formData.entries()) {
            data[key] = value;
        }
        localStorage.setItem('entregaBorrador', JSON.stringify(data));
    }

    // Cargar borrador si existe
    function cargarBorrador() {
        const borrador = localStorage.getItem('entregaBorrador');
        if (borrador) {
            const data = JSON.parse(borrador);
            Object.keys(data).forEach(key => {
                const field = form.querySelector(`[name="${key}"]`);
                if (field) {
                    field.value = data[key];
                }
            });
        }
    }

    // Auto-guardar cada 30 segundos
    setInterval(autoGuardar, 30000);

    // Auto-guardar al cambiar campos
    form.addEventListener('input', autoGuardar);
    form.addEventListener('change', autoGuardar);

    // Cargar borrador al inicio
    cargarBorrador();
});

function guardarBorrador() {
    const form = document.getElementById('entregaForm');
    const formData = new FormData(form);
    const data = {};
    for (let [key, value] of formData.entries()) {
        data[key] = value;
    }
    localStorage.setItem('entregaBorrador', JSON.stringify(data));

    // Mostrar notificación
    const notification = document.createElement('div');
    notification.className = 'fixed bottom-4 right-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded z-50';
    notification.innerHTML = `
        <div class="flex items-center">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            Borrador guardado correctamente
        </div>
    `;
    document.body.appendChild(notification);

    setTimeout(() => {
        notification.remove();
    }, 3000);
}
</script>
@endsection