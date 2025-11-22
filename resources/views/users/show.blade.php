@extends('layouts.app')

@section('title', 'Usuario: ' . $user->name)

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between">
            <div>
                <div class="flex items-center space-x-3">
                    <div class="w-10 h-10 bg-primary-100 rounded-full flex items-center justify-center">
                        <span class="text-sm font-medium text-primary-600">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </span>
                    </div>
                    <h1 class="text-2xl font-bold text-gray-900">{{ $user->name }}</h1>
                    @if($user->email === 'admin@erp.local')
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                            ADMINISTRADOR
                        </span>
                    @endif
                </div>
                <p class="text-gray-600 mt-1">{{ $user->email }}</p>
                <p class="text-sm text-gray-500 mt-1">
                    Registrado el {{ $user->created_at->format('d/m/Y H:i') }}
                    @if($user->email_verified_at)
                        | Verificado el {{ $user->email_verified_at->format('d/m/Y') }}
                    @endif
                </p>
            </div>
            <div class="flex items-center space-x-3 mt-4 sm:mt-0">
                <!-- Editar -->
                <a href="{{ route('users.edit', $user) }}"
                   class="inline-flex items-center px-3 py-2 text-blue-700 bg-blue-100 rounded-lg hover:bg-blue-200 transition-colors duration-200">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                    </svg>
                    Editar
                </a>

                <!-- Eliminar (solo si no es admin y no es el usuario actual) -->
                @if($user->email !== 'admin@erp.local' && $user->id !== Auth::id())
                    <form action="{{ route('users.destroy', $user) }}" method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="inline-flex items-center px-3 py-2 text-red-700 bg-red-100 rounded-lg hover:bg-red-200 transition-colors duration-200"
                                onclick="return confirm('¿Estás seguro de eliminar este usuario? Esta acción no se puede deshacer.')">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3m4 6h2m-6 0h6"/>
                            </svg>
                            Eliminar
                        </button>
                    </form>
                @endif
            </div>
        </div>
    </div>

    <!-- Información Detallada -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Información Principal -->
        <div class="lg:col-span-2 space-y-6">
            <!-- Estado de la Cuenta -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Estado de la Cuenta</h2>

                <div class="space-y-4">
                    <!-- Estado de Verificación -->
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-gray-900">Email Verificado</h3>
                            @if($user->email_verified_at)
                                <p class="text-sm text-gray-500">Verificado el {{ $user->email_verified_at->format('d/m/Y H:i') }}</p>
                            @else
                                <p class="text-sm text-gray-500">No verificado</p>
                            @endif
                        </div>
                        <div>
                            @if($user->email_verified_at)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-green-100 text-green-800">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Verificado
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-red-100 text-red-800">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                    </svg>
                                    Pendiente
                                </span>
                            @endif
                        </div>
                    </div>

                    <!-- Rol del Usuario -->
                    <div class="flex items-center justify-between">
                        <div>
                            <h3 class="text-sm font-medium text-gray-900">Rol</h3>
                            <p class="text-sm text-gray-500">
                                @if($user->email === 'admin@erp.local')
                                    Administrador del Sistema
                                @else
                                    Usuario Regular
                                @endif
                            </p>
                        </div>
                        <div>
                            @if($user->email === 'admin@erp.local')
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-yellow-100 text-yellow-800">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                                    </svg>
                                    Admin
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium bg-gray-100 text-gray-800">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                    </svg>
                                    Usuario
                                </span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actividad Reciente -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Información de Registro</h2>

                <div class="space-y-3">
                    <div class="flex justify-between">
                        <span class="text-sm font-medium text-gray-700">Fecha de Registro:</span>
                        <span class="text-sm text-gray-900">{{ $user->created_at->format('d/m/Y H:i:s') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-sm font-medium text-gray-700">ID de Usuario:</span>
                        <span class="text-sm text-gray-900">#{{ $user->id }}</span>
                    </div>
                    @if($user->updated_at != $user->created_at)
                        <div class="flex justify-between">
                            <span class="text-sm font-medium text-gray-700">Última Actualización:</span>
                            <span class="text-sm text-gray-900">{{ $user->updated_at->format('d/m/Y H:i:s') }}</span>
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Acciones Rápidas -->
        <div class="space-y-6">
            <!-- Acciones de Seguridad -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Acciones de Seguridad</h2>

                <div class="space-y-3">
                    <!-- Cambiar Contraseña -->
                    @if($user->id === Auth::id())
                        <button onclick="confirmarCambioContraseña()"
                                class="w-full px-4 py-2 text-orange-700 bg-orange-100 rounded-lg hover:bg-orange-200 transition-colors duration-200">
                            <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a3 3 0 11-6 0 3 3 0 016 0zM12.828 1H9.172a3 3 0 00-.485.613l3.828 3.828A3 3 0 0115.828 1z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.828 3l3.414 3.414L9.172 9.828 12.586 6.414A3 3 0 0111.828 3z"/>
                            </svg>
                            Cambiar Contraseña
                        </button>
                    @endif

                    <!-- Reenviar Email de Verificación -->
                    @if(!$user->email_verified_at && $user->id === Auth::id())
                        <form method="POST" action="{{ route('verification.send') }}">
                            @csrf
                            <button type="submit"
                                    class="w-full px-4 py-2 text-green-700 bg-green-100 rounded-lg hover:bg-green-200 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-2 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 2.2l5.64-5.64a2 2 0 012.22-2.2L3 8m0 0l5.64 5.64a2 2 0 002.22 2.2l-5.64 5.64a2 2 0 01-2.22-2.2L3 8z"/>
                                </svg>
                                Reenviar Verificación
                            </button>
                        </form>
                    @endif
                </div>
            </div>

            <!-- Estadísticas -->
            <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
                <h2 class="text-lg font-semibold text-gray-900 mb-4">Estadísticas</h2>

                <div class="space-y-3 text-sm">
                    <div class="flex justify-between">
                        <span class="text-gray-600">ID del Sistema:</span>
                        <span class="text-gray-900">#{{ $user->id }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">Dominio:</span>
                        <span class="text-gray-900">{{ parse_url(url('/'), PHP_URL_HOST) }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-gray-600">IP de Registro:</span>
                        <span class="text-gray-900">No disponible</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function confirmarCambioContraseña() {
    if (confirm('¿Estás seguro de que quieres cambiar la contraseña de tu cuenta?')) {
        window.location.href = '/profile';
    }
}
</script>
@endsection