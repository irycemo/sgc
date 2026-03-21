<x-h4>Datos generales</x-h4>

<div class="bg-white p-4 rounded-lg w-full shadow-lg mb-5 text-sm text-gray-600">

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

        <div class="rounded-lg bg-gray-100 py-1 px-2">

            <strong>Folio</strong>

            <p>{{ $avaluo->año }}-{{ $avaluo->folio }}-{{ $avaluo->usuario }}</p>

        </div>

        <div class="rounded-lg bg-gray-100 py-1 px-2">

            <strong>Estado</strong>

            <p class="capitalize">{{ $avaluo->estado }}</p>

        </div>

        <div class="rounded-lg bg-gray-100 py-1 px-2">

            <strong>Asignado a</strong>

            <p>{{ $avaluo->asignadoA->name }}</p>

        </div>

        <div class="rounded-lg bg-gray-100 py-1 px-2">

            <strong>Trámtie de inspección ocular</strong>

            <p>{{ $avaluo->tramiteInspeccion?->año }}-{{ $avaluo->tramiteInspeccion?->folio }}-{{ $avaluo->tramiteInspeccion?->usuario }}</p>

        </div>

        <div class="rounded-lg bg-gray-100 py-1 px-2">

            <strong>Trámtie de desglose</strong>

            <p>{{ $avaluo->tramiteDesglose?->año }}-{{ $avaluo->tramiteDesglose?->folio }}-{{ $avaluo->tramiteDesglose?->usuario }}</p>

        </div>

        <div class="rounded-lg bg-gray-100 py-1 px-2">

            <strong>Registro</strong>

            <p>Registrado por: {{ $avaluo->creadoPor->name }}</p>
            <p>Registrado en: {{ $avaluo->created_at }}</p>

        </div>

        <div class="rounded-lg bg-gray-100 py-1 px-2">

            <strong>Notificación</strong>

            <p>Notificado por:{{ $avaluo->notificador?->name }}</p>
            <p>Notificado en: {{ $avaluo->notificado_en?->format('d-m-Y') }}</p>

        </div>

        @if($avaluo->predioIgnorado)

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Predio ignorado</strong>

                <p>{{ $avaluo->predioIgnorado->año }}-{{ $avaluo->predioIgnorado->folio }}</p>

            </div>

        @endif

        @if($avaluo->variacionCatastral)

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Variación catastral</strong>

                <p>{{ $avaluo->variacionCatastral->año }}-{{ $avaluo->variacionCatastral->folio }}</p>

            </div>

        @endif

        <div class="rounded-lg bg-gray-100 py-1 px-2 col-span-1 sm:col-span-2 lg:col-span-4">

            <strong>Observaciones</strong>

            <p>{{ $avaluo->observaciones }}</p>

        </div>

    </div>

</div>