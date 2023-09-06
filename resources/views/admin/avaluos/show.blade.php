@extends('layouts.admin')

@section('content')

    <h1 class="text-3xl tracking-widest py-3 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-thin mb-6  bg-white">Predio avaluo</h1>

    <h4 class="text-2xl tracking-widest py-1 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-thin mb-6  bg-white">Datos generales</h4>

    <div class="bg-white p-4 rounded-lg w-full shadow-lg mb-5">

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

                <strong>Estado</strong>

                <p>{{ $predio->status }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Folio real</strong>

                <p>{{ $predio->folio_real }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Título de propiedad</strong>

                <p>{{ $predio->titulo_propiedad }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>CURT</strong>

                <p>{{ $predio->curt }}</p>

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

    <div class="bg-white p-4 rounded-lg w-full shadow-lg mb-5">

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

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

    @forelse ($predio->colindancias as $colindancia)

        <div class="bg-white p-4 rounded-lg w-full shadow-lg mb-5">

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">

                <div class="rounded-lg bg-gray-100 py-1 px-2">

                    <strong>Viento</strong>

                    <p>{{ $colindancia->viento }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2">

                    <strong>Longitud</strong>

                    <p>{{ number_format($colindancia->longitud, 2) }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2">

                    <strong>Descripción</strong>

                    <p>{{ $colindancia->descripcion }}</p>

                </div>

            </div>

        </div>

    @empty

        <div class="border-b border-gray-300 bg-white text-gray-500 text-center p-5 rounded-lg mb-5 text-lg">

            No hay resultados.

        </div>

    @endforelse

    <h4 class="text-2xl tracking-widest py-1 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-thin mb-6  bg-white">Terrenos ({{ $predio->terrenos->count() }})</h4>

    @forelse ($predio->terrenos as $terreno)

        <div class="bg-white p-4 rounded-lg w-full shadow-lg mb-5">

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">

                <div class="rounded-lg bg-gray-100 py-1 px-2">

                    <strong>Superficie</strong>

                    <p>{{ $terreno->superficie }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2">

                    <strong>Valor unitario</strong>

                    <p>{{ $terreno->valor_unitario }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2">

                    <strong>Demerito</strong>

                    <p>{{ $terreno->demerito }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2">

                    <strong>Valor demeritado</strong>

                    <p>{{ $terreno->valor_demeritado }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2">

                    <strong>Valor del terreno</strong>

                    <p>${{ number_format($terreno->valor_terreno, 2) }}</p>

                </div>

            </div>

        </div>

    @empty

        <div class="border-b border-gray-300 bg-white text-gray-500 text-center p-5 rounded-lg mb-5 text-lg">

            No hay resultados.

        </div>

    @endforelse

    <h4 class="text-2xl tracking-widest py-1 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-thin mb-6  bg-white">Construcciones ({{ $predio->construcciones->count() }})</h4>

    @forelse ($predio->construcciones as $construccion)

        <div class="bg-white p-4 rounded-lg w-full shadow-lg mb-5">

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">

                <div class="rounded-lg bg-gray-100 py-1 px-2">

                    <strong>Referencia</strong>

                    <p>{{ $construccion->referencia }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2">

                    <strong>Clasificación de construccion</strong>

                    <p>{{ $construccion->tipo }}-{{ $construccion->uso }}-{{ $construccion->calidad }}-{{ $construccion->estado }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2">

                    <strong>Niveles</strong>

                    <p>{{ $construccion->niveles }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2">

                    <strong>Superficie</strong>

                    <p>{{ $construccion->superficie }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2">

                    <strong>Valor unitario</strong>

                    <p>{{ $construccion->valor_unitario }}</p>

                </div>

            </div>

        </div>

    @empty

        <div class="border-b border-gray-300 bg-white text-gray-500 text-center p-5 rounded-lg mb-5 text-lg">

            No hay resultados.

        </div>

    @endforelse

    <h4 class="text-2xl tracking-widest py-1 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-thin mb-6  bg-white">Terrenos de área común ({{ $predio->condominioTerrenos->count() }})</h4>

    @forelse ($predio->condominioTerrenos as $terreno)

        <div class="bg-white p-4 rounded-lg w-full shadow-lg mb-5">

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">

                <div class="rounded-lg bg-gray-100 py-1 px-2">

                    <strong>Área común de terreno</strong>

                    <p>{{ $terreno->area_terreno_comun }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2">

                    <strong>Indiviso de terreno</strong>

                    <p>{{ $terreno->indiviso_terreno }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2">

                    <strong>Valor unitario</strong>

                    <p>{{ $terreno->valor_unitario }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2">

                    <strong>Valor de terreno común</strong>

                    <p>${{ number_format($terreno->valor_terreno_comun, 2) }}</p>

                </div>

            </div>

        </div>

    @empty

        <div class="border-b border-gray-300 bg-white text-gray-500 text-center p-5 rounded-lg mb-5 text-lg">

            No hay resultados.

        </div>

    @endforelse

    <h4 class="text-2xl tracking-widest py-1 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-thin mb-6  bg-white">Construcciones de área común ({{ $predio->condominioConstrucciones->count() }})</h4>

    @forelse ($predio->condominioConstrucciones as $construccion)

        <div class="bg-white p-4 rounded-lg w-full shadow-lg mb-5">

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">

                <div class="rounded-lg bg-gray-100 py-1 px-2">

                    <strong>Área común de construcción</strong>

                    <p>{{ $construccion->area_comun_construccion }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2">

                    <strong>Clasificación de construccion</strong>

                    <p>{{ $construccion->valor_clasificacion_construccion }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2">

                    <strong>Valor de construcción común</strong>

                    <p>${{ number_format($construccion->valor_construccion_comun, 2) }}</p>

                </div>

            </div>

        </div>

    @empty

        <div class="border-b border-gray-300 bg-white text-gray-500 text-center p-5 rounded-lg mb-5 text-lg">

            No hay resultados.

        </div>

    @endforelse

    <h4 class="text-2xl tracking-widest py-1 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-thin mb-6  bg-white">Propietarios ({{ $predio->propietarios->count() }})</h4>

    @forelse ($predio->propietarios as $propietario)

        <div class="bg-white p-4 rounded-lg w-full shadow-lg mb-2">

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

                <div class="rounded-lg bg-gray-100 py-1 px-2">

                    <strong>Tipo</strong>

                    <p>{{ $propietario->tipo }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2">

                    <strong>Porcentaje</strong>

                    <p>{{ $propietario->porcentaje }}%</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2">

                    <strong>Nombre</strong>

                    <p>{{ $propietario->persona->nombre }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2">

                    <strong>Apellido paterno</strong>

                    <p>{{ $propietario->persona->ap_paterno }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2">

                    <strong>Apellido materno</strong>

                    <p>{{ $propietario->persona->ap_materno }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2">

                    <strong>Tipo de persona</strong>

                    <p>{{ $propietario->persona->tipo }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2">

                    <strong>CURP</strong>

                    <p>{{ $propietario->persona->curp }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2">

                    <strong>RFC</strong>

                    <p>{{ $propietario->persona->rfc }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2">

                    <strong>Razón social</strong>

                    <p>{{ $propietario->persona->razon_social }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2">

                    <strong>Estado civil</strong>

                    <p>{{ $propietario->persona->estado_civil }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2 col-span-2">

                    <strong>Dirección</strong>

                    <div class="flex flex-wrap space-x-2">

                        <p>Calle: {{ $propietario->persona->calle }}.</p>
                        <p>Número exterior: {{ $propietario->persona->numero_exterior }}.</p>
                        <p>Número interior: {{ $propietario->persona->numero_interior }}.</p>
                        <p>Colonia: {{ $propietario->persona->colonia }}.</p>
                        <p>Código postal: {{ $propietario->persona->cp }}.</p>
                        <p>Entidad: {{ $propietario->persona->entidad }}.</p>
                        <p>Municipio: {{ $propietario->persona->municipio }}.</p>

                    </div>

                </div>

            </div>

        </div>

    @empty

        <div class="border-b border-gray-300 bg-white text-gray-500 text-center p-5 rounded-lg mb-5 text-lg">

            No hay resultados.

        </div>

    @endforelse

    <h4 class="text-2xl tracking-widest py-1 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-thin mb-6  bg-white">Movimientos ({{ $predio->audits->count() }})</h4>

    @forelse ($predio->audits as $audit)

        <div class="bg-white p-4 rounded-lg w-full shadow-lg mb-2">

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

                <div class="rounded-lg bg-gray-100 py-1 px-2">

                    <strong>Usuario</strong>

                    <p>{{ $audit->user->name }} {{ $audit->user->ap_paterno }} {{ $audit->user->ap_materno }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2">

                    <strong>Movimiento</strong>

                    <p> {{ Str::ucfirst($audit->event) }}. {{ $audit->tags }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2">

                    <strong>Fecha</strong>

                    <p>{{ $audit->created_at->format('d-m-Y H:i:s') }}</p>

                </div>

            </div>

        </div>

    @empty

        <div class="border-b border-gray-300 bg-white text-gray-500 text-center p-5 rounded-lg mb-5 text-lg">

            No hay resultados.

        </div>

    @endforelse

@endsection
