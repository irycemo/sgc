<p class="separador">Superficies y valor catastral</p>

<p class="parrafo">

    <strong>Superficie total de terreno:</strong>  {{ $predio->superficie_total_terreno }} @if($predio->tipo_predio == 1) Metros cuadrados; @else Hectáreas; @endif

    @if ($predio->superficie_construccion)

        <strong>Superficie total de construcción:</strong> {{ $predio->superficie_total_construccion }} @if($predio->tipo_predio == 1) Metros cuadrados; @else Hectáreas; @endif

    @endif

    @if ($predio->superficie_judicial)
        <strong>superficie judicial:</strong>  {{ $predio->superficie_judicial }};
    @endif

    @if ($predio->superficie_notarial)
        <strong>superficie notarial:</strong> {{ $predio->superficie_notarial }};
    @endif

    @if ($predio->area_comun_terreno)
        <strong>área de terreno común:</strong> {{ $predio->area_comun_terreno }} @if($predio->tipo_predio == 1) Metros cuadrados; @else Hectáreas; @endif
    @endif

    @if ($predio->area_comun_construccion)
        <strong>área de construcción común:</strong> {{ $predio->area_comun_construccion }} @if($predio->tipo_predio == 1) Metros cuadrados; @else Hectáreas; @endif
    @endif

</p>

<p>

    @if ($predio->valor_terreno_comun)
        <strong>valor de terreno común:</strong> ${{ number_format($predio->valor_terreno_comun, 2) }};
    @endif

    @if ($predio->valor_construccion_comun)
        <strong>valor de construcción común:</strong> ${{ number_format($predio->valor_construccion_comun, 2) }};
    @endif

    @if ($predio->valor_total_terreno)
        <strong>valor total de terreno:</strong> ${{ number_format($predio->valor_total_terreno, 2) }};
    @endif

    @if ($predio->valor_total_construccion)
        <strong>valor total de construcción:</strong> ${{ number_format($predio->valor_total_construccion, 2) }};
    @endif

    @if($predio->ubicacion_en_manzana == 'ESQUINA')

        <strong>Ubicación en esquina:</strong> ${{ number_format(($predio->valor_total_terreno + $predio->valor_total_construccion) * 0.15, 2) }}

    @endif

</p>

<p class="parrafo">
    <strong>Valor catastral: </strong>${{ number_format($predio->valor_catastral, 2) }}
</p>
