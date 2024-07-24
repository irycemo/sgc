<div>

    <x-header>Conciliación de predios</x-header>

    <div class="space-y-2 mb-5 bg-white rounded-lg p-2 shadow-lg">

        <div class="flex-auto ">

            <div class="">

                <div class="flex-row lg:flex lg:space-x-2 mb-2 space-y-2 lg:space-y-0 items-center justify-center" >

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

                <div class="flex-row lg:flex lg:space-x-2 space-y-2 lg:space-y-0 items-center justify-center">

                     <div class="text-left">

                        <Label class="text-base tracking-widest rounded-xl border-gray-500">Clave catastral </Label>

                    </div>

                    <div class="space-y-1">

                        <input placeholder="Estado" type="number" class="bg-white rounded text-xs w-20" title="Estado" value="16" readonly>

                        <input title="Región catastral" placeholder="Región" type="number" class="bg-white rounded text-xs w-20  @error('predio.region_catastral') border-1 border-red-500 @enderror" wire:model="predio.region_catastral">

                        <input title="Municipio" placeholder="Municipio" type="number" class="bg-white rounded text-xs w-20 @error('predio.municipio') border-1 border-red-500 @enderror" wire:model="predio.municipio">

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

        <div class="space-y-2 mb-5 bg-white rounded-lg p-2 shadow-lg">

            <h4 class="text-lg mb-5 text-center">Ubicación del predio</h4>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-3 items-start">

                <div class="flex-auto ">

                    <div>

                        <label class="text-sm" >Código postal</label>

                    </div>

                    <div>

                        <input type="number" class="bg-white rounded text-xs w-full" wire:model.lazy="predio.codigo_postal">

                    </div>

                    <div>

                        @error('predio.codigo_postal') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                    </div>

                </div>

                <div class="flex-auto">

                    <div class="">

                        <label class="text-sm " >Nombre del asentamiento</label>

                    </div>

                    <div>

                        <select class="bg-white rounded text-xs w-full" wire:model.live="predio.nombre_asentamiento">

                            <option value="" selected>Seleccione una opción</option>

                            @if($nombres_asentamientos)

                                @foreach ($nombres_asentamientos as $nombre)

                                    <option value="{{ $nombre }}">{{ $nombre }}</option>

                                @endforeach

                            @endif

                        </select>

                    </div>

                    <div>

                        @error('predio.nombre_asentamiento') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                    </div>

                </div>

                <div class="flex-auto">

                    <div>

                        <Label class="text-sm">Tipo de asentamiento</Label>
                    </div>

                    <div>

                        <input type="text" class="bg-white rounded text-xs w-full" wire:model="predio.tipo_asentamiento" readonly>

                    </div>

                    <div>

                        @error('predio.tipo_asentamiento') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                    </div>

                </div>

                <div class="flex-auto ">

                    <div>

                        <Label class="text-sm">Tipo de vialidad</Label>
                    </div>

                    <div>

                        <select class="bg-white rounded text-xs w-full" wire:model="predio.tipo_vialidad">
                            <option value="" selected>Seleccione una opción</option>

                            @foreach ($tipoVialidades as $item)

                                <option value="{{ $item }}" selected>{{ $item }}</option>

                            @endforeach

                        </select>

                    </div>

                    <div>

                        @error('predio.tipo_vialidad') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                    </div>

                </div>

                <div class="flex-auto ">

                    <div>

                        <label class="text-sm" >Nombre de la vialidad</label>

                    </div>

                    <div>

                        <input type="text" class="bg-white rounded text-xs w-full" wire:model="predio.nombre_vialidad">

                    </div>

                    <div>

                        @error('predio.nombre_vialidad') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                    </div>

                </div>

                <div class="flex-auto ">

                    <div>

                        <label class="text-sm" >Número exterior</label>

                    </div>

                    <div>

                        <input type="text" class="bg-white rounded text-xs w-full" wire:model="predio.numero_exterior">

                    </div>

                    <div>

                        @error('predio.numero_exterior') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                    </div>

                </div>

                <div class="flex-auto ">

                    <div>

                        <label class="text-sm" >Número exterior 2</label>

                    </div>

                    <div>

                        <input type="text" class="bg-white rounded text-xs w-full" wire:model="predio.numero_exterior_2">

                    </div>

                    <div>

                        @error('predio.numero_exterior_2') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                    </div>

                </div>

                <div class="flex-auto ">

                    <div>

                        <label class="text-sm" >Número interior</label>

                    </div>

                    <div>

                        <input type="text" class="bg-white rounded text-xs w-full" wire:model="predio.numero_interior">

                    </div>

                    <div>

                        @error('predio.numero_interior') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                    </div>

                </div>

                <div class="flex-auto ">

                    <div>

                        <label class="text-sm" >Número adicional</label>

                    </div>

                    <div>

                        <input type="text" class="bg-white rounded text-xs w-full" wire:model="predio.numero_adicional">

                    </div>

                    <div>

                        @error('predio.numero_adicional') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                    </div>

                </div>

                <div class="flex-auto ">

                    <div>

                        <label class="text-sm" >Número adicional 2</label>

                    </div>

                    <div>

                        <input type="text" class="bg-white rounded text-xs w-full" wire:model="predio.numero_adicional_2">

                    </div>

                    <div>

                        @error('predio.numero_adicional_2') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                    </div>

                </div>

                <div class="flex-auto ">

                    <div>

                        <label class="text-sm" >Lote del fraccionador</label>

                    </div>

                    <div>

                        <input type="number" class="bg-white rounded text-xs w-full" wire:model="predio.lote_fraccionador">

                    </div>

                    <div>

                        @error('predio.lote_fraccionador') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                    </div>

                </div>

                <div class="flex-auto ">

                    <div>

                        <label class="text-sm" >Manzana del fraccionador</label>

                    </div>

                    <div>

                        <input type="number" class="bg-white rounded text-xs w-full" wire:model="predio.manzana_fraccionador">

                    </div>

                    <div>

                        @error('predio.manzana_fraccionador') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                    </div>

                </div>

                <div class="flex-auto ">

                    <div>

                        <label class="text-sm" >Etapa o zona del fraccionador</label>

                    </div>

                    <div>

                        <input type="number" class="bg-white rounded text-xs w-full" wire:model="predio.etapa_fraccionador">

                    </div>

                    <div>

                        @error('predio.etapa_fraccionador') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                    </div>

                </div>

                <div class="flex-auto ">

                    <div>

                        <label class="text-sm">Nombre del Edificio</label>

                    </div>

                    <div>

                        <input type="text" class="bg-white rounded text-xs w-full" wire:model="predio.nombre_edificio">

                    </div>

                    <div>

                        @error('predio.nombre_edificio') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                    </div>

                </div>

                <div class="flex-auto ">

                    <div>

                        <label class="text-sm">Clave del edificio</label>

                    </div>

                    <div>

                        <input type="text" class="bg-white rounded text-xs w-full" wire:model="predio.clave_edificio">

                    </div>

                    <div>

                        @error('predio.clave_edificio') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                    </div>

                </div>

                <div class="flex-auto ">

                    <div>

                        <label class="text-sm">Departamento</label>

                    </div>

                    <div>

                        <input type="text" class="bg-white rounded text-xs w-full" wire:model="predio.departamento_edificio">

                    </div>

                    <div>

                        @error('predio.departamento_edificio') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                    </div>

                </div>

                <div class="flex-auto col-span-2">

                    <div>

                        <label class="text-sm">Predio Rústico Denominado ó Antecedente</label>

                    </div>

                    <div>

                        <input type="text" class="bg-white rounded text-xs w-full" wire:model="predio.nombre_predio">

                    </div>

                    <div>

                        @error('predio.nombre_predio') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                    </div>

                </div>

            </div>

        </div>

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

                    <div class="flex items-center justify-center gap-3">

                        <a href="{{ 'http://mapa.catastro.michoacan.gob.mx:8080/index.html?pzoom=20&plat=' . $predio->lat . '&plon=' . $predio->lon }}" title="SIG" target="_blank">
                            <img class="h-6 cursor-pointer" src="{{ asset('storage/img/ico.png') }}" alt="SIG">
                        </a>

                        <a href="{{ 'https://www.google.com/maps/?q=' . $predio->lat . ',' . $predio->lon . '&z=5&t=k' }}" title="Google" target="_blank">

                            <img class="h-6 cursor-pointer" src="{{ asset('storage/img/ico.png') }}" alt="Google">

                        </a>

                    </div>

                </div>

            </div>

        </div>

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

        @if(count($errors) > 0)

            <div class="mb-5 bg-white rounded-lg p-2 shadow-lg flex gap-2 flex-wrap ">

                <ul class="flex gap-2 felx flex-wrap list-disc ml-5">
                @foreach ($errors->all() as $error)

                    <li class="text-red-500 text-xs md:text-sm ml-5">
                        {{ $error }}
                    </li>

                @endforeach

            </ul>

            </div>

        @endif

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
