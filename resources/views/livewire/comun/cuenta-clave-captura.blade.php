<div class="">

    <div class="flex-row lg:flex lg:space-x-2 mb-2 space-y-2 lg:space-y-0 items-center justify-center" >

        <div class="text-left">

            <Label class="text-base tracking-widest rounded-xl border-gray-500">Cuenta predial</Label>

        </div>

        <div class="space-y-1">

            <input title="Localidad" placeholder="Localidad" type="number" class="bg-white rounded text-xs w-20 @error('predio.localidad') border-1 border-red-500 @enderror" wire:model.blur="predio.localidad">

            <input title="Oficina" placeholder="Oficina" type="number" class="bg-white rounded text-xs w-20 @error('predio.oficina') border-1 border-red-500 @enderror" wire:model.blur="predio.oficina" @if(auth()->user()->oficina->oficina != 101) readonly @endif>

            <input title="Tipo de predio" placeholder="Tipo" type="number" class="bg-white rounded text-xs w-20 @error('predio.tipo_predio') border-1 border-red-500 @enderror" wire:model="predio.tipo_predio">

            <input title="Número de registro" placeholder="Registro" type="number" class="bg-white rounded text-xs w-20 @error('predio.numero_registro') border-1 border-red-500 @enderror" wire:model.blur="predio.numero_registro">

        </div>

    </div>

    <div class="flex-row lg:flex lg:space-x-2 space-y-2 lg:space-y-0 items-center justify-center">

         <div class="text-left">

            <Label class="text-base tracking-widest rounded-xl border-gray-500">Clave catastral </Label>

        </div>

        <div class="space-y-1">

            <input placeholder="Estado" type="number" class="bg-white rounded text-xs w-20" title="Estado" value="16" readonly>

            <input title="Región" placeholder="Región" type="number" class="bg-white rounded text-xs w-20  @error('predio.region_catastral') border-1 border-red-500 @enderror" wire:model="predio.region_catastral">

            <input title="Municipio" placeholder="Municipio" type="number" class="bg-white rounded text-xs w-20 @error('predio.municipio') border-1 border-red-500 @enderror" wire:model="predio.municipio" readonly>

            <input title="Zona" placeholder="Zona" type="number" class="bg-white rounded text-xs w-20 @error('predio.zona_catastral') border-1 border-red-500 @enderror" wire:model="predio.zona_catastral">

            <input title="Localidad" placeholder="Localidad" type="number" class="bg-white rounded text-xs w-20 @error('predio.localidad') border-1 border-red-500 @enderror" wire:model.blur="predio.localidad">

            <input title="Sector" placeholder="Sector" type="number" class="bg-white rounded text-xs w-20 @error('predio.sector') border-1 border-red-500 @enderror" wire:model="predio.sector">

            <input title="Manzana" placeholder="Manzana" type="number" class="bg-white rounded text-xs w-20 @error('predio.manzana') border-1 border-red-500 @enderror" wire:model="predio.manzana">

            <input title="Predio" placeholder="Predio" type="number" class="bg-white rounded text-xs w-20 @error('predio.predio') border-1 border-red-500 @enderror" wire:model.blur="predio.predio">

            <input title="Edificio" placeholder="Edificio" type="number" class="bg-white rounded text-xs w-20 @error('predio.edificio') border-1 border-red-500 @enderror" wire:model="predio.edificio">

            <input title="Departamento" placeholder="Departamento" type="number" class="bg-white rounded text-xs w-20 @error('predio.departamento') border-1 border-red-500 @enderror" wire:model="predio.departamento">

        </div>

    </div>

</div>