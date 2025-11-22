@extends('layouts.app')

@section('title', 'Editar Cliente')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
        <nav class="flex items-center space-x-2 text-sm text-gray-500 mb-4">
            <a href="{{ route('clientes.index') }}" class="hover:text-gray-700">Clientes</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span>{{ $cliente->nombre_empresa }}</span>
        </nav>
        <h1 class="text-3xl font-bold text-gray-900">Editar Cliente</h1>
        <p class="text-gray-600 mt-1">Actualiza la información del cliente</p>
    </div>

    <x-card>
        <form action="{{ route('clientes.update', $cliente) }}" method="POST" class="space-y-6">
            @csrf
            @method('PUT')

            <!-- Información de la Empresa -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">
                    Información de la Empresa
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-input
                        name="nombre_empresa"
                        label="Nombre de la Empresa"
                        placeholder="Ej: Empresa S.A."
                        :value="$cliente->nombre_empresa"
                        required
                        :error="$errors->first('nombre_empresa')"
                    />

                    <x-input
                        name="rut_cliente"
                        label="RUT"
                        placeholder="Ej: 12.345.678-9"
                        :value="$cliente->rut_cliente"
                        required
                        :error="$errors->first('rut_cliente')"
                    />
                </div>

                <div class="mt-6">
                    <x-input
                        name="direccion"
                        label="Dirección"
                        placeholder="Ej: Av. Principal #123, Santiago"
                        :value="$cliente->direccion"
                        required
                        :error="$errors->first('direccion')"
                    />
                </div>
            </div>

            <!-- Información de Contacto -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">
                    Información de Contacto
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-input
                        name="contacto_nombre"
                        label="Nombre del Contacto"
                        placeholder="Ej: Juan Pérez"
                        :value="$cliente->contacto_nombre"
                        required
                        :error="$errors->first('contacto_nombre')"
                    />

                    <x-input
                        name="contacto_telefono"
                        label="Teléfono"
                        placeholder="Ej: +56 9 1234 5678"
                        :value="$cliente->contacto_telefono"
                        required
                        :error="$errors->first('contacto_telefono')"
                    />
                </div>

                <div class="mt-6">
                    <x-input
                        name="contacto_email"
                        label="Email"
                        type="email"
                        placeholder="Ej: contacto@empresa.cl"
                        :value="$cliente->contacto_email"
                        required
                        :error="$errors->first('contacto_email')"
                    />
                </div>
            </div>

            <!-- Notas -->
            <div>
                <h3 class="text-lg font-medium text-gray-900 mb-4 pb-2 border-b border-gray-200">
                    Información Adicional
                </h3>
                <div>
                    <label for="notas" class="block text-sm font-medium text-gray-700 mb-2">
                        Notas
                    </label>
                    <textarea
                        name="notas"
                        id="notas"
                        rows="4"
                        placeholder="Información adicional relevante sobre el cliente..."
                        class="block w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:ring-primary-500 focus:border-primary-500 sm:text-sm"
                    >{{ old('notas', $cliente->notas) }}</textarea>
                    @error('notas')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Información del Sistema -->
            <div class="bg-gray-50 p-4 rounded-lg">
                <h3 class="text-sm font-medium text-gray-700 mb-2">Información del Sistema</h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4 text-sm text-gray-600">
                    <div>
                        <span class="font-medium">ID:</span> {{ $cliente->id }}
                    </div>
                    <div>
                        <span class="font-medium">Creado:</span> {{ $cliente->created_at->format('d/m/Y H:i') }}
                    </div>
                    <div>
                        <span class="font-medium">Actualizado:</span> {{ $cliente->updated_at->format('d/m/Y H:i') }}
                    </div>
                    <div>
                        <span class="font-medium">Cotizaciones:</span> {{ $cliente->cotizaciones()->count() }}
                    </div>
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                <div class="flex items-center space-x-3">
                    <a href="{{ route('clientes.show', $cliente) }}"
                       class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                        </svg>
                        Ver Detalles
                    </a>

                    <a href="{{ route('clientes.index') }}"
                       class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                        <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                        </svg>
                        Volver al Listado
                    </a>
                </div>

                <div class="flex items-center space-x-3">
                    <form action="{{ route('clientes.destroy', $cliente) }}" method="POST"
                          onsubmit="return confirm('¿Estás seguro de eliminar este cliente? Esta acción no se puede deshacer.')"
                          class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="px-4 py-2 border border-red-300 rounded-lg text-red-700 hover:bg-red-50 transition-colors">
                            <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                            </svg>
                            Eliminar
                        </button>
                    </form>

                    <button type="submit"
                            class="inline-flex items-center px-6 py-2 bg-gradient-to-r from-primary-600 to-primary-700 text-white rounded-lg hover:from-primary-700 hover:to-primary-800 transition-all duration-200 shadow-sm">
                        <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                        Actualizar Cliente
                    </button>
                </div>
            </div>
        </form>
    </x-card>
</div>
@endsection