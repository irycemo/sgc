<div x-data="{openValuacion:false, openValuacionyD:true}" class="mb-5">

    <div class="flex items-center  w-full justify-between mb-2">

        <p class="uppercase text-base text-rojo tracking-wider">Valuación</p>

        <button @click="openValuacion = false" x-show="openValuacion" class="rounded-full p-1 focus:outline-rojo">

            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5  text-gray-300 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>

        </button>

        <button @click="openValuacion = true" x-show="!openValuacion" class="rounded-full p-1 focus:outline-rojo" x-cloak>

            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5  text-gray-300 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
            </svg>

        </button>

    </div>

    <div
        x-transition:enter="transition duration-2000 transform ease-out"
        x-transition:leave="transition duration-200 transform ease-in"
        x-transition:leave-end="opacity-0 scale-90"
        x-transition:enter-start="scale-75"
        class="flex flex-col w-full justify-between transition ease-in-out duration-500  rounded-xl text-sm"
        x-show="!openValuacion">

        @can('Asignación de cuentas')

            <a href="{{ route('asignacion_cuenta') }}" class="capitalize font-medium text-sm flex items-center w-full py-2 px-4 focus:outline-rojo focus:outline-offset-2 rounded-lg">

                Asignación de cuenta predial

            </a>

        @endcan

        @can('Valuación y desglose')

            <a href="{{ route('valuacion_y_desglose') }}" class="capitalize font-medium text-sm flex items-center w-full py-2 px-4 focus:outline-rojo focus:outline-offset-2 rounded-lg">

                Valuación y desglose

            </a>

        @endcan

        @can('Ficha técnica')

            <a href="{{ route('ficha_tecnica') }}" class="capitalize font-medium text-sm flex items-center w-full py-2 px-4 focus:outline-rojo focus:outline-offset-2 rounded-lg">

                Ficha técnica

            </a>

        @endcan

        @can('Impresión de avaluos')

            <a href="{{ route('impresion_avaluos') }}" class="capitalize font-medium text-sm flex items-center w-full py-2 px-4 focus:outline-rojo focus:outline-offset-2 rounded-lg">

                Impresión

            </a>

        @endcan

        @can('Notificación')

            <a href="{{ route('notificacion_avaluos') }}" class="capitalize font-medium text-sm flex items-center w-full py-2 px-4 focus:outline-rojo focus:outline-offset-2 rounded-lg">

                Notificación

            </a>

        @endcan

        @can('Avaluos de predio ignorado')

            <a href="{{ route('avaluo_predio_ignorado') }}" class="capitalize font-medium text-sm flex items-center w-full py-2 px-4 focus:outline-rojo focus:outline-offset-2 rounded-lg">

                Avaluos de predios ignorados

            </a>

        @endcan

        @can('Ver mis avaluos')

            <a href="{{ route('mis_avaluos') }}" class="capitalize font-medium text-sm flex items-center w-full py-2 px-4 focus:outline-rojo focus:outline-offset-2 rounded-lg">

                Mis avaluos

            </a>

        @endcan

    </div>

</div>
