<div class="bg-white p-4 rounded-lg shadow-lg">

    <div class="text-lg font-semibold text-center tracking-widest mb-3">

        <span>Avalúo de perito externo</span>

    </div>

    <div class="tab-wrapper max-h-full" x-data="{ activeTab: 0 }">

        <div class="flex py-4 items-center flex-wrap justify-center gap-3">

            <label
                @click="activeTab = 0"
                class="px-6 py-1 text-gray-600 rounded-full border-b-2 border-gray-500 font-semibold mb-3 cursor-pointer bg-white w-full"
                :class="{'active  bg-gray-200 text-gray-500 no-underline': activeTab === 0 }"
            >Identificación del inmueble
            </label>

            <div class="tab-panel w-full" :class="{ 'active': activeTab === 0 }" x-show.transition.in.opacity.duration.800="activeTab === 0"  wire:key="tab-0">

                <div class="rounded-lg bg-gray-100 py-1 px-2 mb-2 flex gap-2">

                    <strong>Cuenta predial</strong>

                    <p>{{ $avaluo['localidad'] }}-{{ $avaluo['oficina'] }}-{{ $avaluo['tipo_predio'] }}-{{ $avaluo['numero_registro'] }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2 mb-2 flex gap-2">

                    <strong>Clave catastral</strong>

                    <p>16-{{ $avaluo['region_catastral'] }}-{{ $avaluo['municipio'] }}-{{ $avaluo['zona_catastral'] }}-{{ $avaluo['localidad'] }}-{{ $avaluo['sector'] }}-{{ $avaluo['manzana'] }}-{{ $avaluo['predio'] }}-{{ $avaluo['edificio'] }}-{{ $avaluo['departamento'] }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2 mb-2 flex gap-2">

                    <strong>Código postal</strong>

                    <p>{{ $avaluo['codigo_postal'] }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2 mb-2 flex gap-2">

                    <strong>Nombre del asentamiento</strong>

                    <p>{{ $avaluo['nombre_asentamiento'] }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2 mb-2 flex gap-2">

                    <strong>Tipo de asentamiento</strong>

                    <p>{{ $avaluo['tipo_asentamiento'] }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2 mb-2 flex gap-2">

                    <strong>Nombre del vialidad</strong>

                    <p>{{ $avaluo['nombre_vialidad'] }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2 mb-2 flex gap-2">

                    <strong>Tipo de vialidad</strong>

                    <p>{{ $avaluo['tipo_vialidad'] }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2 mb-2 flex gap-2">

                    <strong>Número exterior</strong>

                    <p>{{ $avaluo['numero_exterior'] }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2 mb-2 flex gap-2">

                    <strong>Número exterior 2</strong>

                    <p>{{ $avaluo['numero_exterior_2'] }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2 mb-2 flex gap-2">

                    <strong>Número interior</strong>

                    <p>{{ $avaluo['numero_interior'] }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2 mb-2 flex gap-2">

                    <strong>Número adicional</strong>

                    <p>{{ $avaluo['numero_adicional'] }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2 mb-2 flex gap-2">

                    <strong>Número adicional 2</strong>

                    <p>{{ $avaluo['numero_adicional_2'] }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2 mb-2 flex gap-2">

                    <strong>Lote del fraccionador</strong>

                    <p>{{ $avaluo['lote_fraccionador'] }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2 mb-2 flex gap-2">

                    <strong>Manzana del fraccionador</strong>

                    <p>{{ $avaluo['manzana_fraccionador'] }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2 mb-2 flex gap-2">

                    <strong>Etapa o zona del fraccionador</strong>

                    <p>{{ $avaluo['etapa_fraccionador'] }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2 mb-2 flex gap-2">

                    <strong>Nombre del edificio</strong>

                    <p>{{ $avaluo['nombre_edificio'] }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2 mb-2 flex gap-2">

                    <strong>Clave del edificio</strong>

                    <p>{{ $avaluo['clave_edificio'] }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2 mb-2 flex gap-2">

                    <strong>Departamento</strong>

                    <p>{{ $avaluo['departamento_edificio'] }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2 mb-2">

                    <strong>Predio Rústico Denominado ó Antecedente</strong>

                    <p>{{ $avaluo['nombre_predio'] }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2 mb-2">

                    <strong>Coordenadas geográficas</strong>

                    <p>LAT: {{ $avaluo['lat'] }}, LON: {{ $avaluo['lon'] }}</p>

                </div>

            </div>

            <label
                @click="activeTab = 2"
                class="px-6 py-1 text-gray-600 rounded-full border-b-2 border-gray-500 font-semibold mb-3 cursor-pointer bg-white w-full"
                :class="{'active  bg-gray-200 text-gray-500 no-underline': activeTab === 2 }"
            >Colindancias
            </label>

            <div class="tab-panel w-full" :class="{ 'active': activeTab === 2 }" x-show.transition.in.opacity.duration.800="activeTab === 2"  wire:key="tab-2">

                <table class="w-full">

                    <thead class="border-b border-gray-300 ">

                        <tr class="text-sm text-gray-500 text-left traling-wider whitespace-nowrap">

                            <th class="px-2">Viento</th>
                            <th class="px-2">Longitud</th>
                            <th class="px-2">Descripcion</th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-200">

                        @foreach ($avaluo['colindancias'] as $colindancia)

                            <tr class="text-gray-500 text-sm leading-relaxed">
                                <td class=" px-2 w-min">{{ $colindancia['viento'] }}</td>
                                <td class=" px-2 w-min">{{ $colindancia['longitud'] }}</td>
                                <td class=" px-2 w-full">{{ $colindancia['descripcion'] }}</td>
                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

            <label
                @click="activeTab = 1"
                class="px-6 py-1 text-gray-600 rounded-full border-b-2 border-gray-500 font-semibold mb-3 cursor-pointer bg-white w-full"
                :class="{'active  bg-gray-200 text-gray-500 no-underline': activeTab === 1 }"
            >Propietarios
            </label>

            <div class="tab-panel w-full  overflow-auto" :class="{ 'active': activeTab === 1 }" x-show.transition.in.opacity.duration.800="activeTab === 1"  wire:key="tab-1">

                <table class="w-full">

                    <thead class="border-b border-gray-300 ">

                        <tr class="text-sm text-gray-500 text-left traling-wider whitespace-nowrap">

                            <th class="px-2">Nombre / Razón social</th>
                            <th class="px-2">% Porpiedad</th>
                            <th class="px-2">% Nuda</th>
                            <th class="px-2">% Usufructo</th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-gray-200">

                        @foreach ($avaluo['propietarios'] as $propietario)

                            <tr class="text-gray-500 text-sm leading-relaxed">
                                <td class=" px-2 w-full">{{ $propietario['persona']['nombre'] }} {{ $propietario['persona']['ap_paterno'] }} {{ $propietario['persona']['ap_materno'] }} {{ $propietario['persona']['razon_social'] }}</td>
                                <td class=" px-2 w-min">{{ $propietario['porcentaje'] ?? '0' }}</td>
                                <td class=" px-2 w-min">{{ $propietario['porcentaje_nuda'] ?? '0' }}</td>
                                <td class=" px-2 w-min">{{ $propietario['porcentaje_usufructo'] ?? '0' }}</td>
                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

            <label
                @click="activeTab = 3"
                class="px-6 py-1 text-gray-600 rounded-full border-b-2 border-gray-500 font-semibold mb-3 cursor-pointer bg-white w-full"
                :class="{'active  bg-gray-200 text-gray-500 no-underline': activeTab === 3 }"
            >Superficies y valores
            </label>

            <div class="tab-panel w-full" :class="{ 'active': activeTab === 3 }" x-show.transition.in.opacity.duration.800="activeTab === 3"  wire:key="tab-3">

                <div class="rounded-lg bg-gray-100 py-1 px-2 mb-2 flex gap-2">

                    <strong>Superficie total de terreno</strong>

                    <p>{{ $avaluo['superficie_total_terreno'] }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2 mb-2 flex gap-2">

                    <strong>Superficie total de construcción</strong>

                    <p>{{ $avaluo['superficie_total_construccion'] }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2 mb-2 flex gap-2">

                    <strong>Valor de terreno</strong>

                    <p>{{ $avaluo['valor_total_terreno'] }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2 mb-2 flex gap-2">

                    <strong>Valor de construcción</strong>

                    <p>{{ $avaluo['valor_total_construccion'] }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2 mb-2 flex gap-2">

                    <strong>Valor catastral</strong>

                    <p>{{ $avaluo['valor_catastral'] }}</p>

                </div>

            </div>

        </div>

    </div>

    <x-button-blue
        wire:click="imprimirAvaluo({{ $traslado->id }})"
        wire:loading.attr="disabled"
        wire:target="imprimirAvaluo({{ $traslado->id }})">

        <img wire:loading wire:target="imprimirAvaluo({{ $traslado->id }})" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

        Ver avalúo

    </x-button-blue>

</div>
