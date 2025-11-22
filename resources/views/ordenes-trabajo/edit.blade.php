@extends('layouts.app')

@section('title', 'Editar Orden de Trabajo: ' . $ordenTrabajo->numero_ot)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <a href="{{ route('ordenes-trabajo.show', $ordenTrabajo) }}"
               class="text-gray-600 hover:text-gray-900 mr-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-primary-100 rounded-full flex items-center justify-center">
                        <span class="text-sm font-medium text-primary-600">
                            OT
                        </span>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Editar Orden de Trabajo</h1>
                        <p class="text-gray-600 mt-1">{{ $ordenTrabajo->numero_ot }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulario -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <form action="{{ route('ordenes-trabajo.update', $ordenTrabajo) }}" method="POST" id="ordenForm">
            @csrf
            @method('PUT')

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
                                   value="{{ old('numero_ot', $ordenTrabajo->numero_ot) }}"
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
                                    <option value="{{ $cliente->id }}" {{ old('cliente_id', $ordenTrabajo->cliente_id) == $cliente->id ? 'selected' : '' }}>
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
                                    <option value="{{ $cotizacion->id }}" {{ old('cotizacion_id', $ordenTrabajo->cotizacion_id) == $cotizacion->id ? 'selected' : '' }}>
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
                                    <option value="{{ $usuario->id }}" {{ old('user_id', $ordenTrabajo->user_id) == $usuario->id ? 'selected' : '' }}>
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
                                  class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 @error('descripcion') border-red-500 @enderror">{{ old('descripcion', $ordenTrabajo->descripcion) }}</textarea>
                        @error('descripcion')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Fechas y Plazos -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Fechas y Plazos</h3>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <!-- Fecha Inicio -->
                        <div>
                            <label for="fecha_inicio" class="block text-sm font-medium text-gray-700 mb-1">
                                Fecha de Inicio <span class="text-red-500">*</span>
                            </label>
                            <input type="date"
                                   name="fecha_inicio"
                                   id="fecha_inicio"
                                   value="{{ old('fecha_inicio', $ordenTrabajo->fecha_inicio?->format('Y-m-d')) }}"
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
                                   value="{{ old('fecha_fin_estimada', $ordenTrabajo->fecha_fin_estimada?->format('Y-m-d')) }}"
                                   required
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 @error('fecha_fin_estimada') border-red-500 @enderror">
                            @error('fecha_fin_estimada')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Fecha Fin Real -->
                        <div>
                            <label for="fecha_fin_real" class="block text-sm font-medium text-gray-700 mb-1">
                                Fecha Fin Real
                            </label>
                            <input type="date"
                                   name="fecha_fin_real"
                                   id="fecha_fin_real"
                                   value="{{ old('fecha_fin_real', $ordenTrabajo->fecha_fin_real?->format('Y-m-d')) }}"
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 @error('fecha_fin_real') border-red-500 @enderror">
                            @error('fecha_fin_real')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                            <p class="text-xs text-gray-500 mt-1">Se llena automáticamente al completar la orden</p>
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
                                    <option value="{{ $key }}" {{ old('estado', $ordenTrabajo->estado) == $key ? 'selected' : '' }}>
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
                                    <option value="{{ $key }}" {{ old('prioridad', $ordenTrabajo->prioridad) == $key ? 'selected' : '' }}>
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
                                       value="{{ old('costo_estimado', $ordenTrabajo->costo_estimado) }}"
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

                        <!-- Costo Real -->
                        <div>
                            <label for="costo_real" class="block text-sm font-medium text-gray-700 mb-1">
                                Costo Real
                            </label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500">$</span>
                                <input type="number"
                                       name="costo_real"
                                       id="costo_real"
                                       value="{{ old('costo_real', $ordenTrabajo->costo_real) }}"
                                       step="0.01"
                                       min="0"
                                       max="99999999.99"
                                       placeholder="0.00"
                                       class="block w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 @error('costo_real') border-red-500 @enderror">
                            </div>
                            @error('costo_real')
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
                                  rows="4"
                                  maxlength="2000"
                                  placeholder="Notas, observaciones o instrucciones especiales..."
                                  class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 @error('notas') border-red-500 @enderror">{{ old('notas', $ordenTrabajo->notas) }}</textarea>
                        @error('notas')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Información Actual -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <h3 class="text-sm font-medium text-blue-800 mb-2">Información Actual</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 text-sm">
                        <div>
                            <span class="text-blue-700">Creado:</span>
                            <p class="text-blue-900">{{ $ordenTrabajo->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <span class="text-blue-700">Última Actualización:</span>
                            <p class="text-blue-900">{{ $ordenTrabajo->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                        @if($ordenTrabajo->duracion_estimada)
                            <div>
                                <span class="text-blue-700">Duración:</span>
                                <p class="text-blue-900">{{ $ordenTrabajo->duracion_estimada }} días</p>
                            </div>
                        @endif
                        @if($ordenTrabajo->esta_atrasada)
                            <div>
                                <span class="text-blue-700">Estado:</span>
                                <p class="text-red-700 font-medium">⚠️ Atrasada</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Botones -->
            <div class="flex items-center justify-between mt-8 pt-6 border-t border-gray-200">
                <div class="flex items-center space-x-3">
                    <!-- Ver -->
                    <a href="{{ route('ordenes-trabajo.show', $ordenTrabajo) }}"
                       class="inline-flex items-center px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        Ver Detalles
                    </a>

                    <!-- Volver al Listado -->
                    <a href="{{ route('ordenes-trabajo.index') }}"
                       class="inline-flex items-center px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-7-7 7-7m8 14l-4-4m0 0L3 15m-3 0l-4-4m0 0l4 4m-4-4v6m0 0h6"/>
                        </svg>
                        Órdenes
                    </a>
                </div>

                <div class="flex items-center space-x-3">
                    <a href="{{ route('ordenes-trabajo.show', $ordenTrabajo) }}"
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
    const form = document.getElementById('ordenForm');
    const fechaInicio = document.getElementById('fecha_inicio');
    const fechaFinEstimada = document.getElementById('fecha_fin_estimada');
    const fechaFinReal = document.getElementById('fecha_fin_real');
    const estadoSelect = document.getElementById('estado');

    // Establecer fechas mínimas
    fechaInicio.min = '2000-01-01';
    fechaFinEstimada.min = '2000-01-01';
    fechaFinReal.min = '2000-01-01';

    // Validación de fechas
    fechaInicio.addEventListener('change', function() {
        fechaFinEstimada.min = this.value;
        if (fechaFinEstimada.value && fechaFinEstimada.value < this.value) {
            fechaFinEstimada.value = this.value;
        }
        fechaFinReal.min = this.value;
        if (fechaFinReal.value && fechaFinReal.value < this.value) {
            fechaFinReal.value = '';
        }
    });

    fechaFinEstimada.addEventListener('change', function() {
        fechaFinReal.min = this.value;
        if (fechaFinReal.value && fechaFinReal.value < this.value) {
            fechaFinReal.value = '';
        }
    });

    // Auto-gestionar fecha fin real según estado
    estadoSelect.addEventListener('change', function() {
        if (this.value === 'completada') {
            if (!fechaFinReal.value) {
                fechaFinReal.value = new Date().toISOString().split('T')[0];
            }
        } else if (this.value !== 'completada' && fechaFinReal.value) {
            if (confirm('¿Desea limpiar la fecha de finalización real al cambiar el estado?')) {
                fechaFinReal.value = '';
            }
        }
    });

    // Confirmar antes de enviar si hay cambios importantes
    form.addEventListener('submit', function(e) {
        const estadoActual = '{{ $ordenTrabajo->estado }}';
        const estadoNuevo = estadoSelect.value;

        if (estadoActual === 'completada' && estadoNuevo !== 'completada') {
            if (!confirm('¿Está seguro de cambiar el estado de "completada" a otro estado? Esto podría afectar informes y estadísticas.')) {
                e.preventDefault();
            }
        }
    });
});
</script>
@endsection