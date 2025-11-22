@extends('layouts.app')

@section('content')
<div class="py-6">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <!-- Header -->
        <div class="mb-6">
            <div class="flex items-center justify-between mb-4">
                <h1 class="text-2xl font-bold text-gray-900">Calendario de Pagos</h1>
                <div class="flex items-center space-x-3">
                    <a href="{{ route('calendario-pagos.create') }}"
                       class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:shadow-outline-blue transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                        </svg>
                        Nuevo Pago
                    </a>
                    <a href="{{ route('calendario-pagos.index') }}"
                       class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md font-semibold text-xs text-gray-700 uppercase tracking-widest hover:bg-gray-50 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150">
                        <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                        Lista
                    </a>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-6">
                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-blue-500 rounded-md flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm leading-5 font-medium text-gray-500 truncate">Total Pagos</dt>
                                    <dd class="text-3xl leading-9 font-semibold text-gray-900">{{ $stats['total'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-yellow-500 rounded-md flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm leading-5 font-medium text-gray-500 truncate">Pendientes</dt>
                                    <dd class="text-3xl leading-9 font-semibold text-gray-900">{{ $stats['pendientes'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-green-500 rounded-md flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm leading-5 font-medium text-gray-500 truncate">Pagados</dt>
                                    <dd class="text-3xl leading-9 font-semibold text-gray-900">{{ $stats['pagados'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-white overflow-hidden shadow rounded-lg">
                    <div class="px-4 py-5 sm:p-6">
                        <div class="flex items-center">
                            <div class="flex-shrink-0">
                                <div class="w-8 h-8 bg-red-500 rounded-md flex items-center justify-center">
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.964-.833-2.732 0L4.082 16.5c-.77.833.192 2.5 1.732 2.5z"></path>
                                    </svg>
                                </div>
                            </div>
                            <div class="ml-5 w-0 flex-1">
                                <dl>
                                    <dt class="text-sm leading-5 font-medium text-gray-500 truncate">Vencidos</dt>
                                    <dd class="text-3xl leading-9 font-semibold text-gray-900">{{ $stats['vencidos'] }}</dd>
                                </dl>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Navigation and Filters -->
            <div class="bg-white shadow rounded-lg p-4 mb-6">
                <form method="GET" action="{{ route('calendario-pagos.calendario') }}">
                    <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                        <!-- Month/Year Navigation -->
                        <div class="flex items-center space-x-2">
                            <button type="button" onclick="navigateMonth(-1)"
                                    class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                                </svg>
                            </button>
                            <span class="font-semibold text-lg min-w-[200px] text-center">
                                {{ ucfirst($nombreMes) }} {{ $anio }}
                            </span>
                            <button type="button" onclick="navigateMonth(1)"
                                    class="p-2 text-gray-600 hover:text-gray-900 hover:bg-gray-100 rounded">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                                </svg>
                            </button>
                        </div>

                        <!-- Proveedor Filter -->
                        <div>
                            <select name="proveedor_id" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Todos los proveedores</option>
                                @foreach($proveedores as $proveedor)
                                    <option value="{{ $proveedor->id }}" {{ request('proveedor_id') == $proveedor->id ? 'selected' : '' }}>
                                        {{ $proveedor->nombre }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Categoría Filter -->
                        <div>
                            <select name="categoria" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-blue-500 focus:border-blue-500">
                                <option value="">Todas las categorías</option>
                                @foreach($categorias as $key => $label)
                                    <option value="{{ $key }}" {{ request('categoria') == $key ? 'selected' : '' }}>
                                        {{ $label }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <div>
                            <button type="submit" class="w-full px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                                Filtrar
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <!-- Calendar -->
        <div class="bg-white shadow rounded-lg overflow-hidden">
            <!-- Calendar Header -->
            <div class="grid grid-cols-7 bg-gray-50 border-b">
                <div class="px-2 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider">Dom</div>
                <div class="px-2 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider">Lun</div>
                <div class="px-2 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider">Mar</div>
                <div class="px-2 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider">Mié</div>
                <div class="px-2 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider">Jue</div>
                <div class="px-2 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider">Vie</div>
                <div class="px-2 py-3 text-center text-xs font-medium text-gray-700 uppercase tracking-wider">Sáb</div>
            </div>

            <!-- Calendar Grid -->
            <div class="grid grid-cols-7">
                @forelse($calendar as $day)
                    @if($day['day'] === null)
                        <!-- Empty cell -->
                        <div class="min-h-[120px] border-r border-b bg-gray-50"></div>
                    @else
                        <!-- Day cell -->
                        <div class="min-h-[120px] border-r border-b p-2 @if($day['is_today']) bg-blue-50 @elseif($day['is_weekend']) bg-gray-50 @else bg-white @endif hover:bg-gray-50 cursor-pointer"
                             @if($day['pagos']->count() == 0)
                             onclick="openCreateModal('{{ $day['date']->format('Y-m-d') }}')"
                             @else
                             onclick="openDayPayments('{{ $day['date']->format('Y-m-d') }}')"
                             @endif
                             >
                            <div class="flex justify-between items-start mb-1">
                                <span class="text-sm font-medium @if($day['has_vencido']) text-red-600 @elseif($day['has_proximo']) text-yellow-600 @else text-gray-900 @endif">
                                    {{ $day['day'] }}
                                </span>
                                @if($day['pagos']->count() > 0)
                                    <span class="inline-flex items-center px-2 py-1 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                        {{ $day['pagos']->count() }}
                                    </span>
                                @endif
                            </div>

                            <!-- Payments for this day -->
                            <div class="space-y-1 overflow-y-auto max-h-[80px]">
                                @foreach($day['pagos']->take(3) as $pago)
                                    <div class="text-xs p-1 rounded @if($pago->estado === 'pagado') bg-green-100 text-green-800 @elseif($pago->esta_vencido) bg-red-100 text-red-800 @else bg-yellow-100 text-yellow-800 @endif"
                                         title="{{ $pago->titulo_servicio }} - {{ $pago->proveedor->nombre }} ({{ $pago->monto_formatted ?? '$' . number_format($pago->monto, 2) }})"
                                         onclick="event.stopPropagation(); window.location.href='{{ route('calendario-pagos.show', $pago) }}'">
                                        <div class="truncate font-medium">{{ $pago->titulo_servicio }}</div>
                                        <div class="truncate">{{ $pago->proveedor->nombre }}</div>
                                    </div>
                                @endforeach
                                @if($day['pagos']->count() > 3)
                                    <div class="text-xs text-gray-500 text-center">+{{ $day['pagos']->count() - 3 }} más</div>
                                @endif
                            </div>
                        </div>
                    @endif
                @empty
                    <div class="col-span-7 text-center py-12 text-gray-500">
                        No hay datos para mostrar
                    </div>
                @endforelse
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('calendario-pagos.create', ['fecha' => now()->format('Y-m-d')]) }}"
               class="block p-4 bg-white rounded-lg shadow hover:shadow-md transition-shadow">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900">Pago para Hoy</p>
                        <p class="text-sm text-gray-500">Crear pago para la fecha actual</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('calendario-pagos.create', ['fecha' => now()->addDays(7)->format('Y-m-d')]) }}"
               class="block p-4 bg-white rounded-lg shadow hover:shadow-md transition-shadow">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900">Próxima Semana</p>
                        <p class="text-sm text-gray-500">Crear pago para la próxima semana</p>
                    </div>
                </div>
            </a>

            <a href="{{ route('calendario-pagos.dashboard') }}"
               class="block p-4 bg-white rounded-lg shadow hover:shadow-md transition-shadow">
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <svg class="h-6 w-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"></path>
                        </svg>
                    </div>
                    <div class="ml-3">
                        <p class="text-sm font-medium text-gray-900">Dashboard</p>
                        <p class="text-sm text-gray-500">Ver estadísticas y análisis</p>
                    </div>
                </div>
            </a>
        </div>
    </div>
</div>

<!-- Hidden form for navigation -->
<form id="navigationForm" method="GET" action="{{ route('calendario-pagos.calendario') }}" class="hidden">
    <input type="hidden" name="mes" id="navigationMonth">
    <input type="hidden" name="anio" id="navigationYear">
    @if(request('proveedor_id'))
        <input type="hidden" name="proveedor_id" value="{{ request('proveedor_id') }}">
    @endif
    @if(request('categoria'))
        <input type="hidden" name="categoria" value="{{ request('categoria') }}">
    @endif
</form>

<script>
function navigateMonth(direction) {
    const currentMonth = {{ $mes }};
    const currentYear = {{ $anio }};

    let newMonth = currentMonth + direction;
    let newYear = currentYear;

    if (newMonth < 1) {
        newMonth = 12;
        newYear = currentYear - 1;
    } else if (newMonth > 12) {
        newMonth = 1;
        newYear = currentYear + 1;
    }

    document.getElementById('navigationMonth').value = newMonth;
    document.getElementById('navigationYear').value = newYear;
    document.getElementById('navigationForm').submit();
}

function openCreateModal(date) {
    window.location.href = `{{ route('calendario-pagos.create') }}?fecha=${date}`;
}

function openDayPayments(date) {
    window.location.href = `{{ route('calendario-pagos.dia') }}?fecha=${date}`;
}

// Auto-refresh calendar every 5 minutes to check for status changes
setInterval(() => {
    window.location.reload();
}, 300000);
</script>
@endsection