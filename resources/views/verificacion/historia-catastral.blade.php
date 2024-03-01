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

    <strong>Historia</strong>

    <p class="text-gray-500 text-sm leading-relaxed">{!! $objeto->historia !!}</p>

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

        <p class="font-semibold text-gray-900">Firma electrónica</p>

        <p class="text-gray-500 text-sm leading-relaxed break-words">{{ $certificacion->cadena_encriptada }}</p>

    </div>

@endif

@if($certificacion->observaciones)

    <div class="rounded-lg bg-gray-100 py-1 px-2 mt-3">

        <p class="font-semibold text-gray-900">Observaciones</p>

        <p class="text-gray-500 text-sm leading-relaxed break-words">{{ $certificacion->observaciones }}</p>

    </div>

@endif
