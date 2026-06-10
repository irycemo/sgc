<div >

    <p class="separador">propietarios</p>

    <table>

        <thead>

            <tr>
                <th style="padding-right: 10px; text-align: left;">Nombre / Razon social</th>
                <th style="padding-right: 10px; text-align: left;">Apellido paterno</th>
                <th style="padding-right: 10px; text-align: left;">Apellido materno</th>
                <th style="padding-right: 10px;">% de propiedad</th>
                <th style="padding-right: 10px;">% de nuda</th>
                <th style="padding-right: 10px;">% de usufructo</th>
            </tr>

        </thead>

        <tbody>

            @foreach ($predio->propietarios as $propietario)

                <tr >
                    <td style="padding-right: 40px; text-align: left;">
                        <p style="margin:0">{{ $propietario->persona->nombre }}{{ $propietario->persona->razon_social }}</p>
                        @if($propietario->persona->multiple_nombre)
                            <p style="margin:0">({{ $propietario->persona->multiple_nombre }})</p>
                        @endif
                    </td>
                    <td style="padding-right: 40px; text-align: left;">
                        <p style="margin:0">{{ $propietario->persona->ap_paterno }}</p>
                    </td>
                    <td style="padding-right: 40px; text-align: left;">
                        <p style="margin:0">{{ $propietario->persona->ap_materno }}</p>
                    </td>
                    <td style="padding-right: 40px;">
                        <p style="margin:0">
                            @if(isset($predio->partes_iguales))

                                @if($predio->partes_iguales)

                                    Partes iguales

                                @else

                                    {{ $propietario->porcentaje_propiedad ?? '0.00' }}%

                                @endif

                            @else

                                {{ $propietario->porcentaje_propiedad ?? '0.00' }}%

                            @endif
                        </p>
                    </td>
                    <td style="padding-right: 40px;">
                        <p style="margin:0">{{ $propietario->porcentaje_nuda ?? '0.00' }} %</p>
                    </td>
                    <td style="padding-right: 40px;">
                        <p style="margin:0">{{ $propietario->porcentaje_usufructo ?? '0.00' }} %</p>
                    </td>
                </tr>

            @endforeach

        </tbody>

    </table>

</div>
