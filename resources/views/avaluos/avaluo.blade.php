<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Avalúo</title>
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

    .imagenes{

        max-width: 100%;

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

            <p class="titulo">AVALÚO CATASTRAL</p>

        </div>

        @include('avaluos.ubicacion_inmueble')

        @include('avaluos.colindancias')

        @include('avaluos.descripcion_inmueble')

        @include('avaluos.terrenos_construcciones')

        @include('avaluos.propietarios')

        @include('avaluos.bloques')

        <p class="separador">Imágenes</p>

        <div class="informacion">

            <table>

                <tbody>
                        <tr>
                            <td style="font-size:12px; display: flex; align-content: start;">

                                <div>

                                    <p style="margin-bottom: 10px;">Fachada</p>

                                    <img class="imagenes" src="{{ $predio->avaluo->fachada() }}" alt="Fachada">

                                </div>

                            </td>
                            <td style="font-size:12px; ">

                                <div>

                                    <p style="margin-bottom: 10px;">Fotografía 2</p>

                                    <img class="imagenes" src="{{ $predio->avaluo->foto2() }}" alt="Fotografia 2">

                                </div>

                            </td>
                        </tr>

                        <tr>
                            <td style="font-size:12px;">
                                <div>

                                    <p style="margin-bottom: 10px;">Fotografía 3</p>

                                    <img class="imagenes" src="{{ $predio->avaluo->foto3() }}" alt="Fotografia 3">

                                </div>
                            </td>
                            <td style="font-size:12px;">
                                <div>

                                    <p style="margin-bottom: 10px;">Fotografía 4</p>

                                    <img class="imagenes" src="{{ $predio->avaluo->foto4() }}" alt="Fotografia 4">

                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td style="font-size:12px;">
                                <div>

                                    <p style="margin-bottom: 10px;">Macrolocalización</p>

                                    <img class="imagenes" src="{{ $predio->avaluo->macrolocalizacion() }}" alt="Macrolocalización">

                                </div>
                            </td>
                            <td style="font-size:12px;">
                                <div>

                                    <p style="margin-bottom: 10px;">Microlocalización</p>

                                    <img class="imagenes" src="{{ $predio->avaluo->microlocalizacion() }}" alt="Microlocalización">

                                </div>
                            </td>
                        </tr>

                        <tr>
                            <td style="font-size:12px;">
                                <div>

                                    <p style="margin-bottom: 10px;">Representación del polígono</p>

                                    <img class="imagenes" src="{{ $predio->avaluo->poligonoImagen() }}" alt="Representación del polígono">

                                </div>
                            </td>
                        </tr>
                </tbody>

            </table>

        </div>

        @if($predio->avaluo->observaciones)

            <div class="caracteristicas-tabla">

                <p class="separador">Observaciones</p>

                <div class="informacion">
                    @if($predio->avaluo->observaciones)<p style="text-align: justify">{{ $predio->avaluo->observaciones }}</p>@endif
                </div>

            </div>

        @endif

    </main>

</body>
</html>
