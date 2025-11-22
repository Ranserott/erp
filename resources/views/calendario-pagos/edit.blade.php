@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-2xl font-bold text-gray-900">Editar Pago</h1>
            <div class="flex items-center space-x-3">
                <a href="{{ route('calendario-pagos.show', $pago) }}"
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    Ver
                </a>
                <a href="{{ route('calendario-pagos.calendario') }}"
                   class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150">
                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                    </svg>
                    Volver al Calendario
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Main Form -->
            <div class="lg:col-span-2">
                <div class="bg-white shadow rounded-lg p-6">
                    <form method="POST" action="{{ route('calendario-pagos.update', $pago) }}">
                        @csrf
                        @method('PUT')

                        <!-- Información Básica -->
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900 mb-4">Información del Pago</h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                <div class="md:col-span-2">
                                    <label for="titulo_servicio" class="block text-sm font-medium text-gray-700">Título del Servicio</label>
                                    <input type="text" id="titulo_servicio" name="titulo_servicio" required
                                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                           value="{{ old('titulo_servicio', $pago->titulo_servicio) }}" placeholder="Ej: Alquiler de oficina">
                                </div>

                                <div>
                                    <label for="proveedor_id" class="block text-sm font-medium text-gray-700">Proveedor</label>
                                    <select id="proveedor_id" name="proveedor_id" required
                                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                        <option value="">Seleccionar proveedor</option>
                                        @foreach($proveedores as $proveedor)
                                            <option value="{{ $proveedor->id }}" {{ old('proveedor_id', $pago->proveedor_id) == $proveedor->id ? 'selected' : '' }}>
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
                                            <option value="{{ $key }}" {{ old('categoria', $pago->categoria) == $key ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="md:col-span-2">
                                    <label for="descripcion" class="block text-sm font-medium text-gray-700">Descripción (opcional)</label>
                                    <textarea id="descripcion" name="descripcion" rows="3"
                                              class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                              placeholder="Descripción detallada del servicio">{{ old('descripcion', $pago->descripcion) }}</textarea>
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
                                               value="{{ old('monto', $pago->monto) }}" placeholder="0.00">
                                    </div>
                                </div>

                                <div>
                                    <label for="tipo_pago" class="block text-sm font-medium text-gray-700">Tipo de Pago</label>
                                    <select id="tipo_pago" name="tipo_pago" required
                                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                        @foreach($tiposPago as $key => $label)
                                            <option value="{{ $key }}" {{ old('tipo_pago', $pago->tipo_pago) == $key ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="fecha_pago" class="block text-sm font-medium text-gray-700">Fecha de Pago</label>
                                    <input type="date" id="fecha_pago" name="fecha_pago" required
                                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                           value="{{ old('fecha_pago', $pago->fecha_pago->format('Y-m-d')) }}">
                                </div>

                                <div>
                                    <label for="estado" class="block text-sm font-medium text-gray-700">Estado</label>
                                    <select id="estado" name="estado" required
                                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                        @foreach($estados as $key => $label)
                                            <option value="{{ $key }}" {{ old('estado', $pago->estado) == $key ? 'selected' : '' }}>
                                                {{ $label }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div>
                                    <label for="dias_recordatorio" class="block text-sm font-medium text-gray-700">Días de Recordatorio</label>
                                    <input type="number" id="dias_recordatorio" name="dias_recordatorio" min="1" max="30"
                                           class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500"
                                           value="{{ old('dias_recordatorio', $pago->dias_recordatorio) }}" placeholder="3">
                                    <p class="mt-1 text-xs text-gray-500">Días antes del pago para enviar recordatorio</p>
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
                                          placeholder="Notas internas que no serán visibles para el proveedor">{{ old('notas_internas', $pago->notas_internas) }}</textarea>
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
                                Actualizar Pago
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Sidebar Info -->
            <div class="lg:col-span-1">
                <!-- Current Status Card -->
                <div class="bg-white shadow rounded-lg p-4 mb-6">
                    <h3 class="text-sm font-medium text-gray-900 mb-3">Estado Actual</h3>
                    @if($pago->estado == 'pagado')
                        <div class="flex items-center">
                            <svg class="w-8 h-8 text-green-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-green-800">Pagado</p>
                                <p class="text-sm text-green-600">Este pago ha sido completado</p>
                            </div>
                        </div>
                    @elseif($pago->esta_vencido)
                        <div class="flex items-center">
                            <svg class="w-8 h-8 text-red-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                            </svg>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-red-800">Vencido</p>
                                <p class="text-sm text-red-600">Vencido hace {{ $pago->dias_restantes }} días</p>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center">
                            <svg class="w-8 h-8 text-yellow-500" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z" clip-rule="evenodd" />
                            </svg>
                            <div class="ml-3">
                                <p class="text-sm font-medium text-yellow-800">Pendiente</p>
                                <p class="text-sm text-yellow-600">
                                    @if($pago->es_proximo)
                                        Próximo en {{ $pago->dias_restantes }} días
                                    @else
                                        {{ $pago->dias_restantes }} días restantes
                                    @endif
                                </p>
                            </div>
                        </div>
                    @endif
                </div>

                <!-- Payment Info -->
                <div class="bg-white shadow rounded-lg p-4 mb-6">
                    <h3 class="text-sm font-medium text-gray-900 mb-3">Información del Pago</h3>
                    <dl class="space-y-2 text-sm">
                        <div class="flex justify-between">
                            <dt class="text-gray-600">ID:</dt>
                            <dd class="font-medium text-gray-900">#{{ $pago->id }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-600">Creado:</dt>
                            <dd class="font-medium text-gray-900">{{ $pago->created_at->format('d/m/Y H:i') }}</dd>
                        </div>
                        <div class="flex justify-between">
                            <dt class="text-gray-600">Actualizado:</dt>
                            <dd class="font-medium text-gray-900">{{ $pago->updated_at->format('d/m/Y H:i') }}</dd>
                        </div>
                        @if($pago->dias_recordatorio)
                            <div class="flex justify-between">
                                <dt class="text-gray-600">Recordatorio:</dt>
                                <dd class="font-medium text-gray-900">{{ $pago->dias_recordatorio }} días antes</dd>
                            </div>
                        @endif
                        @if($pago->recordatorio_enviado)
                            <div class="flex justify-between">
                                <dt class="text-gray-600">Recordatorio enviado:</dt>
                                <dd class="font-medium text-green-600">Sí</dd>
                            </div>
                        @endif
                    </dl>
                </div>

                <!-- Quick Actions -->
                <div class="bg-white shadow rounded-lg p-4">
                    <h3 class="text-sm font-medium text-gray-900 mb-3">Acciones Rápidas</h3>
                    <div class="space-y-2">
                        @if($pago->estado != 'pagado')
                            <form method="POST" action="{{ route('calendario-pagos.marcar-pagado', $pago) }}">
                                @csrf
                                <button type="submit" onclick="return confirm('¿Marcar este pago como pagado?')"
                                        class="w-full flex items-center justify-center px-4 py-2 bg-green-600 text-white rounded-md hover:bg-green-700 transition-colors">
                                    <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Marcar como Pagado
                                </button>
                            </form>
                        @endif

                        <a href="{{ route('calendario-pagos.create', ['proveedor_id' => $pago->proveedor_id, 'monto' => $pago->monto]) }}"
                           class="w-full flex items-center justify-center px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                            </svg>
                            Duplicar Pago
                        </a>

                        <form method="POST" action="{{ route('calendario-pagos.destroy', $pago) }}" onsubmit="return confirm('¿Está seguro de eliminar este pago? Esta acción no se puede deshacer.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="w-full flex items-center justify-center px-4 py-2 bg-red-600 text-white rounded-md hover:bg-red-700 transition-colors">
                                <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                                Eliminar Pago
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection