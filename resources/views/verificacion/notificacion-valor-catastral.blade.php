<div class="flex flex-col lg:flex-row gap-3 mb-3">

    <div class="rounded-lg bg-gray-100 py-1 px-2">

        <p class="font-semibold text-gray-900">Estado del documento</p>

        <p class="text-gray-500 text-sm leading-relaxed capitalize">{{ $certificacion->estado }}</p>

    </div>

    <div class="rounded-lg bg-gray-100 py-1 px-2">

        <p class="font-semibold text-gray-900">Cantidad de avalúos</p>

        <p class="text-gray-500 text-sm leading-relaxed">{{ $objeto->numero }}</p>

    </div>

    <div class="rounded-lg bg-gray-100 py-1 px-2">

        <p class="font-semibold text-gray-900">Valuador</p>

        <p class="text-gray-500 text-sm leading-relaxed">{{ $objeto->valuador }}</p>

    </div>

    <div class="rounded-lg bg-gray-100 py-1 px-2 mb-3">

        <strong>Titular</strong>

        <p class="text-gray-500 text-sm leading-relaxed">{{ $objeto->titular }}</p>

    </div>

    <div class="rounded-lg bg-gray-100 py-1 px-2 mb-3">

        <strong>Cargo</strong>

        <p class="text-gray-500 text-sm leading-relaxed">{{ $objeto->cargo }}</p>

    </div>

    <div class="rounded-lg bg-gray-100 py-1 px-2">

        <p class="font-semibold text-gray-900">Jefe de departamento</p>

        <p class="text-gray-500 text-sm leading-relaxed">{{ $objeto->jefe_de_departamento }}</p>

    </div>

</div>

<div class="rounded-lg bg-gray-100 py-1 px-2 mb-3 overflow-x-auto">

    <p class="text-center"><strong>Avaluos</strong></p>

    <table class="w-full overflow-x-auto table">

        <thead class="border-b border-gray-300 ">

            <tr class="text-sm text-gray-500 text-left traling-wider whitespace-nowrap">

                <th class="px-2">Folio avalúo</th>
                <th class="px-2">Cuenta predial</th>
                <th class="px-2">Clave catastral</th>
                <th class="px-2">Propietario</th>
                <th class="px-2">Valor catastral</th>

            </tr>

        </thead>

        <tbody class="divide-y divide-gray-200">

            @foreach ($objeto->avaluos as $avaluo)

                <tr class="text-gray-500 text-sm leading-relaxed">
                    <td class=" px-2 w-full whitespace-nowrap">{{ $avaluo->folio }}</td>
                    <td class=" px-2 w-full whitespace-nowrap">{{ $avaluo->cuenta_predial }}</td>
                    <td class=" px-2 w-full whitespace-nowrap">{{ $avaluo->clave_catastral }}</td>
                    <td class=" px-2 w-full whitespace-nowrap">{{ $avaluo->propietario }}</td>
                    <td class=" px-2 w-full whitespace-nowrap text-right">${{ number_format($avaluo->valor_catastral, 2) }}</td>
                </tr>

            @endforeach

        </tbody>

    </table>

</div>

<div class="flex flex-col lg:flex-row gap-3 mb-3">

    @if(isset($objeto->tramite_inspeccion))

        <div class="rounded-lg bg-gray-100 py-1 px-2">

            <p class="font-semibold text-gray-900">Trámite de inspección</p>

            <p class="text-gray-500 text-sm leading-relaxed">{{ $objeto->tramite_inspeccion }}</p>

            <p class="text-gray-500 text-sm leading-relaxed">Recibo: {{ $objeto->recibo_inspeccion }}</p>

        </div>

    @endif

    @if(isset($objeto->tramite_avaluo))

        <div class="rounded-lg bg-gray-100 py-1 px-2">

            <p class="font-semibold text-gray-900">Trámite de avalúo</p>

            <p class="text-gray-500 text-sm leading-relaxed">{{ $objeto->tramite_avaluo }}</p>

            <p class="text-gray-500 text-sm leading-relaxed">Recibo: {{ $objeto->recibo_avaluo }}</p>

        </div>

    @endif

    <div class="rounded-lg bg-gray-100 py-1 px-2">

        <p class="font-semibold text-gray-900">Impreso en</p>

        <p class="text-gray-500 text-sm leading-relaxed">{{ $objeto->impreso_en }}</p>

    </div>

    <div class="rounded-lg bg-gray-100 py-1 px-2">

        <p class="font-semibold text-gray-900">Impreso por</p>

        <p class="text-gray-500 text-sm leading-relaxed">{{ $objeto->impreso_por }}</p>

    </div>

</div>

@if(isset($objeto->convenio_municipal))

    <div class="rounded-lg bg-gray-100 py-1 px-2 mb-3">

        <p class="font-semibold text-gray-900">Convenio municipal</p>

        <p class="text-gray-500 text-sm leading-relaxed break-words">Convenio municipal</p>

    </div>

@endif

@if(isset($objeto->firma_jefe_de_departamento))

    <div class="rounded-lg bg-gray-100 py-1 px-2 mb-3">

        <p class="font-semibold text-gray-900 text-center">Firma electrónica (Jefe de departamento)</p>

        <p class="text-gray-500 text-sm leading-relaxed break-words">{{ $objeto->firma_jefe_de_departamento }}</p>

    </div>

@endif

@if($certificacion->cadena_encriptada)

    <div class="rounded-lg bg-gray-100 py-1 px-2">

        <p class="font-semibold text-gray-900 text-center">Firma electrónica (Director)</p>

        <p class="text-gray-500 text-sm leading-relaxed break-words">{{ $certificacion->cadena_encriptada }}</p>

    </div>

@endif

@if($certificacion->observaciones)

    <div class="rounded-lg bg-gray-100 py-1 px-2 mt-3">

        <p class="font-semibold text-gray-900">Observaciones</p>

        <p class="text-gray-500 text-sm leading-relaxed break-words">{{ $certificacion->observaciones }}</p>

    </div>

@endif
