<p class="separador">Características</p>

<p class="parrafo">

    <p><strong>Clasificación de la zona:</strong> {{ $predio->avaluo->clasificacion_zona }}</p>
    <p><strong>Tipo de construcción dominante:</strong> {{ $predio->avaluo->construccion_dominante }}</p>

    <p>
        <strong>Uso del predio:</strong> {{ $predio->uso_1 }}
        @if($predio->uso_2); <strong>Uso del predio 2:</strong> {{ $predio->uso_2 }}@endif
        @if($predio->uso_3); <strong>Uso del predio 3:</strong> {{ $predio->uso_3 }}@endif
    </p>

</p>

<table style="margin-top: 20px;" class="no-break">

    <thead>

        <tr>
            <th style="padding: 0 5px 0 5px; text-align: center;"></th>
            <th style="padding: 0 5px 0 5px; text-align: center;">Agua</th>
            <th style="padding: 0 5px 0 5px; text-align: center;">Drenaje</th>
            <th style="padding: 0 5px 0 5px; text-align: center;">Pavimento</th>
            <th style="padding: 0 5px 0 5px; text-align: center;">Energía eléctrica</th>
            <th style="padding: 0 5px 0 5px; text-align: center;">Alumbrado púlico</th>
            <th style="padding: 0 5px 0 5px; text-align: center;">Banqueta</th>
        </tr>

    </thead>

    <tbody>

        <tr>
            <td style="padding-right: 40px;">
                <p><strong>Servicios municipales</strong></p>
            </td>
            <td style="text-align: center;">
                {{ $predio->avaluo->agua ? 'Si' : 'No' }}
            </td>
            <td style="text-align: center;">
                {{ $predio->avaluo->drenaje ? 'Si' : 'No' }}
            </td>
            <td style="text-align: center;">
                {{ $predio->avaluo->drenaje ? 'Si' : 'No' }}
            </td>
            <td style="text-align: center;">
                {{ $predio->avaluo->energia_electrica ? 'Si' : 'No' }}
            </td>
            <td style="text-align: center;">
                {{ $predio->avaluo->alumbrado_publico ? 'Si' : 'No' }}
            </td>
            <td style="text-align: center;">
                {{ $predio->avaluo->banqueta ? 'Si' : 'No' }}
            </td>
        </tr>

    </tbody>

</table>

<p style="text-align: center; margin-top: 20px;"><strong>Obra negra</strong></p>

<table class="no-break">

    <thead>

        <tr>
            <th style="padding: 0 5px 0 5px; text-align: center;">Cimentación</th>
            <th style="padding: 0 5px 0 5px; text-align: center;">Estructura</th>
            <th style="padding: 0 5px 0 5px; text-align: center;">Muros</th>
            <th style="padding: 0 5px 0 5px; text-align: center;">Entrepisos</th>
            <th style="padding: 0 5px 0 5px; text-align: center;">Techo</th>
        </tr>

    </thead>

    <tbody style="border-right: 1px solid black;">

        <tr>
            <td style="padding: 0 10px 0 10px; text-align: center;">
                <p>{{ $predio->avaluo->cimentacion }}</p>
            </td>
            <td style="padding: 0 10px 0 10px; text-align: center;">
                <p>{{ $predio->avaluo->estructura }}</p>
            </td>
            <td style="padding: 0 10px 0 10px; text-align: center;">
                <p>{{ $predio->avaluo->muros }}</p>
            </td>
            <td style="padding: 0 10px 0 10px; text-align: center;">
                <p>{{ $predio->avaluo->entrepiso }}</p>
            </td>
            <td style="padding: 0 10px 0 10px; text-align: center;">
                <p>{{ $predio->avaluo->techo }}</p>
            </td>
        </tr>

    </tbody>

</table>

<p style="text-align: center; margin-top: 20px;"><strong>Acabados</strong></p>

<table class="no-break">

    <thead>

        <tr>
            <th style="padding: 0 5px 0 5px; text-align: center;">Plafones</th>
            <th style="padding: 0 5px 0 5px; text-align: center;">Vidriería</th>
            <th style="padding: 0 5px 0 5px; text-align: center;">Lambrines</th>
            <th style="padding: 0 5px 0 5px; text-align: center;">Pisos</th>
        </tr>

    </thead>

    <tbody>

        <tr>
            <td style="padding: 0 10px 0 10px; text-align: center;">
                <p>{{ $predio->avaluo->plafones }}</p>
            </td>
            <td style="padding: 0 10px 0 10px; text-align: center;">
                <p>{{ $predio->avaluo->vidrieria }}</p>
            </td>
            <td style="padding: 0 10px 0 10px; text-align: center;">
                <p>{{ $predio->avaluo->lambrines }}</p>
            </td>
            <td style="padding: 0 10px 0 10px; text-align: center;">
                <p>{{ $predio->avaluo->pisos }}</p>
            </td>
        </tr>

    </tbody>

</table>

<table class="no-break">

    <thead>

        <tr>
            <th style="padding: 0 5px 0 5px; text-align: center;">Herrería</th>
            <th style="padding: 0 5px 0 5px; text-align: center;">Pintura</th>
            <th style="padding: 0 5px 0 5px; text-align: center;">Carpintería</th>
            <th style="padding: 0 5px 0 5px; text-align: center;">Aplanados</th>
            <th style="padding: 0 5px 0 5px; text-align: center;">Recubrimiento especial</th>
        </tr>

    </thead>

    <tbody>

        <tr>
            <td style="padding: 0 10px 0 10px; text-align: center;">
                <p>{{ $predio->avaluo->herreria }}</p>
            </td>
            <td style="padding: 0 10px 0 10px; text-align: center;">
                <p>{{ $predio->avaluo->pintura }}</p>
            </td>
            <td style="padding: 0 10px 0 10px; text-align: center;">
                <p>{{ $predio->avaluo->carpinteria }}</p>
            </td>
            <td style="padding: 0 10px 0 10px; text-align: center;">
                <p>{{ $predio->avaluo->aplanados }}</p>
            </td>
            <td style="padding: 0 10px 0 10px; text-align: center;">
                <p>{{ $predio->avaluo->recubrimiento_especial }}</p>
            </td>
        </tr>

    </tbody>

</table>

<p style="text-align: center; margin-top: 20px;"><strong>Instalaciones</strong></p>

<table class="no-break">

    <thead>

        <tr>
            <th style="padding: 0 5px 0 5px; text-align: center;">Hidráulica</th>
            <th style="padding: 0 5px 0 5px; text-align: center;">Sanitaria</th>
            <th style="padding: 0 5px 0 5px; text-align: center;">Eléctrica</th>
            <th style="padding: 0 5px 0 5px; text-align: center;">Gas</th>
            <th style="padding: 0 5px 0 5px; text-align: center;">Especiales</th>
        </tr>

    </thead>

    <tbody>

        <tr>
            <td style="padding: 0 10px 0 10px; text-align: center;">
                <p>{{ $predio->avaluo->hidraulica }}</p>
            </td>
            <td style="padding: 0 10px 0 10px; text-align: center;">
                <p>{{ $predio->avaluo->sanitaria }}</p>
            </td>
            <td style="padding: 0 10px 0 10px; text-align: center;">
                <p>{{ $predio->avaluo->electrica }}</p>
            </td>
            <td style="padding: 0 10px 0 10px; text-align: center;">
                <p>{{ $predio->avaluo->gas }}</p>
            </td>
            <td style="padding: 0 10px 0 10px; text-align: center;">
                <p>{{ $predio->avaluo->especiales }}</p>
            </td>
        </tr>

    </tbody>

</table>