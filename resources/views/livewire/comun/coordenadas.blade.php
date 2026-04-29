<div class="space-y-2 mb-5 bg-white rounded-lg p-3 shadow-xl">

    <h4 class="text-lg mb-5 text-center">Coordenadas geografícas</h4>

    <div class="flex-auto ">

        <div class="">

            <div class="flex-row lg:flex lg:space-x-2 mb-2 space-y-2 lg:space-y-0 items-center justify-center" >

                <div class="text-left">

                    <Label class="text-base tracking-widest rounded-xl border-gray-500">UTM</Label>

                </div>

                <div class="space-y-1">

                    <input placeholder="X" type="text" class="bg-white rounded text-xs w-40 @error('predio.xutm') border-red-500 @enderror" wire:model.lazy="predio.xutm">

                    <input placeholder="Y" type="text" class="bg-white rounded text-xs w-40 @error('predio.yutm') border-red-500 @enderror" wire:model.lazy="predio.yutm">

                    <select class="bg-white rounded text-xs" wire:model.lazy="predio.zutm">

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

                    <input placeholder="Lat" type="number" class="bg-white rounded text-xs w-40 @error('predio.lat') border-red-500 @enderror" wire:model.lazy="predio.lat">

                    <input placeholder="Lon" type="number" class="bg-white rounded text-xs w-40 @error('predio.lon') border-red-500 @enderror" wire:model.lazy="predio.lon">

                </div>

                <button
                    wire:click="convertirCoordenadas"
                    wire:loading.attr="disabled"
                    wire:target="convertirCoordenadas"
                    type="button"
                    class="bg-blue-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded text-xs hover:bg-blue-700 focus:outline-none flex items-center justify-center focus:outline-blue-400 focus:outline-offset-2">

                    Convertir

                </button>

            </div>

        </div>

    </div>

</div>