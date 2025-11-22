@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Crear Nuevo Pago</h1>
            <a href="{{ route('calendario-pagos.calendario') }}"
               class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150">
                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                </svg>
                Volver al Calendario
            </a>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Form -->
            <div class="lg:col-span-2">
                <div class="bg-white shadow rounded-lg p-6">
                    <form method="POST" action="{{ route('calendario-pagos.store') }}" x-data="{ isRecurring: false }">
                        @csrf

                        <!-- Información Básica -->
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Información del Pago</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="md:col-span-2">
                                    <label for="titulo_servicio" class="block text-sm font-medium text-gray-700">Título del Servicio</label>
                                    <input type="text" id="titulo_servicio" name="titulo_servicio" required
                                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                           value="{{ old('titulo_servicio') }}" placeholder="Ej: Alquiler de oficina">
                                </div>

                                <div>
                                    <label for="proveedor_id" class="block text-sm font-medium text-gray-700">Proveedor</label>
                                    <select id="proveedor_id" name="proveedor_id" required
                                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Seleccionar proveedor</option>
                                        @foreach($proveedores as $proveedor)
                                            <option value="{{ $proveedor->id }}" {{ old('proveedor_id') == $proveedor->id ? 'selected' : '' }}>
                                                {{ $proveedor->nombre }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="categoria" class="block text-sm font-medium text-gray-700">Categoría</label>
                                    <select id="categoria" name="categoria"
                                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Seleccionar categoría</option>
                                        @foreach($categorias as $key => $label)
                                            <option value="{{ $key }}" {{ old('categoria') == $key ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="md:col-span-2">
                                    <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción (opcional)</label>
                                    <textarea id="descripcion" name="descripcion" rows="3"
                                              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                              placeholder="Descripción detallada del servicio">{{ old('descripcion') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <!-- Detalles del Pago -->
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Detalles del Pago</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div>
                                    <label for="monto" class="block text-sm font-medium text-gray-700">Monto</label>
                                    <div class="mt-1 relative rounded-md shadow-sm">
                                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                            <span class="text-gray-500 sm:text-sm">$</span>
                                        </div>
                                        <input type="number" id="monto" name="monto" required min="0" step="0.01"
                                               class="mt-1 block w-full pl-7 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                               value="{{ old('monto') }}" placeholder="0.00">
                                    </div>
                                </div>

                                <div>
                                    <label for="tipo_pago" class="block text-sm font-medium text-gray-700">Tipo de Pago</label>
                                    <select id="tipo_pago" name="tipo_pago" required
                                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                        @foreach($tiposPago as $key => $label)
                                            <option value="{{ $key }}" {{ old('tipo_pago') == $key ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="fecha_pago" class="block text-sm font-medium text-gray-700">Fecha de Pago</label>
                                    <input type="date" id="fecha_pago" name="fecha_pago" required
                                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                           value="{{ old('fecha_pago') ?? request('fecha') ?? now()->format('Y-m-d') }}">
                                </div>

                                <div>
                                    <label for="dias_recordatorio" class="block text-sm font-medium text-gray-700">Días de Recordatorio</label>
                                    <input type="number" id="dias_recordatorio" name="dias_recordatorio" min="1" max="30"
                                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                           value="{{ old('dias_recordatorio') ?? '3' }}" placeholder="3">
                                    <p class="mt-1 text-xs text-gray-500">Días antes del pago para enviar recordatorio</p>
                                </div>
                            </div>
                        </div>

                        <!-- Recurrencia -->
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Configuración de Recurrencia</h3>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">Frecuencia</label>
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                    @foreach($recurrentes as $key => $label)
                                        <div class="flex items-center">
                                            <input type="radio" id="recurrente_{{ $key }}" name="recurrente" value="{{ $key }}"
                                                   x-on:change="isRecurring = value !== 'unico'"
                                                   {{ old('recurrente') == $key ? 'checked' : ($key == 'unico' ? 'checked' : '') }}
                                                   class="focus:ring-blue-500 h-4 w-4 text-blue-600 border-gray-300">
                                            <label for="recurrente_{{ $key }}" class="ml-2 block text-sm text-gray-700">
                                                {{ $label }}
                                            </label>
                                        </div>
                                    @endforeach
                                </div>

                                <div x-show="isRecurring" x-transition class="mt-4 p-4 bg-yellow-50 border border-yellow-200 rounded-md">
                                    <div class="flex">
                                        <div class="flex-shrink-0">
                                            <svg class="h-5 w-5 text-yellow-400" viewBox="0 0 20 20" fill="currentColor">
                                                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd" />
                                            </svg>
                                        </div>
                                        <div class="ml-3">
                                            <p class="text-sm text-yellow-800">
                                                Se crearán pagos recurrentes automáticamente para los próximos {{
                                                    collect($recurrentes)->search(old('recurrente') ?? 'unico') === 'mensual' ? '24 meses' :
                                                    (collect($recurrentes)->search(old('recurrente') ?? 'unico') === 'trimestral' ? '8 trimestres' :
                                                    (collect($recurrentes)->search(old('recurrente') ?? 'unico') === 'semestral' ? '4 semestres' : '2 años'))
                                                }}.
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Notas Internas -->
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Notas Internas</h3>
                            <div>
                                <label for="notas_internas" class="block text-sm font-medium text-gray-700">Notas (opcional)</label>
                                <textarea id="notas_internas" name="notas_internas" rows="4"
                                          class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                          placeholder="Notas internas que no serán visibles para el proveedor">{{ old('notas_internas') }}</textarea>
                            </div>
                        </div>

                        <!-- Submit Buttons -->
                        <div class="flex justify-end space-x-3">
                            <a href="{{ route('calendario-pagos.calendario') }}"
                               class="px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150">
                                Cancelar
                            </a>
                            <button type="submit"
                                    class="px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:shadow-outline-blue transition ease-in-out duration-150">
                                Crear Pago
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Sidebar Info -->
            <div class="lg:col-span-1">
                <!-- Pre-filled Provider Info -->
                @if($proveedor)
                    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
                        <h3 class="text-sm font-medium text-blue-800 mb-2">Información del Proveedor</h3>
                        <div class="space-y-1 text-sm text-blue-700">
                            <p><strong>{{ $proveedor->nombre }}</strong></p>
                            <p>{{ $proveedor->email }}</p>
                            <p>{{ $proveedor->telefono }}</p>
                            <p>{{ $proveedor->tipo_rubro }}</p>
                        </div>
                    </div>
                @endif

                <!-- Quick Tips -->
                <div class="bg-white shadow rounded-lg p-4 mb-6">
                    <h3 class="text-sm font-medium text-gray-900 mb-3">Consejos Útiles</h3>
                    <ul class="space-y-2 text-sm text-gray-600">
                        <li class="flex items-start">
                            <svg class="w-4 h-4 text-green-500 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Los pagos recurrentes se crearán automáticamente
                        </li>
                        <li class="flex items-start">
                            <svg class="w-4 h-4 text-green-500 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Configura recordatorios para no olvidar pagos
                        </li>
                        <li class="flex items-start">
                            <svg class="w-4 h-4 text-green-500 mr-2 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Usa categorías para mejor organización
                        </li>
                    </ul>
                </div>

                <!-- Recent Payments -->
                <div class="bg-white shadow rounded-lg p-4">
                    <h3 class="text-sm font-medium text-gray-900 mb-3">Pagos Recientes</h3>
                    <div class="space-y-2">
                        @php
                            $recentPayments = \App\Models\CalendarioPago::with('proveedor')
                                ->orderBy('created_at', 'desc')
                                ->limit(5)
                                ->get();
                        @endphp
                        @forelse($recentPayments as $payment)
                            <div class="flex items-center justify-between text-sm">
                                <div>
                                    <p class="font-medium text-gray-900">{{ $payment->titulo_servicio }}</p>
                                    <p class="text-gray-500">{{ $payment->proveedor->nombre }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="font-medium">${{ number_format($payment->monto, 2) }}</p>
                                    <p class="text-xs text-gray-500">{{ $payment->fecha_pago->format('d/m/Y') }}</p>
                                </div>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">No hay pagos recientes</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection