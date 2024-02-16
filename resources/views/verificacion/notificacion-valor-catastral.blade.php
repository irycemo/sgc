<div class="flex flex-col lg:flex-row gap-3 mb-3">

    <div class="rounded-lg bg-gray-100 py-1 px-2">

        <p class="font-semibold text-gray-900">Estado del documento</p>

        <p class="text-gray-500 text-sm leading-relaxed capitalize">{{ $certificacion->estado }}</p>

    </div>

    <div class="rounded-lg bg-gray-100 py-1 px-2">

        <p class="font-semibold text-gray-900">Cantidad de avalúos</p>

        @foreach ($array as $item)

            @if(key($item) === 'Número')

                <p class="text-gray-500 text-sm leading-relaxed">{{ $item[key($item)] }}</p>

            @endif

        @endforeach

    </div>

    <div class="rounded-lg bg-gray-100 py-1 px-2">

        <p class="font-semibold text-gray-900">Valuador</p>

        @foreach ($array as $item)

            @if(key($item) === 'Valuador')

                <p class="text-gray-500 text-sm leading-relaxed">{{ $item[key($item)] }}</p>

            @endif

        @endforeach

    </div>

    <div class="rounded-lg bg-gray-100 py-1 px-2 mb-3">

        <strong>Titular</strong>

        @foreach ($array as $item)

            @if(key($item) === 'Titular')

                <p class="text-gray-500 text-sm leading-relaxed">{!! $item[key($item)] !!}</p>

            @endif

        @endforeach

    </div>

    <div class="rounded-lg bg-gray-100 py-1 px-2 mb-3">

        <strong>Cargo</strong>

        @foreach ($array as $item)

            @if(key($item) === 'Cargo')

                <p class="text-gray-500 text-sm leading-relaxed">{!! $item[key($item)] !!}</p>

            @endif

        @endforeach

    </div>

    @foreach ($array as $item)

        @if(key($item) === 'Jefe de departamento')

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <p class="font-semibold text-gray-900">Jefe de departamento</p>

                <p class="text-gray-500 text-sm leading-relaxed">{{ $item[key($item)] }}</p>

            </div>

        @endif

    @endforeach

</div>

<div class="rounded-lg bg-gray-100 py-1 px-2 mb-3 overflow-x-auto">

    <strong>Avaluos</strong>

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

            @foreach ($array as $item)

                @if(count($item) === 5)

                    <tr class="text-gray-500 text-sm leading-relaxed">
                        <td class=" px-2 w-full whitespace-nowrap">{{ str_replace('Folio avalúo=' , '', $item[0]) }}</td>
                        <td class=" px-2 w-full whitespace-nowrap">{{ str_replace('Cuenta predial=' , '', $item[1]) }}</td>
                        <td class=" px-2 w-full whitespace-nowrap">{{ str_replace('Clave catastral=' , '', $item[2]) }}</td>
                        <td class=" px-2 w-full whitespace-nowrap">{{ str_replace('Propietario=' , '', $item[3]) }}</td>
                        <td class=" px-2 w-full whitespace-nowrap text-right">${{ number_format(str_replace('Valor catastral=' , '', $item[4]), 2) }}</td>
                    </tr>

                @endif

            @endforeach

        </tbody>

    </table>

</div>

<div class="flex flex-col lg:flex-row gap-3 mb-3">

    @foreach ($array as $item)

        @if(key($item) === 'Trámite de inspección')

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <p class="font-semibold text-gray-900">Trámite de inspección</p>

                <p class="text-gray-500 text-sm leading-relaxed">{{ $item[key($item)] }}</p>

                @foreach ($array as $item)

                    @if(key($item) === 'Recibo Inspección')

                        <p class="text-gray-500 text-sm leading-relaxed">Recibo: {{ $item[key($item)] }}</p>

                    @endif

                @endforeach

            </div>

        @endif

    @endforeach

    @foreach ($array as $item)

        @if(key($item) === 'Trámite de avalúo')

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <p class="font-semibold text-gray-900">Trámite de avalúo</p>

                <p class="text-gray-500 text-sm leading-relaxed">{{ $item[key($item)] }}</p>

                @foreach ($array as $item)

                    @if(key($item) === 'Recibo Avalúo')

                        <p class="text-gray-500 text-sm leading-relaxed">Recibo: {{ $item[key($item)] }}</p>

                    @endif

                @endforeach

            </div>

        @endif

    @endforeach

    <div class="rounded-lg bg-gray-100 py-1 px-2">

        <p class="font-semibold text-gray-900">Impreso en</p>

        @foreach ($array as $item)

            @if(key($item) === 'Impreso en')

                <p class="text-gray-500 text-sm leading-relaxed">{{ $item[key($item)] }}</p>

            @endif

        @endforeach

    </div>

    <div class="rounded-lg bg-gray-100 py-1 px-2">

        <p class="font-semibold text-gray-900">Impreso por</p>

        @foreach ($array as $item)

            @if(key($item) === 'Impreso por')

                <p class="text-gray-500 text-sm leading-relaxed">{{ $item[key($item)] }}</p>

            @endif

        @endforeach

    </div>

</div>

@foreach ($array as $item)

    @if(key($item) === 'Convenio municipal')

        <div class="rounded-lg bg-gray-100 py-1 px-2 mb-3">

            <p class="font-semibold text-gray-900">Convenio municipal</p>

            <p class="text-gray-500 text-sm leading-relaxed break-words">Convenio municipal</p>

        </div>

    @endif

@endforeach

@foreach ($array as $item)

    @if(key($item) === 'Firma Jefe de departamento')

        <div class="rounded-lg bg-gray-100 py-1 px-2 mb-3">

            <p class="font-semibold text-gray-900">Firma electrónica (Jefe de departamento)</p>

            <p class="text-gray-500 text-sm leading-relaxed break-words">{{ $item[key($item)] }}</p>

        </div>

    @endif

@endforeach

@if($certificacion->cadena_encriptada)

    <div class="rounded-lg bg-gray-100 py-1 px-2">

        <p class="font-semibold text-gray-900">Firma electrónica (Director)</p>

        <p class="text-gray-500 text-sm leading-relaxed break-words">{{ $certificacion->cadena_encriptada }}</p>

    </div>

@endif

@if($certificacion->observaciones)

    <div class="rounded-lg bg-gray-100 py-1 px-2 mt-3">

        <p class="font-semibold text-gray-900">Observaciones</p>

        <p class="text-gray-500 text-sm leading-relaxed break-words">{{ $certificacion->observaciones }}</p>

    </div>

@endif
