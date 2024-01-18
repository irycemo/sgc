<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Avaluo</title>
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
    }

    .titulo{
        text-align: center;
        font-size: 14px;
        font-weight: bold;
    }

    .fundamento{
        text-align: justify;
        font-size: 10px;
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
        font-size: 12px;
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

            <p class="fundamento">
                CON FUNDAMENTO LEGAL EN EL ARTÍCULO 134 DE LA LEY DE LA FUNCIÓN REGISTRAL Y CATASTRAL DEL ESTADO DE MICHOACÁN DE OCAMPO Y CON LA FINALIDAD DE DAR CUMPLIMIENTO A LAS OBLIGACIONES PROPIAS DE LA DIRECCIÓN
                DE CATASTRO DEL INSTITUTO REGISTRAL Y CATASTRAL DEL ESTADO DE MICHOACÁN DE OCAMPO, CON EL CARÁCTER SEÑALADO ME PERMITO NOTIFICARLE <strong>{{ $predios->count() }}</strong> <strong>{{ $numero_avaluos_letra }}</strong>
                AVALÚO(S) DE VALOR CATASTRAL, QUE PARA MAYOR REFERENCIA SE DETALLA EN EL CUADRO ANEXO, ELLO CON EL PROPÓSITO DE QUE SURTA LOS EFECTOS LEGALES PROCEDENTES A QUE HAYA LUGAR;
            </p>

        </div>

        <div class="content">

            <div class="informacion" >

                <table>

                    <thead>

                        <tr>
                            <th>FOLIO DEL AVALÚO</th>
                            <th>CUENTA PREDIAL</th>
                            <th>PROPIETARIO</th>
                            <th>vALOR CATASTRAL</th>
                        </tr>

                    </thead>

                    <tbody>

                        @foreach ($predios as $predio)

                            <tr>
                                <td style="padding-right: 40px;">
                                    <p>{{ $predio->avaluo->año }}-{{ $predio->avaluo->folio }}</p>
                                </td>
                                <td style="padding-right: 40px;">
                                    <p>{{ $predio->avaluo->cuentaPredial() }}</p>
                                </td>
                                <td>
                                    <p>${{ number_format($predio->avaluo->valor_catastral, 2) }}</p>
                                </td>
                            </tr>

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

                <p style="margin-top: 10px">En la ciudad de: ____________________________________________ a las _______
                     del mes _______ del año _______
                </p>
                <p>PROPIETAIO (REPRESENTANTE O APODERADO LEGAL): __________________________________________________________________________________</p>
                <p>FIRMA DEL PROPIETAIO (REPRESENTANTE O APODERADO LEGAL): ___________________________________</p>
                <p>NOTIFICADOR:  ___________________________________</p>
                <p>FIRMA DEL NOTIFICADOR: _________________________</p>



                <table style="margin-top: 10px">

                    <tbody>
                        <tr>
                            <td style="font-size:12px; padding-right: 40px;">

                                <img class="qr" src="{{ $qr }}" alt="QR">
                            </td>
                            <td style="font-size:12px; padding-right: 40px;">

                                <p><strong>Trámite de inspección ocular:</strong> {{ $tramiteInspeccion->folio }} <strong>Recibo:</strong> {{ $tramiteInspeccion->folio_pago }}</p>
                                @if ($tramiteAvaluo)
                                    <p><strong>Trámite de impresión:</strong> {{ $tramiteAvaluo->folio }} <strong>Recibo:</strong> {{ $tramiteAvaluo->folio_pago }}</p>
                                @endif
                                <p><strong>Elaborado por:</strong> {{ auth()->user()->name }} {{ auth()->user()->ap_paterno }} {{ auth()->user()->ap_materno }}, <strong>con fecha:</strong> {{ now()->format('d-m-Y H:i:s') }}</p>

                            </td>
                        </tr>
                    </tbody>

                </table>
            </div>

        </div>

    </main>

    <script type="text/php">
        if (isset($predio)) {
            $x = 480;
            $y = 794;
            $text = "Página: {PAGE_NUM} de {PAGE_COUNT}";
            $font = null;
            $size = 9;
            $color = array(1,1,1);
            $word_space = 0.0;  //  default
            $char_space = 0.0;  //  default
            $angle = 0.0;   //  default
            $pdf->page_text($x, $y, $text, $font, $size, $color, $word_space, $char_space, $angle);
        }
    </script>

</body>
</html>
