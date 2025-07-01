<div x-data="{openValuacion:false, openValuacionyD:true}" class="mb-5">

    <div class="flex items-center  w-full justify-between mb-2">

        <p class="uppercase text-base mb-2 border-b border-rojo rounded-lg px-1.5 w-full">Trámites</p>

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

        <div class="flex items-center w-full justify-between hover:text-red-600 transition ease-in-out duration-500 hover:bg-gray-100 rounded-xl">

            <a href="{{ route('ventanilla') }}" class="capitalize font-medium text-sm flex items-center w-full py-2 px-4 focus:outline-rojo focus:outline-offset-2 rounded-lg">

                Ventanilla

            </a>

        </div>

        @can('Reactivar trámites')

            <div class="flex items-center w-full justify-between hover:text-red-600 transition ease-in-out duration-500 hover:bg-gray-100 rounded-xl">

                <a href="{{ route('reactivar_tramites') }}" class="capitalize font-medium text-sm flex items-center w-full py-2 px-4 focus:outline-rojo focus:outline-offset-2 rounded-lg">

                    Reactivar trámites

                </a>

            </div>

        @endcan

        @can('Trámites en línea')

            <div class="flex items-center w-full justify-between hover:text-red-600 transition ease-in-out duration-500 hover:bg-gray-100 rounded-xl">

                <a href="{{ route('tramites_linea') }}" class="capitalize font-medium text-sm flex items-center w-full py-2 px-4 focus:outline-rojo focus:outline-offset-2 rounded-lg">

                    Trámites en línea

                </a>

            </div>

        @endcan

        @can('Requerimientos')

            <div class="flex items-center w-full justify-between hover:text-red-600 transition ease-in-out duration-500 hover:bg-gray-100 rounded-xl">

                <a href="{{ route('requerimientos') }}" class="capitalize font-medium text-sm flex items-center w-full py-2 px-4 focus:outline-rojo focus:outline-offset-2 rounded-lg">

                    Requerimientos

                </a>

            </div>

        @endcan

    </div>

</div>
