<p class="separador">Superficies y valor catastral</p>

<p class="parrafo">

    <strong>Superficie total de terreno:</strong>  {{ $predio->superficie_total_terreno }} @if(isset($predio->tipo_predio) && $predio->tipo_predio == 2) Hectareas @else Metros cuadrados @endif

    <strong>Superficie total de construcción:</strong> {{ $predio->superficie_total_construccion }} Metros cuadrados
</p>

<p class="parrafo">

    <strong>superficie judicial:</strong>  {{ $predio->superficie_judicial }} @if(isset($predio->tipo_predio) && $predio->tipo_predio == 2) Hectareas @else Metros cuadrados @endif;

    <strong>superficie notarial:</strong> {{ $predio->superficie_notarial }} @if(isset($predio->tipo_predio) && $predio->tipo_predio == 2) Hectareas @else Metros cuadrados @endif;

</p>

<p class="parrafo">
    <strong>Valor catastral: </strong>${{ number_format($predio->valor_catastral, 2) }}
</p>
