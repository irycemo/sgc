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

            <div class="informacion" >

                <p class="fundamento">
                    CON FUNDAMENTO EN LOS ARTICULOS 18° FRACCIÓN VI DE LA LEY DE LA FUNCIÓN REGISTRAL Y CATASTRAL
                    DEL ESTADO DE MICHOACÁN DE OCAMPO,8 FRACCIONES XI Y XVIII,DEL REGLAMENTO DE LA LEY DE LA
                    FUNCIÓN REGISTRAL Y CATASTRAL DEL ESTADO DE MICHOACÁN DE OCAMPO,Y 11 FRACCIONES I,II,VI,XXVII
                    Y XXXIV DEL REGLAMENTO INTERIOR DEL INSTITUTO REGISTRAL Y CATASTRAL DEL ESTADO DE MICHOACÁN
                    DE OCAMPO EL SUSCRITO  @if(isset($director)) <strong style="text-transform: uppercase;">{{ $director }} DIRECTOR DE CATASTRO.</strong> @elseif(isset($titular)) <strong style="text-transform: uppercase;">{{ $titular }}, {{ $cargo }}.</strong> @endif CERTIFICA QUE EN LOS ARCHIVOS CATASTRALES EXISTENTES EN ESTA OFICINA A MI CARGO, SE ENCONTRARON
                    REGISTROS HISTORICOS DE LA SIGUIENTE PROPIEDAD:
                </p>

            </div>

        </div>

        <div class="informacion" >

            <p><strong>Cuenta predial</strong> {{ $predio->cuentaPredial() }}</p>
            <p><strong>Clave catastral</strong> {{ $predio->claveCatastral() }}</p>
            <p><strong>Propietario</strong> {{ $predio->primerPropietario() }}</p>

            <p style="text-transform: uppercase; font-weight: bold; text-align: center; margin-top: 10px;">HISTORIA</p>

            {!! $certificado !!}

            <p style="margin-top: 10px;">A SOLICITUD DE <strong style="text-transform: uppercase;">{{ $tramite->nombre_solicitante }}</strong> EXPIDO EL PRESENTE CERTIFICADO EN LA CIUDAD DE <strong style="text-transform: uppercase;">{{ $oficina }}</strong>, MICHOACÁN.</p>

        </div>

        <p class="separador">Datos de control</p>

        <div class="informacion">

            <div>

                <table style="margin-top: 60px">

                    <tbody>
                        <tr>
                            <td style="padding-right: 40px; text-align:center; ; vertical-align: bottom; white-space: nowrap;">

                                @if(isset($director))

                                    <p style="text-transform: uppercase; border-bottom: gray solid 1px; text-align: center; display: inline">{{ $director }}</p>
                                    <p>DIRECTOR DE CATASTRO</p>

                                @else

                                    <p style="text-transform: uppercase; border-bottom: gray solid 1px; text-align: center; display: inline">{{ $titular }}</p>
                                    <p >{{ $cargo }}</p>

                                @endif

                            </td>

                            <td style="padding-right: 40px; text-align:center; ; vertical-align: bottom; white-space: nowrap;">

                                <p></p>
                                <p style="text-transform: uppercase; border-top: gray solid 1px; text-align: center; display: inline">SELLO DE LA OFICINA</p>

                            </td>

                        </tr>
                    </tbody>

                </table>

                @if(isset($firmaDirector))

                    <p style="text-align: center">Firma Electrónica:</p>
                    <p style="overflow-wrap: break-word;">{{ $firmaDirector }}</p>

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
        </div>

    </main>

</body>
</html>
