<div>

    <x-header>Consulta del padrón catastral</x-header>

    <div class="bg-white p-4 rounded-lg shadow-lg mb-5">

        <ul class="grid w-full  mx-auto gap-6 md:grid-cols-3">

            <li>

                <input type="radio" id="clave" name="hosting" value="clave" class="hidden peer" wire:model.live="radio" >

                <label for="clave" class="inline-flex items-center justify-between w-full p-1 px-3 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">

                    <div class="block">

                        <div class="w-full font-semibold">Buscar por cuenta predial o clave catastral</div>

                    </div>

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 13.5 12 21m0 0-7.5-7.5M12 21V3" />
                    </svg>

                </label>

            </li>

            <li>

                <input type="radio" id="propietario" name="hosting" value="propietario" class="hidden peer" wire:model.live="radio">

                <label for="propietario" class="inline-flex items-center justify-between w-full p-1 px-3 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">

                    <div class="block">

                        <div class="w-full font-semibold">Buscar por propietario</div>

                    </div>

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 13.5 12 21m0 0-7.5-7.5M12 21V3" />
                    </svg>

                </label>

            </li>

            <li>

                <input type="radio" id="ubicacion" name="hosting" value="ubicacion" class="hidden peer" wire:model.live="radio">

                <label for="ubicacion" class="inline-flex items-center justify-between w-full p-1 px-3 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">

                    <div class="block">

                        <div class="w-full font-semibold">Buscar por ubicación</div>

                    </div>

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 13.5 12 21m0 0-7.5-7.5M12 21V3" />
                    </svg>

                </label>

            </li>

        </ul>

    </div>

    <div>

        @if($radio === 'clave' && $predio)

            <div class="space-y-2 mb-5 bg-white rounded-lg p-2 shadow-lg">

                <div class="flex-auto ">

                    <div class="">

                        <div class="flex-row lg:flex lg:space-x-2 mb-2 space-y-2 lg:space-y-0 items-center justify-center" >

                            <div class="text-left">

                                <Label class="text-base tracking-widest rounded-xl border-gray-500">Cuenta predial</Label>

                            </div>

                            <div class="space-y-1">

                                <input title="Localidad" placeholder="Localidad" type="number" class="bg-white rounded text-xs w-20 @error('predio.localidad') border-1 border-red-500 @enderror" wire:model.blur="predio.localidad">

                                <input title="Oficina" placeholder="Oficina" type="number" class="bg-white rounded text-xs w-20 @error('predio.oficina') border-1 border-red-500 @enderror" wire:model.blur="predio.oficina" @if(auth()->user()->oficina->oficina != 101) readonly @endif>

                                <input title="Tipo de predio" placeholder="Tipo" type="number" min="1" max="2" class="bg-white rounded text-xs w-20 @error('predio.tipo_predio') border-1 border-red-500 @enderror" wire:model="predio.tipo_predio">

                                <input title="Número de registro" placeholder="Registro" type="number" class="bg-white rounded text-xs w-20 @error('predio.numero_registro') border-1 border-red-500 @enderror" wire:model.blur="predio.numero_registro">

                                <div class="inline-flex items-center">
                                    <span class="text-xs mr-2">+/- 10</span><x-checkbox wire:model.live="diez"></x-checkbox>
                                </div>

                            </div>

                        </div>

                        <div class="flex-row lg:flex lg:space-x-2 space-y-2 lg:space-y-0 items-center justify-center">

                            <div class="text-left">

                                <Label class="text-base tracking-widest rounded-xl border-gray-500">Clave catastral </Label>

                            </div>

                            <div class="space-y-1">

                                <input placeholder="Estado" type="number" class="bg-white rounded text-xs w-20" title="Estado" value="16" readonly>

                                <input title="Región catastral" placeholder="Región" type="number" class="bg-white rounded text-xs w-20  @error('predio.region_catastral') border-1 border-red-500 @enderror" wire:model="predio.region_catastral">

                                <input title="Municipio" placeholder="Municipio" type="number" class="bg-white rounded text-xs w-20 @error('predio.municipio') border-1 border-red-500 @enderror" wire:model="predio.municipio" readonly>

                                <input title="Zona" placeholder="Zona" type="number" class="bg-white rounded text-xs w-20 @error('predio.zona_catastral') border-1 border-red-500 @enderror" wire:model="predio.zona_catastral">

                                <input title="Localidad" placeholder="Localidad" type="number" class="bg-white rounded text-xs w-20 @error('predio.localidad') border-1 border-red-500 @enderror" wire:model.blur="predio.localidad">

                                <input title="Sector" placeholder="Sector" type="number" class="bg-white rounded text-xs w-20 @error('predio.sector') border-1 border-red-500 @enderror" wire:model="predio.sector">

                                <input title="Manzana" placeholder="Manzana" type="number" class="bg-white rounded text-xs w-20 @error('predio.manzana') border-1 border-red-500 @enderror" wire:model="predio.manzana">

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

        @elseif($radio === 'propietario')

            <div class="mb-5 bg-white rounded-lg p-4 shadow-lg" id="propietarios-div">

                <div class="flex flex-col lg:flex-row gap-3 mb-5">

                    <x-input-group for="nombre" label="Nombre" :error="$errors->first('nombre')" class="w-full">

                        <x-input-text id="nombre" wire:model="nombre" />

                    </x-input-group>

                    <x-input-group for="ap_paterno" label="Apellido paterno" :error="$errors->first('ap_paterno')" class="w-full">

                        <x-input-text id="ap_paterno" wire:model="ap_paterno" />

                    </x-input-group>

                    <x-input-group for="ap_materno" label="Apellido materno" :error="$errors->first('ap_materno')" class="w-full">

                        <x-input-text id="ap_materno" wire:model="ap_materno" />

                    </x-input-group>

                    <x-input-group for="razon_social" label="Razón social" :error="$errors->first('razon_social')" class="w-full">

                        <x-input-text id="razon_social" wire:model="razon_social" />

                    </x-input-group>

                    <x-input-group for="rfc" label="RFC" :error="$errors->first('rfc')" class="w-full">

                        <x-input-text id="rfc" wire:model="rfc" />

                    </x-input-group>

                    <x-input-group for="curp" label="CURP" :error="$errors->first('curp')" class="w-full">

                        <x-input-text id="curp" wire:model="curp" />

                    </x-input-group>

                </div>

                <button
                    wire:click="buscarPorPropietario"
                    wire:loading.attr="disabled"
                    wire:target="buscarPorPropietario"
                    type="button"
                    class="bg-blue-400 hover:shadow-lg text-white mx-auto font-bold px-4 py-2 rounded text-xs hover:bg-blue-700 focus:outline-none flex items-center justify-center focus:outline-blue-400 focus:outline-offset-2">

                    <img wire:loading wire:target="buscarPorPropietario" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                    Buscar

                </button>

            </div>

        @elseif($radio === 'ubicacion')

            <div class="space-y-2 mb-5 bg-white rounded-lg p-2 shadow-lg" id="ubicacion-div">

                <x-input-group for="ubicacion" label="Ubicación" :error="$errors->first('ubicacion')" class="w-full lg:w-1/2 mx-auto mb-5">

                    <x-input-text id="ubicacion" wire:model="ubicacion" placeholder="Ingresa el texto para buscar en todos los campos de ubicación del predio"/>

                </x-input-group>

                <button
                    wire:click="buscarPorUbicacion"
                    wire:loading.attr="disabled"
                    wire:target="buscarPorUbicacion"
                    type="button"
                    class="bg-blue-400 hover:shadow-lg text-white mx-auto font-bold px-4 py-2 rounded text-xs hover:bg-blue-700 focus:outline-none flex items-center justify-center focus:outline-blue-400 focus:outline-offset-2">

                    <img wire:loading wire:target="buscarPorUbicacion" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                    Buscar

                </button>

            </div>

        @endif

    </div>

    @if($predios)

        <div class="overflow-x-auto rounded-lg shadow-xl border-t-2 border-t-gray-500">

            <x-table>

                <x-slot name="head">

                    <x-table.heading >Cuenta predial</x-table.heading>
                    <x-table.heading >Clave catastral</x-table.heading>
                    <x-table.heading >Propietario</x-table.heading>
                    <x-table.heading >Asentamiento</x-table.heading>
                    <x-table.heading >Vialidad</x-table.heading>
                    <x-table.heading ># Exterior / # Interior</x-table.heading>
                    <x-table.heading ></x-table.heading>

                </x-slot>

                <x-slot name="body">

                    @forelse ($predios as $item)

                        <x-table.row wire:loading.class.delaylongest="opacity-50" wire:key="row-{{ $item->id }}">

                            <x-table.cell>

                                <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Cuenta predial</span>

                                <span class="whitespace-nowrap">{{ $item->cuentaPredial() }}</span>

                            </x-table.cell>

                            <x-table.cell>

                                <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Clave catastral</span>

                                <span class="whitespace-nowrap">{{ $item->claveCatastral() }}</span>

                            </x-table.cell>

                            <x-table.cell>

                                <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Propietario</span>

                                {{ $item->primerPropietario() }}

                            </x-table.cell>

                            <x-table.cell>

                                <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Asentamiento</span>

                                {{ $item->tipo_asentamiento . ', ' . $item->nombre_asentamiento }}

                            </x-table.cell>

                            <x-table.cell>

                                <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Vialidad</span>

                                {{ $item->tipo_vialidad . ', ' . $item->nombre_vialidad }}

                            </x-table.cell>

                            <x-table.cell>

                                <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Vialidad</span>

                                {{ $item->numero_interior . ', ' , $item->numero_exterior }}

                            </x-table.cell>

                            <x-table.cell>

                                <x-button-green
                                    wire:click="verPredio({{ $item->id }})"
                                    wire:loading.attr="disabled"
                                    wire:target="verPredio({{ $item->id }})">
                                    Ver
                                </x-button-green>

                            </x-table.cell>

                        </x-table.row>

                    @empty

                        <x-table.row wire:key="row-empty">

                            <x-table.cell colspan="9">

                                <div class="bg-white text-gray-500 text-center p-5 rounded-full text-lg">

                                    No hay resultados.

                                </div>

                            </x-table.cell>

                        </x-table.row>

                    @endforelse

                </x-slot>

                <x-slot name="tfoot">

                </x-slot>

            </x-table>

        </div>

    @endif

    @if($predio->getKey())

        <div>

            <h4 class="text-2xl tracking-widest py-1 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-thin mb-6  bg-white">Datos generales</h4>

            <div class="bg-white p-4 rounded-lg w-full shadow-lg mb-5 text-gray-600">

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 text-sm">

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <strong>Cuenta predial</strong>

                        <p>{{ $predio->localidad }}-{{ $predio->oficina }}-{{ $predio->tipo_predio }}-{{ $predio->numero_registro }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <strong>Clave catastral</strong>

                        <p>{{ $predio->estado }}-{{ $predio->region_catastral }}-{{ $predio->municipio }}-{{ $predio->zona_catastral }}-{{ $predio->localidad }}-{{ $predio->sector }}-{{ $predio->manzana }}-{{ $predio->predio }}-{{ $predio->edificio }}-{{ $predio->departamento }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <strong>Estado</strong>

                        <p>{{ $predio->status }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <strong>Folio real</strong>

                        <p>{{ $predio->folio_real }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <strong>Título de propiedad</strong>

                        <p>{{ $predio->documento_numero }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <strong>CURT</strong>

                        <p>{{ $predio->curt }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <strong>Fecha de efectos</strong>

                        <p>{{ $predio->fecha_efectos }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <strong>Superficie notarial</strong>

                        <p>{{ number_format($predio->superficie_notarial, 2) }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <strong>Superficie judicial</strong>

                        <p>{{ number_format($predio->superficie_judicial, 2) }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <strong>Superficie de terreno</strong>

                        <p>{{ number_format($predio->superficie_terreno, 2) }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <strong>Valor de terreno</strong>

                        <p>{{ number_format($predio->valor_total_terreno, 2) }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <strong>Superficie de construcción</strong>

                        <p>{{ number_format($predio->superficie_construccion, 2) }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <strong>Valor de construcción</strong>

                        <p>{{ number_format($predio->valor_total_construccion, 2) }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <strong>Área común de terreno</strong>

                        <p>{{ number_format($predio->area_comun_terreno, 2) }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <strong>Valor de terreno común</strong>

                        <p>{{ number_format($predio->valor_terreno_comun, 2) }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <strong>Área común de construcción</strong>

                        <p>{{ number_format($predio->area_comun_construccion, 2) }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <strong>Valor de construcción común</strong>

                        <p>{{ number_format($predio->valor_construccion_comun, 2) }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <strong>Valor catastral</strong>

                        <p>${{ number_format($predio->valor_catastral, 2) }}</p>

                    </div>

                </div>

            </div>

            <h4 class="text-2xl tracking-widest py-1 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-thin mb-6  bg-white">Ubicación del predio</h4>

            <div class="bg-white p-4 rounded-lg w-full shadow-lg mb-5 text-gray-600">

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 text-sm">

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <strong>Tipo de asentamiento</strong>

                        <p>{{ $predio->tipo_asentamiento }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <strong>Nombre del asentamiento</strong>

                        <p>{{ $predio->nombre_asentamiento }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <strong>Tipo de vialidad</strong>

                        <p>{{ $predio->tipo_vialidad }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <strong>Nombre de la vialidad</strong>

                        <p>{{ $predio->nombre_vialidad }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <strong>Número exterior</strong>

                        <p>{{ $predio->numero_exterior }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <strong>Número exterior 2</strong>

                        <p>{{ $predio->numero_exterior_2 }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <strong>Número interior</strong>

                        <p>{{ $predio->numero_interior }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <strong>Número adicional</strong>

                        <p>{{ $predio->numero_adicional }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <strong>Número adicional 2</strong>

                        <p>{{ $predio->numero_adicional_2 }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <strong>Código postal</strong>

                        <p>{{ $predio->codigo_postal }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <strong>Lote del fraccionador</strong>

                        <p>{{ $predio->lote_fraccionador }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <strong>Manzana del fraccionador</strong>

                        <p>{{ $predio->manzana_fraccionador }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <strong>Etapa o zona del fraccionador</strong>

                        <p>{{ $predio->etapa_fraccionador }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <strong>Nombre del Edificio</strong>

                        <p>{{ $predio->nombre_edificio }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <strong>Clave del edificio</strong>

                        <p>{{ $predio->clave_edificio }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <strong>Departamento</strong>

                        <p>{{ $predio->departamento_edificio }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <strong>Predio Rústico Denominado ó Antecedente</strong>

                        <p>{{ $predio->nombre_predio }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <strong>Ubicación en manzana</strong>

                        <p>{{ $predio->ubicacion_en_manzana }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <strong>Coordenadas geográficas UTM</strong>

                        <p>X: {{ $predio->xutm }}</p>
                        <p>Y: {{ $predio->yutm }}</p>
                        <p>Z: {{ $predio->zutm }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <strong>Coordenadas geográficas GEO</strong>

                        <p>Lat: {{ $predio->lat }}</p>
                        <p>Lon: {{ $predio->lon }}</p>

                    </div>

                </div>

            </div>

            <h4 class="text-2xl tracking-widest py-1 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-thin mb-6  bg-white">Colindancias ({{ $predio->colindancias->count() }})</h4>

            <div class="bg-white p-4 rounded-lg w-full shadow-lg mb-5">

                <table class="w-full overflow-x-auto table-fixed">

                    <thead class="border-b border-gray-300 ">

                        <tr class="text-sm text-gray-500 text-left traling-wider whitespace-nowrap">

                            <th class="px-2">Viento</th>
                            <th class="px-2">Longitud(mts.)</th>
                            <th class="px-2">Descripción</th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-200">

                        @foreach ($predio->colindancias as $colindancia)

                            <tr class="text-gray-500 text-sm leading-relaxed">
                                <td class=" px-2 w-full whitespace-nowrap">{{ $colindancia->viento }}</td>
                                <td class=" px-2 w-full whitespace-nowrap">{{ $colindancia->longitud }}</td>
                                <td class=" px-2 w-full whitespace-nowrap">{{ $colindancia->descripcion }}</td>
                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

            <h4 class="text-2xl tracking-widest py-1 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-thin mb-6  bg-white">Terrenos ({{ $predio->terrenos->count() }})</h4>

            <div class="bg-white p-4 rounded-lg w-full shadow-lg mb-5">

                <table class="w-full overflow-x-auto table-fixed">

                    <thead class="border-b border-gray-300 ">

                        <tr class="text-sm text-gray-500 text-left traling-wider whitespace-nowrap">

                            <th class="px-2">Superficie</th>
                            <th class="px-2">Valor unitario</th>
                            <th class="px-2">Demerito</th>
                            <th class="px-2">Valor demeritado</th>
                            <th class="px-2">Valor del terreno</th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-200">

                        @foreach ($predio->terrenos as $terreno)

                            <tr class="text-gray-500 text-sm leading-relaxed">
                                <td class=" px-2 w-full whitespace-nowrap">{{ $terreno->superficie }}</td>
                                <td class=" px-2 w-full whitespace-nowrap">{{ $terreno->valor_unitario }}</td>
                                <td class=" px-2 w-full whitespace-nowrap">{{ $terreno->demerito }}</td>
                                <td class=" px-2 w-full whitespace-nowrap">{{ $terreno->demerito }}</td>
                                <td class=" px-2 w-full whitespace-nowrap">${{ number_format($terreno->valor_terreno, 2) }}</td>
                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

            <h4 class="text-2xl tracking-widest py-1 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-thin mb-6  bg-white">Construcciones ({{ $predio->construcciones->count() }})</h4>

            <div class="bg-white p-4 rounded-lg w-full shadow-lg mb-5">

                <table class="w-full overflow-x-auto table-fixed">

                    <thead class="border-b border-gray-300 ">

                        <tr class="text-sm text-gray-500 text-left traling-wider whitespace-nowrap">

                            <th class="px-2">Referencia</th>
                            <th class="px-2">Clasificación de construcción</th>
                            <th class="px-2">Niveles</th>
                            <th class="px-2">Superficie</th>
                            <th class="px-2">Valor unitario</th>
                            <th class="px-2">Valor de construcción</th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-200">

                        @foreach ($predio->construcciones as $construccion)

                            <tr class="text-gray-500 text-sm leading-relaxed">
                                <td class=" px-2 w-full whitespace-nowrap">{{ $construccion->referencia }}</td>
                                <td class=" px-2 w-full whitespace-nowrap">{{ $construccion->tipo }}-{{ $construccion->uso }}-{{ $construccion->calidad }}-{{ $construccion->estado }}</td>
                                <td class=" px-2 w-full whitespace-nowrap">{{ $construccion->niveles }}</td>
                                <td class=" px-2 w-full whitespace-nowrap">{{ $construccion->superficie }}</td>
                                <td class=" px-2 w-full whitespace-nowrap">{{ $construccion->valor_unitario }}</td>
                                <td class=" px-2 w-full whitespace-nowrap">${{ number_format($construccion->valor_construccion, 2) }}</td>
                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

            <h4 class="text-2xl tracking-widest py-1 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-thin mb-6  bg-white">Terrenos de área común ({{ $predio->condominioTerrenos->count() }})</h4>

            <div class="bg-white p-4 rounded-lg w-full shadow-lg mb-5">

                <table class="w-full overflow-x-auto table-fixed">

                    <thead class="border-b border-gray-300 ">

                        <tr class="text-sm text-gray-500 text-left traling-wider whitespace-nowrap">

                            <th class="px-2">Área común de terreno</th>
                            <th class="px-2">Indiviso de terreno</th>
                            <th class="px-2">Valor unitario</th>
                            <th class="px-2">Valor de terreno común</th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-200">

                        @foreach ($predio->condominioTerrenos as $terreno)

                            <tr class="text-gray-500 text-sm leading-relaxed">
                                <td class=" px-2 w-full whitespace-nowrap">{{ $terreno->area_terreno_comun }}</td>
                                <td class=" px-2 w-full whitespace-nowrap">{{ $terreno->indiviso_terreno }}</td>
                                <td class=" px-2 w-full whitespace-nowrap">{{ $terreno->valor_unitario }}</td>
                                <td class=" px-2 w-full whitespace-nowrap">${{ number_format($terreno->valor_terreno_comun, 2) }}</td>
                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

            <h4 class="text-2xl tracking-widest py-1 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-thin mb-6  bg-white">Construcciones de área común ({{ $predio->condominioConstrucciones->count() }})</h4>

            <div class="bg-white p-4 rounded-lg w-full shadow-lg mb-5">

                <table class="w-full overflow-x-auto table-fixed">

                    <thead class="border-b border-gray-300 ">

                        <tr class="text-sm text-gray-500 text-left traling-wider whitespace-nowrap">

                            <th class="px-2">Área común de construcción</th>
                            <th class="px-2">Clasificación de construccion</th>
                            <th class="px-2">Valor de construcción común</th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-200">

                        @foreach ($predio->condominioConstrucciones as $construccion)

                            <tr class="text-gray-500 text-sm leading-relaxed">
                                <td class=" px-2 w-full whitespace-nowrap">{{ $construccion->area_comun_construccion }}</td>
                                <td class=" px-2 w-full whitespace-nowrap">{{ $construccion->valor_clasificacion_construccion }}</td>
                                <td class=" px-2 w-full whitespace-nowrap">${{ number_format($construccion->valor_construccion_comun, 2) }}</td>
                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

            <h4 class="text-2xl tracking-widest py-1 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-thin mb-6  bg-white">Propietarios ({{ $predio->propietarios->count() }})</h4>

            <div class="bg-white p-4 rounded-lg w-full shadow-lg mb-5">

                <table class="w-full overflow-x-auto table-fixed">

                    <thead class="border-b border-gray-300 ">

                        <tr class="text-sm text-gray-500 text-left traling-wider whitespace-nowrap">

                            <th class="px-2">Tipo de propietario</th>
                            <th class="px-2">Porcentaje de propiedad</th>
                            <th class="px-2">Porcentaje de nuda</th>
                            <th class="px-2">Porcentaje de usufructo</th>
                            <th class="px-2">Tipo de persona</th>
                            <th class="px-2">Nombre / Razón social</th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-200">

                        @foreach ($predio->propietarios as $propietario)

                            <tr class="text-gray-500 text-sm leading-relaxed">
                                <td class=" px-2 w-full ">{{ $propietario->tipo }}</td>
                                <td class=" px-2 w-full ">{{ $propietario->porcentaje }}%</td>
                                <td class=" px-2 w-full ">{{ $propietario->porcentaje_nuda }}%</td>
                                <td class=" px-2 w-full ">{{ $propietario->porcentaje_usufructo }}%</td>
                                <td class=" px-2 w-full ">{{ $propietario->persona->tipo }}</td>
                                <td class=" px-2 w-full ">{{ $propietario->persona->nombre }} {{ $propietario->persona->ap_paterno }} {{ $propietario->persona->ap_materno }} {{ $propietario->persona->razon_social }}</td>
                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

            <h4 class="text-2xl tracking-widest py-1 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-thin mb-6  bg-white">Movimientos ({{ $predio->movimientos->count() }})</h4>

            <div class="bg-white p-4 rounded-lg w-full shadow-lg mb-5">

                <table class="w-full overflow-x-auto table-fixed">

                    <thead class="border-b border-gray-300 ">

                        <tr class="text-sm text-gray-500 text-left traling-wider whitespace-nowrap">

                            <th class="px-2">Movimiento</th>
                            <th class="px-2">Fecha</th>
                            <th class="px-2">Descripción</th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-200">

                        @foreach ($predio->movimientos as $movimiento)

                            <tr class="text-gray-500 text-sm leading-relaxed">
                                <td class=" px-2 w-full ">{{ $movimiento->nombre }}</td>
                                <td class=" px-2 w-full ">{{ $movimiento->fecha->format('d-m-Y') }}</td>
                                <td class=" px-2 w-full ">{{ $movimiento->descripcion }}</td>
                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

    @endif

</div>
