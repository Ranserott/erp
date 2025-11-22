@extends('layouts.app')

@section('title', 'Nueva Orden de Trabajo')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <a href="{{ route('ordenes-trabajo.index') }}"
               class="text-gray-600 hover:text-gray-900 mr-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Nueva Orden de Trabajo</h1>
                <p class="text-gray-600 mt-1">Crea una nueva orden de trabajo en el sistema</p>
            </div>
        </div>
    </div>

    <!-- Formulario -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <form action="{{ route('ordenes-trabajo.store') }}" method="POST" id="ordenForm">
            @csrf

            <!-- Información Básica -->
            <div class="space-y-6">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Información de la Orden</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Número OT -->
                        <div>
                            <label for="numero_ot" class="block text-sm font-medium text-gray-700 mb-1">
                                Número de OT <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   name="numero_ot"
                                   id="numero_ot"
                                   value="{{ old('numero_ot', $nuevoNumero) }}"
                                   required
                                   maxlength="20"
                                   placeholder="Ej: OT-0001"
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 @error('numero_ot') border-red-500 @enderror">
                            @error('numero_ot')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Cliente -->
                        <div>
                            <label for="cliente_id" class="block text-sm font-medium text-gray-700 mb-1">
                                Cliente <span class="text-red-500">*</span>
                            </label>
                            <select name="cliente_id"
                                    id="cliente_id"
                                    required
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 @error('cliente_id') border-red-500 @enderror">
                                <option value="">Seleccionar cliente</option>
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

                        <!-- Cotización Asociada -->
                        <div>
                            <label for="cotizacion_id" class="block text-sm font-medium text-gray-700 mb-1">
                                Cotización Asociada
                            </label>
                            <select name="cotizacion_id"
                                    id="cotizacion_id"
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 @error('cotizacion_id') border-red-500 @enderror">
                                <option value="">Seleccionar cotización (opcional)</option>
                                @foreach($cotizaciones as $cotizacion)
                                    <option value="{{ $cotizacion->id }}" {{ old('cotizacion_id') == $cotizacion->id ? 'selected' : '' }}>
                                        {{ $cotizacion->codigo }} - {{ $cotizacion->asunto }} - ${{ number_format($cotizacion->total, 2) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('cotizacion_id')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Asignado a -->
                        <div>
                            <label for="user_id" class="block text-sm font-medium text-gray-700 mb-1">
                                Asignado a <span class="text-red-500">*</span>
                            </label>
                            <select name="user_id"
                                    id="user_id"
                                    required
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 @error('user_id') border-red-500 @enderror">
                                <option value="">Seleccionar usuario</option>
                                @foreach($usuarios as $usuario)
                                    <option value="{{ $usuario->id }}" {{ old('user_id') == $usuario->id ? 'selected' : '' }}>
                                        {{ $usuario->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('user_id')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Descripción -->
                    <div>
                        <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">
                            Descripción del Trabajo <span class="text-red-500">*</span>
                        </label>
                        <textarea name="descripcion"
                                  id="descripcion"
                                  rows="4"
                                  required
                                  maxlength="1000"
                                  placeholder="Describe detalladamente el trabajo a realizar..."
                                  class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 @error('descripcion') border-red-500 @enderror">{{ old('descripcion') }}</textarea>
                        @error('descripcion')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Fechas y Plazos -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Fechas y Plazos</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Fecha Inicio -->
                        <div>
                            <label for="fecha_inicio" class="block text-sm font-medium text-gray-700 mb-1">
                                Fecha de Inicio <span class="text-red-500">*</span>
                            </label>
                            <input type="date"
                                   name="fecha_inicio"
                                   id="fecha_inicio"
                                   value="{{ old('fecha_inicio') }}"
                                   required
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 @error('fecha_inicio') border-red-500 @enderror">
                            @error('fecha_inicio')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Fecha Fin Estimada -->
                        <div>
                            <label for="fecha_fin_estimada" class="block text-sm font-medium text-gray-700 mb-1">
                                Fecha Fin Estimada <span class="text-red-500">*</span>
                            </label>
                            <input type="date"
                                   name="fecha_fin_estimada"
                                   id="fecha_fin_estimada"
                                   value="{{ old('fecha_fin_estimada') }}"
                                   required
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 @error('fecha_fin_estimada') border-red-500 @enderror">
                            @error('fecha_fin_estimada')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Estado y Prioridad -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Estado y Prioridad</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
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

                        <!-- Prioridad -->
                        <div>
                            <label for="prioridad" class="block text-sm font-medium text-gray-700 mb-1">
                                Prioridad <span class="text-red-500">*</span>
                            </label>
                            <select name="prioridad"
                                    id="prioridad"
                                    required
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 @error('prioridad') border-red-500 @enderror">
                                <option value="">Seleccionar prioridad</option>
                                @foreach($prioridades as $key => $label)
                                    <option value="{{ $key }}" {{ old('prioridad', 'media') == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                            @error('prioridad')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Información Adicional -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Información Adicional</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Costo Estimado -->
                        <div>
                            <label for="costo_estimado" class="block text-sm font-medium text-gray-700 mb-1">
                                Costo Estimado
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">$</span>
                                <input type="number"
                                       name="costo_estimado"
                                       id="costo_estimado"
                                       value="{{ old('costo_estimado') }}"
                                       step="0.01"
                                       min="0"
                                       max="99999999.99"
                                       placeholder="0.00"
                                       class="block w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 @error('costo_estimado') border-red-500 @enderror">
                            </div>
                            @error('costo_estimado')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Notas -->
                    <div class="mt-6">
                        <label for="notas" class="block text-sm font-medium text-gray-700 mb-1">
                            Notas Adicionales
                        </label>
                        <textarea name="notas"
                                  id="notas"
                                  rows="3"
                                  maxlength="2000"
                                  placeholder="Notas, observaciones o instrucciones especiales..."
                                  class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 @error('notas') border-red-500 @enderror">{{ old('notas') }}</textarea>
                        @error('notas')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
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
                            <h3 class="text-sm font-medium text-blue-800">Información Importante</h3>
                            <div class="mt-2 text-sm text-blue-700">
                                <ul class="list-disc list-inside space-y-1">
                                    <li>El número de OT debe ser único en el sistema</li>
                                    <li>Las fechas se usarán para calcular la duración estimada del trabajo</li>
                                    <li>La prioridad ayudará a organizar las órdenes de trabajo</li>
                                    <li>Si asocias una cotización, se importará automáticamente la información relevante</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botones -->
            <div class="flex items-center justify-end space-x-4 mt-8 pt-6 border-t border-gray-200">
                <a href="{{ route('ordenes-trabajo.index') }}"
                   class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                    Cancelar
                </a>
                <button type="button"
                        onclick="guardarBorrador()"
                        class="px-4 py-2 text-gray-700 bg-yellow-100 rounded-lg hover:bg-yellow-200 transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4"/>
                    </svg>
                    Guardar Borrador
                </button>
                <button type="submit"
                        class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors duration-200">
                    <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Crear Orden de Trabajo
                </button>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('ordenForm');
    const fechaInicio = document.getElementById('fecha_inicio');
    const fechaFinEstimada = document.getElementById('fecha_fin_estimada');
    const cotizacionSelect = document.getElementById('cotizacion_id');
    const clienteSelect = document.getElementById('cliente_id');

    // Establecer fecha mínima como hoy
    const hoy = new Date().toISOString().split('T')[0];
    fechaInicio.min = hoy;
    fechaFinEstimada.min = hoy;

    // Auto-guardado en localStorage
    function autoGuardar() {
        const formData = new FormData(form);
        const data = {};
        for (let [key, value] of formData.entries()) {
            data[key] = value;
        }
        localStorage.setItem('ordenTrabajoBorrador', JSON.stringify(data));
    }

    // Cargar borrador si existe
    function cargarBorrador() {
        const borrador = localStorage.getItem('ordenTrabajoBorrador');
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

    // Validación de fechas
    fechaInicio.addEventListener('change', function() {
        fechaFinEstimada.min = this.value;
        if (fechaFinEstimada.value && fechaFinEstimada.value < this.value) {
            fechaFinEstimada.value = this.value;
        }
    });

    // Si se selecciona una cotización, auto-completar cliente y descripción
    cotizacionSelect.addEventListener('change', function() {
        if (this.value) {
            // Aquí podrías hacer una llamada AJAX para obtener los datos de la cotización
            // Por ahora solo mostramos un mensaje
            const option = this.options[this.selectedIndex];
            if (option && option.value) {
                console.log('Cotización seleccionada:', option.text);
            }
        }
    });
});

function guardarBorrador() {
    const form = document.getElementById('ordenForm');
    const formData = new FormData(form);
    const data = {};
    for (let [key, value] of formData.entries()) {
        data[key] = value;
    }
    localStorage.setItem('ordenTrabajoBorrador', JSON.stringify(data));

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