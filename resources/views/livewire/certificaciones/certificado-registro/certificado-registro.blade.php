<div>

    <x-header>Certificado de registro</x-header>

    <div class="bg-white p-4 rounded-lg mb-5 shadow-lg">

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

        <div class="mb-3">

            <button
                wire:click="buscarTramite"
                wire:loading.attr="disabled"
                wire:target="buscarTramite"
                type="button"
                class="bg-blue-400 mx-auto hover:shadow-lg text-white font-bold px-4 py-2 rounded text-xs hover:bg-blue-700 focus:outline-none flex items-center justify-center focus:outline-blue-400 focus:outline-offset-2">

                <img wire:loading wire:target="buscarTramite" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                Buscar trámtie

            </button>

        </div>

        @if($tramite)

            <div class="flex flex-col lg:flex-row gap-3 justify-center text-sm mb-3">

                <div class="rounded-lg bg-gray-100 py-1 px-2">

                    <strong>Trámite</strong>

                    <p>{{ $tramite->año . '-' . $tramite->folio . '-' . $tramite->usuario }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2">

                    <strong>Servicio</strong>

                    <p>{{ $tramite->servicio->nombre }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2">

                    <strong>Solicitante</strong>

                    <p>{{ $tramite->nombre_solicitante }}</p>

                </div>

            </div>

            <div class="flex flex-wrap gap-3 justify-center text-sm mt-5">

                <p class="text-center w-full">Predios</p>

                @foreach ($tramite->predios as $item)

                    @if($item->pivot->estado === "A")

                        <div
                            wire:click="seleccionarPredio({{ $item->id }})"
                            class="rounded-lg bg-gray-100 py-1 px-2 hover:cursor-pointer hover:bg-gray-200">

                            <p>{{ $item->cuentaPredial() }}</p>

                        </div>

                    @endif

                @endforeach

            </div>

        @endif

    </div>

    @if($predio)

        <div class="bg-white p-4 rounded-lg mb-5 shadow-lg text-sm">

            <div class="flex flex-col lg:flex-row gap-3 justify-center w-full mx-auto lg:w-1/2">

                <div class="rounded-lg bg-gray-100 py-1 px-2">

                    <strong>Cuenta predial</strong>

                    <p>{{ $predio->cuentaPredial() }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2">

                    <strong>Clave catastral</strong>

                    <p>{{ $predio->claveCatastral() }}</p>

                </div>

            </div>

            <p class="text-center my-4">Ubicación del predio</p>

            <div class="bg-gray-100 py-1 px-2 gap-3 justify-center w-full mx-auto lg:w-1/2">

                <p class="mb-2">
                    @if($predio->tipo_asentamiento)<strong>Tipo de asentamiento:</strong> {{ $predio->tipo_asentamiento }},@endif
                    @if($predio->nombre_asentamiento)<strong>Nombre del asentamiento:</strong> {{ $predio->nombre_asentamiento }},@endif
                    @if($predio->tipo_vialidad)<strong>Tipo de vialidad:</strong> {{ $predio->tipo_vialidad }},@endif
                    @if($predio->nombre_vialidad)<strong>Nombre de la vialidad:</strong> {{ $predio->nombre_vialidad }},@endif
                    @if($predio->numero_interior)<strong>Número interior:</strong> {{ $predio->numero_interior }},@endif
                    @if($predio->numero_exterior)<strong>Número exterior:</strong> {{ $predio->numero_exterior }},@endif
                    @if($predio->numero_exterior_2)<strong>Número exterior 2:</strong> {{ $predio->numero_exterior_2 }},@endif
                    @if($predio->numero_adicional)<strong>Número adicional:</strong> {{ $predio->numero_adicional }},@endif
                    @if($predio->numero_adicional_2)<strong>Número adicional 2:</strong> {{ $predio->numero_adicional_2 }},@endif
                    @if($predio->codigo_postal)<strong>Código postal:</strong> {{ $predio->codigo_postal }}@endif
                </p>

                <p class="mb-2">
                    @if($predio->nombre_edificio)<strong>Nombre del edificio:</strong> {{ $predio->nombre_edificio }},@endif
                    @if($predio->clave_edificio)<strong>Clave del edificio:</strong> {{ $predio->clave_edificio }},@endif
                    @if($predio->departamento_edificio)<strong>Departamento:</strong> {{ $predio->departamento_edificio }}@endif
                </p>

                <p class="mb-2">
                    @if($predio->lote_fraccionador)<strong>Lote del fraccionador:</strong> {{ $predio->lote_fraccionador }},@endif
                    @if($predio->manzana_fraccionador)<strong>Manzana del fraccionador:</strong> {{ $predio->manzana_fraccionador }},@endif
                    @if($predio->etapa_fraccionador)<strong>Etapa del fraccionador:</strong> {{ $predio->etapa_fraccionador }}@endif
                    @if($predio->ubicacion_en_manzana)<strong>Ubicación del predio en la manzana:</strong> {{ $predio->ubicacion_en_manzana }}@endif
                </p>

                <p>
                    @if($predio->nombre_predio)<strong>Predio Rústico Denominado ó Antecedente:</strong> {{ $predio->nombre_predio }}@endif
                </p>

                @if($predio->xutm || $predio->lat)

                    <p class="mb-4">
                        <strong>Coordenadas geográficas: </strong>
                    </p>

                    @if($predio->xutm)

                            <strong>UTM: </strong>
                            <strong>X:</strong> {{ $predio->xutm }}, <strong>Y:</strong> {{ $predio->yutm }},  <strong>Z:</strong> {{ $predio->zutm }}

                    @endif

                    @if($predio->xutm)
                        <p>
                            <strong>GEO: </strong>
                            <strong>LAT:</strong> {{ $predio->lat }}, <strong>LON:</strong> {{ $predio->lon }}
                        </p>
                    @endif

                @endif

            </div>

            <p class="text-center my-4">Superficies y valor catastral</p>

            <div class="flex flex-col lg:flex-row gap-3 justify-center w-full mx-auto lg:w-1/2">

                @if($predio->superficie_notarial)

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <strong>Superficie notarial</strong>

                        <p>{{ $predio->superficie_notarial }}</p>

                    </div>

                @endif

                @if($predio->superficie_judicial)

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <strong>Superficie judicial</strong>

                        <p>{{ $predio->superficie_judicial }}</p>

                    </div>

                @endif

                <div class="rounded-lg bg-gray-100 py-1 px-2">

                    <strong>Superficie de terreno</strong>

                    <p>{{ $predio->superficie_terreno }}</p>

                </div>

                @if($predio->superficie_construccion)

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <strong>Superficie de construcción</strong>

                        <p>{{ $predio->superficie_construccion }}</p>

                    </div>

                @endif

                @if($predio->area_comun_terreno)

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <strong>Superficie común de terreno</strong>

                        <p>{{ $predio->area_comun_terreno }}</p>

                    </div>

                @endif

                @if($predio->area_comun_construccion)

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <strong>Superficie común de construcción</strong>

                        <p>{{ $predio->area_comun_construccion }}</p>

                    </div>

                @endif

                <div class="rounded-lg bg-gray-100 py-1 px-2">

                    <strong>Valor catastral</strong>

                    <p>${{ number_format($predio->valor_catastral, 2) }}</p>

                </div>

            </div>

            <p class="text-center my-4">Propietarios</p>

            <div class="overflow-auto w-full mx-auto lg:w-1/2 space-y-2">

                <table class="w-full overflow-x-auto table-fixed">

                    <thead class="border-b border-gray-300 ">

                        <tr class="text-sm text-gray-500 text-left traling-wider whitespace-nowrap">

                            <th class="px-2">Tipo de persona</th>
                            <th class="px-2">Nombre / Razón social</th>
                            <th class="px-2">% de propiedad</th>
                            <th class="px-2">% de nuda</th>
                            <th class="px-2">% de usufructo</th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-200">

                        @foreach ($predio->propietarios->sortBy('persona.nombre') as $propietario)

                            <tr class="text-gray-500 text-sm leading-relaxed">
                                <td class=" px-2 w-full ">{{ $propietario->persona->tipo }}</td>
                                <td class=" px-2 w-full ">{{ $propietario->persona->nombre }} {{ $propietario->persona->ap_paterno }} {{ $propietario->persona->ap_materno }} {{ $propietario->persona->razon_social }}</td>
                                <td class=" px-2 w-full ">{{ $propietario->porcentaje_propiedad }}%</td>
                                <td class=" px-2 w-full ">{{ $propietario->porcentaje_nuda }}%</td>
                                <td class=" px-2 w-full ">{{ $propietario->porcentaje_usufructo }}%</td>
                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

            @if($tramite->servicio->id == 6)

                <p class="text-center my-4">Colindancias</p>

                <div class="overflow-auto w-full mx-auto lg:w-1/2 space-y-2">

                    @foreach ($predio->colindancias as $colindancia)

                        <div class="flex gap-3 justify-center">

                            <div class="rounded-lg bg-gray-100 py-1 px-2">

                                <strong>Viento</strong>

                                <p>{{ $colindancia->viento }}</p>

                            </div>

                            <div class="rounded-lg bg-gray-100 py-1 px-2">

                                <strong>Longitud</strong>

                                <p>{{ $colindancia->longitud }}</p>

                            </div>

                            <div class="rounded-lg bg-gray-100 py-1 px-2">

                                <strong>Descripción</strong>

                                <p>{{ $colindancia->descripcion }}</p>

                            </div>

                        </div>

                    @endforeach

                </div>

            @endif

        </div>

        <div class="flex flex-col lg:flex-row gap-3 mb-5 bg-white rounded-lg p-2 shadow-lg justify-center lg:justify-between items-center">

            <div>

                {{-- <div class="flex space-x-4 items-center">

                    <x-checkbox wire:model="impresionDirector"></x-checkbox>

                    <Label>Imprimir certificado con firma del director de catastro</Label>

                </div> --}}

            </div>

            <x-button-green
                wire:click="generarCertificado"
                wire:loading.attr="disabled"
                wire:target="generarCertificado">

                <img wire:loading wire:target="generarCertificado" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                Generar certificado

            </x-button-green>

        </div>

    @endif

</div>
