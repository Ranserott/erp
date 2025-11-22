@extends('layouts.app')

@section('title', 'Nuevo Proveedor')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <a href="{{ route('proveedores.index') }}"
               class="text-gray-600 hover:text-gray-900 mr-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <h1 class="text-2xl font-bold text-gray-900">Nuevo Proveedor</h1>
                <p class="text-gray-600 mt-1">Agrega un nuevo proveedor al sistema</p>
            </div>
        </div>
    </div>

    <!-- Formulario -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <form action="{{ route('proveedores.store') }}" method="POST">
            @csrf

            <!-- Información Básica -->
            <div class="space-y-6">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Información del Proveedor</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nombre -->
                        <div>
                            <label for="nombre" class="block text-sm font-medium text-gray-700 mb-1">
                                Nombre del Proveedor <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   name="nombre"
                                   id="nombre"
                                   value="{{ old('nombre') }}"
                                   required
                                   maxlength="255"
                                   placeholder="Nombre completo del proveedor"
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 @error('nombre') border-red-500 @enderror">
                            @error('nombre')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- RUT -->
                        <div>
                            <label for="rut" class="block text-sm font-medium text-gray-700 mb-1">
                                RUT <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   name="rut"
                                   id="rut"
                                   value="{{ old('rut') }}"
                                   required
                                   maxlength="20"
                                   placeholder="12.345.678-9"
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 @error('rut') border-red-500 @enderror">
                            @error('rut')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                Correo Electrónico <span class="text-red-500">*</span>
                            </label>
                            <input type="email"
                                   name="email"
                                   id="email"
                                   value="{{ old('email') }}"
                                   required
                                   maxlength="255"
                                   placeholder="proveedor@ejemplo.com"
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 @error('email') border-red-500 @enderror">
                            @error('email')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Teléfono -->
                        <div>
                            <label for="telefono" class="block text-sm font-medium text-gray-700 mb-1">
                                Teléfono <span class="text-red-500">*</span>
                            </label>
                            <input type="tel"
                                   name="telefono"
                                   id="telefono"
                                   value="{{ old('telefono') }}"
                                   required
                                   maxlength="20"
                                   placeholder="+56 9 1234 5678"
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 @error('telefono') border-red-500 @enderror">
                            @error('telefono')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Tipo de Rubro -->
                        <div>
                            <label for="tipo_rubro" class="block text-sm font-medium text-gray-700 mb-1">
                                Tipo de Rubro <span class="text-red-500">*</span>
                            </label>
                            <select name="tipo_rubro"
                                    id="tipo_rubro"
                                    required
                                    class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 @error('tipo_rubro') border-red-500 @enderror">
                                <option value="">Seleccionar rubro</option>
                                @foreach($tiposRubro as $tipo)
                                    <option value="{{ $tipo }}" {{ old('tipo_rubro') == $tipo ? 'selected' : '' }}>
                                        {{ $tipo }}
                                    </option>
                                @endforeach
                                <option value="Otro" {{ old('tipo_rubro') == 'Otro' ? 'selected' : '' }}>Otro</option>
                            </select>
                            @error('tipo_rubro')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Dirección -->
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Dirección</h3>
                    <div>
                        <label for="direccion" class="block text-sm font-medium text-gray-700 mb-1">
                            Dirección Completa <span class="text-red-500">*</span>
                        </label>
                        <textarea name="direccion"
                                  id="direccion"
                                  rows="3"
                                  required
                                  maxlength="500"
                                  placeholder="Calle, número, ciudad, región..."
                                  class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 @error('direccion') border-red-500 @enderror">{{ old('direccion') }}</textarea>
                        @error('direccion')
                            <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                </div>

                <!-- Notas Adicionales -->
                <div>
                    <label for="notas" class="block text-sm font-medium text-gray-700 mb-1">
                        Notas Adicionales
                    </label>
                    <textarea name="notas"
                              id="notas"
                              rows="4"
                              maxlength="2000"
                              placeholder="Información adicional importante sobre el proveedor..."
                              class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 @error('notas') border-red-500 @enderror">{{ old('notas') }}</textarea>
                    @error('notas')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-sm text-gray-500 mt-1">{{ 2000 - strlen(old('notas')) }} caracteres restantes</p>
                </div>
            </div>

            <!-- Botones -->
            <div class="flex items-center justify-between mt-8 pt-6 border-t border-gray-200">
                <div class="flex items-center space-x-3">
                    <!-- Volver al Listado -->
                    <a href="{{ route('proveedores.index') }}"
                       class="inline-flex items-center px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-7-7 7-7m8 14l-4-4m0 0L3 15m-3 0l-4-4m0 0l4 4m-4-4v6m0 0h6"/>
                        </svg>
                        Proveedores
                    </a>
                </div>

                <div class="flex items-center space-x-3">
                    <a href="{{ route('proveedores.index') }}"
                       class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                        Cancelar
                    </a>
                    <button type="submit"
                            class="px-6 py-2 bg-primary-600 text-white rounded-lg hover:bg-primary-700 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Guardar Proveedor
                    </button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const tipoRubroSelect = document.getElementById('tipo_rubro');

    // Auto-guardado con localStorage
    const autoSave = () => {
        const formData = new FormData(form);
        const data = {};
        formData.forEach((value, key) => {
            data[key] = value;
        });
        localStorage.setItem('proveedorFormData', JSON.stringify(data));
    };

    // Cargar datos guardados
    const savedData = localStorage.getItem('proveedorFormData');
    if (savedData) {
        try {
            const data = JSON.parse(savedData);
            Object.keys(data).forEach(key => {
                const field = form.querySelector(`[name="${key}"]`);
                if (field) {
                    field.value = data[key];
                }
            });
        } catch (e) {
            console.error('Error loading saved data:', e);
        }
    }

    // Auto-guardar al cambiar campos
    form.addEventListener('input', autoSave);
    form.addEventListener('change', autoSave);

    // Limpiar localStorage al enviar
    form.addEventListener('submit', function(e) {
        localStorage.removeItem('proveedorFormData');
    });

    // Formateo de RUT (chileno)
    const rutInput = document.getElementById('rut');
    rutInput.addEventListener('input', function(e) {
        let value = e.target.value.replace(/\./g, '').replace('-', '');
        if (value.length > 1) {
            const body = value.slice(0, -1);
            const dv = value.slice(-1);
            let formattedRut = '';

            // Formatear con puntos y guión
            for (let i = body.length - 1, count = 0; i >= 0; i--, count++) {
                formattedRut = body[i] + formattedRut;
                if (count === 2 && i !== 0) {
                    formattedRut = '.' + formattedRut;
                    count = -1;
                }
            }
            formattedRut += '-' + dv;
            e.target.value = formattedRut;
        }
    });

    // Validación de email
    const emailInput = document.getElementById('email');
    emailInput.addEventListener('blur', function(e) {
        const email = e.target.value;
        const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (email && !emailRegex.test(email)) {
            e.target.setCustomValidity('Por favor ingresa un correo electrónico válido');
        } else {
            e.target.setCustomValidity('');
        }
    });
});
</script>
@endsection