<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Certificado negativo</title>
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
        text-transform: uppercase;
        font-size: 9px;
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

            <p class="titulo">CERTIFICADO NEGATIVO DE REGISTRO</p>

            <div class="informacion" >

                <p class="fundamento">
                    CON FUNDAMENTO EN LOS ARTICULOS 18° FRACCIÓN VI DE LA LEY DE LA FUNCIÓN REGISTRAL Y CATASTRAL
                    DEL ESTADO DE MICHOACÁN DE OCAMPO,8 FRACCIONES XI Y XVIII,DEL REGLAMENTO DE LA LEY DE LA
                    FUNCIÓN REGISTRAL Y CATASTRAL DEL ESTADO DE MICHOACÁN DE OCAMPO,Y II FRACCIONES I,II,VI,XXVII
                    Y XXXIV DEL REGLAMENTO INTERIOR DEL INSTITUTO REGISTRAL Y CATASTRAL DEL ESTADO DE MICHOACÁN
                    DE OCAMPO EL SUSCRITO  @if(isset($director)) <strong style="text-transform: uppercase;">{{ $director }}, DIRECTOR DE CATASTRO.</strong> @elseif(isset($titular)) <strong style="text-transform: uppercase;">{{ $titular }}, {{ $cargo }}. </strong> @endif
                    QUE HABIENDO EFECTUADO UNA REVISIÓN DE LOS PADRONES CATASTRALES EXISTENTES EN ESTA OFICINA A MI CARGO, NO SE ENCONTRO REGISTRO DE PROPIEDAD A NOMBRE DE: <strong> {{ $nombre }} {{ $ap_paterno }} {{ $ap_materno }} {{ $razon_social }}.</strong>
                </p>

                <p class="fundamento">EL PRESENTE CERTIFICADO HACE CONSTAR QUE EL INSTITUTO REGISTRAL Y CATASTRAL DEL ESTADO DE MICHOACAN NO CUENTA CON REGISTRO
                    DE PROPIEDAD ALGUNA EN LA JURISDICCION ADMINISTRATIVA DE LA OFICINA QUE LO SUSCRIBE
                    EL PRESENTE NO ES BASE PARA TRAMITES DE PREDIO IGNORADO.
                </p>

            </div>

        </div>

        <div class="informacion" >

            <p class="separador">Datos de control</p>

            <div class="informacion">

                <p style="margin: 10px 0 10px 0;">A SOLICITUD DE <strong style="text-transform: uppercase;">{{ $tramite->nombre_solicitante }}</strong> EXPIDO EL PRESENTE CERTIFICADO EN LA CIUDAD DE <strong style="text-transform: uppercase;"> {{ $oficina }}</strong>, MICHOACÁN.</p>

                <div>

                    <table style="margin-top: 20px">

                        @if(isset($director))
                            <p><img style="height: 40px;" src="{{ public_path('efirma/' . $imagen) }}" alt=""></p>
                            <p style="text-transform: uppercase; border-bottom: gray solid 1px; text-align: center; display: inline">{{ $director }}</p>
                            <p style="text-align: center;">DIRECTOR DE CATASTRO</p>

                        @else

                            <p style="text-transform: uppercase; border-bottom: gray solid 1px; text-align: center; display: inline">{{ $titular }}</p>
                            <p style="text-align: center;" >{{ $cargo }}</p>

                        @endif

                    </table>

                    @if(isset($firmaDirector))

                        <div style="page-break-inside: avoid;">

                            <p style="text-align: center">Firma Electrónica:</p>
                            <p style="overflow-wrap: break-word;">{{ $firmaDirector }}</p>

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

                                <p><strong>Trámite:</strong> {{ $tramite->año }}-{{ $tramite->folio }}-{{ $tramite->usuario }} <strong>Recibo:</strong> {{ $tramite->folio_pago }}</p>

                                <p><strong>Impreso el:</strong> {{ $fecha_impresion }}</p>

                                <p><strong>Impreso por:</strong> {{ $impreso_por }}</p>

                                @if(isset($certificacion))

                                    <p><strong>Certificación:</strong>{{ $certificacion->documento }} {{ $certificacion->año }}-{{ $certificacion->folio }}</p>

                                @endif

                            </td>
                        </tr>
                    </tbody>

                </table>

                <p style="font-size: 7px; text-align: justify">
                    EL PRESENTE CERTIFICADO ES SOLO PARA FINES ADMINISTRATIVOS PARA CUALQUIER OTRO DEBE SER VALIDADO POR LA OFICINA CORRESPONDIENTE
                    SE EXPIDE EL PRESENTE CONFORME A LOS DATOS CONTENIDOS EN EL SISTEMA DE GESTION CATASTRAL
                    A PETICION DEL INTERESADO, SIN REPOSICIÓN POR FALTA DE ACTUALIZACIÓN
                </p>

            </div>

        </div>

    </main>

</body>
</html>
