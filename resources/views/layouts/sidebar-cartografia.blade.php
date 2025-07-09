<div x-data="{openValuacion:false, openValuacionyD:true}" class="mb-5">

    <div class="flex items-center  w-full justify-between mb-2">

        <p class="uppercase text-base mb-2 border-b border-rojo rounded-lg px-1.5 w-full">Cartografía</p>

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

            <x-nav-dropdown>

                <x-slot name="head">

                        <a href="{{ route('asignacion_cuenta') }}" class="capitalize font-medium text-sm flex items-center w-full py-2 px-4 focus:outline-rojo focus:outline-offset-2 rounded-lg">

                            Asignar cuenta predial

                        </a>

                </x-slot>

                <x-slot name="body">

                    <a href="{{ route('cuentas_asignadas') }}" class="capitalize font-medium text-sm  flex w-full  hover:bg-gray-100 p-2 px-4  rounded-xl hover:text-red-600">Cuentas asignadas</a>

                </x-slot>

            </x-nav-dropdown>

        @endcan

        @can('Conciliar')

            <div class="flex items-center w-full justify-between hover:text-red-600 transition ease-in-out duration-500 hover:bg-gray-100 rounded-xl">

                <a href="{{ route('conciliar') }}" class="capitalize font-medium text-sm flex items-center w-full py-2 px-4 focus:outline-rojo focus:outline-offset-2 rounded-lg">

                    Conciliar

                </a>

            </div>

        @endcan

        @can('Conciliar manzanas')

            <div class="flex items-center w-full justify-between hover:text-red-600 transition ease-in-out duration-500 hover:bg-gray-100 rounded-xl">

                <a href="{{ route('conciliar_manzanas') }}" class="capitalize font-medium text-sm flex items-center w-full py-2 px-4 focus:outline-rojo focus:outline-offset-2 rounded-lg">

                    Conciliar manzanas

                </a>

            </div>

        @endcan

        @can('Asignar coordenadas')

            <div class="flex items-center w-full justify-between hover:text-red-600 transition ease-in-out duration-500 hover:bg-gray-100 rounded-xl">

                <a href="{{ route('asignar_coordenadas') }}" class="capitalize font-medium text-sm flex items-center w-full py-2 px-4 focus:outline-rojo focus:outline-offset-2 rounded-lg">

                    Asignar coordenadas

                </a>

            </div>

        @endcan

    </div>

</div>
