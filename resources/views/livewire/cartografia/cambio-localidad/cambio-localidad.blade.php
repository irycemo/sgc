<div>

    <x-header>Cambio de localidad</x-header>

    <div class="space-y-2 mb-5 bg-white rounded-lg p-2 shadow-lg">

        @if(!$predio->getKey())
            <div class="flex-auto ">

                <div class="">

                    <div class="flex-col lg:flex lg:space-x-2 mb-2 space-y-2 lg:space-y-0 items-center justify-center" >

                        <div class="text-left">

                            <Label class="text-base tracking-widest rounded-xl border-gray-500">Cuenta predial</Label>

                        </div>

                        <div class="space-y-1">

                            <input title="Localidad" placeholder="Localidad" type="number" class="bg-white rounded text-xs w-20 @error('localidad') border-1 border-red-500 @enderror" wire:model.blur="localidad">

                            <input title="Oficina" placeholder="Oficina" type="number" class="bg-white rounded text-xs w-20 @error('oficina') border-1 border-red-500 @enderror" wire:model="oficina" @if(auth()->user()->oficina->oficina != 101) readonly @endif>

                            <input title="Tipo de predio" placeholder="Tipo" type="number" class="bg-white rounded text-xs w-20 @error('tipo_predio') border-1 border-red-500 @enderror" wire:model="tipo_predio">

                            <input title="Número de registro" placeholder="Registro" type="number" class="bg-white rounded text-xs w-20 @error('numero_registro') border-1 border-red-500 @enderror" wire:model.blur="numero_registro">

                        </div>

                    </div>

                </div>

                <div class="mb-2 flex-col sm:flex-row mx-auto mt-5 flex space-y-2 sm:space-y-0 sm:space-x-3 justify-center">

                    <button
                        wire:click="buscarCuentaPredial"
                        wire:loading.attr="disabled"
                        wire:target="buscarCuentaPredial"
                        type="button"
                        class="bg-blue-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded text-xs hover:bg-blue-700 focus:outline-none flex items-center justify-center focus:outline-blue-400 focus:outline-offset-2">

                        <img wire:loading wire:target="buscarCuentaPredial" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                        Consultar cuenta predial

                    </button>

                </div>

            </div>

        @else

            <div class="flex-auto ">

                <div class="flex-col lg:flex lg:space-x-2 mb-2 space-y-2 lg:space-y-0 items-center justify-center" >

                    <div class="text-left">

                        <Label class="text-base tracking-widest rounded-xl border-gray-500">Cuenta predial</Label>

                    </div>

                    <div class="space-y-1">

                        <input title="Localidad" placeholder="Localidad" type="number" class="bg-white rounded text-xs w-20 @error('predio_nuevo.localidad') border-1 border-red-500 @enderror" wire:model.blur="predio_nuevo.localidad">

                        <input title="Oficina" placeholder="Oficina" type="number" class="bg-white rounded text-xs w-20 @error('predio_nuevo.oficina') border-1 border-red-500 @enderror" wire:model="predio_nuevo.oficina" @if(auth()->user()->oficina->oficina != 101) readonly @endif>

                        <input title="Tipo de predio" placeholder="Tipo" type="number" class="bg-white rounded text-xs w-20 @error('predio_nuevo.tipo_predio') border-1 border-red-500 @enderror" wire:model="predio_nuevo.tipo_predio">

                        <input title="Número de registro" placeholder="Registro" type="number" class="bg-white rounded text-xs w-20 @error('predio_nuevo.numero_registro') border-1 border-red-500 @enderror" wire:model.blur="predio_nuevo.numero_registro">

                    </div>

                </div>

                <div class="flex-col lg:flex lg:space-x-2 mb-2 space-y-2 lg:space-y-0 items-center justify-center" >

                    <div class="text-left">

                        <Label class="text-base tracking-widest rounded-xl border-gray-500">Clave catastral </Label>

                    </div>

                    <div class="space-y-1">

                        <input placeholder="Estado" type="number" class="bg-white rounded text-xs w-20" title="Estado" value="16" readonly>

                        <input title="Región" placeholder="Región" type="number" class="bg-white rounded text-xs w-20  @error('predio_nuevo.region_catastral') border-1 border-red-500 @enderror" wire:model="predio_nuevo.region_catastral">

                        <input title="Municipio" placeholder="Municipio" type="number" class="bg-white rounded text-xs w-20 @error('predio_nuevo.municipio') border-1 border-red-500 @enderror" wire:model="predio_nuevo.municipio" readonly>

                        <input title="Zona" placeholder="Zona" type="number" class="bg-white rounded text-xs w-20 @error('predio_nuevo.zona_catastral') border-1 border-red-500 @enderror" wire:model="predio_nuevo.zona_catastral">

                        <input title="Localidad" placeholder="Localidad" type="number" class="bg-white rounded text-xs w-20 @error('predio_nuevo.localidad') border-1 border-red-500 @enderror" wire:model.blur="predio_nuevo.localidad">

                        <input title="Sector" placeholder="Sector" type="number" class="bg-white rounded text-xs w-20 @error('predio_nuevo.sector') border-1 border-red-500 @enderror" wire:model="predio_nuevo.sector">

                        <input title="Manzana" placeholder="Manzana" type="number" class="bg-white rounded text-xs w-20 @error('predio_nuevo.manzana') border-1 border-red-500 @enderror" wire:model="predio_nuevo.manzana">

                        <input title="Predio" placeholder="Predio" type="number" class="bg-white rounded text-xs w-20 @error('predio_nuevo.predio') border-1 border-red-500 @enderror" wire:model.blur="predio_nuevo.predio">

                        <input title="Edificio" placeholder="Edificio" type="number" class="bg-white rounded text-xs w-20 @error('predio_nuevo.edificio') border-1 border-red-500 @enderror" wire:model="predio_nuevo.edificio">

                        <input title="Departamento" placeholder="Departamento" type="number" class="bg-white rounded text-xs w-20 @error('predio_nuevo.departamento') border-1 border-red-500 @enderror" wire:model="predio_nuevo.departamento">

                    </div>

                </div>

                <div class="mb-2 flex-col sm:flex-row mx-auto mt-5 flex space-y-2 sm:space-y-0 sm:space-x-3 justify-center">

                    <button
                        wire:click="cambiarLocalidad"
                        wire:loading.attr="disabled"
                        wire:target="cambiarLocalidad"
                        type="button"
                        class="bg-blue-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded text-xs hover:bg-blue-700 focus:outline-none flex items-center justify-center focus:outline-blue-400 focus:outline-offset-2">

                        <img wire:loading wire:target="cambiarLocalidad" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                        Hacer cambio de localidad

                    </button>

                </div>

            </div>

        @endif

    </div>

</div>
