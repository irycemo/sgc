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

</div>

<div class="rounded-lg bg-gray-100 py-1 px-2 mb-3">

    <div class="text-gray-500 text-sm leading-relaxed">

        <p class="mb-2">
            CON FUNDAMENTO EN LOS ARTICULOS 18° FRACCIÓN VI DE LA LEY DE LA FUNCIÓN REGISTRAL Y CATASTRAL
            DEL ESTADO DE MICHOACÁN DE OCAMPO,8 FRACCIONES XI Y XVIII,DEL REGLAMENTO DE LA LEY DE LA
            FUNCIÓN REGISTRAL Y CATASTRAL DEL ESTADO DE MICHOACÁN DE OCAMPO,Y II FRACCIONES I,II,VI,XXVII
            Y XXXIV DEL REGLAMENTO INTERIOR DEL INSTITUTO REGISTRAL Y CATASTRAL DEL ESTADO DE MICHOACÁN
            DE OCAMPO EL SUSCRITO  <strong style="text-transform: uppercase;">{{ $objeto->suscrito }}, </strong> <strong style="text-transform: uppercase;">{{ $objeto->cargo }}. </strong>
            QUE HABIENDO EFECTUADO UNA REVISIÓN DE LOS PADRONES CATASTRALES EXISTENTES EN ESTA OFICINA A MI CARGO, NO SE ENCONTRO REGISTRO DE PROPIEDAD A NOMBRE DE: <strong> @if(!isset($objeto->razon_social)) {{ $objeto->nombre }} {{ $objeto->ap_paterno }} {{ $objeto->ap_materno }} @else {{ $objeto->razon_social }} @endif.</strong>
        </p>

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
