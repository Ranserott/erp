<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'ERP Sistema') | Panel de Administración</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            50: '#eff6ff',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                            800: '#1e40af',
                            900: '#1e3a8a',
                        }
                    },
                    animation: {
                        'fade-in-down': 'fadeInDown 0.2s ease-out',
                        'slide-in-right': 'slideInRight 0.3s ease-out',
                        'pulse-slow': 'pulse 3s cubic-bezier(0.4, 0, 0.6, 1) infinite',
                    },
                    keyframes: {
                        fadeInDown: {
                            '0%': { opacity: '0', transform: 'translateY(-10px)' },
                            '100%': { opacity: '1', transform: 'translateY(0)' },
                        },
                        slideInRight: {
                            '0%': { opacity: '0', transform: 'translateX(-100%)' },
                            '100%': { opacity: '1', transform: 'translateX(0)' },
                        }
                    }
                }
            }
        }
    </script>
    <link rel="stylesheet" href="{{ secure_asset('build/assets/app-DhQsjqMi.css') }}">
</head>
<body class="bg-gray-50 font-sans antialiased" x-data="appLayout">

    <!-- Mobile Menu Overlay -->
    <div x-show="mobileMenuOpen"
         x-transition.opacity.duration.300ms
         class="fixed inset-0 z-30 bg-black bg-opacity-50 lg:hidden"
         @click="closeMobileMenu()">
    </div>

    <!-- Botón flotante para abrir sidebar en desktop (solo cuando está cerrada) -->
    <button x-show="!sidebarOpen"
            @click="toggleSidebar()"
            x-transition.opacity.duration.300ms
            class="hidden lg:block fixed top-4 left-4 z-50 p-3 bg-primary-600 text-white rounded-lg shadow-lg hover:bg-primary-700 transition-all duration-200 hover:scale-110"
            title="Abrir Sidebar">
        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
        </svg>
    </button>

    <div class="flex h-screen overflow-hidden">
        <!-- Sidebar -->
        @include('layouts.sidebar')

        <!-- Contenido Principal -->
        <div class="flex-1 flex flex-col overflow-hidden transition-all duration-300 ease-in-out"
             :class="sidebarOpen ? 'lg:ml-64' : 'lg:ml-0'">
            <!-- Header con botón toggle para mobile -->
            @include('layouts.header')

            <!-- Main Content -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-3 sm:p-4 lg:p-6">
                <div class="max-w-7xl mx-auto">
                    @yield('content')
                </div>
            </main>

        </div>
    </div>

    @stack('scripts')
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('appLayout', () => ({
                sidebarOpen: true,
                mobileMenuOpen: false,

                init() {
                    // Recuperar estado de localStorage
                    const sidebarState = localStorage.getItem('sidebarState');
                    if (sidebarState === 'closed') {
                        this.sidebarOpen = false;
                    }

                    // Watch para mobile menu
                    this.$watch('mobileMenuOpen', (value) => {
                        if (value) {
                            document.body.style.overflow = 'hidden';
                        } else {
                            document.body.style.overflow = '';
                        }
                    });
                },

                toggleSidebar() {
                    this.sidebarOpen = !this.sidebarOpen;
                    localStorage.setItem('sidebarState', this.sidebarOpen ? 'open' : 'closed');
                    console.log('Sidebar toggled:', this.sidebarOpen);
                },

                closeMobileMenu() {
                    this.mobileMenuOpen = false;
                },

                openMobileMenu() {
                    this.mobileMenuOpen = true;
                }
            }))
        });
    </script>
</body>
</html>