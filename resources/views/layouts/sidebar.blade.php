<!-- Sidebar -->
<aside class="fixed top-0 left-0 h-full w-64 bg-gradient-to-b from-primary-900 via-primary-700 to-primary-500 text-white flex-shrink-0 z-40 transition-transform duration-300 ease-in-out lg:fixed"
       :class="{
           'translate-x-0': mobileMenuOpen || sidebarOpen,
           '-translate-x-full': !mobileMenuOpen && !sidebarOpen,
           'lg:-translate-x-full': !sidebarOpen,
           'lg:translate-x-0': sidebarOpen
       }">

    <!-- Mobile Header (dentro de sidebar) -->
    <div class="lg:hidden flex items-center justify-between p-4 border-b border-primary-600 bg-black bg-opacity-20">
        <div class="flex items-center space-x-3">
            <div class="w-8 h-8 bg-white rounded-lg flex items-center justify-center">
                <svg class="w-5 h-5 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                </svg>
            </div>
            <span class="text-white font-medium">ERP Sistema</span>
        </div>
        <button @click="closeMobileMenu()"
                class="text-white hover:text-gray-200 p-2 rounded-lg hover:bg-white hover:bg-opacity-10 transition-colors duration-200">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <!-- Desktop Logo -->
    <div class="hidden lg:block p-6 border-b border-primary-600">
        <div class="flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-white rounded-lg flex items-center justify-center">
                    <svg class="w-6 h-6 text-primary-600" fill="currentColor" viewBox="0 0 20 20">
                        <path d="M3 4a1 1 0 011-1h12a1 1 0 011 1v2a1 1 0 01-1 1H4a1 1 0 01-1-1V4zM3 10a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H4a1 1 0 01-1-1v-6zM14 9a1 1 0 00-1 1v6a1 1 0 001 1h2a1 1 0 001-1v-6a1 1 0 00-1-1h-2z"/>
                    </svg>
                </div>
                <div>
                    <h1 class="text-xl font-bold">ERP Sistema</h1>
                    <p class="text-primary-200 text-sm">Panel de Control</p>
                </div>
            </div>
            <!-- Botón toggle para sidebar -->
            <button @click="toggleSidebar()"
                    class="text-white hover:text-gray-200 p-2 rounded-lg hover:bg-white hover:bg-opacity-10 transition-colors duration-200"
                    title="Toggle Sidebar">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Navigation -->
    <nav class="p-4 overflow-y-auto flex-1">
        <ul class="space-y-2">
            <li>
                <a href="{{ route('dashboard') }}"
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('dashboard') ? 'bg-white bg-opacity-20 text-white shadow-lg' : 'hover:bg-white hover:bg-opacity-10 text-primary-100' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
                    </svg>
                    <span class="truncate">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('clientes.index') }}"
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('clientes.*') ? 'bg-white bg-opacity-20 text-white shadow-lg' : 'hover:bg-white hover:bg-opacity-10 text-primary-100' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span class="truncate">Clientes</span>
                </a>
            </li>
            <li>
                <a href="{{ route('cotizaciones.index') }}"
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('cotizaciones.*') ? 'bg-white bg-opacity-20 text-white shadow-lg' : 'hover:bg-white hover:bg-opacity-10 text-primary-100' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                    </svg>
                    <span class="truncate">Cotizaciones</span>
                </a>
            </li>
            <li>
                <a href="{{ route('ordenes-trabajo.index') }}"
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('ordenes-trabajo.*') ? 'bg-white bg-opacity-20 text-white shadow-lg' : 'hover:bg-white hover:bg-opacity-10 text-primary-100' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                    <span class="truncate">Órdenes de Trabajo</span>
                </a>
            </li>
            <li>
                <a href="{{ route('facturas.index') }}"
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('facturas.*') ? 'bg-white bg-opacity-20 text-white shadow-lg' : 'hover:bg-white hover:bg-opacity-10 text-primary-100' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/>
                    </svg>
                    <span class="truncate">Facturación</span>
                </a>
            </li>
            <li>
                <a href="{{ route('entregas.index') }}"
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('entregas.*') ? 'bg-white bg-opacity-20 text-white shadow-lg' : 'hover:bg-white hover:bg-opacity-10 text-primary-100' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v10a2 2 0 002 2h8a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"/>
                    </svg>
                    <span class="truncate">Entregas</span>
                </a>
            </li>
            <li>
                <a href="{{ route('proveedores.index') }}"
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('proveedores.*') ? 'bg-white bg-opacity-20 text-white shadow-lg' : 'hover:bg-white hover:bg-opacity-10 text-primary-100' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/>
                    </svg>
                    <span class="truncate">Proveedores</span>
                </a>
            </li>
            <li>
                <a href="{{ route('calendario-pagos.calendario') }}"
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('calendario-pagos.*') ? 'bg-white bg-opacity-20 text-white shadow-lg' : 'hover:bg-white hover:bg-opacity-10 text-primary-100' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <span class="truncate">Calendario de Pagos</span>
                </a>
            </li>

            @if(auth()->user()->email === 'admin@metalu.bytea.cl')
            <li>
                <a href="{{ route('users.index') }}"
                   class="flex items-center space-x-3 px-4 py-3 rounded-lg transition-all duration-200 {{ request()->routeIs('users.*') ? 'bg-white bg-opacity-20 text-white shadow-lg' : 'hover:bg-white hover:bg-opacity-10 text-primary-100' }}">
                    <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/>
                    </svg>
                    <span class="truncate">Gestión de Usuarios</span>
                </a>
            </li>
            @endif

        </ul>
    </nav>

    <!-- Footer Sidebar -->
    <div class="hidden lg:block p-4 border-t border-primary-600">
        <div class="flex items-center justify-center">
            <span class="text-primary-200 text-xs">ERP Sistema © {{ date('Y') }}</span>
        </div>
    </div>
</aside>