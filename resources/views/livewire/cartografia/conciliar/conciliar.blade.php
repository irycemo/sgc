<div>

    <x-header>Conciliación de predios</x-header>

    <div class="space-y-2 mb-5 bg-white rounded-lg p-2 shadow-lg">

        <div class="flex-auto ">

            @include('livewire.comun.cuenta-clave-captura')

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

                <button
                    wire:click="buscarClaveCatastral"
                    wire:loading.attr="disabled"
                    wire:target="buscarClaveCatastral"
                    type="button"
                    class="bg-blue-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded text-xs hover:bg-blue-700 focus:outline-none flex items-center justify-center focus:outline-blue-400 focus:outline-offset-2">

                    <img wire:loading wire:target="buscarClaveCatastral" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                    Consultar clave catastral

                </button>

            </div>

        </div>

    </div>

    @if($predio->getKey())

        @include('livewire.comun.ubicacion-predio')

        @include('livewire.comun.coordenadas')

        <div class="space-y-2 mb-5 bg-white rounded-lg p-2 shadow-lg">

            <div class="flex-auto ">

                <div class="">

                    <div class="flex-row lg:flex lg:space-x-2 space-y-2 lg:space-y-0 items-center justify-center">

                         <div class="text-left">

                            <Label class="text-base tracking-widest rounded-xl border-gray-500">Clave catastral conciliada </Label>

                        </div>

                        <div class="space-y-1">

                            <input placeholder="Estado" type="number" class="bg-white rounded text-xs w-20" title="Estado" value="16" readonly>

                            <input title="Región catastral" placeholder="Región" type="number" class="bg-white rounded text-xs w-20  @error('region_catastral') border-1 border-red-500 @enderror" wire:model="region_catastral" readonly>

                            <input title="Municipio" placeholder="Municipio" type="number" class="bg-white rounded text-xs w-20 @error('municipio') border-1 border-red-500 @enderror" wire:model="municipio" readonly>

                            <input title="Zona" placeholder="Zona" type="number" class="bg-white rounded text-xs w-20 @error('zona_catastral') border-1 border-red-500 @enderror" wire:model="zona_catastral" readonly>

                            <input title="Localidad" placeholder="Localidad" type="number" class="bg-white rounded text-xs w-20 @error('localidad') border-1 border-red-500 @enderror" wire:model="localidad" readonly>

                            <input title="Sector" placeholder="Sector" type="number" class="bg-white rounded text-xs w-20 @error('sector') border-1 border-red-500 @enderror" wire:model="sector">

                            <input title="Manzana" placeholder="Manzana" type="number" class="bg-white rounded text-xs w-20 @error('manzana') border-1 border-red-500 @enderror" wire:model="manzana">

                            <input title="Predio" placeholder="Predio" type="number" class="bg-white rounded text-xs w-20 @error('predio_cc') border-1 border-red-500 @enderror" wire:model="predio_cc">

                            <input title="Edificio" placeholder="Edificio" type="number" class="bg-white rounded text-xs w-20 @error('edificio') border-1 border-red-500 @enderror" wire:model="edificio">

                            <input title="Departamento" placeholder="Departamento" type="number" class="bg-white rounded text-xs w-20 @error('departamento') border-1 border-red-500 @enderror" wire:model="departamento">

                        </div>

                    </div>

                    @if($flag)

                        <div class="flex-row lg:flex lg:space-x-2 mb-2 space-y-2 lg:space-y-0 items-center justify-center" >

                            <div class="text-left">

                                <Label class="text-base tracking-widest rounded-xl border-gray-500">Cuenta predial encontrada</Label>

                            </div>

                            <div class="space-y-1">

                                <input readonly title="Localidad" placeholder="Localidad" type="number" class="bg-white rounded text-xs w-20 @error('localidad') border-1 border-red-500 @enderror" wire:model.blur="localidad">

                                <input readonly title="Oficina" placeholder="Oficina" type="number" class="bg-white rounded text-xs w-20 @error('oficina') border-1 border-red-500 @enderror" wire:model="oficina" @if(auth()->user()->oficina->oficina != 101) readonly @endif>

                                <input readonly title="Tipo de predio" placeholder="Tipo" type="number" class="bg-white rounded text-xs w-20 @error('tipo_predio') border-1 border-red-500 @enderror" wire:model="tipo_predio">

                                <input readonly title="Número de registro" placeholder="Registro" type="number" class="bg-white rounded text-xs w-20 @error('numero_registro') border-1 border-red-500 @enderror" wire:model.blur="numero_registro">

                            </div>

                        </div>

                    @endif

                </div>

            </div>

        </div>

        @include('livewire.comun.errores')

        <div class="space-y-2 mb-5 bg-white rounded-lg p-2 shadow-lg flex justify-end">

            <x-button-green
                wire:click="conciliar"
                wire:loading.attr="disabled"
                wire:target="conciliar">

                <img wire:loading wire:target="conciliar" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                Conciliar

            </x-button-green>

        </div>

    @endif

</div>
