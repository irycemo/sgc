<div class="bg-white p-4 rounded-lg shadow-lg">

    <div class="text-lg font-semibold text-center tracking-widest mb-3">

        <span>Aviso de traslado</span>

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

                    <p>{{ $aviso['localidad'] }}-{{ $aviso['oficina'] }}-{{ $aviso['tipo_predio'] }}-{{ $aviso['numero_registro'] }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2 mb-2 flex gap-2">

                    <strong>Clave catastral</strong>

                    <p>16-{{ $aviso['region_catastral'] }}-{{ $aviso['municipio'] }}-{{ $aviso['zona_catastral'] }}-{{ $aviso['localidad'] }}-{{ $aviso['sector'] }}-{{ $aviso['manzana'] }}-{{ $aviso['predio'] }}-{{ $aviso['edificio'] }}-{{ $aviso['departamento'] }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2 mb-2 flex gap-2">

                    <strong>Código postal</strong>

                    <p>{{ $aviso['codigo_postal'] }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2 mb-2 flex gap-2">

                    <strong>Nombre del asentamiento</strong>

                    <p>{{ $aviso['nombre_asentamiento'] }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2 mb-2 flex gap-2">

                    <strong>Tipo de asentamiento</strong>

                    <p>{{ $aviso['tipo_asentamiento'] }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2 mb-2 flex gap-2">

                    <strong>Nombre del vialidad</strong>

                    <p>{{ $aviso['nombre_vialidad'] }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2 mb-2 flex gap-2">

                    <strong>Tipo de vialidad</strong>

                    <p>{{ $aviso['tipo_vialidad'] }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2 mb-2 flex gap-2">

                    <strong>Número exterior</strong>

                    <p>{{ $aviso['numero_exterior'] }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2 mb-2 flex gap-2">

                    <strong>Número exterior 2</strong>

                    <p>{{ $aviso['numero_exterior_2'] }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2 mb-2 flex gap-2">

                    <strong>Número interior</strong>

                    <p>{{ $aviso['numero_interior'] }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2 mb-2 flex gap-2">

                    <strong>Número adicional</strong>

                    <p>{{ $aviso['numero_adicional'] }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2 mb-2 flex gap-2">

                    <strong>Número adicional 2</strong>

                    <p>{{ $aviso['numero_adicional_2'] }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2 mb-2 flex gap-2">

                    <strong>Lote del fraccionador</strong>

                    <p>{{ $aviso['lote_fraccionador'] }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2 mb-2 flex gap-2">

                    <strong>Manzana del fraccionador</strong>

                    <p>{{ $aviso['manzana_fraccionador'] }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2 mb-2 flex gap-2">

                    <strong>Etapa o zona del fraccionador</strong>

                    <p>{{ $aviso['etapa_fraccionador'] }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2 mb-2 flex gap-2">

                    <strong>Nombre del edificio</strong>

                    <p>{{ $aviso['nombre_edificio'] }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2 mb-2 flex gap-2">

                    <strong>Clave del edificio</strong>

                    <p>{{ $aviso['clave_edificio'] }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2 mb-2 flex gap-2">

                    <strong>Departamento</strong>

                    <p>{{ $aviso['departamento_edificio'] }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2 mb-2">

                    <strong>Predio Rústico Denominado ó Antecedente</strong>

                    <p>{{ $aviso['nombre_predio'] }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2 mb-2 flex gap-2">

                    <strong>Coordenadas geográficas</strong>

                    <p>LAT: {{ $aviso['lat'] }}, LON: {{ $aviso['lon'] }}</p>

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

                        @foreach ($aviso['colindancias'] as $colindancia)

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
            >Transmitentes
            </label>

            <div class="tab-panel w-full" :class="{ 'active': activeTab === 1 }" x-show.transition.in.opacity.duration.800="activeTab === 1"  wire:key="tab-1">

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

                        @foreach ($aviso['transmitentes'] as $transmitente)

                            <tr class="text-gray-500 text-sm leading-relaxed">
                                <td class=" px-2 w-full">{{ $transmitente['nombre'] }} {{ $transmitente['ap_paterno'] }} {{ $transmitente['ap_materno'] }} {{ $transmitente['razon_social'] }}</td>
                                <td class=" px-2 w-min">{{ $transmitente['porcentaje'] ?? '0' }}</td>
                                <td class=" px-2 w-min">{{ $transmitente['porcentaje_nuda'] ?? '0' }}</td>
                                <td class=" px-2 w-min">{{ $transmitente['porcentaje_usufructo'] ?? '0' }}</td>
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

                    <strong>Superficie de terreno</strong>

                    <p>{{ $aviso['superficie_terreno'] }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2 mb-2 flex gap-2">

                    <strong>Superficie de construcción</strong>

                    <p>{{ $aviso['superficie_construccion'] }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2 mb-2 flex gap-2">

                    <strong>Valor catastral</strong>

                    <p>{{ $aviso['valor_catastral'] }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2 mb-2 flex gap-2">

                    <strong>Valor de ISAI</strong>

                    <p>{{ $aviso['valor_isai'] }}</p>

                </div>

            </div>

            <label
                @click="activeTab = 4"
                class="px-6 py-1 text-gray-600 rounded-full border-b-2 border-gray-500 font-semibold mb-3 cursor-pointer bg-white w-full"
                :class="{'active  bg-gray-200 text-gray-500 no-underline': activeTab === 4 }"
            >Acto / Escritura
            </label>

            <div class="tab-panel w-full" :class="{ 'active': activeTab === 4 }" x-show.transition.in.opacity.duration.800="activeTab === 4"  wire:key="tab-4">

                <div class="rounded-lg bg-gray-100 py-1 px-2 mb-2 flex gap-2">

                    <strong>Acto transmitivo de dominio</strong>

                    <p>{{ $aviso['acto'] }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2 mb-2">

                    <strong>Para el caso de adquisición por resolución judicial, fecha en la que causo ejecutoria</strong>

                    <p>{{ $aviso['fecha_ejecutoria'] }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2 mb-2 flex gap-2">

                    <strong>Tipo de escritura</strong>

                    <p>{{ $aviso['tipo_escritura'] }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2 mb-2 flex gap-2">

                    <strong>Número de escritura</strong>

                    <p>{{ $aviso['numero_escritura'] }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2 mb-2 flex gap-2">

                    <strong>Volumen</strong>

                    <p>{{ $aviso['volumen_escritura'] }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2 mb-2 flex gap-2">

                    <strong>Lugar de otorgamiento</strong>

                    <p>{{ $aviso['lugar_otorgamiento'] }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2 mb-2 flex gap-2">

                    <strong>Fecha de otorgamiento</strong>

                    <p>{{ $aviso['fecha_otorgamiento'] }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2 mb-2 flex gap-2">

                    <strong>Lugar de firma</strong>

                    <p>{{ $aviso['lugar_firma'] }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2 mb-2 flex gap-2">

                    <strong>Fecha de firma</strong>

                    <p>{{ $aviso['fecha_firma'] }}</p>

                </div>

            </div>

            <label
                @click="activeTab = 5"
                class="px-6 py-1 text-gray-600 rounded-full border-b-2 border-gray-500 font-semibold mb-3 cursor-pointer bg-white w-full"
                :class="{'active  bg-gray-200 text-gray-500 no-underline': activeTab === 5 }"
            >Archivo / Observaciones
            </label>

            <div class="tab-panel w-full" :class="{ 'active': activeTab === 5 }" x-show.transition.in.opacity.duration.800="activeTab === 5"  wire:key="tab-5">

                <div class="rounded-lg bg-gray-100 py-1 px-2 mb-2">

                    <strong>Observaciones</strong>

                    <p>{{ $aviso['observaciones'] }}</p>

                </div>

                <x-link-blue
                    href="{{ $aviso['archivo'] }}"
                    target="_blank"
                    >
                    Ver archivo
                </x-link-blue>

            </div>

        </div>

    </div>

</div>
