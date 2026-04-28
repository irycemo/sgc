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

    <div class="flex gap-4 justify-center text-sm">

        <div class="bg-white rounded-lg p-2 shadow-lg max-h-80 overflow-auto">

            <span>Manzanas ocupadas</span>

            @foreach ($manzanas_ocupadas as $ocupada)

                <p>{{ $municipio }}-{{ $zona }}-{{ $localidad }}-{{ $sector }}-{{ $ocupada }}</p>

            @endforeach

        </div>

        <div class="bg-white rounded-lg p-2 shadow-lg max-h-80 overflow-auto">

            <span>Manzanas disponibles</span>

            @foreach ($manzanas_disponibles as $ocupada)

                <p>{{ $municipio }}-{{ $zona }}-{{ $localidad }}-{{ $sector }}-{{ $ocupada }}</p>

            @endforeach

        </div>

    </div>

</div>
