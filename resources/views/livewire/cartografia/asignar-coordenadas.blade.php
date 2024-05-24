<div>

    <x-header>Asignar coordenadas</x-header>

    <div class="space-y-2 mb-5 bg-white rounded-lg p-2 shadow-lg">

        <div class="flex-auto ">

            <div class="">

                <div class="flex-col lg:flex lg:space-x-2 mb-2 space-y-2 lg:space-y-0 items-center justify-center" >

                    <div class="text-left">

                        <Label class="text-base tracking-widest rounded-xl border-gray-500">Cuenta predial</Label>

                    </div>

                    <div class="space-y-1">

                        <input title="Localidad" placeholder="Localidad" type="number" class="bg-white rounded text-xs w-20 @error('predio.localidad') border-1 border-red-500 @enderror" wire:model.blur="predio.localidad">

                        <input title="Oficina" placeholder="Oficina" type="number" class="bg-white rounded text-xs w-20 @error('predio.oficina') border-1 border-red-500 @enderror" wire:model="predio.oficina" @if(auth()->user()->oficina->oficina != 101) readonly @endif>

                        <input title="Tipo de predio" placeholder="Tipo" type="number" class="bg-white rounded text-xs w-20 @error('predio.tipo_predio') border-1 border-red-500 @enderror" wire:model="predio.tipo_predio">

                        <input title="Número de registro" placeholder="Registro" type="number" class="bg-white rounded text-xs w-20 @error('predio.numero_registro') border-1 border-red-500 @enderror" wire:model.blur="predio.numero_registro">

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

    </div>

    @if($predio->getKey())

        <div class="space-y-2 mb-5 bg-white rounded-lg p-2 shadow-lg">

            <h4 class="text-lg mb-5 text-center">Coordenadas geografícas</h4>

            <div class="flex-auto ">

                <div class="">

                    <div class="flex-row lg:flex lg:space-x-2 mb-2 space-y-2 lg:space-y-0 items-center justify-center" >

                        <div class="text-left">

                            <Label class="text-base tracking-widest rounded-xl border-gray-500">UTM</Label>

                        </div>

                        <div class="space-y-1">

                            <input placeholder="X" type="text" class="bg-white rounded text-xs w-40 @error('predio.xutm') border-red-500 @enderror" wire:model.blur="predio.xutm">

                            <input placeholder="Y" type="text" class="bg-white rounded text-xs w-40 @error('predio.yutm') border-red-500 @enderror" wire:model.blur="predio.yutm">

                            <select class="bg-white rounded text-xs" wire:model.blur="predio.zutm">

                                <option value="" selected>Z</option>
                                <option value="13" selected>13</option>
                                <option value="14" selected>14</option>

                            </select>

                            <input placeholder="Norte" type="text" class="bg-white rounded text-xs w-40" readonly>

                        </div>

                    </div>

                </div>

                <div class="">

                    <div class="flex-row lg:flex lg:space-x-2 mb-2 space-y-2 lg:space-y-0 items-center justify-center" >

                        <div class="text-left">

                            <Label class="text-base tracking-widest rounded-xl border-gray-500">GEO</Label>

                        </div>

                        <div class="space-y-1">

                            <input placeholder="Lat" type="number" class="bg-white rounded text-xs w-40 @error('predio.lat') border-red-500 @enderror" wire:model.blur="predio.lat">

                            <input placeholder="Lon" type="number" class="bg-white rounded text-xs w-40 @error('predio.lon') border-red-500 @enderror" wire:model.blur="predio.lon">

                        </div>

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

                    Asignar coordenadas

                </button>

            </div>

        </div>

    @endif

</div>
