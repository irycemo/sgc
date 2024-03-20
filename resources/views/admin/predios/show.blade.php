@extends('layouts.admin')

@section('content')

    <h1 class="text-3xl tracking-widest py-3 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-thin mb-6  bg-white">Predio</h1>

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
                    <th class="px-2">Registrado por</th>

                </tr>

            </thead>

            <tbody class="divide-y divide-gray-200">

                @foreach ($predio->movimientos as $movimiento)

                    <tr class="text-gray-500 text-sm leading-relaxed">
                        <td class=" px-2 w-full ">{{ $movimiento->nombre }}</td>
                        <td class=" px-2 w-full ">{{ $movimiento->fecha }}</td>
                        <td class=" px-2 w-full ">{{ $movimiento->descripcion }}</td>
                        <td class=" px-2 w-full ">{{ $movimiento->creadoPor?->nombreCompleto() }}</td>
                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

    <h4 class="text-2xl tracking-widest py-1 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-thin mb-6  bg-white">Bloqueos ({{ $predio->bloqueos->count() }})</h4>

    <div class="bg-white p-4 rounded-lg w-full shadow-lg mb-5">

        <table class="w-full overflow-x-auto table-fixed">

            <thead class="border-b border-gray-300 ">

                <tr class="text-sm text-gray-500 text-left traling-wider whitespace-nowrap">

                    <th class="px-2">Estado</th>
                    <th class="px-2">Observaciones</th>
                    <th class="px-2">Registrado por</th>

                </tr>

            </thead>

            <tbody class="divide-y divide-gray-200">

                @foreach ($predio->bloqueos as $bloqueo)

                    <tr class="text-gray-500 text-sm leading-relaxed">
                        <td class=" px-2 w-full capitalize">{{ $bloqueo->estado }}</td>
                        <td class=" px-2 w-full ">{{ $bloqueo->observaciones }}</td>
                        <td class=" px-2 w-full ">{{ $bloqueo->creadoPor?->nombreCompleto() }}</td>
                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

    <h4 class="text-2xl tracking-widest py-1 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-thin mb-6  bg-white">Auditoria ({{ $predio->audits->count()}})</h4>

    <div class="bg-white p-4 rounded-lg w-full shadow-lg mb-5">

        <table class="w-full overflow-x-auto table-fixed">

            <thead class="border-b border-gray-300 ">

                <tr class="text-sm text-gray-500 text-left traling-wider whitespace-nowrap">

                    <th class="px-2">Usuario</th>
                    <th class="px-2">Movimiento</th>
                    <th class="px-2">Fecha</th>

                </tr>

            </thead>

            <tbody class="divide-y divide-gray-200">

                @foreach ($predio->audits as $audit)

                    <tr class="text-gray-500 text-sm leading-relaxed">
                        <td class=" px-2 w-full whitespace-nowrap">{{ $audit->user->nombreCompleto() }}</td>
                        <td class=" px-2 w-full whitespace-nowrap">{{ Str::ucfirst($audit->event) }}: {{ $audit->tags }}</td>
                        <td class=" px-2 w-full whitespace-nowrap">{{ $audit->created_at->format('d-m-Y H:i:s') }}</td>
                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

@endsection
