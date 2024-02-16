<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Notificación de valor catastral</title>
</head>
<style>

    /* @page {
        margin: 0cm 0cm;
    } */

    header{
        position: fixed;
        top: 0cm;
        left: 0cm;
        right: 0cm;
        height: 100px;
        text-align: center;
    }

    .encabezado{
        height: 100px;
        display: block;
        margin-left: auto;
        margin-right: auto;
    }


    body{
        margin-top: 120px;
        counter-reset: page;
        height: 100%;
        background-image: url("storage/img/escudo_fondo.png");
        background-size: cover;
        font-family: sans-serif;
        font-weight: normal;
        line-height: 1.5;
    }

    .titulo{
        text-align: center;
        font-size: 14px;
        font-weight: bold;
    }

    .fundamento{
        text-align: justify;
        font-size: 9px;
    }

    .separador{
        text-align: justify;
        border-bottom: 1px solid black;
        padding: 0 20px 0 20px;
        border-radius: 25px;
        border-color: gray;
        letter-spacing: 5px;
        margin: 0 0 5px 0;
    }

    .informacion{
        padding: 0 20px 0 20px;
        font-size: 10px;
        margin-bottom: 10px;
    }

    .informacion p{
        margin: 0;
    }

    table{
        margin-bottom: 5px;
        margin-left: auto;
        margin-right: auto;
    }

    footer{
        position: fixed;
        bottom: 0cm;
        left: 0cm;
        right: 0cm;
        background: #5E1D45;
        color: white;
        font-size: 12px;

    }

    .fot{
        padding: 2px;
    }

    .fot p{
        text-align: center;
        margin: 0;
        margin-left: 10px;
    }

    .qr{
        display: block;
    }

    .caracteristicas-tabla{
        page-break-inside: avoid;
    }

    .totales{
        flex: auto;
    }

    .imagenes{
        width: 200px;
    }

    .borde{
        display: inline;
        border-top: 1px solid;
    }

</style>
<body>

    <header>

            <img class="encabezado" src="{{ public_path('storage/img/encabezado.png') }}" alt="encabezado">

    </header>

    <footer>

        <div class="fot">
            <p>www.irycem.michoacan.gob.mx</p>
        </div>

    </footer>

    <main>

        <div>

            <p class="titulo">NOTIFICACIÓN DE VALOR CATASTRAL</p>

            <div class="informacion" >

                <p class="fundamento">
                    CON FUNDAMENTO LEGAL EN EL ARTÍCULO 134 DE LA LEY DE LA FUNCIÓN REGISTRAL Y CATASTRAL DEL ESTADO DE MICHOACÁN DE OCAMPO Y CON LA FINALIDAD DE DAR CUMPLIMIENTO A LAS OBLIGACIONES PROPIAS DE LA DIRECCIÓN
                    DE CATASTRO DEL INSTITUTO REGISTRAL Y CATASTRAL DEL ESTADO DE MICHOACÁN DE OCAMPO, CON EL CARÁCTER SEÑALADO ME PERMITO NOTIFICARLE <strong>@foreach ($array as $item) @if(key($item) === 'Número') {{ $item[key($item)] }}@endif @endforeach</strong>
                    AVALÚO(S) DE VALOR CATASTRAL, QUE PARA MAYOR REFERENCIA SE DETALLA EN EL CUADRO ANEXO, ELLO CON EL PROPÓSITO DE QUE SURTA LOS EFECTOS LEGALES PROCEDENTES A QUE HAYA LUGAR;
                </p>

            </div>

        </div>

        <div class="informacion" >

            <table style="font-size: 11px;">

                <thead>

                    <tr>
                        <th style="padding: 0 5px 0 5px; text-align: center">FOLIO DEL AVALÚO</th>
                        <th style="padding: 0 5px 0 5px; text-align: center">CUENTA PREDIAL</th>
                        <th style="padding: 0 5px 0 5px; text-align: center">CLAVE CATASTRAL</th>
                        <th style="padding: 0 5px 0 5px; text-align: center">PROPIETARIO</th>
                        <th style="padding: 0 5px 0 5px; text-align: center">VALOR CATASTRAL</th>
                    </tr>

                </thead>

                <tbody>

                    @foreach ($array as $item)

                        @if(count($item) === 5)

                            <tr>
                                <td style="border: 1px solid gray; padding: 0 5px 0 5px;  white-space: nowrap;">
                                    <p>{{ str_replace('Folio avalúo=' , '', $item[0]) }}</p>
                                </td>
                                <td style="border: 1px solid gray; padding: 0 5px 0 5px;  white-space: nowrap;">
                                    <p>{{ str_replace('Cuenta predial=' , '', $item[1]) }}</p>
                                </td>
                                <td style="border: 1px solid gray; padding: 0 5px 0 5px; white-space: nowrap;">
                                    <p>{{ str_replace('Clave catastral=' , '', $item[2]) }}</p>
                                </td>
                                <td style="border: 1px solid gray; padding: 0 5px 0 5px;">
                                    <p>{{ str_replace('Propietario=' , '', $item[3]) }}</p>
                                </td>
                                <td style="border: 1px solid gray; padding: 0 5px 0 5px;  white-space: nowrap; text-align: right;">
                                    <p>${{ number_format(str_replace('Valor catastral=' , '', $item[4]), 2) }}</p>
                                </td>
                            </tr>

                        @endif

                    @endforeach

                </tbody>

            </table>

            <p class="fundamento">
                EL PRESENTE ACTO ES RECURRIBLE, POR LO CUAL DEBERÁ SER INPUGNADO DENTRO DEL TÉRMINO DE 10 DÍAS HÁBILES SIGUIENTES A SU NOTIFICACIÓN ANTE ESTA DIRECCIÓN DE CATASTRO DEL INSTITUTO REGISTRAL Y CATASTRAL DEL ESTADO
                DE MICHOACÁN DE OCAMPO O BIEN ANTE EL TRIBUNAL DE JUSTICIA ADMINISTRATIVA DEL ESTADO DE MICHOACÁN, DE CONFORMIDAD CON EL ARTÍCULO 128 Y 129 DEL CÓDIGO DE JUSTICIA ADMINISTRATIVA DEL ESTADO DE MICHOACÁN DE OCAMPO.
            </p>

            <p class="fundamento">
                DE CONFORMIDAD CON LO DISPUESTO EN LAFRACCIÓN I, XII DEL ARTÍCULO 18, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 90, 92 Y 93 DE LA LEY DE LA FUNCIÓN REGISTRAL Y CATASTRAL DEL ESTADO DE MICHOACÁN DE OCAMPO FRACCIÓN VII
                DEL ARTÍCULO 1°, FRACCIÓN XX DE ARTÍCULO 2°, FRACCIÓN II DEL ARTÍCULO 90 DEL CÓDIGO DE DESARROLLO URBANO DEL ESTADO DE MICHOACÁN DE OCAMPO, ASÍ COMO LAS FRACCIONES II, VII Y XVI DEL ARTÍCULO 13 DEL REGLAMENTO INTERIOR
                DEL INSTITUTO REGISTRAL Y CATASTRAL DEL ESTADO DE MICHOACÁN DE OCAMPO.
            </p>

        </div>

        <p class="separador">Datos de control</p>

        <div class="informacion">

            <p style="margin-top: 10px">EN LA CIUDAD DE _____________________________________ A LAS _______DEL MES _______ DEL AÑO _______.</p>

            <div>

                <table style="margin-top: 40px">

                    <tbody>
                        <tr>

                            <td style="padding-right: 20px; text-align:center; vertical-align: bottom; ">

                                <p></p>
                                <p style="border-top: gray solid 1px; overflow: hidden;">FIRMA Y NOMBRE DEL PROPIETAIO (REPRESENTANTE O APODERADO LEGAL)</p>

                            </td>

                            <td style="padding-right: 20px; text-align:center; vertical-align: bottom;">

                                <p style="border-top: gray solid 1px; text-align: center">FIRMA Y NOMBRE DEL NOTIFICADOR</p>

                            </td>s

                            @foreach ($array as $item)

                                @if(key($item) === 'Titular')

                                    @foreach ($array as $item)

                                        @if(key($item) === 'Valuador')

                                            <td style="padding-right: 20px; text-align:center; vertical-align: bottom;">

                                                <p style="text-transform: uppercase;">{{ $item[key($item)] }}</p>
                                                <p style="border-top: gray solid 1px; text-align: center">FIRMA Y NOMBRE DEL VALUADOR</p>

                                            </td>

                                        @endif

                                    @endforeach

                                @endif

                            @endforeach

                        </tr>

                    </tbody>

                </table>

                @foreach ($array as $item)

                    @if(key($item) === 'Autoridad municipal')

                        <table style="margin-top: 40px">

                            <tbody>
                                <tr>

                                    <td style="padding-right: 20px; text-align:center; vertical-align: bottom;">

                                        <p style="text-transform: uppercase;">{{ $item[key($item)] }}</p>
                                        <p style="border-top: gray solid 1px; text-align: center">FIRMA Y NOMBRE DE LA AUTORIDAD MUNICIPAL</p>

                                    </td>

                                    @foreach ($array as $item)

                                        @if(key($item) === 'Valuador')

                                            <td style="padding-right: 20px; text-align:center; vertical-align: bottom;">

                                                <p style="text-transform: uppercase;">{{ $item[key($item)] }}</p>
                                                <p style="border-top: gray solid 1px; text-align: center">FIRMA Y NOMBRE DEL VALUADOR</p>

                                            </td>

                                        @endif

                                    @endforeach

                                </tr>
                            </tbody>

                        </table>

                    @endif

                @endforeach

                @foreach ($array as $item)

                    @if(key($item) === 'Titular')

                        @if($certificacion->cadena_encriptada)

                            <div style="margin-top: 30px; page-break-inside: avoid;">

                                <div style="text-align: center">

                                    <p style="text-transform: uppercase; border-bottom: gray solid 1px; text-align: center; display: inline">@foreach ($array as $item) @if(key($item) === 'Titular') {{ $item[key($item)] }}@endif @endforeach</p>
                                    <p >DIRECTOR DE CATASTRO</p>
                                    <p>Firma Electrónica:</p>

                                </div>

                                <p style="overflow-wrap: break-word;">{{ $certificacion->cadena_encriptada }}</p>

                            </div>

                            <div style="page-break-inside: avoid;">

                                <div style="text-align: center;">

                                    <p style="text-transform: uppercase;">@foreach ($array as $item) @if(key($item) === 'Jefe de departamento') {{ $item[key($item)] }}@endif @endforeach</p>
                                    <p class="borde" style="width: ">JEFE DE DEPARTAMENTO DE VALUACIÓN</p>
                                    <p>Firma Electrónica:</p>

                                </div>

                                <p style="overflow-wrap: break-word;">@foreach ($array as $item) @if(key($item) === 'Firma Jefe de departamento') {{ $item[key($item)] }}@endif @endforeach</p>

                            </div>

                        @else

                            <div style="text-align: center; margin-top: 30px">

                                <p style="text-transform: uppercase; border-bottom: gray solid 1px; text-align: center; display: inline">@foreach ($array as $item) @if(key($item) === 'Titular') {{ $item[key($item)] }}@endif @endforeach</p>
                                <p style="text-transform: uppercase;">@foreach ($array as $item) @if(key($item) === 'Cargo') {{ $item[key($item)] }}@endif @endforeach</p>

                            </div>

                        @endif

                    @endif

                @endforeach

            </div>

            <table style="margin-top: 10px">

                <tbody>
                    <tr>
                        <td style="padding-right: 40px;">

                            <img class="qr" src="{{ $qr }}" alt="QR">
                        </td>
                        <td style="padding-right: 40px;">

                            @foreach ($array as $item)

                                @if(key($item) === 'Trámite de inspección')

                                        <p>
                                            <strong>Trámite de inspección ocular:</strong> {{ $item[key($item)] }}

                                            @foreach ($array as $item)

                                                @if(key($item) === 'Recibo Inspección')

                                                    <strong>Recibo:</strong> {{ $item[key($item)] }}

                                                @endif

                                            @endforeach

                                        </p>

                                @endif

                            @endforeach

                            @foreach ($array as $item)

                                @if(key($item) === 'Trámite de avalúo')

                                    <p>
                                        <strong>Trámite de impresión:</strong> {{ $item[key($item)] }}

                                        @foreach ($array as $item)

                                            @if(key($item) === 'Recibo Avalúo')

                                                <strong>Recibo:</strong> {{ $item[key($item)] }}

                                            @endif

                                        @endforeach

                                    </p>

                                @endif

                            @endforeach

                            <p><strong>Impreso el:</strong> @foreach ($array as $item) @if(key($item) === 'Impreso en') {{ $item[key($item)] }}@endif @endforeach</p>

                            <p><strong>Impreso por:</strong> @foreach ($array as $item) @if(key($item) === 'Impreso por') {{ $item[key($item)] }}@endif @endforeach</p>

                            @if(isset($certificacion))

                                <p><strong>Certificación:</strong>{{ $certificacion->documento }} {{ $certificacion->año }}-{{ $certificacion->folio }}</p>

                            @endif

                            @foreach ($array as $item)

                                @if(key($item) === 'Convenio municipal')

                                    <p>
                                        <strong>Convenio:</strong> {{ $item[key($item)] }}
                                    </p>

                                @endif

                            @endforeach

                        </td>
                    </tr>
                </tbody>

            </table>
        </div>

    </main>

</body>
</html>
