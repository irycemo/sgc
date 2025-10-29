<div>

    <x-header>Conciliar manzanas</x-header>

    <div class="mb-5 bg-white rounded-lg p-4 shadow-lg">

        <div class="mb-3">

            <div class="text-center">

                <Label class="text-base tracking-widest rounded-xl border-gray-500">Clave catastral </Label>

            </div>

            <div class="text-center space-y-2">

                <input placeholder="Estado" type="number" class="bg-white rounded text-xs w-20" title="Estado" value="16" readonly>

                <input title="Región catastral" placeholder="Región" type="number" class="bg-white rounded text-xs w-20  @error('region_catastral') border-1 border-red-500 @enderror" wire:model="region_catastral">

                <input title="Municipio" placeholder="Municipio" type="number" class="bg-white rounded text-xs w-20 @error('municipio') border-1 border-red-500 @enderror" wire:model="municipio">

                <input title="Zona" placeholder="Zona" type="number" class="bg-white rounded text-xs w-20 @error('zona_catastral') border-1 border-red-500 @enderror" wire:model="zona_catastral">

                <input title="Localidad" placeholder="Localidad" type="number" class="bg-white rounded text-xs w-20 @error('localidad') border-1 border-red-500 @enderror" wire:model.blur="localidad">

                <input title="Sector" placeholder="Sector" type="number" class="bg-white rounded text-xs w-20 @error('sector') border-1 border-red-500 @enderror" wire:model="sector">

                <input title="Manzana" placeholder="Manzana" type="number" class="bg-white rounded text-xs w-20 @error('manzana') border-1 border-red-500 @enderror" wire:model="manzana">

            </div>

        </div>

        <div class="mx-auto mb-3">

            <div class="text-center">

                <Label class="text-base tracking-widest rounded-xl border-gray-500">Predios</Label>

            </div>

            <div class="text-center">

                <input title="Predio inicial" placeholder="Predio inicial" type="number" class="bg-white rounded text-xs w-28 @error('predio_inicial') border-1 border-red-500 @enderror" wire:model="predio_inicial">

                <input title="Predio final" placeholder="Predio final" type="number" class="bg-white rounded text-xs w-28 @error('predio_final') border-1 border-red-500 @enderror" wire:model="predio_final">

            </div>

        </div>

        <div class="mx-auto mb-3">

            <div class="text-center">

                <Label class="text-base tracking-widest rounded-xl border-gray-500">Nuevos valores</Label>

            </div>

            <div class="text-center">

                <input title="Nuevo sector" placeholder="Nuevo sector" type="number" class="bg-white rounded text-xs w-28 @error('nuevo_sector') border-1 border-red-500 @enderror" wire:model="nuevo_sector">

                <input title="Nueva manzana" placeholder="Nueva manzana" type="number" class="bg-white rounded text-xs w-28 @error('nueva_manzana') border-1 border-red-500 @enderror" wire:model="nueva_manzana">

            </div>

        </div>

        <button
            wire:click="cambiarManzana"
            wire:loading.attr="disabled"
            wire:target="cambiarManzana"
            type="button"
            class="bg-blue-400 hover:shadow-lg mx-auto text-white font-bold px-4 py-2 rounded text-xs hover:bg-blue-700 focus:outline-none flex items-center justify-center focus:outline-blue-400 focus:outline-offset-2">

            <img wire:loading wire:target="cambiarManzana" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

            Conciliar

        </button>

    </div>

    @if($flag)

        <div class="mb-5 bg-white rounded-lg p-4 shadow-lg">

            <span class="block text-center tracking-wider font-bold">{{ $predio_final  - $predio_inicial}} predios conciliados</span>

        </div>

    @endif

</div>
