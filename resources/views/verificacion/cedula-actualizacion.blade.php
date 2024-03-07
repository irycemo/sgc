<div class="flex flex-col lg:flex-row gap-3 mb-3">

    <div class="rounded-lg bg-gray-100 py-1 px-2">

        <p class="font-semibold text-gray-900">Estado del documento</p>

        <p class="text-gray-500 text-sm leading-relaxed capitalize">{{ $certificacion->estado }}</p>

    </div>

    <div class="rounded-lg bg-gray-100 py-1 px-2">

        <p class="font-semibold text-gray-900">Suscrito</p>

        <p class="text-gray-500 text-sm leading-relaxed">{{ $objeto->suscrito }}</p>

    </div>

    <div class="rounded-lg bg-gray-100 py-1 px-2">

        <p class="font-semibold text-gray-900">Cargo</p>

        <p class="text-gray-500 text-sm leading-relaxed">{{ $objeto->cargo }}</p>

    </div>

    <div class="rounded-lg bg-gray-100 py-1 px-2">

        <strong>Cuenta predial</strong>

        <p class="text-gray-500 text-sm leading-relaxed">{{ $objeto->cuenta_predial }}</p>

    </div>

    <div class="rounded-lg bg-gray-100 py-1 px-2">

        <strong>Clave catastral</strong>

        <p class="text-gray-500 text-sm leading-relaxed">{{ $objeto->clave_catastral }}</p>

    </div>

    <div class="rounded-lg bg-gray-100 py-1 px-2">

        <strong>Propietario</strong>

        <p class="text-gray-500 text-sm leading-relaxed">{{ $objeto->propietario }}</p>

    </div>

</div>

<div class="rounded-lg bg-gray-100 py-1 px-2 mb-3">

    <p class="text-center"><strong>Ubicación del predio</strong></p>

    <div class="text-gray-500 text-sm leading-relaxed">

        <p class="mb-2">
            @if(isset($objeto->tipo_asentamiento))<strong>Tipo de asentamiento:</strong> {{ $objeto->tipo_asentamiento }},@endif
            @if(isset($objeto->nombre_asentamiento))<strong>Nombre del asentamiento:</strong> {{ $objeto->nombre_asentamiento }},@endif
            @if(isset($objeto->tipo_vialidad))<strong>Tipo de vialidad:</strong> {{ $objeto->tipo_vialidad }},@endif
            @if(isset($objeto->nombre_vialidad))<strong>Nombre de la vialidad:</strong> {{ $objeto->nombre_vialidad }},@endif
            @if(isset($objeto->numero_interior))<strong>Número interior:</strong> {{ $objeto->numero_interior }},@endif
            @if(isset($objeto->numero_exterior))<strong>Número exterior:</strong> {{ $objeto->numero_exterior }},@endif
            @if(isset($objeto->numero_exterior_2))<strong>Número exterior 2:</strong> {{ $objeto->numero_exterior_2 }},@endif
            @if(isset($objeto->numero_adicional))<strong>Número adicional:</strong> {{ $objeto->numero_adicional }},@endif
            @if(isset($objeto->numero_adicional_2))<strong>Número adicional 2:</strong> {{ $objeto->numero_adicional_2 }},@endif
            @if(isset($objeto->codigo_postal))<strong>Código postal:</strong> {{ $objeto->codigo_postal }}@endif
        </p>

        <p class="mb-2">
            @if(isset($objeto->nombre_edificio))<strong>Nombre del edificio:</strong> {{ $objeto->nombre_edificio }},@endif
            @if(isset($objeto->clave_edificio))<strong>Clave del edificio:</strong> {{ $objeto->clave_edificio }},@endif
            @if(isset($objeto->departamento_edificio))<strong>Departamento:</strong> {{ $objeto->departamento_edificio }}@endif
        </p>

        <p class="mb-2">
            @if(isset($objeto->lote_fraccionador))<strong>Lote del fraccionador:</strong> {{ $objeto->lote_fraccionador }},@endif
            @if(isset($objeto->manzana_fraccionador))<strong>Manzana del fraccionador:</strong> {{ $objeto->manzana_fraccionador }},@endif
            @if(isset($objeto->etapa_fraccionador))<strong>Etapa del fraccionador:</strong> {{ $objeto->etapa_fraccionador }}@endif
            @if(isset($objeto->ubicacion_en_manzana))<strong>Ubicación del predio en la manzana:</strong> {{ $objeto->ubicacion_en_manzana }}@endif
        </p>

        <p>
            @if(isset($objeto->nombre_predio))<strong>Predio Rústico Denominado ó Antecedente:</strong> {{ $objeto->nombre_predio }}@endif
        </p>

        @if(isset($objeto->xutm) || isset($objeto->lat))

            <p class="mb-4">
                <strong>Coordenadas geográficas: </strong>
            </p>

            @if(isset($objeto->xutm))

                    <strong>UTM: </strong>
                    <strong>X:</strong> {{ $objeto->xutm }}, <strong>Y:</strong> {{ $objeto->yutm }},  <strong>Z:</strong> {{ $objeto->zutm }}

            @endif

            @if(isset($objeto->xutm))
                <p>
                    <strong>GEO: </strong>
                    <strong>LAT:</strong> {{ $objeto->lat }}, <strong>LON:</strong> {{ $objeto->lon }}
                </p>
            @endif

        @endif

        @if(isset($objeto->observaciones))<strong>Observaciones:</strong> {{ $objeto->observaciones }}@endif

    </div>

</div>

<div class="rounded-lg bg-gray-100 py-1 px-2 mb-3">

    <p class="text-center my-4"><strong>Superficies y valor catastral</strong></p>

    <div class="flex gap-3 justify-center w-full mx-auto text-gray-500 text-sm leading-relaxed">

        @if(isset($objeto->superficie_notarial))

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Superficie notarial</strong>

                <p>{{ $objeto->superficie_notarial }}</p>

            </div>

        @endif

        @if(isset($objeto->superficie_judicial))

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Superficie judicial</strong>

                <p>{{ $objeto->superficie_judicial }}</p>

            </div>

        @endif

        <div class="rounded-lg bg-gray-100 py-1 px-2">

            <strong>Superficie de terreno</strong>

            <p>{{ $objeto->superficie_terreno }}</p>

        </div>

        @if(isset($objeto->superficie_construccion))

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Superficie de construcción</strong>

                <p>{{ $objeto->superficie_construccion }}</p>

            </div>

        @endif

        @if(isset($objeto->area_comun_terreno))

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Superficie común de terreno</strong>

                <p>{{ $objeto->area_comun_terreno }}</p>

            </div>

        @endif

        @if(isset($objeto->area_comun_construccion))

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Superficie común de construcción</strong>

                <p>{{ $objeto->area_comun_construccion }}</p>

            </div>

        @endif

        <div class="rounded-lg bg-gray-100 py-1 px-2">

            <strong>Valor catastral</strong>

            <p>${{ number_format($objeto->valor_catastral, 2) }}</p>

        </div>

    </div>

</div>

<div class="flex flex-col lg:flex-row gap-3 mb-3">

    <div class="rounded-lg bg-gray-100 py-1 px-2">

        <p class="font-semibold text-gray-900">Solicitante</p>

        <p class="text-gray-500 text-sm leading-relaxed">{{ $objeto->solicitante }}</p>

    </div>

    <div class="rounded-lg bg-gray-100 py-1 px-2">

        <p class="font-semibold text-gray-900">Expedido en</p>

        <p class="text-gray-500 text-sm leading-relaxed">{{ $objeto->oficina }}</p>

    </div>

    <div class="rounded-lg bg-gray-100 py-1 px-2">

        <p class="font-semibold text-gray-900">Trámite</p>

        <p class="text-gray-500 text-sm leading-relaxed">{{ $objeto->tramite }}</p>

        <p class="text-gray-500 text-sm leading-relaxed">Recibo: {{ $objeto->recibo }}</p>

    </div>

    <div class="rounded-lg bg-gray-100 py-1 px-2">

        <p class="font-semibold text-gray-900">Impreso en</p>

        <p class="text-gray-500 text-sm leading-relaxed">{{ $objeto->impreso_en }}</p>

    </div>

    <div class="rounded-lg bg-gray-100 py-1 px-2">

        <p class="font-semibold text-gray-900">Impreso por</p>

        <p class="text-gray-500 text-sm leading-relaxed">{{ $objeto->impreso_por }}</p>

    </div>

</div>

@if($certificacion->cadena_encriptada)

    <div class="rounded-lg bg-gray-100 py-1 px-2">

        <p class="font-semibold text-gray-900 text-center">Firma electrónica</p>

        <p class="text-gray-500 text-sm leading-relaxed break-words">{{ $certificacion->cadena_encriptada }}</p>

    </div>

@endif

@if($certificacion->observaciones)

    <div class="rounded-lg bg-gray-100 py-1 px-2 mt-3">

        <p class="font-semibold text-gray-900">Observaciones</p>

        <p class="text-gray-500 text-sm leading-relaxed break-words">{{ $certificacion->observaciones }}</p>

    </div>

@endif
