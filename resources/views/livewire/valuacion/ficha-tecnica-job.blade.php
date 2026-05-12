<div class="">

    <x-header>Ficha Técnica jobs</x-header>

    <div class="space-y-2 mb-5 bg-white rounded-lg p-2 shadow-xl">

        @if(! $procesando)

            <div class="md:w-1/2 lg:w-1/4 mx-auto items-center text-center">

                <div class="mb-5">

                    <x-filepond wire:model.live="documento"  accept="['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', '.xlsx']"/>

                </div>

                <div>

                    @error('documento') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                </div>

                @if($documento)

                    <button
                        class="bg-blue-400 hover:shadow-lg w-full justify-center text-white text-xs md:text-sm px-3 py-1 items-center rounded-full mr-2 hover:bg-blue-700 flex focus:outline-none"
                        wire:click="procesar"
                        wire:loading.attr="disabled"
                        wire:target="procesar">

                        <img wire:loading wire:target="procesar" class="h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                        Procesar
                    </button>

                @else

                    <button
                        class="bg-green-400 hover:shadow-lg w-full justify-center text-white text-xs md:text-sm px-3 py-1 items-center rounded-full mr-2 hover:bg-green-700 flex focus:outline-none"
                        wire:click="descargarFicha"
                        wire:loading.attr="disabled"
                        wire:target="descargarFicha">

                        <div wire:loading.flex wire:target="descargarFicha" class="flex absolute top-1 right-1 items-center">
                            <svg class="animate-spin h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>

                        Descargar ficha técnica
                    </button>

                @endif

            </div>

        @else

            <div wire:poll.1500ms="estadisticas" class="w-full max-w-xl mx-auto bg-white rounded-lg p-2 mb-5">

                <div class="mb-2 flex justify-between text-sm">
                    <span>Progreso</span>
                    <span>{{ $progress }}%</span>
                </div>

                <div class="w-full bg-gray-200 rounded-full h-4">
                    <div
                        class="h-4 rounded-full transition-all duration-500 bg-green-500"
                        style="width: {{ $progress }}%">
                    </div>
                </div>

                <div class="mt-3 text-sm text-gray-600">
                    Procesados: {{ $processed }} / {{ $total }}
                </div>

            </div>

        @endif

    </div>

    @if(count($errores) > 0)

        <div class="mb-5 bg-white rounded-lg p-2 shadow-lg flex gap-2 flex-wrap ">

            <ul class="flex gap-2 felx flex-wrap list-disc ml-5">

                @foreach ($errores as $error)

                    <li class="text-red-500 text-xs md:text-sm ml-5">
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif

    @if(count($avaluos_generados) > 0)

        <div class="mb-5 bg-white rounded-lg p-2 shadow-lg flex gap-2 flex-wrap ">

            <ul class="gap-2 felx flex-wrap list-disc ml-5 grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4">

                @foreach ($avaluos_generados as $avaluo)

                    <li class="text-sm md:text-sm ml-5">
                        {{ $avaluo }}
                    </li>

                @endforeach

            </ul>

        </div>

    @endif

</div>
