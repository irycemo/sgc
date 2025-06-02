<div class="bg-white p-4 rounded-lg space-y-2 mb-3 shadow-md" wire:loading.class.delay.longest="opacity-50">

    <div class="mb-2">

        <Label class="text-lg tracking-widest rounded-xl border-gray-500">Clave catastral</Label>

    </div>

    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-2">

        <input placeholder="Estado" type="number" class="bg-white rounded text-xs w-full" title="Estado" value="16" readonly>

        <input title="Región" placeholder="Región" type="number" class="bg-white rounded text-xs w-full  @error('region_catastral') border-1 border-red-500 @enderror" wire:model="region_catastral">

        <input title="Municipio" placeholder="Municipio" type="number" class="bg-white rounded text-xs w-full @error('municipio') border-1 border-red-500 @enderror" wire:model="municipio" @if(auth()->user()->oficina->oficina != 101) readonly @endif>

        <input title="Zona" placeholder="Zona" type="number" class="bg-white rounded text-xs w-full @error('zona_catastral') border-1 border-red-500 @enderror" wire:model="zona_catastral">

        <input title="Localidad" placeholder="Localidad" type="number" class="bg-white rounded text-xs w-full @error('localidad') border-1 border-red-500 @enderror" wire:model="localidad">

        <input title="Sector" placeholder="Sector" type="number" class="bg-white rounded text-xs w-full @error('sector') border-1 border-red-500 @enderror" wire:model="sector">

        <input title="Manzana" placeholder="Manzana" type="number" class="bg-white rounded text-xs w-full @error('manzana') border-1 border-red-500 @enderror" wire:model="manzana">

        <input title="Predio" placeholder="Predio" type="number" class="bg-white rounded text-xs w-full @error('predio') border-1 border-red-500 @enderror" wire:model="predio">

        <input title="Edificio" placeholder="Edificio" type="number" class="bg-white rounded text-xs w-full @error('edificio') border-1 border-red-500 @enderror" wire:model="edificio">

        <input title="Departamento" placeholder="Departamento" type="number" class="bg-white rounded text-xs w-full @error('departamento') border-1 border-red-500 @enderror" wire:model="departamento">

    </div>

    <div>

        @error('modelo_editar.predio_avaluo') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

    </div>

    <div class="text-right">

        <button
            wire:click="buscarPredio"
            wire:loading.attr="disabled"
            wire:target="buscarPredio"
            type="button"
            class="bg-blue-400  hover:shadow-lg text-white font-bold px-4 py-2 rounded text-sm hover:bg-blue-700 focus:outline-none items-center w-fit">
            <img wire:loading wire:target="buscarPredio" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">
            <p class="mr-1"> Buscar</p>
        </button>

    </div>

</div>