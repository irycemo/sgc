<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cedula de actualización</title>
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
        margin-bottom: 20px;
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
        font-size: 11px;
        font-weight: bold;
        margin: 0;
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

            <p class="titulo">DIRECCIÓN DE CATASTRO</p>
            <p class="titulo">CÉDULA DE ACTUALIZACIÓN CATASTRAL</p>

        </div>

        <div class="informacion" >

            <p style="margin-bottom: 10px;"><strong>Cuenta predial</strong> {{ $objeto->cuenta_predial }} <strong style="margin-left: 40px;">Clave catastral</strong> {{ $objeto->clave_catastral }}</p>

            <p style="margin-bottom: 10px;"><strong>PROPIETARIO</strong> {{ $objeto->propietario }}</p>

            <p class="separador">Ubicación del predio</p>

            <div class="informacion">

                <p style=" margin: 4px 0 4px 0;">
                    @if(isset($objeto->tipo_asentamiento))<strong>Tipo de asentamiento:</strong> {{ $objeto->tipo_asentamiento }},@endif
                    @if(isset($objeto->nombre_asentamiento))<strong>Nombre del asentamiento:</strong> {{ $objeto->nombre_asentamiento }},@endif
                    @if(isset($objeto->tipo_vialidad))<strong>Tipo de vialidad:</strong> {{ $objeto->tipo_vialidad }},@endif
                    @if(isset($objeto->nombre_vialidad))<strong>Nombre de la vialidad:</strong> {{ $objeto->nombre_vialidad }},@endif
                    @if(isset($objeto->numero_interior))<strong>Número interior:</strong> {{ $objeto->numero_interior }},@endif
                    @if(isset($objeto->numero_exterior))<strong>Número exterior:</strong> {{ $objeto->numero_exterior }},@endif
                    @if(isset($objeto->numero_exterior_2))<strong>Número exterior 2:</strong> {{ $objeto->numero_exterior_2 }},@endif
                    @if(isset($objeto->numero_adicional))<strong>Número adicional:</strong> {{ $objeto->numero_adicional }},@endif
                    @if(isset($objeto->numero_adicional_2))<strong>Número adicional 2:</strong> {{ $objeto->numero_adicional_2 }},@endif
                    @if(isset($objeto->codigo_postal))<strong>Código postal:</strong> {{ $objeto->codigo_postal }}@endif
                </p>

                <p style=" margin-bottom: 4px;">
                    @if(isset($objeto->nombre_edificio))<strong>Nombre del edificio:</strong> {{ $objeto->nombre_edificio }},@endif
                    @if(isset($objeto->clave_edificio))<strong>Clave del edificio:</strong> {{ $objeto->clave_edificio }},@endif
                    @if(isset($objeto->departamento_edificio))<strong>Departamento:</strong> {{ $objeto->departamento_edificio }}@endif
                </p>

                <p style=" margin-bottom: 4px;">
                    @if(isset($objeto->lote_fraccionador))<strong>Lote del fraccionador:</strong> {{ $objeto->lote_fraccionador }},@endif
                    @if(isset($objeto->manzana_fraccionador))<strong>Manzana del fraccionador:</strong> {{ $objeto->manzana_fraccionador }},@endif
                    @if(isset($objeto->etapa_fraccionador))<strong>Etapa del fraccionador:</strong> {{ $objeto->etapa_fraccionador }}@endif
                    @if(isset($objeto->ubicacion_en_manzana))<strong>Ubicación del predio en la manzana:</strong> {{ $objeto->ubicacion_en_manzana }}@endif
                </p>

                <p style="">
                    @if(isset($objeto->nombre_predio))<strong>Predio Rústico Denominado ó Antecedente:</strong> {{ $objeto->nombre_predio }}@endif
                </p>

                @if(isset($objeto->xutm) || isset($objeto->lat))

                    <p style=" margin-top: 4px;">
                        <strong>Coordenadas geográficas: </strong>
                    </p>

                    @if(isset($objeto->xutm))

                            <strong>UTM: </strong>
                            <strong>X:</strong> {{ $objeto->xutm }}, <strong>Y:</strong> {{ $objeto->yutm }},  <strong>Z:</strong> {{ $objeto->zutm }}

                    @endif

                    @if(isset($objeto->xutm))
                        <p style="">
                            <strong>GEO: </strong>
                            <strong>LAT:</strong> {{ $objeto->lat }}, <strong>LON:</strong> {{ $objeto->lon }}
                        </p>
                    @endif

                @endif

                @if(isset($objeto->observaciones))<strong>Observaciones:</strong> {{ $objeto->observaciones }}@endif

            </div>

            <p class="separador">Superficies y valor catastral</p>

            <div class="informacion">

                <p style=" margin: 4px 0 4px 0;">
                    @if(isset($objeto->superficie_notarial))<strong>Superficie notarial:</strong> {{ number_format($objeto->superficie_notarial, 2) }},@endif
                    @if(isset($objeto->superficie_judicial))<strong>Superficie judicial:</strong> {{ number_format($objeto->superficie_judicial, 2) }},@endif
                    @if(isset($objeto->superficie_terreno))<strong>Superficie de terreno:</strong> {{ number_format($objeto->superficie_terreno, 2) }},@endif
                    @if(isset($objeto->superficie_construccion))<strong>Superficie de construcción:</strong> {{ number_format($objeto->superficie_construccion, 2) }},@endif
                    @if(isset($objeto->area_comun_terreno))<strong>Superficie de terreno común:</strong> {{ number_format($objeto->area_comun_terreno, 2) }},@endif
                    @if(isset($objeto->area_comun_construccion))<strong>Superficie de construcción común:</strong> {{ number_format($objeto->area_comun_construccion, 2) }},@endif

                </p>

                <p><strong>Valor catastral: </strong>${{ number_format($objeto->valor_catastral, 2) }}</p>

            </div>

            <p class="separador">Datos de control</p>

            <div class="informacion">

                <p style="margin: 10px 0 10px 0;">A SOLICITUD DE <strong style="text-transform: uppercase;">{{ $certificacion->tramite->nombre_solicitante }}</strong> EXPIDO EL PRESENTE CERTIFICADO EN LA CIUDAD DE <strong style="text-transform: uppercase;"> {{ $objeto->oficina }}</strong>, MICHOACÁN.</p>

                <div>

                    <table style="margin-top: 20px">

                        @if($objeto->cargo === 'Director de catastro') <p><img style="height: 40px;" src="{{ public_path('efirma/' . $imagen) }}" alt=""></p> @endif
                        <p style="text-transform: uppercase; border-bottom: gray solid 1px; text-align: center; display: inline">{{ $objeto->suscrito }}</p>
                        <p style="text-align: center;" >{{ $objeto->cargo }}</p>

                    </table>

                    @if($certificacion->cadena_encriptada)

                        <div style="page-break-inside: avoid;">

                            <p style="text-align: center">Firma Electrónica:</p>
                            <p style="overflow-wrap: break-word;">{{ $certificacion->cadena_encriptada }}</p>

                        <div>

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

        </div>

    </main>

</body>
</html>
