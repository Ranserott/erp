@extends('layouts.app')

@section('title', 'Nueva Cotización')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <a href="{{ route('cotizaciones.index') }}"
               class="text-gray-600 hover:text-gray-900 mr-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Nueva Cotización</h1>
                <p class="text-gray-600 mt-1">Crea una nueva cotización para tus clientes</p>
            </div>
        </div>
    </div>

    <!-- Formulario -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <form action="{{ route('cotizaciones.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

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
                                   value="{{ $codigo }}"
                                   readonly
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-500">
                            <p class="text-xs text-gray-500 mt-1">Código generado automáticamente</p>
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
                                    <option value="{{ $cliente->id }}" {{ old('cliente_id') == $cliente->id ? 'selected' : '' }}>
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
                               value="{{ old('asunto') }}"
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
                                  class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 @error('descripcion') border-red-500 @enderror">{{ old('descripcion') }}</textarea>
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
                                       value="{{ old('monto') }}"
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
                                   value="{{ old('vigencia', now()->addDays(15)->format('Y-m-d')) }}"
                                   required
                                   min="{{ now()->tomorrow()->format('Y-m-d') }}"
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 @error('vigencia') border-red-500 @enderror">
                            @error('vigencia')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
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
                                  class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 @error('condiciones') border-red-500 @enderror">{{ old('condiciones') }}</textarea>
                        @error('condiciones')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                        <p class="text-xs text-gray-500 mt-1">Describe los términos de pago, garantías, plazos de entrega, etc.</p>
                    </div>
                </div>

                <!-- Vista Previa -->
                <div class="border-t border-gray-200 pt-6">
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
                                        <li>El código de cotización se genera automáticamente</li>
                                        <li>Las cotizaciones se crearán con estado "Pendiente"</li>
                                        <li>Podrás generar un PDF una vez creada la cotización</li>
                                        <li>Podrás duplicar cotizaciones para agilizar el proceso</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Botones -->
            <div class="flex items-center justify-end space-x-4 mt-8 pt-6 border-t border-gray-200">
                <a href="{{ route('cotizaciones.index') }}"
                   class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                    Cancelar
                </a>
                <button type="submit"
                        class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors duration-200">
                    Crear Cotización
                </button>
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

// Autoguardar en localStorage (opcional)
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const inputs = form.querySelectorAll('input, textarea, select');

    // Cargar datos guardados
    inputs.forEach(input => {
        const savedValue = localStorage.getItem('cotizacion_draft_' + input.name);
        if (savedValue && input.type !== 'file') {
            input.value = savedValue;
        }
    });

    // Guardar mientras se escribe
    inputs.forEach(input => {
        if (input.type !== 'file') {
            input.addEventListener('input', function() {
                localStorage.setItem('cotizacion_draft_' + input.name, input.value);
            });
        }
    });

    // Limpiar datos al enviar
    form.addEventListener('submit', function() {
        inputs.forEach(input => {
            localStorage.removeItem('cotizacion_draft_' + input.name);
        });
    });
});
</script>
@endsection