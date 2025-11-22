@extends('layouts.app')

@section('title', 'Editar Cotización ' . $cotizacion->codigo)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <a href="{{ route('cotizaciones.show', $cotizacion) }}"
               class="text-gray-600 hover:text-gray-900 mr-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <div class="flex items-center space-x-3">
                    <h1 class="text-2xl font-bold text-gray-900">Editar Cotización</h1>
                    <span class="text-gray-500">{{ $cotizacion->codigo }}</span>
                </div>
                <p class="text-gray-600 mt-1">Modifica los detalles de la cotización</p>
            </div>
        </div>
    </div>

    <!-- Alerta de edición -->
    @if($cotizacion->estado === 'aprobada')
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4">
            <div class="flex items-start">
                <div class="flex-shrink-0">
                    <svg class="w-5 h-5 text-yellow-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 15.5c-.77.833.192 2.5 1.732 2.5z"/>
                    </svg>
                </div>
                <div class="ml-3">
                    <h3 class="text-sm font-medium text-yellow-800">Cotización aprobada</h3>
                    <div class="mt-2 text-sm text-yellow-700">
                        Esta cotización ya fue aprobada por el cliente. Si realizas cambios, notifica al cliente sobre las modificaciones.
                    </div>
                </div>
            </div>
        </div>
    @endif

    <!-- Formulario -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <form action="{{ route('cotizaciones.update', $cotizacion) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <!-- Información General -->
            <div class="space-y-6">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Información General</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Código (solo lectura) -->
                        <div>
                            <label for="codigo" class="block text-sm font-medium text-gray-700 mb-1">
                                Código de Cotización
                            </label>
                            <input type="text"
                                   id="codigo"
                                   value="{{ $cotizacion->codigo }}"
                                   readonly
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-500">
                            <p class="text-xs text-gray-500 mt-1">Código no modificable</p>
                        </div>

                        <!-- Cliente -->
                        <div>
                            <label for="cliente_id" class="block text-sm font-medium text-gray-700 mb-1">
                                Cliente <span class="text-red-500">*</span>
                            </label>
                            <select name="cliente_id"
                                    id="cliente_id"
                                    required
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 @error('cliente_id') border-red-500 @enderror">
                                <option value="">Seleccionar cliente</option>
                                @foreach($clientes as $cliente)
                                    <option value="{{ $cliente->id }}" {{ old('cliente_id', $cotizacion->cliente_id) == $cliente->id ? 'selected' : '' }}>
                                        {{ $cliente->nombre }} - {{ $cliente->email }}
                                    </option>
                                @endforeach
                            </select>
                            @error('cliente_id')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>

                    <!-- Asunto -->
                    <div class="mt-6">
                        <label for="asunto" class="block text-sm font-medium text-gray-700 mb-1">
                            Asunto <span class="text-red-500">*</span>
                        </label>
                        <input type="text"
                               name="asunto"
                               id="asunto"
                               value="{{ old('asunto', $cotizacion->asunto) }}"
                               required
                               maxlength="255"
                               placeholder="Ej: Desarrollo de sitio web corporativo"
                               class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 @error('asunto') border-red-500 @enderror">
                        @error('asunto')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Descripción -->
                    <div class="mt-6">
                        <label for="descripcion" class="block text-sm font-medium text-gray-700 mb-1">
                            Descripción del Proyecto <span class="text-red-500">*</span>
                        </label>
                        <textarea name="descripcion"
                                  id="descripcion"
                                  rows="6"
                                  required
                                  placeholder="Describe detalladamente los servicios o productos a cotizar..."
                                  class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 @error('descripcion') border-red-500 @enderror">{{ old('descripcion', $cotizacion->descripcion) }}</textarea>
                        @error('descripcion')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Detalles Financieros -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Detalles Financieros</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Monto -->
                        <div>
                            <label for="monto" class="block text-sm font-medium text-gray-700 mb-1">
                                Monto Total <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500">$</span>
                                </div>
                                <input type="number"
                                       name="monto"
                                       id="monto"
                                       value="{{ old('monto', $cotizacion->monto) }}"
                                       required
                                       min="0"
                                       step="0.01"
                                       placeholder="0.00"
                                       class="block w-full pl-8 pr-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 @error('monto') border-red-500 @enderror">
                            </div>
                            @error('monto')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Vigencia -->
                        <div>
                            <label for="vigencia" class="block text-sm font-medium text-gray-700 mb-1">
                                Fecha de Vigencia <span class="text-red-500">*</span>
                            </label>
                            <input type="date"
                                   name="vigencia"
                                   id="vigencia"
                                   value="{{ old('vigencia', $cotizacion->vigencia->format('Y-m-d')) }}"
                                   required
                                   min="{{ now()->tomorrow()->format('Y-m-d') }}"
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 @error('vigencia') border-red-500 @enderror">
                            @error('vigencia')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                            @if($cotizacion->vigencia->isPast())
                                <p class="text-xs text-orange-600 mt-1">⚠️ Esta fecha ya pasó</p>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- Estado -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Estado de la Cotización</h3>

                    <div>
                        <label for="estado" class="block text-sm font-medium text-gray-700 mb-1">
                            Estado Actual
                        </label>
                        <select name="estado"
                                id="estado"
                                class="block w-full px-3 py-2 border border-gray-300 rounded-lg bg-white focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 @error('estado') border-red-500 @enderror">
                            <option value="pendiente" {{ old('estado', $cotizacion->estado) == 'pendiente' ? 'selected' : '' }}>Pendiente</option>
                            <option value="aprobada" {{ old('estado', $cotizacion->estado) == 'aprobada' ? 'selected' : '' }}>Aprobada</option>
                            <option value="rechazada" {{ old('estado', $cotizacion->estado) == 'rechazada' ? 'selected' : '' }}>Rechazada</option>
                            <option value="vencida" {{ old('estado', $cotizacion->estado) == 'vencida' ? 'selected' : '' }}>Vencida</option>
                        </select>
                        @error('estado')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Condiciones y Términos -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Condiciones y Términos</h3>

                    <!-- Condiciones -->
                    <div>
                        <label for="condiciones" class="block text-sm font-medium text-gray-700 mb-1">
                            Condiciones Comerciales
                        </label>
                        <textarea name="condiciones"
                                  id="condiciones"
                                  rows="4"
                                  placeholder="Ej: 50% anticipo, 50% contra entrega. Garantía de 6 meses. Soporte técnico incluido por 3 meses."
                                  class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 @error('condiciones') border-red-500 @enderror">{{ old('condiciones', $cotizacion->condiciones) }}</textarea>
                        @error('condiciones')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">Describe los términos de pago, garantías, plazos de entrega, etc.</p>
                    </div>
                </div>

                <!-- Historial de cambios -->
                <div class="border-t border-gray-200 pt-6">
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="w-5 h-5 text-gray-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-gray-800">Información de Creación</h3>
                                <div class="mt-2 text-sm text-gray-700">
                                    <ul class="list-disc list-inside space-y-1">
                                        <li>Creada el {{ $cotizacion->created_at->format('d/m/Y H:i') }}</li>
                                        <li>Creada por {{ $cotizacion->user->name }}</li>
                                        <li>Última actualización {{ $cotizacion->updated_at->format('d/m/Y H:i') }}</li>
                                        @if($cotizacion->estado === 'aprobada')
                                            <li class="text-green-700 font-medium">⚠️ Esta cotización está aprobada - notifica cualquier cambio al cliente</li>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botones -->
            <div class="flex items-center justify-between mt-8 pt-6 border-t border-gray-200">
                <div class="flex items-center space-x-3">
                    <!-- Ver cotización -->
                    <a href="{{ route('cotizaciones.show', $cotizacion) }}"
                       class="inline-flex items-center px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        Ver Cotización
                    </a>

                    <!-- Duplicar -->
                    <form action="{{ route('cotizaciones.duplicar', $cotizacion) }}" method="POST" class="inline">
                        @csrf
                        <button type="submit"
                                class="inline-flex items-center px-4 py-2 text-purple-700 bg-purple-100 rounded-lg hover:bg-purple-200 transition-colors duration-200"
                                onclick="return confirm('¿Deseas duplicar esta cotización?')">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/>
                            </svg>
                            Duplicar
                        </button>
                    </form>
                </div>

                <div class="flex items-center space-x-3">
                    <!-- Cancelar -->
                    <a href="{{ route('cotizaciones.show', $cotizacion) }}"
                       class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                        Cancelar
                    </a>
                    <!-- Guardar -->
                    <button type="submit"
                            class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors duration-200">
                        Guardar Cambios
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
// Formatear moneda mientras se escribe
document.getElementById('monto').addEventListener('input', function(e) {
    // Permitir solo números y punto decimal
    let value = e.target.value;
    value = value.replace(/[^\d.]/g, '');

    // Solo permitir un punto decimal
    let parts = value.split('.');
    if (parts.length > 2) {
        parts = [parts[0], parts.slice(1).join('')];
    }

    // Limitar decimales a 2
    if (parts[1] && parts[1].length > 2) {
        parts[1] = parts[1].substring(0, 2);
    }

    e.target.value = parts.join('.');
});

// Validar que la fecha de vigencia sea futura
document.getElementById('vigencia').addEventListener('change', function(e) {
    const selectedDate = new Date(e.target.value);
    const tomorrow = new Date();
    tomorrow.setDate(tomorrow.getDate() + 1);

    if (selectedDate < tomorrow) {
        e.target.setCustomValidity('La fecha de vigencia debe ser posterior a hoy');
    } else {
        e.target.setCustomValidity('');
    }
});

// Contador de caracteres para el asunto
document.getElementById('asunto').addEventListener('input', function(e) {
    const maxLength = 255;
    const currentLength = e.target.value.length;

    if (currentLength > maxLength * 0.9) {
        e.target.style.borderColor = '#f59e0b';
    } else {
        e.target.style.borderColor = '';
    }
});

// Alerta al cambiar el estado si está aprobada
document.getElementById('estado').addEventListener('change', function(e) {
    const currentState = '{{ $cotizacion->estado }}';
    const newState = e.target.value;

    if (currentState === 'aprobada' && newState !== 'aprobada') {
        if (!confirm('¿Estás seguro de cambiar el estado de "aprobada" a "' + e.target.options[e.target.selectedIndex].text + '"? Esta acción podría tener implicaciones contractuales.')) {
            e.target.value = currentState;
        }
    }
});

// Confirmar antes de salir si hay cambios no guardados
let formChanged = false;
const form = document.querySelector('form');
const inputs = form.querySelectorAll('input, textarea, select');

inputs.forEach(input => {
    input.addEventListener('change', () => {
        formChanged = true;
    });
});

window.addEventListener('beforeunload', function(e) {
    if (formChanged) {
        e.preventDefault();
        e.returnValue = 'Hay cambios no guardados. ¿Estás seguro de salir?';
        return e.returnValue;
    }
});

form.addEventListener('submit', function() {
    formChanged = false;
});
</script>
@endsection