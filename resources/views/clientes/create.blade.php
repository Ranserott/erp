@extends('layouts.app')

@section('title', 'Nuevo Cliente')

@section('content')
<div class="max-w-4xl mx-auto">
    <!-- Page Header -->
    <div class="mb-8">
        <nav class="flex items-center space-x-2 text-sm text-gray-500 mb-4">
            <a href="{{ route('clientes.index') }}" class="hover:text-gray-700">Clientes</a>
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
            <span>Nuevo Cliente</span>
        </nav>
        <h1 class="text-3xl font-bold text-gray-900">Nuevo Cliente</h1>
        <p class="text-gray-600 mt-1">Registra un nuevo cliente en el sistema</p>
    </div>

    <x-card>
        <form action="{{ route('clientes.store') }}" method="POST" class="space-y-6">
            @csrf

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
                        required
                        :error="$errors->first('nombre_empresa')"
                    />

                    <x-input
                        name="rut_cliente"
                        label="RUT"
                        placeholder="Ej: 12.345.678-9"
                        required
                        :error="$errors->first('rut_cliente')"
                    />
                </div>

                <div class="mt-6">
                    <x-input
                        name="direccion"
                        label="Dirección"
                        placeholder="Ej: Av. Principal #123, Santiago"
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
                        required
                        :error="$errors->first('contacto_nombre')"
                    />

                    <x-input
                        name="contacto_telefono"
                        label="Teléfono"
                        placeholder="Ej: +56 9 1234 5678"
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
                    >{{ old('notas') }}</textarea>
                    @error('notas')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <!-- Botones de Acción -->
            <div class="flex items-center justify-between pt-6 border-t border-gray-200">
                <a href="{{ route('clientes.index') }}"
                   class="px-4 py-2 border border-gray-300 rounded-lg text-gray-700 hover:bg-gray-50 transition-colors">
                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                    </svg>
                    Cancelar
                </a>

                <button type="submit"
                        class="inline-flex items-center px-6 py-2 bg-gradient-to-r from-primary-600 to-primary-700 text-white rounded-lg hover:from-primary-700 hover:to-primary-800 transition-all duration-200 shadow-sm">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                    </svg>
                    Guardar Cliente
                </button>
            </div>
        </form>
    </x-card>
</div>
@endsection