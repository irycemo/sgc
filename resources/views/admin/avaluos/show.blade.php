@push('styles')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" integrity="sha512-ZKX+BvQihRJPA8CROKBhDNvoc2aDMOdAlcm7TUQY+35XYtrd3yh95QOOhsPDQY9QnKE0Wqag9y38OIgEvb88cA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

@endpush

@extends('layouts.admin')

@section('content')

    <x-header>Avaluo</x-header>

    <h4 class="text-2xl tracking-widest py-1 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-thin mb-6  bg-white">Datos generales</h4>

    <div class="bg-white p-4 rounded-lg w-full shadow-lg mb-5 text-sm text-gray-600">

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Folio</strong>

                <p>{{ $avaluo->año }}-{{ $avaluo->folio }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Estado</strong>

                <p class="capitalize">{{ $avaluo->estado }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Asignado a</strong>

                <p>{{ $avaluo->asignadoA->name }} {{ $avaluo->asignadoA->ap_paterno }} {{ $avaluo->asignadoA->ap_materno }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Trámtie</strong>

                <p>{{ $avaluo->tramite?->año }}-{{ $avaluo->tramite?->folio }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Registro</strong>

                <p>Registrado por: {{ $avaluo->creadoPor->name }} {{ $avaluo->creadoPor->ap_paterno }} {{ $avaluo->creadoPor->ap_materno }}</p>
                <p>Registrado en: {{ $avaluo->created_at }}</p>

            </div><div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Notificación</strong>

                <p>Notificado por:{{ $avaluo->notificador?->name }} {{ $avaluo->notificador?->ap_paterno }} {{ $avaluo->notificador?->ap_materno }}</p>
                <p>Notificado en: {{ $avaluo->notificado_en?->format('d-m-Y') }}</p>

            </div>

        </div>

    </div>

    <h4 class="text-2xl tracking-widest py-1 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-thin mb-6  bg-white">Datos generales del predio</h4>

    <div class="bg-white p-4 rounded-lg w-full shadow-lg mb-5 text-sm text-gray-600">

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Cuenta predial</strong>

                <p>{{ $predio->localidad }}-{{ $predio->oficina }}-{{ $predio->tipo_predio }}-{{ $predio->numero_registro }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Clave catastral</strong>

                <p>{{ $predio->estado }}-{{ $predio->region_catastral }}-{{ $predio->municipio }}-{{ $predio->zona_catastral }}-{{ $predio->localidad }}-{{ $predio->sector }}-{{ $predio->manzana }}-{{ $predio->predio }}-{{ $predio->edificio }}-{{ $predio->departamento }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Fecha de notificación</strong>

                <p>{{ $predio->fecha_notificacion ?? 'N/A' }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Fecha de efectos</strong>

                <p>{{ $predio->fecha_efectos ?? 'N/A' }}</p>

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

    <h4 class="text-2xl tracking-widest py-1 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-thin mb-6  bg-white">Caracteristicas</h4>

    <div class="bg-white p-4 rounded-lg w-full shadow-lg mb-5 text-gray-600">

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 text-sm">

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Clasificación de la zona</strong>

                <p>{{ $avaluo->clasificacion_zona }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Tipo de construcción dominante</strong>

                <p>{{ $avaluo->construccion_dominante }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Cimentación</strong>

                <p>{{ $avaluo->cimentacion }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Estructura</strong>

                <p>{{ $avaluo->estructura }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Muros</strong>

                <p>{{ $avaluo->muros }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Entrepisos</strong>

                <p>{{ $avaluo->entrepiso }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Techo</strong>

                <p>{{ $avaluo->techo }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Plafones</strong>

                <p>{{ $avaluo->plafones }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Vidriería</strong>

                <p>{{ $avaluo->vidrieria }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Lambrines</strong>

                <p>{{ $avaluo->lambrines }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Pisos</strong>

                <p>{{ $avaluo->pisos }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Herreria</strong>

                <p>{{ $avaluo->herreria }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Pintura</strong>

                <p>{{ $avaluo->pintura }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Carpinteria</strong>

                <p>{{ $avaluo->carpinteria }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Recubrimiento especial</strong>

                <p>{{ $avaluo->recubrimiento_especial }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Aplanados</strong>

                <p>{{ $avaluo->aplanados }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Hidraulica</strong>

                <p>{{ $avaluo->hidraulica }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Sanitaria</strong>

                <p>{{ $avaluo->sanitaria }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Eléctrica</strong>

                <p>{{ $avaluo->electrica }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Gas</strong>

                <p>{{ $avaluo->gas }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Especiales</strong>

                <p>{{ $avaluo->especiales }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2 col-span-1 sm:col-span-2 lg:col-span-5">

                <strong>Observaciones</strong>

                <p>{{ $avaluo->observaciones }}</p>

            </div>

        </div>

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

    <h4 class="text-2xl tracking-widest py-1 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-thin mb-6  bg-white">Imágenes</h4>

    <div class="bg-white p-4 rounded-lg w-full shadow-lg mb-5 text-sm">

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Fachada</strong>

                <a href="{{ $avaluo->fachada() }}" data-lightbox="imagen" data-title="Fachada">
                    <img class="h-20 w-20 mx-auto my-3" src="{{ $avaluo->fachada() }}" alt="Fachada">
                </a>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Foto</strong>

                <a href="{{ $avaluo->foto2() }}" data-lightbox="imagen" data-title="Foto 2">
                    <img class="h-20 w-20 mx-auto my-3" src="{{ $avaluo->foto2() }}" alt="Foto 2">
                </a>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Foto</strong>

                <a href="{{ $avaluo->foto3() }}" data-lightbox="imagen" data-title="Foto 3">
                    <img class="h-20 w-20 mx-auto my-3" src="{{ $avaluo->foto3() }}" alt="Foto 3">
                </a>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Foto</strong>

                <a href="{{ $avaluo->foto4() }}" data-lightbox="imagen" data-title="Foto 4">
                    <img class="h-20 w-20 mx-auto my-3" src="{{ $avaluo->foto4() }}" alt="Foto 4">
                </a>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Macrolocalización</strong>

                <a href="{{ $avaluo->macrolocalizacion() }}" data-lightbox="imagen" data-title="Macrolocalización">
                    <img class="h-20 w-20 mx-auto my-3" src="{{ $avaluo->macrolocalizacion() }}" alt="Macrolocalización">
                </a>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Microlocalización</strong>

                <a href="{{ $avaluo->microlocalizacion() }}" data-lightbox="imagen" data-title="Microlocalización">
                    <img class="h-20 w-20 mx-auto my-3" src="{{ $avaluo->microlocalizacion() }}" alt="Microlocalización">
                </a>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Imágen del poligono</strong>

                <a href="{{ $avaluo->poligonoImagen() }}" data-lightbox="imagen" data-title="Imágen del poligono">
                    <img class="h-20 w-20 mx-auto my-3" src="{{ $avaluo->poligonoImagen() }}" alt="Imágen del poligono">
                </a>

            </div>


        </div>

    </div>

    <h4 class="text-2xl tracking-widest py-1 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-thin mb-6  bg-white">Auditoria ({{ $avaluo->audits->count()}})</h4>

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

                @foreach ($avaluo->audits as $audit)

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

@push('scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js" integrity="sha512-k2GFCTbp9rQU412BStrcD/rlwv1PYec9SNrkbQlo6RZCf75l6KcC3UwDY8H5n5hl4v77IDtIPwOk9Dqjs/mMBQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

@endpush
