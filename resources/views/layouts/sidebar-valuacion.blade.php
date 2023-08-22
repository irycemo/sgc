<div x-data="{openValuacion:false, openValuacionyD:true}" class="mb-5">

    <div class="flex items-center  w-full justify-between mb-2">

        <p class="uppercase text-base text-rojo tracking-wider">Valuación</p>

        <svg @click="openValuacion = false" x-show="openValuacion" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 text-gray-300 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>

        <svg @click="openValuacion = true" x-show="!openValuacion" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 text-gray-300 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
        </svg>

    </div>

    <div
        x-transition:enter="transition duration-2000 transform ease-out"
        x-transition:leave="transition duration-200 transform ease-in"
        x-transition:leave-end="opacity-0 scale-90"
        x-transition:enter-start="scale-75"
        class="flex flex-col w-full justify-between transition ease-in-out duration-500  rounded-xl text-sm"
        x-show="!openValuacion">

        @can('Asignación de cuentas')

            <a href="{{ route('asignacion_cuenta') }}" class="capitalize hover:text-red-600  font-medium text-sm transition ease-in-out duration-500 flex hover  hover:bg-gray-100 p-2 px-4 rounded-xl">

                Asignación de cuenta predial

            </a>

        @endcan

        @can('Valuación y desglose')

            <div class="flex items-center w-full justify-between rounded-xl">

                <a href="{{ route('valuacion_y_desglose') }}" class="capitalize font-medium text-sm transition ease-in-out hover:text-red-600 duration-500 flex hover  hover:bg-gray-100 p-2 px-4 rounded-xl">

                    Valuación y desglose

                </a>

                <svg @click="openValuacionyD = false" x-show="openValuacionyD" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 text-gray-300 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>

                <svg @click="openValuacionyD = true" x-show="!openValuacionyD" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 text-gray-300 cursor-pointer" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7" />
                </svg>

            </div>

            <div
                x-transition:enter="transition duration-2000 transform ease-out"
                x-transition:leave="transition duration-200 transform ease-in"
                x-transition:leave-end="opacity-0 scale-90"
                x-transition:enter-start="scale-75"
                class="flex flex-col items-center mb-3 w-full rounded-xl text-sm text-left"
                x-show="!openValuacionyD">

                @can('Ficha técnica')

                    <a href="{{ route('ficha_tecnica') }}" class="ml-8 w-full hover:text-red-600 capitalize font-medium transition ease-in-out duration-500 flex hover hover:bg-gray-100 p-2 px-4 rounded-xl">

                        Ficha técnica

                    </a>

                @endcan

                @can('Impresión de avaluos')

                    <a href="{{ route('impresion_avaluos') }}" class="ml-8 w-full hover:text-red-600 capitalize font-medium transition ease-in-out duration-500 flex hover hover:bg-gray-100 p-2 px-4 rounded-xl">

                        Impresión

                    </a>

                @endcan

                @can('Notificación')

                    <a href="{{ route('notificacion_avaluos') }}" class="ml-8 w-full hover:text-red-600 capitalize font-medium transition ease-in-out duration-500 flex hover hover:bg-gray-100 p-2 px-4 rounded-xl">

                        Notificación

                    </a>

                @endcan

            </div>

        @endcan

        {{-- @can('Topografía')

            <a href="{{ route('usuarios') }}" class="w-full hover:text-red-600 capitalize font-medium text-sm transition ease-in-out duration-500 flex hover  hover:bg-gray-100 p-2 px-4 rounded-xl">

                Topografía

            </a>

        @endcan --}}

        @can('Avaluos de predio ignorado')

            <a href="{{ route('avaluo_predio_ignorado') }}" class="capitalize hover:text-red-600  font-medium text-sm transition ease-in-out duration-500 flex hover  hover:bg-gray-100 p-2 px-4 rounded-xl">

                Avaluos de predios ignorados

            </a>

        @endcan

    </div>

</div>
