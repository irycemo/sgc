<div>

    <x-header>Asignación de manzanas</x-header>

    <div class="space-y-2 mb-5 bg-white rounded-lg p-2 shadow-lg text-center">

        <div class="space-y-1 mb-5">

            <input placeholder="Municipio" type="number" class="bg-white rounded text-xs w-20 @error('municipio') border-1 border-red-500 @enderror" wire:model="municipio">

            <input placeholder="Zona" type="number" class="bg-white rounded text-xs w-20 @error('zona') border-1 border-red-500 @enderror" wire:model="zona">

            <input placeholder="Localidad" type="number" class="bg-white rounded text-xs w-20 @error('localidad') border-1 border-red-500 @enderror" wire:model="localidad">

            <input placeholder="Sector" type="number" class="bg-white rounded text-xs w-20 @error('sector') border-1 border-red-500 @enderror" wire:model="sector">

        </div>

        <div class="mb-2 flex-col sm:flex-row mx-auto mt-5 flex space-y-2 sm:space-y-0 sm:space-x-3 justify-center">

            <button
                wire:click="buscarManzanas"
                wire:loading.attr="disabled"
                wire:target="buscarManzanas"
                type="button"
                class="bg-blue-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded text-xs hover:bg-blue-700 focus:outline-none flex items-center justify-center focus:outline-blue-400 focus:outline-offset-2">

                <img wire:loading wire:target="buscarManzanas" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                Consultar manzanas

            </button>

        </div>

    </div>

    <div class="flex gap-4 justify-center text-sm mb-5 overflow-x-auto max-h-80">

        <div class="bg-white rounded-lg p-2 shadow-lg max-h-80 overflow-y-auto">

            <span class="font-semibold whitespace-nowrap">Manzanas en padrón</span>

            <ul>

                @foreach ($manzanas_ocupadas as $ocupada)

                    <li class="whitespace-nowrap">{{ $municipio }}-{{ $zona }}-{{ $localidad }}-{{ $sector }}-{{ $ocupada }}</li>

                @endforeach

            </ul>

        </div>

        <div class="bg-white rounded-lg p-2 shadow-lg max-h-80 overflow-y-auto">

            <span class="font-semibold whitespace-nowrap">Manzanas restantes</span>

            <ul>

                @foreach ($manzanas_disponibles as $disponible)

                    <li wire:click="agregarManzana({{ $disponible }})"
                        class="cursor-pointer hover:bg-gray-300 rounded-lg px-2 whitespace-nowrap">
                        {{ $municipio }}-{{ $zona }}-{{ $localidad }}-{{ $sector }}-{{ $disponible }}
                    </li>

                @endforeach

            </ul>

        </div>

        @if(count($manzanas_seleccionadas))

            <div class="bg-white rounded-lg p-2 shadow-lg max-h-80 overflow-y-auto">

                <span class="font-semibold whitespace-nowrap">Manzanas seleccionadas</span>

                <ul>

                    @foreach ($manzanas_seleccionadas as $key => $seleccionada)

                        <li wire:click="quitarManzana({{ $key }})"
                            class="cursor-pointer hover:bg-gray-300 rounded-lg px-2 whitespace-nowrap">
                            {{ $municipio }}-{{ $zona }}-{{ $localidad }}-{{ $sector }}-{{ $seleccionada }}
                        </li>

                    @endforeach

                </ul>

            </div>

        @endif

    </div>

    @if(count($manzanas_seleccionadas))

        @include('livewire.comun.coordenadas')

        <div class="bg-white rounded-lg p-2 shadow-lg max-h-80 overflow-auto">

            <x-input-group for="valuador" label="Valuadores" :error="$errors->first('valuador')" class="w-fit mb-5 mx-auto">

                <x-input-select id="valuador" wire:model="valuador" class="w-full">

                    <option value="">Seleccione una opción</option>

                    @foreach ($valuadores as $valuador)

                            <option value="{{ $valuador->id }}">{{ $valuador->name }}</option>

                    @endforeach

                </x-input-select>

            </x-input-group>

            <x-input-group for="observaciones" label="Observaciones" :error="$errors->first('observaciones')" class="w-full lg:w-1/2 mb-5 mx-auto">

                <textarea class="bg-white rounded text-xs w-full " rows="4" wire:model="observaciones"></textarea>

            </x-input-group>

            <button
                wire:click="asignarManzanas"
                wire:loading.attr="disabled"
                wire:target="asignarManzanas"
                type="button"
                class="bg-blue-400 hover:shadow-lg mx-auto mb-5 text-white font-bold px-4 py-2 rounded text-xs hover:bg-blue-700 focus:outline-none flex items-center justify-center focus:outline-blue-400 focus:outline-offset-2">

                <img wire:loading wire:target="asignarManzanas" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                Asignar

            </button>

        </div>

    @endif

</div>
