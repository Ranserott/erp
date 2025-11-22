@extends('layouts.app')

@section('title', 'Editar Proveedor: ' . $proveedor->nombre)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <a href="{{ route('proveedores.show', $proveedor) }}"
               class="text-gray-600 hover:text-gray-900 mr-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-primary-100 rounded-full flex items-center justify-center">
                        <span class="text-sm font-medium text-primary-600">
                            {{ strtoupper(substr($proveedor->nombre, 0, 2)) }}
                        </span>
                    </div>
                    <div>
                        <h1 class="text-2xl font-bold text-gray-900">Editar Proveedor</h1>
                        <p class="text-gray-600 mt-1">{{ $proveedor->nombre }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulario -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <form action="{{ route('proveedores.update', $proveedor) }}" method="POST">
            @csrf
            @method('PUT')

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
                                   value="{{ old('nombre', $proveedor->nombre) }}"
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
                                   value="{{ old('rut', $proveedor->rut) }}"
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
                                   value="{{ old('email', $proveedor->email) }}"
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
                                   value="{{ old('telefono', $proveedor->telefono) }}"
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
                                    <option value="{{ $tipo }}" {{ old('tipo_rubro', $proveedor->tipo_rubro) == $tipo ? 'selected' : '' }}>
                                        {{ $tipo }}
                                    </option>
                                @endforeach
                                <option value="Otro" {{ old('tipo_rubro', $proveedor->tipo_rubro) == 'Otro' ? 'selected' : '' }}>Otro</option>
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
                                  class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 @error('direccion') border-red-500 @enderror">{{ old('direccion', $proveedor->direccion) }}</textarea>
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
                              class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 @error('notas') border-red-500 @enderror">{{ old('notas', $proveedor->notas) }}</textarea>
                    @error('notas')
                        <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                    @enderror
                    <p class="text-sm text-gray-500 mt-1">{{ 2000 - strlen(old('notas', $proveedor->notas ?? '')) }} caracteres restantes</p>
                </div>

                <!-- Información Actual -->
                <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                    <h3 class="text-sm font-medium text-blue-800 mb-2">Información Actual</h3>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 text-sm">
                        <div>
                            <span class="text-blue-700">Creado:</span>
                            <p class="text-blue-900">{{ $proveedor->created_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <span class="text-blue-700">Última Actualización:</span>
                            <p class="text-blue-900">{{ $proveedor->updated_at->format('d/m/Y H:i') }}</p>
                        </div>
                        <div>
                            <span class="text-blue-700">ID Interno:</span>
                            <p class="text-blue-900">#{{ $proveedor->id }}</p>
                        </div>
                        @php
                            $pagosCount = $proveedor->calendarioPagos()->count();
                        @endphp
                        <div>
                            <span class="text-blue-700">Pagos Asociados:</span>
                            <p class="text-blue-900">{{ $pagosCount }}</p>
                        </div>
                    </div>
                    @if($pagosCount > 0)
                        <p class="text-xs text-blue-700 mt-2">⚠️ Este proveedor tiene pagos asociados. Los cambios afectarán la información mostrada en dichos pagos.</p>
                    @endif
                </div>
            </div>

            <!-- Botones -->
            <div class="flex items-center justify-between mt-8 pt-6 border-t border-gray-200">
                <div class="flex items-center space-x-3">
                    <!-- Ver -->
                    <a href="{{ route('proveedores.show', $proveedor) }}"
                       class="inline-flex items-center px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        Ver Detalles
                    </a>

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
                    <a href="{{ route('proveedores.show', $proveedor) }}"
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
    const form = document.querySelector('form');
    const tipoRubroSelect = document.getElementById('tipo_rubro');

    // Confirmar antes de enviar si hay cambios importantes
    form.addEventListener('submit', function(e) {
        const nombreActual = '{{ $proveedor->nombre }}';
        const nombreNuevo = document.getElementById('nombre').value;

        if (nombreActual !== nombreNuevo) {
            if (!confirm('¿Está seguro de cambiar el nombre del proveedor? Esto afectará cómo se mostrará en todos los pagos asociados.')) {
                e.preventDefault();
            }
        }
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

    // Contador de caracteres para notas
    const notasTextarea = document.getElementById('notas');
    const updateCharCount = () => {
        const remaining = 2000 - notasTextarea.value.length;
        const counter = notasTextarea.parentElement.querySelector('.text-gray-500');
        if (counter) {
            counter.textContent = `${remaining} caracteres restantes`;
        }
    };

    notasTextarea.addEventListener('input', updateCharCount);
    updateCharCount();
});
</script>
@endsection