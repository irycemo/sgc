<div class="flex flex-col lg:flex-row gap-3 mb-3">

    <div class="rounded-lg bg-gray-100 py-1 px-2">

        <p class="font-semibold text-gray-900">Estado del documento</p>

        <p class="text-gray-500 text-sm leading-relaxed capitalize">{{ $certificacion->estado }}</p>

    </div>

    <div class="rounded-lg bg-gray-100 py-1 px-2">

        <p class="font-semibold text-gray-900">Suscrito</p>

        @foreach ($array as $item)

            @if(key($item) === 'Suscrito')

                <p class="text-gray-500 text-sm leading-relaxed">{{ $item[key($item)] }}</p>

            @endif

        @endforeach

    </div>

    <div class="rounded-lg bg-gray-100 py-1 px-2">

        <p class="font-semibold text-gray-900">Cargo</p>

        @foreach ($array as $item)

            @if(key($item) === 'Cargo')

                <p class="text-gray-500 text-sm leading-relaxed">{{ $item[key($item)] }}</p>

            @endif

        @endforeach

    </div>

    <div class="rounded-lg bg-gray-100 py-1 px-2">

        <strong>Cuenta predial</strong>

        @foreach ($array as $item)

            @if(key($item) === 'Cuenta predial')

                <p class="text-gray-500 text-sm leading-relaxed">{{ $item[key($item)] }}</p>

            @endif

        @endforeach

    </div>

    <div class="rounded-lg bg-gray-100 py-1 px-2">

        <strong>Clave catastral</strong>

        @foreach ($array as $item)

            @if(key($item) === 'Clave catastral')

                <p class="text-gray-500 text-sm leading-relaxed">{{ $item[key($item)] }}</p>

            @endif

        @endforeach

    </div>

    <div class="rounded-lg bg-gray-100 py-1 px-2">

        <strong>Propietario</strong>

        @foreach ($array as $item)

            @if(key($item) === 'Propietario')

                <p class="text-gray-500 text-sm leading-relaxed">{{ $item[key($item)] }}</p>

            @endif

        @endforeach

    </div>

</div>

<div class="rounded-lg bg-gray-100 py-1 px-2 mb-3">

    <strong>Historia</strong>

    @foreach ($array as $item)

        @if(key($item) === 'Historia')

            <p class="text-gray-500 text-sm leading-relaxed">{!! $item[key($item)] !!}</p>

        @endif

    @endforeach

</div>

<div class="flex flex-col lg:flex-row gap-3 mb-3">

    <div class="rounded-lg bg-gray-100 py-1 px-2">

        <p class="font-semibold text-gray-900">Solicitante</p>

        @foreach ($array as $item)

            @if(key($item) === 'Solicitante')

                <p class="text-gray-500 text-sm leading-relaxed">{{ $item[key($item)] }}</p>

            @endif

        @endforeach

    </div>

    <div class="rounded-lg bg-gray-100 py-1 px-2">

        <p class="font-semibold text-gray-900">Expedido en</p>

        @foreach ($array as $item)

            @if(key($item) === 'Oficina')

                <p class="text-gray-500 text-sm leading-relaxed">{{ $item[key($item)] }}</p>

            @endif

        @endforeach

    </div>

    <div class="rounded-lg bg-gray-100 py-1 px-2">

        <p class="font-semibold text-gray-900">Trámite</p>

        @foreach ($array as $item)

            @if(key($item) === 'Trámite')

                <p class="text-gray-500 text-sm leading-relaxed">{{ $item[key($item)] }}</p>

            @endif

        @endforeach

        @foreach ($array as $item)

            @if(key($item) === 'Recibo')

                <p class="text-gray-500 text-sm leading-relaxed">Recibo: {{ $item[key($item)] }}</p>

            @endif

        @endforeach

    </div>

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

    <div class="rounded-lg bg-gray-100 py-1 px-2 mb-3">

        <strong>Titular</strong>

        @foreach ($array as $item)

            @if(key($item) === 'Titular')

                <p class="text-gray-500 text-sm leading-relaxed">{!! $item[key($item)] !!}</p>

            @endif

        @endforeach

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
