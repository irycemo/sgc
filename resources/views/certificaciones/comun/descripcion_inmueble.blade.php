<p class="separador">Superficies y valor catastral</p>

<p class="parrafo">

    <strong>Superficie total de terreno:</strong>  {{ $predio->superficie_total_terreno }} @if(isset($predio->tipo_predio) && $predio->tipo_predio == 2) Hectareas @else Metros cuadrados @endif;

    <strong>Superficie total de construcción:</strong> {{ $predio->superficie_total_construccion }} Metros cuadrados
</p>

<p class="parrafo">

    <strong>superficie notarial:</strong> {{ $predio->superficie_notarial }} @if(isset($predio->tipo_predio) && $predio->tipo_predio == 2) Hectareas @else Metros cuadrados @endif

    <strong>superficie judicial:</strong>  {{ $predio->superficie_judicial }} @if(isset($predio->tipo_predio) && $predio->tipo_predio == 2) Hectareas @else Metros cuadrados @endif;

</p>

@if(isset($predio->terrenosComun) || isset($predio->terrenosComun))

    <p>

        @if(isset($predio->terrenosComun))

            <strong>Superficie privativa de terreno:</strong>  {{ collect($predio->terrenos)->sum('superficie') }}  Metros cuadrados;

        @else

            <strong>Superficie privativa de terreno:</strong>

        @endif

        @if(isset($predio->terrenosComun))

            <strong>Superficie proporcional de terreno:</strong>  {{ collect($predio->terrenosComun)->sum('superficie_proporcional') }}  Metros cuadrados;

        @else

            <strong>Superficie proporcional de terreno:</strong>

        @endif

    </p>

    <p>

        @if(isset($predio->terrenosComun))

            <strong>Superficie privativa de construccion:</strong>  {{ collect($predio->construcciones)->sum('superficie') }}  Metros cuadrados;

        @else

            <strong>Superficie proporcional de construccion:</strong>

        @endif

        @if(isset($predio->terrenosComun))

            <strong>Superficie proporcional de construccion:</strong>  {{ collect($predio->construccionesComun)->sum('superficie_proporcional') }}  Metros cuadrados;

        @else

            <strong>Superficie proporcional de construccion:</strong>

        @endif

    </p>

@endif

<p class="parrafo">
    <strong>Valor catastral: </strong>${{ number_format($predio->valor_catastral, 2) }}
</p>
