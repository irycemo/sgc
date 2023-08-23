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

                        <input placeholder="Localidad" type="number" class="bg-white rounded text-xs w-20 @error('predio.localidad') border-1 border-red-500 @enderror" wire:model.lazy="predio.localidad">

                        <input placeholder="Oficina" type="number" class="bg-white rounded text-xs w-20 @error('predio.oficina') border-1 border-red-500 @enderror" wire:model.defer="predio.oficina" @if(auth()->user()->oficina != 101) readonly @endif>

                        <input placeholder="Tipo" type="number" class="bg-white rounded text-xs w-20 @error('predio.tipo_predio') border-1 border-red-500 @enderror" wire:model.defer="predio.tipo_predio">

                        <input placeholder="Registro" type="number" class="bg-white rounded text-xs w-20 @error('predio.numero_registro') border-1 border-red-500 @enderror" wire:model.lazy="predio.numero_registro">

                    </div>

                </div>

                <div class="flex-row lg:flex lg:space-x-2 space-y-2 lg:space-y-0 items-center justify-center">

                     <div class="text-left">

                        <Label class="text-base tracking-widest rounded-xl border-gray-500">Clave catastral </Label>

                    </div>

                    <div class="space-y-1">

                        <input placeholder="Estado" type="number" class="bg-white rounded text-xs w-20" title="Estado" value="16" readonly>

                        <input placeholder="Región" type="number" class="bg-white rounded text-xs w-20  @error('predio.region_catastral') border-1 border-red-500 @enderror" wire:model.defer="predio.region_catastral">

                        <input placeholder="Municipio" type="number" class="bg-white rounded text-xs w-20 @error('predio.municipio') border-1 border-red-500 @enderror" wire:model.defer="predio.municipio">

                        <input placeholder="Zona" type="number" class="bg-white rounded text-xs w-20 @error('predio.zona_catastral') border-1 border-red-500 @enderror" wire:model.defer="predio.zona_catastral">

                        <input placeholder="Localidad" type="number" class="bg-white rounded text-xs w-20 @error('predio.localidad') border-1 border-red-500 @enderror" wire:model.lazy="predio.localidad">

                        <input placeholder="Sector" type="number" class="bg-white rounded text-xs w-20 @error('predio.sector') border-1 border-red-500 @enderror" wire:model.defer="predio.sector">

                        <input placeholder="Manzana" type="number" class="bg-white rounded text-xs w-20 @error('predio.manzana') border-1 border-red-500 @enderror" wire:model.defer="predio.manzana">

                        <input placeholder="Registro" type="number" class="bg-white rounded text-xs w-20 @error('predio.numero_registro') border-1 border-red-500 @enderror" wire:model.lazy="predio.numero_registro">

                        <input placeholder="Edificio" type="number" class="bg-white rounded text-xs w-20 @error('predio.edificio') border-1 border-red-500 @enderror" wire:model.defer="predio.edificio">

                        <input placeholder="Departamento" type="number" class="bg-white rounded text-xs w-20 @error('predio.departamento') border-1 border-red-500 @enderror" wire:model.defer="predio.departamento">

                    </div>

                </div>

            </div>

            <div class="mb-2 flex-col sm:flex-row mx-auto mt-5 flex space-y-2 sm:space-y-0 sm:space-x-3 justify-center">

                <button
                    wire:click="buscarClaveCatastral"
                    wire:loading.attr="disabled"
                    wire:target="buscarClaveCatastral"
                    type="button"
                    class="bg-blue-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded text-xs hover:bg-blue-700 focus:outline-none flex items-center justify-center">

                    <img wire:loading wire:target="buscarClaveCatastral" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                    Consultar clave catastral

                </button>

                <button
                    wire:click="$set('modal', true)"
                    wire:loading.attr="disabled"
                    wire:target="$set('modal', true)"
                    type="button"
                    class="bg-blue-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded text-xs hover:bg-blue-700 focus:outline-none flex items-center justify-center">

                    <img wire:loading wire:target="$set('modal', true)" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                    Consultar por propietario

                </button>

                <button
                    wire:click="$set('modal2', true)"
                    wire:loading.attr="disabled"
                    wire:target="$set('modal2', true)"
                    type="button"
                    class="bg-blue-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded text-xs hover:bg-blue-700 focus:outline-none flex items-center justify-center">

                    <img wire:loading wire:target="$set('modal2', true)" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

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

                    <input type="text" class="bg-white rounded text-xs w-full" wire:model.defer="ap_paterno" @if($flag) readonly @endif>

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

                    <input type="text" class="bg-white rounded text-xs w-full" wire:model.defer="ap_materno" @if($flag) readonly @endif>

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

                    <input type="text" class="bg-white rounded text-xs w-full" wire:model.defer="nombre" @if($flag) readonly @endif>

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

                    <select class="bg-white rounded text-xs w-full" wire:model.defer="tipo_persona" @if($flag) disabled @endif>

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

                    <select class="bg-white rounded text-xs w-full" wire:model.defer="tipo_propietario" @if($flag) disabled @endif>
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

                    <input type="number" class="bg-white rounded text-xs w-full" wire:model.defer="porcentaje" @if($flag) readonly @endif>

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

                    <input type="checkbox" class="bg-white rounded text-xs" wire:model.defer="predio.sociedad" @if($flag) disabled @endif>

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

                    <select class="bg-white rounded text-xs w-full" wire:model.defer="predio.tipo_asentamiento">
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

                    <input type="text" class="bg-white rounded text-xs w-full" wire:model.defer="predio.nombre_asentamiento">

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

                    <select class="bg-white rounded text-xs w-full" wire:model.defer="predio.tipo_vialidad">
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

                    <input type="text" class="bg-white rounded text-xs w-full" wire:model.defer="predio.nombre_vialidad">

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

                    <input type="number" class="bg-white rounded text-xs w-full" wire:model.defer="predio.numero_exterior">

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

                    <input type="number" class="bg-white rounded text-xs w-full" wire:model.defer="predio.numero_exterior_2">

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

                    <input type="number" class="bg-white rounded text-xs w-full" wire:model.defer="predio.numero_interior">

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

                    <input type="number" class="bg-white rounded text-xs w-full" wire:model.defer="predio.numero_adicional">

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

                    <input type="number" class="bg-white rounded text-xs w-full" wire:model.defer="predio.numero_adicional_2">

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

                    <input type="number" class="bg-white rounded text-xs w-full" wire:model.defer="predio.codigo_postal">

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

                    <input type="number" class="bg-white rounded text-xs w-full" wire:model.defer="predio.lote_fraccionador">

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

                    <input type="number" class="bg-white rounded text-xs w-full" wire:model.defer="predio.manzana_fraccionador">

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

                    <input type="number" class="bg-white rounded text-xs w-full" wire:model.defer="predio.etapa_fraccionador">

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

                    <input type="text" class="bg-white rounded text-xs w-full" wire:model.defer="predio.nombre_edificio">

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

                    <input type="text" class="bg-white rounded text-xs w-full" wire:model.defer="predio.clave_edificio">

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

                    <input type="text" class="bg-white rounded text-xs w-full" wire:model.defer="predio.departamento_edificio">

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

                    <input type="text" class="bg-white rounded text-xs w-full" wire:model.defer="predio.nombre_predio">

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

                </div>

            </div>

        </div>

    </div>

    <div class="bg-white rounded-lg p-3 flex justify-end">

        @if(count($errors) > 0)

            <span class="bg-red-400 hover:shadow-lg text-white text-xs md:text-sm px-3 py-1 ml-auto rounded-full  hover:bg-red-700 flex items-center justify-center focus:outline-none ">
                Campos incorrectos
            </span>

        @endif

        @if(!$editar)

            <button
                wire:click="crear"
                wire:loading.attr="disabled"
                wire:target="crear"
                class=" bg-green-400 hover:shadow-lg text-white text-xs md:text-sm px-3 py-1 ml-auto rounded-full  hover:bg-green-700 flex items-center justify-center focus:outline-none "
            >

                <img wire:loading wire:target="crear" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                Guardar

            </button>

        @else

            <button
                wire:click="actualizar"
                wire:loading.attr="disabled"
                wire:target="actualizar"
                class=" bg-green-400 hover:shadow-lg text-white text-xs md:text-sm px-3 py-1 ml-auto rounded-full  hover:bg-green-700 flex items-center justify-center focus:outline-none "
            >

                <img wire:loading wire:target="actualizar" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                Actualizar

            </button>

        @endif

    </div>

    <x-dialog-modal wire:model="modal">

        <x-slot name="title">

            Buscar propietario

        </x-slot>

        <x-slot name="content">

            <div class="relative p-1">

                <div class="flex flex-col md:flex-row justify-between md:space-x-3 mb-5 items-end">

                    <div class="flex-auto ">

                        <div>

                            <Label>Apellido paterno</Label>

                        </div>

                        <div>

                            <input type="text" class="bg-white rounded text-sm w-full" wire:model.defer="propietario_ap_paterno">

                        </div>

                        <div>

                            @error('propietario_ap_paterno') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                        </div>

                    </div>

                    <div class="flex-auto ">

                        <div>

                            <Label>Apellido materno</Label>

                        </div>

                        <div>

                            <input type="text" class="bg-white rounded text-sm w-full" wire:model.defer="propietario_ap_materno">

                        </div>

                        <div>

                            @error('propietario_ap_materno') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                        </div>

                    </div>

                    <div class="flex-auto ">

                        <div>

                            <Label>Nombre</Label>

                        </div>

                        <div>

                            <input type="text" class="bg-white rounded text-sm w-full" wire:model.defer="propietario_nombre">

                        </div>

                        <div>

                            @error('propietario_nombre') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                        </div>

                    </div>

                    <div class="flex-auto ">

                        <button
                            wire:click="busacarPropietario"
                            wire:loading.attr="disabled"
                            wire:target="busacarPropietario"
                            class=" bg-green-400 hover:shadow-lg text-white text-xs md:text-sm px-3 py-1 ml-auto rounded-full  hover:bg-green-700 flex items-center justify-center focus:outline-none "
                        >

                            <img wire:loading wire:target="busacarPropietario" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                            Buscar

                        </button>

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
                                            <button
                                                wire:click="cargarPredioAvaluo({{ $item->propietarioable->id }})"
                                                wire:loading.attr="disabled"
                                                wire:target="cargarPredioAvaluo({{ $item->propietarioable->id }})"
                                                class=" bg-blue-400 hover:shadow-lg text-white text-xs md:text-sm px-3 ml-auto rounded-full  hover:bg-blue-700 flex items-center justify-center focus:outline-none "
                                            >

                                                <img wire:loading wire:target="cargarPredioAvaluo({{ $item->propietarioable->id }})" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                                                Cargar

                                            </button>
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

            <button
                wire:click="$set('modal', false)"
                wire:loading.attr="disabled"
                wire:target="$set('modal', false)"
                type="button"
                class="bg-red-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded-full text-sm mb-2 hover:bg-red-700 flaot-left focus:outline-none">
                Cerrar
            </button>

        </x-slot>

    </x-dialog-modal>

    <x-dialog-modal wire:model="modal2">

        <x-slot name="title">

            Asignar cuenta predial

        </x-slot>

        <x-slot name="content">

            <div class="relative p-1">

                <div class="flex flex-col md:flex-row justify-between md:space-x-3 mb-5 items-end">

                    <div class="flex-auto ">

                        <div>

                            <Label>Trámite de inscripción</Label>

                        </div>

                        <div>

                            <input type="number" class="bg-white rounded text-sm w-full" wire:model.defer="tramite">

                        </div>

                        <div>

                            @error('tramite') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                        </div>

                    </div>

                    <div class="flex-auto ">

                        <div>

                            <Label>Localidad</Label>

                        </div>

                        <div>

                            <input type="number" class="bg-white rounded text-sm w-full" wire:model.defer="localidad">

                        </div>

                        <div>

                            @error('localidad') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                        </div>

                    </div>

                    <div class="flex-auto ">

                        <div>

                            <Label>Oficina</Label>

                        </div>

                        <div>

                            <input type="number" class="bg-white rounded text-sm w-full" wire:model.defer="oficina">

                        </div>

                        <div>

                            @error('oficina') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                        </div>

                    </div>

                    <div class="flex-auto ">

                        <div>

                            <Label>Tipo</Label>

                        </div>

                        <div>

                            <input type="number" class="bg-white rounded text-sm w-full" wire:model.defer="tipo">

                        </div>

                        <div>

                            @error('tipo') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                        </div>

                    </div>

                    <div class="flex-auto ">

                        <div>

                            <Label>Número de registro</Label>

                        </div>

                        <div>

                            <input type="number" class="bg-white rounded text-sm w-full" wire:model.defer="numero_registro">

                        </div>

                        <div>

                            @error('numero_registro') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                        </div>

                    </div>

                </div>

            </div>

        </x-slot>

        <x-slot name="footer">

            <div class="float-righ">

                <button
                    wire:click="asignarCuenta"
                    wire:loading.attr="disabled"
                    wire:target="asignarCuenta"
                    class="bg-blue-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded-full text-sm mb-2 hover:bg-blue-700 flaot-left mr-1 focus:outline-none">

                    <img wire:loading wire:target="asignarCuenta" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                    Actualizar
                </button>

                <button
                    wire:click="$set('modal2', false)"
                    wire:loading.attr="disabled"
                    wire:target="$set('modal2', false)"
                    type="button"
                    class="bg-red-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded-full text-sm mb-2 hover:bg-red-700 flaot-left focus:outline-none">
                    Cerrar
                </button>

            </div>

        </x-slot>

    </x-dialog-modal>

</div>
