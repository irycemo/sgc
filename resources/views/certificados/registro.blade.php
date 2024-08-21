<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Certificado de registro</title>
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
            <p class="titulo">{{ $tipo_certificado }}</p>

            <div class="informacion" >

                <p class="fundamento">
                    CON FUNDAMENTO EN LOS ARTÍCULOS 18° FRACCIÓN VI DE LA LEY DE LA FUNCIÓN REGISTRAL Y CATASTRAL
                    DEL ESTADO DE MICHOACÁN DE OCAMPO,8 FRACCIONES XI Y XVIII,DEL REGLAMENTO DE LA LEY DE LA
                    FUNCIÓN REGISTRAL Y CATASTRAL DEL ESTADO DE MICHOACÁN DE OCAMPO,Y II FRACCIONES I,II,VI,XXVII
                    Y XXXIV DEL REGLAMENTO INTERIOR DEL INSTITUTO REGISTRAL Y CATASTRAL DEL ESTADO DE MICHOACÁN
                    DE OCAMPO EL SUSCRITO  @if(isset($director)) <strong style="text-transform: uppercase;">{{ $director }}, DIRECTOR DE CATASTRO.</strong> @elseif(isset($titular)) <strong style="text-transform: uppercase;">{{ $titular }}, {{ $cargo }}. </strong> @endif
                    CERTIFICA QUE HABIENDO EFECTUADO UNA REVISIÓN DE LOS PADRONES CATASTRALES EXISTENTES EN ESTA OFICINA A MI CARGO, SE ENCONTRÓ REGISTRO DE LA SIGUIENTE PROPIEDAD.
                </p>

            </div>

        </div>

        <div class="informacion" >

            <p style="margin-bottom: 10px;"><strong>Cuenta predial</strong> {{ $predio->cuentaPredial() }} <strong style="margin-left: 40px;">Clave catastral</strong> {{ $predio->claveCatastral() }}</p>

            <p class="separador">Ubicación del predio</p>

            <div class="informacion">

                <p style=" margin: 4px 0 4px 0;">
                    @if($predio->tipo_asentamiento)<strong>Tipo de asentamiento:</strong> {{ $predio->tipo_asentamiento }},@endif
                    @if($predio->nombre_asentamiento)<strong>Nombre del asentamiento:</strong> {{ $predio->nombre_asentamiento }},@endif
                    @if($predio->tipo_vialidad)<strong>Tipo de vialidad:</strong> {{ $predio->tipo_vialidad }},@endif
                    @if($predio->nombre_vialidad)<strong>Nombre de la vialidad:</strong> {{ $predio->nombre_vialidad }},@endif
                    @if($predio->numero_interior)<strong>Número interior:</strong> {{ $predio->numero_interior }},@endif
                    @if($predio->numero_exterior)<strong>Número exterior:</strong> {{ $predio->numero_exterior }},@endif
                    @if($predio->numero_exterior_2)<strong>Número exterior 2:</strong> {{ $predio->numero_exterior_2 }},@endif
                    @if($predio->numero_adicional)<strong>Número adicional:</strong> {{ $predio->numero_adicional }},@endif
                    @if($predio->numero_adicional_2)<strong>Número adicional 2:</strong> {{ $predio->numero_adicional_2 }},@endif
                    @if($predio->codigo_postal)<strong>Código postal:</strong> {{ $predio->codigo_postal }}@endif
                </p>

                <p style=" margin-bottom: 4px;">
                    @if($predio->nombre_edificio)<strong>Nombre del edificio:</strong> {{ $predio->nombre_edificio }},@endif
                    @if($predio->clave_edificio)<strong>Clave del edificio:</strong> {{ $predio->clave_edificio }},@endif
                    @if($predio->departamento_edificio)<strong>Departamento:</strong> {{ $predio->departamento_edificio }}@endif
                </p>

                <p style=" margin-bottom: 4px;">
                    @if($predio->lote_fraccionador)<strong>Lote del fraccionador:</strong> {{ $predio->lote_fraccionador }},@endif
                    @if($predio->manzana_fraccionador)<strong>Manzana del fraccionador:</strong> {{ $predio->manzana_fraccionador }},@endif
                    @if($predio->etapa_fraccionador)<strong>Etapa del fraccionador:</strong> {{ $predio->etapa_fraccionador }}@endif
                    @if($predio->ubicacion_en_manzana)<strong>Ubicación del predio en la manzana:</strong> {{ $predio->ubicacion_en_manzana }}@endif
                </p>

                <p style="">
                    @if($predio->nombre_predio)<strong>Predio Rústico Denominado ó Antecedente:</strong> {{ $predio->nombre_predio }}@endif
                </p>

                @if($predio->xutm || $predio->lat)

                    <p style=" margin-top: 4px;">
                        <strong>Coordenadas geográficas: </strong>
                    </p>

                    @if($predio->xutm)

                            <strong>UTM: </strong>
                            <strong>X:</strong> {{ $predio->xutm }}, <strong>Y:</strong> {{ $predio->yutm }},  <strong>Z:</strong> {{ $predio->zutm }}

                    @endif

                    @if($predio->xutm)
                        <p style="">
                            <strong>GEO: </strong>
                            <strong>LAT:</strong> {{ $predio->lat }}, <strong>LON:</strong> {{ $predio->lon }}
                        </p>
                    @endif

                @endif

            </div>

            @if($tramite->servicio_id == 6)

                <p class="separador">Colindancias</p>

                <div class="informacion" >

                    <table>

                        <thead>

                            <tr>
                                <th style="text-align: left;">Viento</th>
                                <th style="text-align: left;">Longitud</th>
                                <th style="text-align: left;">Descripción</th>
                            </tr>

                        </thead>

                        <tbody>

                            @foreach ($predio->colindancias as $colindancia)

                                <tr>
                                    <td style="padding-right: 40px;">
                                        <p>{{ $colindancia->viento }}</p>
                                    </td>
                                    <td style="padding-right: 40px;">
                                        <p>{{ number_format($colindancia->longitud, 2) }} mts.</p>
                                    </td>
                                    <td>
                                        <p>{{ $colindancia->descripcion }}</p>
                                    </td>
                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @endif

            <p class="separador">Propietarios</p>

            <div class="informacion" >

                <table>

                    <thead>

                        <tr>
                            <th style="text-align: left;">Tipo</th>
                            <th style="text-align: left;">Nombre/Razón social</th>
                            <th style="text-align: left;">Porcentaje de propiedad</th>
                            <th style="text-align: left;">Porcentaje de nuda</th>
                            <th style="text-align: left;">Porcentaje de usufructo</th>
                        </tr>

                    </thead>

                    <tbody>

                        @foreach ($predio->propietarios as $propietario)

                            <tr>
                                <td style="padding-right: 40px;">
                                    <p>{{ $propietario->persona->tipo }}</p>
                                </td>
                                <td style="padding-right: 40px;">
                                    <p>{{ $propietario->persona->nombre }} {{ $propietario->persona->ap_paterno }} {{ $propietario->persona->ap_materno }} {{ $propietario->persona->razon_social }}</p>
                                </td>
                                <td style="padding-right: 40px;">
                                    <p>{{ number_format($propietario->porcentaje, 2) }}%</p>
                                </td>
                                <td style="padding-right: 40px;">
                                    <p>{{ number_format($propietario->porcentaje_nuda, 2) }}%</p>
                                </td>
                                <td style="padding-right: 40px;">
                                    <p>{{ number_format($propietario->porcentaje_usufructo, 2) }}%</p>
                                </td>
                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

            <p class="separador">Superficies y valor catastral</p>

            <div class="informacion">

                <p style=" margin: 4px 0 4px 0;">
                    @if($predio->superficie_notarial > 0)<strong>Superficie notarial:</strong> {{ number_format($predio->superficie_notarial, 2) }}.@endif
                    @if($predio->superficie_judicial > 0)<strong>Superficie judicial:</strong> {{ number_format($predio->superficie_judicial, 2) }}.@endif
                    @if($predio->superficie_terreno > 0)<strong>Superficie de terreno:</strong> {{ number_format($predio->superficie_terreno, 2) }}.@endif
                    @if($predio->superficie_construccion > 0)<strong>Superficie de construcción:</strong> {{ number_format($predio->superficie_construccion, 2) }}.@endif
                    @if($predio->area_comun_terreno > 0)<strong>Superficie de terreno común:</strong> {{ number_format($predio->area_comun_terreno, 2) }}.@endif
                    @if($predio->area_comun_construccion > 0)<strong>Superficie de construcción común:</strong> {{ number_format($predio->area_comun_construccion, 2) }}.@endif

                </p>

                <p><strong>Valor catastral: </strong>${{ number_format($predio->valor_catastral, 2) }}</p>

                @if($predio->condominioTerrenos->count())

                    <div class="caracteristicas-tabla">

                        <p style="text-align: center; margin-top: 20px;"><strong>Condominios</strong></p>

                        <table>

                            <thead>

                                <tr>
                                    <th style="text-align: left;">Área común de terreno</th>
                                    <th style="text-align: left;">Indiviso de terreno</th>
                                    <th style="text-align: left;">Superficie proporcional</th>
                                    <th style="text-align: left;">Valor unitario</th>
                                    <th style="text-align: left;">Valor de terreno común</th>
                                </tr>

                            </thead>

                            <tbody>

                                @foreach ($predio->condominioTerrenos as $constr)

                                    <tr>
                                        <td style="padding-right: 40px; border: 1px solid black;">
                                            <p>{{ $constr->area_terreno_comun }}</p>
                                        </td>
                                        <td style="padding-right: 40px; border: 1px solid black;">
                                            <p>{{ $constr->indiviso_terreno }}</p>
                                        </td>
                                        <td style="padding-right: 40px; border: 1px solid black;">
                                            <p>{{ $constr->superficie_proporcional }}</p>
                                        </td>
                                        <td style="padding-right: 40px; border: 1px solid black;">
                                            <p>{{ $constr->valor_unitario }}</p>
                                        </td>
                                        <td style="padding-right: 40px; border: 1px solid black;">
                                            <p>${{ number_format($constr->valor_terreno_comun, 2) }}</p>
                                        </td>
                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                @endif

                @if($predio->condominioConstrucciones->count())

                    <div class="caracteristicas-tabla">

                        <p style="text-align: center; margin-top: 20px;"><strong>Construcciones de área común</strong></p>

                        <table>

                            <thead>

                                <tr>
                                    <th style="text-align: left;">Área común de construcción</th>
                                    <th style="text-align: left;">Indiviso de construcción</th>
                                    <th style="text-align: left;">Superficie proporcional</th>
                                    <th style="text-align: left;">Clasificación de construccion</th>
                                    <th style="text-align: left;">Valor de construcción común</th>
                                </tr>

                            </thead>

                            <tbody>

                                @foreach ($predio->condominioConstrucciones as $constr)

                                    <tr>
                                        <td style="padding-right: 40px; border: 1px solid black;">
                                            <p>{{ $constr->area_comun_construccion }}</p>
                                        </td>
                                        <td style="padding-right: 40px; border: 1px solid black;">
                                            <p>{{ $constr->indiviso_construccion }}</p>
                                        </td>
                                        <td style="padding-right: 40px; border: 1px solid black;">
                                            <p>{{ $constr->superficie_proporcional }}</p>
                                        </td>
                                        <td style="padding-right: 40px; border: 1px solid black;">
                                            <p>{{ $constr->valor_clasificacion_construccion }}</p>
                                        </td>
                                        <td style="padding-right: 40px; border: 1px solid black;">
                                            <p>${{ number_format($constr->valor_construccion_comun, 2) }}</p>
                                        </td>
                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                @endif

            </div>

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
