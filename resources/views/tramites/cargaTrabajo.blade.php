<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/css/bootstrap.min.css"
    integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <title>Carga de trabajo</title>
</head>
<style>
    main{
        font-size: 15px;
    }
</style>
<body>
    <main>

        <div class="">

            <div>

                <p class="parrafo">
                    Carga de trabajo, certificados en línea. Fecha inicial: {{ $fecha_inicio }} - Fecha final: {{ $fecha_final }}
                </p>
                <p>Imprimió: {{ auth()->user()->name }}</p>

                <div>

                    <table class="table">

                        <thead>

                            <tr>
                                <th>
                                   Trámite
                                </th>
                                <th>
                                    Predios
                                </th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach ($carga as $item)

                                <tr>

                                    <td style="width: 100px;">{{ $item->año }}-{{ $item->folio }}-{{ $item->usuario }}</td>
                                    <td>
                                        @if($item->predios->count())

                                            @foreach ($item->predios as $predio)

                                                @if($predio->pivot->estado === 'A')

                                                    <span>Activo</span>

                                                @elseif($predio->pivot->estado === 'I')

                                                    <span>Impreso</span>

                                                @endif

                                                {{ $predio->cuentaPredial() }},

                                            @endforeach
                                        @endif
                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>


            </div>

        </div>

    </main>

</body>
</html>
