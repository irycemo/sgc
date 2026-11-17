<x-app-layout>

    @php
        /**
         * Áreas del sistema: etiqueta del menú superior, permiso (gate) y parcial
         * de enlaces. El MISMO parcial se reutiliza para el sidebar lateral y
         * para el desplegable del menú superior.
         */
        $sgcAreas = [
            ['label' => 'Administración',     'can' => 'Área de administración',      'partial' => 'layouts.sidebar-administrador'],
            ['label' => 'Valuación',          'can' => 'Área de valuación',           'partial' => 'layouts.sidebar-valuacion'],
            ['label' => 'Gestión Catastral',  'can' => 'Área de gestión catastral',   'partial' => 'layouts.sidebar-gestion-catastral'],
            ['label' => 'A. Trámites Adm.',   'can' => 'Área de anotaciones y t. a.', 'partial' => 'layouts.sidebar-anotaciones'],
            ['label' => 'Cartografía',        'can' => 'Área de cartografía',         'partial' => 'layouts.sidebar-cartografia'],
            ['label' => 'Certificaciones',    'can' => 'Área de certificados',        'partial' => 'layouts.sidebar-certificados'],
            ['label' => 'Trámites',           'can' => 'Ventanilla',                  'partial' => 'layouts.sidebar-tramites'],
            ['label' => 'Consultas',          'can' => 'Área de consultas',           'partial' => 'layouts.sidebar-consultas'],
        ];
    @endphp

    <div id="sgc-shell" class="relative max-h-screen md:flex" x-data="sgcLayout()">

        {{-- Sidebar lateral--}}
        <div id="sgc-sidebar" class="z-50 bg-white dark:bg-gray-800 w-64 absolute inset-y-0 left-0 transform -translate-x-full transition duration-200 ease-in-out md:relative md:translate-x-0">

            {{-- Header del sidebar --}}
            <div class="w-full flex-none bg-white dark:bg-gray-800 border-b-2 border-gray-200 dark:border-gray-700 flex flex-row p-5 pr-0 justify-between items-center h-20">

                {{-- Logo --}}
                <a href="{{ route('dashboard') }}" class="mx-auto">
                    <img class="h-16" src="{{ asset('storage/img/logo2.png') }}" alt="Logo">
                </a>

                {{-- Cerrar menú (móvil) --}}
                <button type="button" title="Cerrar Menú" id="sidebar-menu-button" class="md:hidden mr-2 inline-flex items-center p-2 rounded-md text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-controls="mobile-menu" aria-expanded="false">
                    <svg class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

            </div>

            {{-- Nav --}}
            <nav class="p-4 sgc-nav overflow-y-auto h-menu text-rojo dark:text-gray-200">

                @foreach($sgcAreas as $area)

                    @can($area['can'])

                        @include($area['partial'])

                    @endcan

                @endforeach

            </nav>

        </div>

        {{-- Content --}}
        <div class="flex-1 flex-col flex max-h-screen overflow-x-auto min-h-screen">

            {{-- Cabecera (solo en modo lateral) --}}
            <div class="sgc-only-sidebar w-full bg-white dark:bg-gray-800 border-b-2 border-gray-200 dark:border-gray-700 flex-none flex flex-row p-5 justify-between items-center h-20">

                {{-- Botón de menú móvil --}}
                <div class="flex items-center">
                    <button type="button" title="Abrir Menú" id="mobile-menu-button" class="md:hidden inline-flex items-center p-2 rounded-md text-gray-400 hover:bg-gray-200 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-white" aria-controls="mobile-menu" aria-expanded="false">
                        <svg class="block h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>

                {{-- Nombre de la app --}}
                <p class="font-semibold text-2xl text-rojo hidden md:block">{{ env('APP_NAME') }}</p>
                <p class="font-semibold text-2xl text-rojo md:hidden">SGC</p>

                {{-- Controles + perfil --}}
                <div class="ml-3">
                    <x-sgc-controls />
                </div>

            </div>

            {{-- ===================== MENÚ SUPERIOR (modo topbar) ===================== --}}
            {{-- flex-wrap (NO overflow-x-auto): un contenedor con overflow recorta
                 los dropdowns absolutos; en pantallas estrechas el menú hace wrap --}}
            <div id="sgc-topnav" class="bg-white dark:bg-gray-800 border-b-2 border-gray-200 dark:border-gray-700 flex-none flex flex-row flex-wrap items-center gap-1 px-3 sm:px-4 py-2">

                {{-- Logo --}}
                <a href="{{ route('dashboard') }}" class="shrink-0">
                    <img class="h-9 sm:h-10" src="{{ asset('storage/img/logo2.png') }}" alt="Logo">
                </a>

                <span class="w-px h-8 bg-gray-200 dark:bg-gray-600 shrink-0 mx-1 sm:mx-2" aria-hidden="true"></span>

                @foreach($sgcAreas as $area)

                    @can($area['can'])

                        <div x-data="{ open_menu: false }" @click.outside="open_menu = false" class="relative shrink-0">

                            <button type="button" @click="open_menu = !open_menu"
                                    class="flex items-center gap-1 px-2 sm:px-3 py-2 rounded-lg text-sm font-medium text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-2 focus:ring-inset focus:ring-rojo">

                                {{ $area['label'] }}

                                <svg class="h-4 w-4 transition-transform" :class="open_menu ? 'rotate-180' : ''" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                                </svg>

                            </button>

                            <div x-cloak x-show="open_menu"
                                 x-transition:enter="transition duration-150 ease-out"
                                 x-transition:enter-start="opacity-0 -translate-y-1"
                                 x-transition:enter-end="opacity-100 translate-y-0"
                                 x-transition:leave="transition duration-100 ease-in"
                                 x-transition:leave-end="opacity-0"
                                 class="absolute left-0 mt-2 z-50 w-64 max-h-[70vh] overflow-y-auto rounded-lg shadow-lg bg-white dark:bg-gray-800 ring-1 ring-black/5 dark:ring-white/10 py-2">

                                <div class="sgc-flatten">

                                    @include($area['partial'])

                                </div>

                            </div>

                        </div>

                    @endcan

                @endforeach

                {{-- Controles + perfil --}}
                <div class="ml-auto shrink-0 pl-1">
                    <x-sgc-controls />
                </div>

            </div>

            {{-- Cuerpo --}}
            <div class="bg-gray-100 dark:bg-gray-900 p-3 flex-1 overflow-y-auto md:border-l-2 border-l-gray-200 dark:border-l-gray-700">

                @yield('content')

            </div>

        </div>

    </div>

    <script>

        function sgcLayout() {

            const read = (key, fallback) => {
                try { return localStorage.getItem(key) || fallback; } catch (e) { return fallback; }
            };

            const write = (key, value) => {
                try { localStorage.setItem(key, value); } catch (e) { /* sin persistencia */ }
            };

            return {
                mode: read('sgc-layout', 'sidebar'),
                theme: read('sgc-theme', (window.matchMedia && matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light')),

                init() { this.apply(); },

                apply() {
                    const root = document.documentElement;
                    root.classList.toggle('sgc-mode-topbar', this.mode === 'topbar');
                    root.classList.toggle('dark', this.theme === 'dark');
                },

                toggleMode() {
                    this.mode = this.mode === 'topbar' ? 'sidebar' : 'topbar';
                    write('sgc-layout', this.mode);
                    this.apply();
                },

                toggleTheme() {
                    this.theme = this.theme === 'dark' ? 'light' : 'dark';
                    write('sgc-theme', this.theme);
                    this.apply();
                },
            };
        }

        /* Menú móvil (solo aplica en modo lateral) */
        const btn_close = document.getElementById('sidebar-menu-button');
        const btn_open = document.getElementById('mobile-menu-button');
        const sidebar = document.getElementById('sgc-sidebar');

        if (btn_open) {
            btn_open.addEventListener('click', () => {
                sidebar.classList.toggle('-translate-x-full');
            });
        }

        if (btn_close) {
            btn_close.addEventListener('click', () => {
                sidebar.classList.toggle('-translate-x-full');
            });
        }

        /* Cambiar foto de perfil (evento global) */
        window.addEventListener('nav-profile-img', event => {
            document.querySelectorAll('.sgc-profile-img').forEach(img => {
                img.setAttribute('src', event.detail.img);
            });
        });

    </script>

</x-app-layout>
