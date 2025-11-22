@extends('layouts.app')

@section('title', 'Test Responsive')

@section('content')
<div class="space-y-6">
    <!-- Header Test -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h1 class="text-2xl font-bold text-gray-900 mb-4">🧪 Test de Responsive Design</h1>
        <p class="text-gray-600">Prueba la sidebar en diferentes tamaños de pantalla:</p>

        <div class="mt-4 grid grid-cols-1 md:grid-cols-3 gap-4">
            <!-- Mobile Test Button -->
            <div class="text-center p-4 bg-blue-50 rounded-lg">
                <div class="text-3xl mb-2">📱</div>
                <h3 class="font-semibold text-blue-900">Móvil</h3>
                <p class="text-sm text-blue-700 mt-1">Prueba el menú hamburguesa</p>
            </div>

            <!-- Tablet Test Button -->
            <div class="text-center p-4 bg-green-50 rounded-lg">
                <div class="text-3xl mb-2">📱</div>
                <h3 class="font-semibold text-green-900">Tablet</h3>
                <p class="text-sm text-green-700 mt-1">Sidebar visible táctil</p>
            </div>

            <!-- Desktop Test Button -->
            <div class="text-center p-4 bg-purple-50 rounded-lg">
                <div class="text-3xl mb-2">🖥️</div>
                <h3 class="font-semibold text-purple-900">Desktop</h3>
                <p class="text-sm text-purple-700 mt-1">Botón toggle funcional</p>
            </div>
        </div>
    </div>

    <!-- Interactive Test -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">🎯 Pruebas Interactivas</h2>

        <div class="space-y-3">
            <!-- Botón para limpiar localStorage -->
            <button onclick="resetAll()"
                    class="w-full sm:w-auto px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600 transition-colors">
                🔄 Resetear Estado Sidebar
            </button>

            <!-- Información de estado -->
            <div class="p-4 bg-gray-50 rounded-lg">
                <h3 class="font-semibold text-gray-900 mb-2">Estado Actual:</h3>
                <div class="grid grid-cols-2 gap-4 text-sm">
                    <div>
                        <span class="font-medium">Sidebar State:</span>
                        <span id="sidebar-state" class="ml-2 text-gray-600">-</span>
                    </div>
                    <div>
                        <span class="font-medium">Screen Size:</span>
                        <span id="screen-size" class="ml-2 text-gray-600">-</span>
                    </div>
                    <div>
                        <span class="font-medium">Local Storage:</span>
                        <span id="local-storage" class="ml-2 text-gray-600">-</span>
                    </div>
                    <div>
                        <span class="font-medium">Alpine Data:</span>
                        <span id="alpine-data" class="ml-2 text-gray-600">-</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Navigation Test -->
    <div class="bg-white rounded-lg shadow-sm border border-gray-200 p-6">
        <h2 class="text-lg font-semibold text-gray-900 mb-4">🧭 Navegación de Prueba</h2>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-3">
            <a href="{{ route('dashboard') }}" class="px-4 py-2 bg-primary-100 text-primary-700 rounded-lg hover:bg-primary-200 transition-colors text-sm text-center">
                Dashboard
            </a>
            <a href="{{ route('clientes.index') }}" class="px-4 py-2 bg-primary-100 text-primary-700 rounded-lg hover:bg-primary-200 transition-colors text-sm text-center">
                Clientes
            </a>
            <a href="{{ route('cotizaciones.index') }}" class="px-4 py-2 bg-primary-100 text-primary-700 rounded-lg hover:bg-primary-200 transition-colors text-sm text-center">
                Cotizaciones
            </a>
            <a href="{{ route('ordenes-trabajo.index') }}" class="px-4 py-2 bg-primary-100 text-primary-700 rounded-lg hover:bg-primary-200 transition-colors text-sm text-center">
                Órdenes
            </a>
        </div>
    </div>
</div>

<script>
// Función para limpiar completamente el estado
function resetAll() {
    localStorage.removeItem('sidebarState');
    location.reload();
}

// Actualizar información de estado en tiempo real
function updateStateInfo() {
    const width = window.innerWidth;
    const isMobile = width < 768;
    const isTablet = width >= 768 && width < 1024;
    const isDesktop = width >= 1024;

    document.getElementById('sidebar-state').textContent = localStorage.getItem('sidebarState') || 'none';
    document.getElementById('screen-size').textContent = width + 'px (' + (isMobile ? 'Mobile' : isTablet ? 'Tablet' : 'Desktop') + ')';
    document.getElementById('local-storage').textContent = JSON.stringify({
        sidebarState: localStorage.getItem('sidebarState')
    });

    // Intentar obtener datos de Alpine
    const appElement = document.querySelector('[x-data="app"]');
    if (appElement && appElement.__x) {
        const alpineData = appElement.__x.$data;
        document.getElementById('alpine-data').textContent = JSON.stringify({
            sidebarOpen: alpineData.sidebarOpen,
            mobileMenuOpen: alpineData.mobileMenuOpen
        });
    }

    // Detectar elementos visibles
    const sidebar = document.querySelector('aside');
    const overlay = document.querySelector('[x-show*="mobileMenuOpen"]');

    console.log('Debug:', {
        width: width,
        isMobile: isMobile,
        isDesktop: isDesktop,
        sidebarVisible: sidebar ? getComputedStyle(sidebar).display : 'hidden',
        sidebarTransform: sidebar ? getComputedStyle(sidebar).transform : 'none',
        overlayVisible: overlay ? getComputedStyle(overlay).display : 'hidden'
    });
}

// Actualizar cada segundo
setInterval(updateStateInfo, 1000);

// Actualizar en resize
window.addEventListener('resize', updateStateInfo);

// Inicializar cuando Alpine esté listo
document.addEventListener('alpine:initialized', updateStateInfo);
document.addEventListener('DOMContentLoaded', updateStateInfo);
</script>
@endsection