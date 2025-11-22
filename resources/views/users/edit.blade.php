@extends('layouts.app')

@section('title', 'Editar Usuario: ' . $user->name)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex items-center">
            <a href="{{ route('users.show', $user) }}"
               class="text-gray-600 hover:text-gray-900 mr-4">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>
            <div>
                <div class="flex items-center space-x-3">
                    <div class="w-8 h-8 bg-primary-100 rounded-full flex items-center justify-center">
                        <span class="text-sm font-medium text-primary-600">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </span>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-900">Editar Usuario</h1>
                    <p class="text-gray-600 mt-1">Modifica la información del usuario</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Formulario -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <form action="{{ route('users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Información Básica -->
            <div class="space-y-6">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 mb-4">Información del Usuario</h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Nombre -->
                        <div>
                            <label for="name" class="block text-sm font-medium text-gray-700 mb-1">
                                Nombre Completo <span class="text-red-500">*</span>
                            </label>
                            <input type="text"
                                   name="name"
                                   id="name"
                                   value="{{ old('name', $user->name) }}"
                                   required
                                   maxlength="255"
                                   placeholder="Ej: Juan Pérez"
                                   class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 @error('name') border-red-500 @enderror">
                            @error('name')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div>
                            <label for="email" class="block text-sm font-medium text-gray-700 mb-1">
                                Email <span class="text-red-500">*</span>
                            </label>
                            <input type="email"
                                   name="email"
                                   id="email"
                                   value="{{ old('email', $user->email) }}"
                                   required
                                   maxlength="255"
                                   placeholder="ejemplo@correo.com"
                                   @if($user->email === 'admin@erp.local')
                                       readonly
                                       class="block w-full px-3 py-2 border border-gray-300 rounded-lg bg-gray-50 text-gray-500"
                                   @else
                                       class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500"
                                   @endif
                                   @error('email') border-red-500 @enderror>
                            @error('email')
                                <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                            @enderror
                            @if($user->email === 'admin@erp.local')
                                <p class="text-xs text-yellow-600 mt-1">El email del administrador no puede ser modificado</p>
                            @endif
                        </div>
                    </div>

                    <!-- Contraseña (Opcional) -->
                    <div class="bg-gray-50 border border-gray-200 rounded-lg p-4">
                        <h4 class="text-sm font-medium text-gray-900 mb-3">Cambiar Contraseña</h4>
                        <p class="text-sm text-gray-600 mb-4">Deja los campos vacíos si no quieres cambiar la contraseña actual</p>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">
                                    Nueva Contraseña
                                </label>
                                <input type="password"
                                       name="password"
                                       id="password"
                                       placeholder="Dejar vacío para no cambiar"
                                       class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 @error('password') border-red-500 @enderror">
                                @error('password')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">
                                    Confirmar Nueva Contraseña
                                </label>
                                <input type="password"
                                       name="password_confirmation"
                                       id="password_confirmation"
                                       placeholder="Repite la nueva contraseña"
                                       class="block w-full px-3 py-2 border border-gray-300 rounded-lg focus:outline-none focus:ring-1 focus:ring-primary-500 focus:border-primary-500 @error('password_confirmation') border-red-500 @enderror">
                                @error('password_confirmation')
                                    <p class="text-sm text-red-600 mt-1">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <!-- Información Adicional -->
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4">
                        <div class="flex items-start">
                            <div class="flex-shrink-0">
                                <svg class="w-5 h-5 text-blue-600 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                </svg>
                            </div>
                            <div class="ml-3">
                                <h3 class="text-sm font-medium text-blue-800">Consideraciones</h3>
                                <div class="mt-2 text-sm text-blue-700">
                                    <ul class="list-disc list-inside space-y-1">
                                        <li>Si cambias el email, el usuario necesitará volver a verificar su cuenta</li>
                                        <li>Si cambias la contraseña, el usuario deberá iniciar sesión con la nueva</li>
                                        @if($user->email === 'admin@erp.local')
                                            <li class="text-yellow-700">El email del administrador no puede ser modificado</li>
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
                    <!-- Ver -->
                    <a href="{{ route('users.show', $user) }}"
                       class="inline-flex items-center px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        Ver Detalles
                    </a>

                    <!-- Volver al Listado -->
                    <a href="{{ route('users.index') }}"
                       class="inline-flex items-center px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 17l-7-7 7-7m8 14l-4-4m0 0L3 15m-3 0l-4-4m0 0l4 4m-4-4v6m0 0h6"/>
                        </svg>
                        Usuarios
                    </a>
                </div>

                <div class="flex items-center space-x-3">
                    <a href="{{ route('users.show', $user) }}"
                       class="px-4 py-2 text-gray-700 bg-gray-100 rounded-lg hover:bg-gray-200 transition-colors duration-200">
                        Cancelar
                    </a>
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
// Validar que las contraseñas coincidan en tiempo real si se están cambiando
document.addEventListener('DOMContentLoaded', function() {
    const password = document.getElementById('password');
    const passwordConfirmation = document.getElementById('password_confirmation');

    function checkPasswords() {
        if (password.value && passwordConfirmation.value) {
            if (password.value !== passwordConfirmation.value) {
                passwordConfirmation.setCustomValidity('Las contraseñas no coinciden');
                passwordConfirmation.classList.add('border-red-500');
                            } else {
                passwordConfirmation.setCustomValidity('');
                passwordConfirmation.classList.remove('border-red-500');
                            }
                        } else {
                            // Si ambos están vacíos, quitar la validación
                            passwordConfirmation.setCustomValidity('');
                            passwordConfirmation.classList.remove('border-red-500');
                        }
                    }

    // Solo validar si ambos campos tienen algo escrito (evitar validaciones innecesarias)
    function checkIfPasswordsHaveValue() {
        if (password.value || passwordConfirmation.value) {
            checkPasswords();
        }
    }

    password.addEventListener('input', checkIfPasswordsHaveValue);
    passwordConfirmation.addEventListener('input', checkIfPasswordsHaveValue);

    // Validar fortaleza de contraseña solo si se está cambiando
    password.addEventListener('input', function() {
        if (this.value.length > 0 && this.value.length < 8) {
            this.setCustomValidity('La contraseña debe tener al menos 8 caracteres');
            this.classList.add('border-red-500');
        } else if (this.value.length >= 8 || this.value.length === 0) {
            this.setCustomValidity('');
            this.classList.remove('border-red-500');
                        }
    });
});
</script>
@endsection