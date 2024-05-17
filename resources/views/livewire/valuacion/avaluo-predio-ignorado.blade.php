<div class="p-4 mb-1">

    @if(isset($predio->avaluo->folio))

        <div class="space-y-2 mb-5 bg-white rounded-lg p-2 text-right">

            <span class="bg-blue-400 text-white text-sm rounded-full px-2 py-1">Folio de avaluo: {{ $predio->avaluo->folio }}</span>

        </div>

    @endif

    <div class="space-y-2 mb-5 bg-white rounded-lg p-2">

        <h4 class="text-lg mb-5 text-center">Consultar predio</h4>

        <div class="flex-auto ">

            <div class="">

                <div class="flex-row lg:flex lg:space-x-2 mb-2 space-y-2 lg:space-y-0 items-center justify-center" >

                    <div class="text-left">

                        <Label class="text-base tracking-widest rounded-xl border-gray-500">Cuenta predial</Label>

                    </div>

                    <div class="space-y-1">

                        <input title="Localidad" placeholder="Localidad" type="number" class="bg-white rounded text-xs w-20 @error('predio.localidad') border-1 border-red-500 @enderror" wire:model.blur="predio.localidad">

                        <input title="Oficina" placeholder="Oficina" type="number" class="bg-white rounded text-xs w-20 @error('predio.oficina') border-1 border-red-500 @enderror" wire:model.blur="predio.oficina" @if(auth()->user()->oficina->oficina != 101) readonly @endif>

                        <input title="Tipo de predio" placeholder="Tipo" type="number" class="bg-white rounded text-xs w-20 @error('predio.tipo_predio') border-1 border-red-500 @enderror" wire:model="predio.tipo_predio">

                        <input title="Número de registro" placeholder="Registro" type="number" class="bg-white rounded text-xs w-20 @error('predio.numero_registro') border-1 border-red-500 @enderror" wire:model.blur="predio.numero_registro" readonly>

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

            <div class="mb-2 flex-col sm:flex-row mx-auto mt-5 flex space-y-2 sm:space-y-0 sm:space-x-3 justify-center">

                <button
                    wire:click="buscarClaveCatastral"
                    wire:loading.attr="disabled"
                    wire:target="buscarClaveCatastral"
                    type="button"
                    class="bg-blue-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded text-xs hover:bg-blue-700 focus:outline-blue-400 focus:outline-offset-2 flex items-center justify-center">

                    <img wire:loading wire:target="buscarClaveCatastral" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                    Consultar clave catastral

                </button>

                <button
                    wire:click="$set('modal', true)"
                    wire:loading.attr="disabled"
                    wire:target="$set('modal', true)"
                    type="button"
                    class="bg-blue-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded text-xs hover:bg-blue-700 focus:outline-blue-400 focus:outline-offset-2 flex items-center justify-center">

                    <img wire:loading wire:target="$set('modal', true)" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                    Consultar por propietario

                </button>

                <button
                    wire:click="abrirModalAsignar"
                    wire:loading.attr="disabled"
                    wire:target="abrirModalAsignar"
                    type="button"
                    class="bg-blue-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded text-xs hover:bg-blue-700 focus:outline-blue-400 focus:outline-offset-2 flex items-center justify-center">

                    <img wire:loading wire:target="abrirModalAsignar" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                    Asignar cuenta predial

                </button>

            </div>

        </div>

    </div>

    <div class="space-y-2 mb-5 bg-white rounded-lg p-3">

        <h4 class="text-lg mb-5 text-center">Propietario</h4>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-7 gap-3 items-start">

            <div class="flex-auto ">

                <div>

                    <label class="text-sm" >Apellido Paterno</label>

                </div>

                <div>

                    <input type="text" class="bg-white rounded text-xs w-full" wire:model="ap_paterno" @if($flag) readonly @endif>

                </div>

                <div>

                    @error('ap_paterno') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                </div>

            </div>

            <div class="flex-auto ">

                <div>

                    <Label class="text-sm">Apellido Materno</Label>
                </div>

                <div>

                    <input type="text" class="bg-white rounded text-xs w-full" wire:model="ap_materno" @if($flag) readonly @endif>

                </div>

                <div>

                    @error('ap_materno') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                </div>

            </div>

            <div class="flex-auto ">

                <div>

                    <Label class="text-sm">Nombre</Label>
                </div>

                <div>

                    <input type="text" class="bg-white rounded text-xs w-full" wire:model="nombre" @if($flag) readonly @endif>

                </div>

                <div>

                    @error('nombre') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                </div>

            </div>

            <div class="flex-auto ">

                <div>

                    <Label class="text-sm">Tipo de persona</Label>
                </div>

                <div>

                    <select class="bg-white rounded text-xs w-full" wire:model="tipo_persona" @if($flag) disabled @endif>

                        <option value="" selected>Seleccione una opción</option>
                        <option value="FISICA" selected>Fisica</option>
                        <option value="MORAL" selected>Moral</option>

                    </select>

                </div>

                <div>

                    @error('tipo_persona') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                </div>

            </div>

            <div class="flex-auto ">

                <div>

                    <Label class="text-sm">Tipo de propietario</Label>
                </div>

                <div>

                    <select class="bg-white rounded text-xs w-full" wire:model="tipo_propietario" @if($flag) disabled @endif>
                        <option value="" selected>Seleccione una opción</option>

                        @foreach ($tipoPropietarios as $item)

                            <option value="{{ $item }}" selected>{{ $item }}</option>

                        @endforeach

                    </select>

                </div>

                <div>

                    @error('tipo_propietario') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                </div>

            </div>

            <div class="flex-auto ">

                <div>

                    <Label class="text-sm">Porcentaje</Label>
                </div>

                <div>

                    <input type="number" class="bg-white rounded text-xs w-full" wire:model="porcentaje" @if($flag) readonly @endif>

                </div>

                <div>

                    @error('porcentaje') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                </div>

            </div>

            <div class="flex-auto ">

                <div>

                    <Label class="text-sm">Sociedad</Label>
                </div>

                <div>

                    <input type="checkbox" class="bg-white rounded text-xs" wire:model="predio.sociedad" @if($flag) disabled @endif>

                </div>

            </div>

        </div>

    </div>

    <div class="space-y-2 mb-5 bg-white rounded-lg p-3">

        <h4 class="text-lg mb-5 text-center">Ubicación del predio</h4>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-6 gap-3 items-start">

            <div class="flex-auto">

                <div>

                    <Label class="text-sm">Tipo de asentamiento</Label>
                </div>

                <div>

                    <select class="bg-white rounded text-xs w-full" wire:model="predio.tipo_asentamiento">
                        <option value="" selected>Seleccione una opción</option>

                        @foreach ($tipoAsentamientos as $item)

                            <option value="{{ $item }}" selected>{{ $item }}</option>

                        @endforeach

                    </select>

                </div>

                <div>

                    @error('predio.tipo_asentamiento') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                </div>

            </div>

            <div class="flex-auto">

                <div class="">

                    <label class="text-sm " >Nombre del asentamiento</label>

                </div>

                <div>

                    <input type="text" class="bg-white rounded text-xs w-full" wire:model="predio.nombre_asentamiento">

                </div>

                <div>

                    @error('predio.nombre_asentamiento') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

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

                    <label class="text-sm" >Código postal</label>

                </div>

                <div>

                    <input type="number" class="bg-white rounded text-xs w-full" wire:model="predio.codigo_postal">

                </div>

                <div>

                    @error('predio.codigo_postal') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

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

                    <input type="text" class="bg-white rounded text-xs w-full" wire:model="predio.manzana_fraccionador">

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

                    <input type="text" class="bg-white rounded text-xs w-full" wire:model="predio.etapa_fraccionador">

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

    <div class="space-y-2 mb-5 bg-white rounded-lg p-3">

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

    <div class="bg-white rounded-lg p-3 flex justify-end">
        @if(!$editar)

            <x-button-green
                wire:click="crear"
                wire:loading.attr="disabled"
                wire:target="crear">

                <img wire:loading wire:target="crear" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                Guardar

            </x-button-green>

        @else

            <x-button-green
                wire:click="actualizar"
                wire:loading.attr="disabled"
                wire:target="actualizar">

                <img wire:loading wire:target="actualizar" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                Actualizar

            </x-button-green>

        @endif

    </div>

    <x-dialog-modal wire:model="modal">

        <x-slot name="title">

            Buscar propietario

        </x-slot>

        <x-slot name="content">

            <div class="relative p-1">

                <div class="flex flex-col md:flex-row justify-between md:space-x-3 mb-5 items-center">

                    <div class="flex-auto items-start">

                        <div>

                            <Label>Apellido paterno</Label>

                        </div>

                        <div>

                            <input type="text" class="bg-white rounded text-sm w-full" wire:model="propietario_ap_paterno">

                        </div>

                        <div>

                            @error('propietario_ap_paterno') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                        </div>

                    </div>

                    <div class="flex-auto items-start">

                        <div>

                            <Label>Apellido materno</Label>

                        </div>

                        <div>

                            <input type="text" class="bg-white rounded text-sm w-full" wire:model="propietario_ap_materno">

                        </div>

                        <div>

                            @error('propietario_ap_materno') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                        </div>

                    </div>

                    <div class="flex-auto items-start">

                        <div>

                            <Label>Nombre</Label>

                        </div>

                        <div>

                            <input type="text" class="bg-white rounded text-sm w-full" wire:model="propietario_nombre">

                        </div>

                        <div>

                            @error('propietario_nombre') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                        </div>

                    </div>

                    <div class="">

                        <x-button-green
                            wire:click="busacarPropietario"
                            wire:loading.attr="disabled"
                            wire:target="busacarPropietario">

                            <img wire:loading wire:target="busacarPropietario" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                            Buscar

                        </x-button-green>

                    </div>

                </div>

                @if($predios_propietario && $predios_propietario->count())

                    <div>

                        <table class="rounded-lg w-full">

                            <thead class="border-b border-gray-300 bg-gray-50">

                                <tr class="text-xs font-medium text-gray-500 uppercase text-left traling-wider">
                                    <th class="px-3 py-3 hidden lg:table-cell">Folio avaluo</th>
                                    <th class="px-3 py-3 hidden lg:table-cell">Propietario</th>
                                    <th class="px-3 py-3 hidden lg:table-cell">Ubicación</th>
                                </tr>

                            </thead>

                            <tbody class="divide-y divide-gray-200 flex-1 sm:flex-none ">

                                @foreach ($predios_propietario as $item)

                                    <tr class="text-sm font-medium text-gray-500 bg-white flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0">

                                        <td class="px-3 py-3 w-full lg:w-auto p-3 text-gray-800 text-center lg:text-left lg:border-0 border border-b block lg:table-cell relative lg:static">{{ $item->propietarioable?->avaluo->folio }}</td>
                                        <td class="px-3 py-3 w-full lg:w-auto p-3 text-gray-800 text-center lg:text-left lg:border-0 border border-b block lg:table-cell relative lg:static">{{ $item->persona->ap_paterno }} {{ $item->persona->ap_materno }} {{ $item->persona->nombre }}</td>
                                        <td class="px-3 py-3 w-full lg:w-auto p-3 text-gray-800 text-center lg:text-left lg:border-0 border border-b block lg:table-cell relative lg:static">{{ $item->propietarioable?->nombre_asentamiento }} {{ $item->propietarioable?->nombre_vialidad }} {{ $item->propietarioable?->numero_exterior }}</td>
                                        <td class="px-3 py-3 w-full lg:w-auto p-3 text-gray-800 text-center lg:text-left lg:border-0 border border-b block lg:table-cell relative lg:static">
                                            <x-button-blue
                                                wire:click="cargarPredioAvaluo({{ $item->propietarioable->id }})"
                                                wire:loading.attr="disabled"
                                                wire:target="cargarPredioAvaluo({{ $item->propietarioable->id }})">

                                                <img wire:loading wire:target="cargarPredioAvaluo({{ $item->propietarioable->id }})" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                                                Cargar

                                            </x-button-blue>
                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                @else

                    <div class="border-b border-gray-300 bg-white text-gray-500 text-center p-5 rounded-full text-lg">

                        No hay resultados.

                    </div>

                @endif

                <div class="h-full w-full rounded-lg bg-gray-200 bg-opacity-75 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2" wire:loading.delay.longer>

                    <img class="mx-auto h-16" src="{{ asset('storage/img/loading.svg') }}" alt="">

                </div>

            </div>

        </x-slot>

        <x-slot name="footer">

            <x-button-red
                wire:click="$set('modal', false)"
                wire:loading.attr="disabled"
                wire:target="$set('modal', false)">
                Cerrar
            </x-button-red>

        </x-slot>

    </x-dialog-modal>

    <x-dialog-modal wire:model="modal2" maxWidth="sm">

        <x-slot name="title">

            Asignar cuenta predial

        </x-slot>

        <x-slot name="content">

            <div class="relative p-1">

                <div class="flex flex-col md:flex-row justify-between md:space-x-3 mb-5 items-start">

                    <div class="flex-auto text-center mb-3">

                        <div >

                            <Label class="text-base tracking-widest rounded-xl border-gray-500">Trámite</Label>

                        </div>

                        <div class="inline-flex">

                            <select class="bg-white rounded-l text-sm border border-r-transparent  focus:ring-0" wire:model="año">
                                @foreach ($años as $año)

                                    <option value="{{ $año }}">{{ $año }}</option>

                                @endforeach
                            </select>

                            <input type="number" class="bg-white text-sm w-20 focus:ring-0 @error('folio') border-red-500 @enderror" wire:model="folio">

                            <input type="number" class="bg-white text-sm w-20 border-l-0 rounded-r focus:ring-0 @error('usuario') border-red-500 @enderror" wire:model="usuario">

                        </div>

                    </div>

                </div>

                <div class="flex flex-col md:flex-row justify-between gap-2 mb-5 items-start">

                    <x-input-group for="localidad" label="Localidad" :error="$errors->first('localidad')">

                        <x-input-text type="number" id="localidad" wire:model="localidad" readonly/>

                    </x-input-group>

                    <x-input-group for="oficina" label="Oficina" :error="$errors->first('oficina')">

                        <x-input-text type="number" id="oficina" wire:model="oficina" readonly/>

                    </x-input-group>

                    <x-input-group for="tipo" label="Tipo" :error="$errors->first('tipo')">

                        <x-input-text type="number" id="tipo" wire:model="tipo" max="2" min="1" readonly/>

                    </x-input-group>

                    <x-input-group for="numero_registro" label="Número de Registro" :error="$errors->first('numero_registro')" class="w-full">

                        <x-input-text type="number" id="numero_registro" wire:model="numero_registro" max="2" min="1"/>

                    </x-input-group>

                </div>

            </div>

        </x-slot>

        <x-slot name="footer">

            <div class="flex gap-3">

                <x-button-blue
                    wire:click="asignarCuenta"
                    wire:loading.attr="disabled"
                    wire:target="asignarCuenta">

                    <img wire:loading wire:target="asignarCuenta" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                    Actualizar
                </x-button-blue>

                <x-button-red
                    wire:click="$set('modal2', false)"
                    wire:loading.attr="disabled"
                    wire:target="$set('modal2', false)">
                    Cerrar
                </x-button-red>

            </div>

        </x-slot>

    </x-dialog-modal>

</div>
