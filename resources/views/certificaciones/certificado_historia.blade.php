<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Certificado de historia</title>
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

            <p class="titulo">CERTIFICADO DE HISTORIA CATASTRAL</p>

            <div>

                <p class="parrafo">
                    CON FUNDAMENTO EN LOS ARTICULOS 18° FRACCIÓN VI DE LA LEY DE LA FUNCIÓN REGISTRAL Y CATASTRAL
                    DEL ESTADO DE MICHOACÁN DE OCAMPO,8 FRACCIONES XI Y XVIII,DEL REGLAMENTO DE LA LEY DE LA
                    FUNCIÓN REGISTRAL Y CATASTRAL DEL ESTADO DE MICHOACÁN DE OCAMPO,Y II FRACCIONES I,II,VI,XXVII
                    Y XXXIV DEL REGLAMENTO INTERIOR DEL INSTITUTO REGISTRAL Y CATASTRAL DEL ESTADO DE MICHOACÁN
                    DE OCAMPO EL SUSCRITO
                    @if(isset($datos_control->director)) <strong style="text-transform: uppercase;"> {{ $datos_control->director }} DIRECTOR DE CATASTRO.</strong> @elseif(isset($datos_control->titular)) <strong style="text-transform: uppercase;"> {{ $datos_control->titular }}, {{ $datos_control->titular_cargo }}.</strong> @endif
                    CERTIFICA QUE EN LOS ARCHIVOS CATASTRALES EXISTENTES EN ESTA OFICINA A MI CARGO, SE ENCONTRARON
                    REGISTROS HISTORICOS DE LA SIGUIENTE PROPIEDAD:
                </p>

            </div>

        </div>

        @include('certificaciones.comun.ubicacion_inmueble')

        @if(count($predio->colindancias))

            @include('certificaciones.comun.colindancias')

        @endif

        @include('certificaciones.comun.descripcion_inmueble')

        @include('certificaciones.comun.propietarios')

        <p class="separador">Historia catastral</p>

        <p class="parrafo">
            {!! $datos_control->historia !!}
        </p>

        <p class="separador">Datos de control</p>

        <div class="informacion">

            <p style="margin: 10px 0 10px 0;">A SOLICITUD DE <strong style="text-transform: uppercase;">{{ $datos_control->solicitante }}</strong> EXPIDO EL PRESENTE CERTIFICADO EN LA CIUDAD DE <strong style="text-transform: uppercase;"> {{ $datos_control->oficina }}</strong>, MICHOACÁN.</p>

            <div>

                <table style="margin-top: 20px">

                    @if(isset($datos_control->director))
                        <p><img style="height: 40px;" src="{{ public_path('efirmas/' . $datos_control->imagen_director) }}" alt=""></p>
                        <p style="text-transform: uppercase; border-bottom: gray solid 1px; text-align: center; display: inline">{{ $datos_control->director }}</p>
                        <p style="text-align: center;">DIRECTOR DE CATASTRO</p>

                    @else

                        <p style="text-transform: uppercase; border-bottom: gray solid 1px; text-align: center; display: inline">{{ $datos_control->titular }}</p>
                        <p style="text-align: center;" >{{ $datos_control->titular_cargo }}</p>

                    @endif

                </table>

                @if(isset($datos_control->firma_director))

                    <div style="page-break-inside: avoid;">

                        <p style="text-align: center">Firma Electrónica:</p>
                        <p style="overflow-wrap: break-word;">{{ $datos_control->firma_director }}</p>

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

                            <p><strong>Trámite de anticipo:</strong> {{ $datos_control->tramite_anticipo }}</p>

                            <p><strong>Trámite de historia:</strong> {{ $datos_control->tramite_historia }}</p>

                            <p><strong>Impreso el:</strong> {{ $datos_control->impreso_en }}</p>

                            <p><strong>Impreso por:</strong> {{ $datos_control->impreso_por }}</p>

                            @if(isset($certificacion))

                                <p><strong>Certificación:</strong> {{ $certificacion->tipo->label() }} {{ $certificacion->año }}-{{ $certificacion->folio }}</p>

                            @endif

                        </td>
                    </tr>
                </tbody>

            </table>

            <p style="font-size: 7px; text-align: justify">
                EL PRESENTE CERTIFICADO ES SOLO PARA FINES ADMINISTRATIVOS PARA CUALQUIER OTRO DEBE SER VALIDADO POR LA OFICINA CORRESPONDIENTE
                SE EXPIDE EL PRESENTE CONFORME A LOS DATOS CONTENIDOS EN EL SISTEMA DE GESTIÓN CATASTRAL
                A PETICIÓN DEL INTERESADO, SIN REPOSICIÓN POR FALTA DE ACTUALIZACIÓN.
            </p>

        </div>

    </main>

</body>
</html>
