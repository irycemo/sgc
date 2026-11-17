{{-- Controles del layout SGC: posición del menú (lateral/superior) + tema (claro/oscuro) + perfil.
     Requiere estar dentro de un elemento con x-data="sgcLayout()" (ver layouts/admin.blade.php). --}}
<div class="flex items-center gap-1">

    {{-- Cambiar posición del menú (lateral / superior) --}}
    <button type="button" x-on:click="toggleMode()"
            title="Cambiar menú lateral / superior" aria-label="Cambiar posición del menú"
            class="hidden md:block p-2 rounded-md text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-rojo">

        {{-- Actualmente lateral -> muestra icono de menú superior --}}
        <svg x-show="mode === 'sidebar'" x-cloak class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <rect x="3" y="4" width="18" height="16" rx="2" stroke-width="1.5" />
            <path stroke-linecap="round" stroke-width="1.5" d="M3 9h18" />
        </svg>

        {{-- Actualmente superior -> muestra icono de menú lateral --}}
        <svg x-show="mode === 'topbar'" x-cloak class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <rect x="3" y="4" width="18" height="16" rx="2" stroke-width="1.5" />
            <path stroke-linecap="round" stroke-width="1.5" d="M9 4v16" />
        </svg>

    </button>

    {{-- Tema claro / oscuro --}}
    <button type="button" x-on:click="toggleTheme()"
            title="Cambiar tema claro / oscuro" aria-label="Cambiar tema"
            class="p-2 rounded-md text-gray-500 hover:bg-gray-100 hover:text-gray-700 dark:text-gray-300 dark:hover:bg-gray-700 dark:hover:text-white focus:outline-none focus:ring-2 focus:ring-inset focus:ring-rojo">

        {{-- En tema claro -> muestra la luna (pasar a oscuro) --}}
        <svg x-show="theme === 'light'" x-cloak class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M21.752 15.002A9.718 9.718 0 0118 15.75c-5.385 0-9.75-4.365-9.75-9.75 0-1.33.266-2.597.748-3.752A9.753 9.753 0 003 11.25C3 16.635 7.365 21 12.75 21a9.753 9.753 0 009.002-5.998Z" />
        </svg>

        {{-- En tema oscuro -> muestra el sol (pasar a claro) --}}
        <svg x-show="theme === 'dark'" x-cloak class="h-6 w-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" aria-hidden="true">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 3v2.25m6.364.386-1.591 1.591M21 12h-2.25m-.386 6.364-1.591-1.591M12 18.75V21m-4.773-4.227-1.591 1.591M5.25 12H3m4.227-4.773L5.636 5.636M15.75 12a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0Z" />
        </svg>

    </button>

    {{-- Perfil --}}
    <div class="relative z-50" x-data="{ open_drop_down:false }">

        <div>

            <button x-on:click="open_drop_down=true" type="button"
                    class="bg-gray-800 dark:bg-gray-600 flex text-sm rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-white dark:focus:ring-offset-gray-800 focus:ring-white"
                    aria-expanded="false" aria-haspopup="true">

                <span class="sr-only">Abrir menú de usuario</span>

                <img class="h-10 w-10 rounded-full sgc-profile-img" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}">

            </button>

        </div>

        <div x-cloak x-show="open_drop_down" x-on:click.away="open_drop_down=false"
             class="origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white dark:bg-gray-800 ring-1 ring-black ring-opacity-5 dark:ring-white/10 focus:outline-none"
             role="menu" aria-orientation="vertical">

            <a href="{{ route('profile.show') }}" class="block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700" role="menuitem">Mi Perfil</a>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full text-left block px-4 py-2 text-sm text-gray-700 dark:text-gray-200 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none" role="menuitem">Cerrar Sesión</button>
            </form>

        </div>

    </div>

</div>
