<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Notificación de valor catastral</title>
</head>

<style>
    header{
        position: fixed;
        top: 0cm;
        left: 0cm;
        right: 0cm;
        height: 100px;
        text-align: center;
    }

    header img{
        height: 100px;
        display: block;
        margin-left: auto;
        margin-right: auto;
    }


    body{
        margin-top: 120px;
        margin-bottom: 40px;
        counter-reset: page;
        height: 100%;
        background-image: url("storage/img/escudo_fondo.png");
        background-size: cover;
        background-position: 0 -50px !important;
        font-family: sans-serif;
        font-weight: normal;
        line-height: 1.5;
        text-transform: uppercase;
        font-size: 9px;
    }

    .center{
        display: block;
        margin-left: auto;
        margin-right: auto;
        width: 50%;
    }

    .container{
        display: flex;
        align-content: space-around;
    }

    .parrafo{
        text-align: justify;
    }

    .firma{
        text-align: center;
    }

    .control{
        text-align: center;
    }

    .atte{
        margin-bottom: 10px;
    }

    .borde{
        display: inline;
        border-top: 1px solid;
    }

    .tabla{
        width: 100%;
        font-size: 10px;
        margin-bottom: 30px;;
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
        text-align: right;
        padding-right: 10px;
        text-transform: lowercase;
    }

    .fot{
        display: flex;
        padding: 2px;
        text-align: center;
    }

    .fot p{
        display: inline-block;
        width: 33%;
        margin: 0;
    }

    .qr{
        display: block;
    }

    .no-break{
        page-break-inside: avoid;
    }

    table{
        margin-bottom: 5px;
        margin-left: auto;
        margin-right: auto;
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

    .titulo{
        text-align: center;
        font-size: 13px;
        font-weight: bold;
        margin: 0;
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

            <p class="titulo">DIRECCIÓN DE CATASTRO</p>

            <p class="titulo">NOTIFICACIÓN DE VALOR CATASTRAL</p>

            <div>

                <p class="parrafo">
                    CON FUNDAMENTO LEGAL EN EL ARTÍCULO 134 DE LA LEY DE LA FUNCIÓN REGISTRAL Y CATASTRAL DEL ESTADO DE MICHOACÁN DE OCAMPO Y CON LA FINALIDAD DE DAR CUMPLIMIENTO A LAS OBLIGACIONES PROPIAS DE LA DIRECCIÓN
                    DE CATASTRO DEL INSTITUTO REGISTRAL Y CATASTRAL DEL ESTADO DE MICHOACÁN DE OCAMPO, CON EL CARÁCTER SEÑALADO ME PERMITO NOTIFICARLE <strong> {{ count($avaluos) }}</strong> <strong>{{ $datos_control->numero_avaluos_letra }}</strong>
                    AVALÚO(S) DE VALOR CATASTRAL, QUE PARA MAYOR REFERENCIA SE DETALLA EN EL CUADRO ANEXO, ELLO CON EL PROPÓSITO DE QUE SURTA LOS EFECTOS LEGALES PROCEDENTES A QUE HAYA LUGAR.
                </p>

            </div>

        </div>

        <div>

            <table >

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

                    @foreach ($avaluos as $avaluo)

                        <tr>
                            <td style="border: 1px solid gray; padding: 0 5px 0 5px;  white-space: nowrap;">
                                <p>{{ $avaluo->folio }}</p>
                            </td>
                            <td style="border: 1px solid gray; padding: 0 5px 0 5px;  white-space: nowrap;">
                                <p>{{ $avaluo->cuenta_predial }}</p>
                            </td>
                            <td style="border: 1px solid gray; padding: 0 5px 0 5px; white-space: nowrap;">
                                <p>{{ $avaluo->clave_catastral }}</p>
                            </td>
                            <td style="border: 1px solid gray; padding: 0 5px 0 5px;">
                                <p>{{ $avaluo->propietario }}</p>
                            </td>
                            <td style="border: 1px solid gray; padding: 0 5px 0 5px;  white-space: nowrap; text-align: right;">
                                <p>${{ number_format($avaluo->valor_catastral, 2) }}</p>
                            </td>
                        </tr>

                    @endforeach

                </tbody>

            </table>

            @if (isset($datos_control->predio_padre))

                <p class="parrafo">
                    Los avalúos son resultado de un desglose del predio {{ $datos_control->predio_padre }}, al cual se actualiza su superficie con valor: {{ $datos_control->predio_padre_superficie }} {{ $datos_control->predio_padre_unidad }}
                </p>

            @endif

            @if(isset($datos_control->predios_fusionantes))

                <p>El avalúo es resultado de la fusión de los siguientes predios:</p>

                <p>

                    @foreach ($datos_control->predios_fusionantes as $predio)

                        {{ $predio }} @if(!$loop->last) , @else . @endif

                    @endforeach

                </p>

            @endif

            <p class="parrafo">
                EL PRESENTE ACTO ES RECURRIBLE, POR LO CUAL DEBERÁ SER IMPUGNADO DENTRO DEL TÉRMINO DE 10 DÍAS HÁBILES SIGUIENTES A SU NOTIFICACIÓN ANTE ESTA DIRECCIÓN DE CATASTRO DEL INSTITUTO REGISTRAL Y CATASTRAL DEL ESTADO
                DE MICHOACÁN DE OCAMPO O BIEN ANTE EL TRIBUNAL DE JUSTICIA ADMINISTRATIVA DEL ESTADO DE MICHOACÁN, DE CONFORMIDAD CON EL ARTÍCULO 128 Y 129 DEL CÓDIGO DE JUSTICIA ADMINISTRATIVA DEL ESTADO DE MICHOACÁN DE OCAMPO.
            </p>

            <p class="parrafo">
                DE CONFORMIDAD CON LO DISPUESTO EN LA FRACCIÓN I, XII DEL ARTÍCULO 18, 68, 69, 70, 71, 72, 73, 74, 75, 76, 77, 90, 92 Y 93 DE LA LEY DE LA FUNCIÓN REGISTRAL Y CATASTRAL DEL ESTADO DE MICHOACÁN DE OCAMPO FRACCIÓN VII
                DEL ARTÍCULO 1°, FRACCIÓN XX DE ARTÍCULO 2°, FRACCIÓN II DEL ARTÍCULO 90 DEL CÓDIGO DE DESARROLLO URBANO DEL ESTADO DE MICHOACÁN DE OCAMPO, ASÍ COMO LAS FRACCIONES II, VII Y XVI DEL ARTÍCULO 13 DEL REGLAMENTO INTERIOR
                DEL INSTITUTO REGISTRAL Y CATASTRAL DEL ESTADO DE MICHOACÁN DE OCAMPO.
            </p>

        </div>

        <p class="separador">Datos de control</p>

        <div>

            <p style="margin-top: 10px">EN LA CIUDAD DE __________________________________________________________  A LAS ________________ DEL MES _____________ DEL AÑO _____________.</p>

            <div>

                <table style="margin-top: 40px">

                    <tbody >
                        <tr>

                            <td style="padding-right: 20px; text-align:center; vertical-align: bottom;">

                                <p></p>
                                <p style="border-top: gray solid 1px; overflow: hidden;">FIRMA Y NOMBRE DEL PROPIETARIO (REPRESENTANTE O APODERADO LEGAL)</p>

                            </td>

                            <td style="padding-right: 20px; text-align:center; vertical-align: bottom;">

                                <p style="border-top: gray solid 1px; text-align: center">FIRMA Y NOMBRE DEL NOTIFICADOR</p>

                            </td>

                            @if(!isset($datos_control->autoridad_municipal))

                                <td style="padding-right: 20px; text-align:center; vertical-align: bottom;">

                                    <p style="text-transform: uppercase;">{{ $datos_control->valuador }}</p>
                                    <p style="border-top: gray solid 1px; text-align: center">FIRMA Y NOMBRE DEL VALUADOR</p>

                                </td>

                            @endif

                            <td style="padding-right: 20px; text-align:center; vertical-align: bottom;">

                                <p style="border-top: gray solid 1px; text-align: center">Sello de la oficina</p>

                            </td>

                        </tr>
                    </tbody>

                </table>

                @if(isset($datos_control->autoridad_municipal))

                    <table style="margin-top: 40px">

                        <tbody>
                            <tr>

                                <td style="padding-right: 20px; text-align:center; vertical-align: bottom;">

                                    <p style="text-transform: uppercase;">{{ $datos_control->autoridad_municipal }}</p>
                                    <p style="border-top: gray solid 1px; text-align: center">FIRMA Y NOMBRE DE LA AUTORIDAD MUNICIPAL</p>

                                </td>

                                <td style="padding-right: 20px; text-align:center; vertical-align: bottom;">

                                    <p style="text-transform: uppercase;">{{ $datos_control->valuador }}</p>
                                    <p style="border-top: gray solid 1px; text-align: center">FIRMA Y NOMBRE DEL VALUADOR</p>

                                </td>

                            </tr>
                        </tbody>

                    </table>

                @elseif(isset($datos_control->firma_director))

                    <div style="margin-top: 30px; page-break-inside: avoid;">

                        <div style="text-align: center">

                            <p><img style="height: 40px;" src="{{ public_path('efirmas/' . $datos_control->imagen_director) }}" alt=""></p>
                            <p style="text-transform: uppercase; border-bottom: gray solid 1px; text-align: center; display: inline">{{ $datos_control->director }}</p>
                            <p >DIRECTOR DE CATASTRO</p>
                            <p>Firma Electrónica:</p>

                        </div>

                        <p style="overflow-wrap: break-word;">{{ $datos_control->firma_director }}</p>

                    </div>

                    <div style="page-break-inside: avoid;">

                        <div style="text-align: center;">

                            <p style="text-transform: uppercase; border-bottom: gray solid 1px; text-align: center; display: inline">{{ $datos_control->jefe_departamento }}</p>
                            <p>JEFE DE DEPARTAMENTO DE VALUACIÓN</p>
                            <p>Firma Electrónica:</p>

                        </div>

                        <p style="overflow-wrap: break-word;">{{ $datos_control->firma_jefe_departamento }}</p>

                    </div>

                @else

                    <div style="text-align: center; margin-top: 30px">

                        <p style="text-transform: uppercase; border-bottom: gray solid 1px; text-align: center; display: inline">{{ $datos_control->titular }}</p>
                        <p style="text-transform: uppercase;">{{ $datos_control->titular_cargo }}</p>

                    </div>

                @endif

            </div>

            <table style="margin-top: 10px">

                <tbody>
                    <tr>
                        <td style="padding-right: 40px;">

                            <img class="qr" src="{{ $qr }}" alt="QR">
                        </td>
                        <td style="padding-right: 40px;">


                            @if (isset($datos_control->tramite_inspeccion))

                                <p><strong>Trámite de inspección ocular: </strong> {{ $datos_control->tramite_inspeccion }}</p>

                            @endif

                            @if (isset($datos_control->tramite_desglose))

                                <p><strong>Trámite de desglose: </strong> {{ $datos_control->tramite_desglose }}</p>

                            @endif

                            <p><strong>Impreso el: </strong> {{ $datos_control->impreso_en }}</p>

                            <p><strong>Impreso por: </strong> {{ $datos_control->impreso_por }}</p>

                            @if(isset($certificacion))

                                <p><strong>Certificación: </strong>{{ $certificacion->tipo->label() }} {{ $certificacion->año }}-{{ $certificacion->folio }}</p>

                            @endif

                        </td>
                    </tr>
                </tbody>

            </table>
        </div>

    </main>

</body>
</html>
