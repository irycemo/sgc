<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Certificado de historia</title>
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
        font-size: 9px;
        text-transform: uppercase;
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
        text-transform: lowercase;
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
<body >

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

            <p class="titulo">CERTIFICADO DE HISTORIA CATASTRAL</p>

            <p class="fundamento">
                CON FUNDAMENTO EN LOS ARTICULOS 18° FRACCIÓN VI DE LA LEY DE LA FUNCIÓN REGISTRAL Y CATASTRAL
                DEL ESTADO DE MICHOACÁN DE OCAMPO,8 FRACCIONES XI Y XVIII,DEL REGLAMENTO DE LA LEY DE LA
                FUNCIÓN REGISTRAL Y CATASTRAL DEL ESTADO DE MICHOACÁN DE OCAMPO,Y II FRACCIONES I,II,VI,XXVII
                Y XXXIV DEL REGLAMENTO INTERIOR DEL INSTITUTO REGISTRAL Y CATASTRAL DEL ESTADO DE MICHOACÁN
                DE OCAMPO EL SUSCRITO
                <strong style="text-transform: uppercase;"> {{ $objeto->suscrito }},</strong> <strong style="text-transform: uppercase;">{{ $objeto->cargo }}</strong>
                CERTIFICA QUE EN LOS ARCHIVOS CATASTRALES EXISTENTES EN ESTA OFICINA A MI CARGO, SE ENCONTRARON
                REGISTROS HISTORICOS DE LA SIGUIENTE PROPIEDAD:
            </p>

        </div>

        <div class="informacion" >

            <p><strong>Cuenta predial </strong>{{ $objeto->cuenta_predial }}</p>
            <p><strong>Clave catastral </strong>{{ $objeto->clave_catastral }}</p>
            <p><strong>Propietario </strong>{{ $objeto->propietario }}</p>

        </div>

        <p class="separador">HISTORIA</p>

        <div class="informacion">

            {!! $objeto->historia !!}

        </div>

        <p class="separador">Datos de control</p>

        <div class="informacion">

            <p style="margin-top: 10px;">
                A SOLICITUD DE <strong style="text-transform: uppercase;">{{ $objeto->solicitante }}</strong>
                EXPIDO EL PRESENTE CERTIFICADO EN LA CIUDAD DE
                <strong style="text-transform: uppercase;">{{ $objeto->oficina }}</strong>, MICHOACÁN.
            </p>

            <div>

                <table style="margin-top: 60px">

                    <tbody>
                        <tr>
                            <td style="padding-right: 40px; text-align:center; ; vertical-align: bottom; white-space: nowrap;">

                                @if($objeto->cargo === 'Director de catastro') <p><img style="height: 40px;" src="{{ public_path('efirma/' . $imagen) }}" alt=""></p> @endif
                                <p style="text-transform: uppercase; border-bottom: gray solid 1px; text-align: center; display: inline">{{ $objeto->suscrito }}</p>
                                <p style="text-transform: uppercase">{{ $objeto->cargo }}</p>

                            </td>

                            <td style="padding-right: 40px; text-align:center; ; vertical-align: bottom; white-space: nowrap;">

                                <p></p>
                                <p style="text-transform: uppercase; border-top: gray solid 1px; text-align: center; display: inline">SELLO DE LA OFICINA</p>

                            </td>

                        </tr>
                    </tbody>

                </table>

                @if($certificacion->cadena_encriptada)

                    <div style="page-break-inside: avoid;">

                        <p style="text-align: center">Firma Electrónica:</p>
                        <p style="overflow-wrap: break-word;">{{ $certificacion->cadena_encriptada }}</p>

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

                            <p><strong>Trámite:</strong> {{ $certificacion->tramite->año }}-{{ $certificacion->tramite->folio }}-{{ $certificacion->tramite->usuario }} <strong>Recibo:</strong> {{ $certificacion->tramite->folio_pago }}</p>

                            <p><strong>Impreso el:</strong> {{ $objeto->impreso_en }}</p>

                            <p><strong>Impreso por:</strong> {{ $objeto->impreso_por }}</p>

                            @if(isset($certificacion))

                                <p><strong>Certificación:</strong>{{ $certificacion->documento }} {{ $certificacion->año }}-{{ $certificacion->folio }}</p>

                            @endif

                        </td>
                    </tr>
                </tbody>

            </table>
        </div>

    </main>

</body>
</html>
