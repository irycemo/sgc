@extends('layouts.admin')

@section('content')

    @if(auth()->user()->hasRole(['Administrador', 'Oficina rentistica']))

        <div class="mb-10">

            <x-header>Gráfica de trámites</x-header>

            <div class="bg-white rounded-lg p-2 shadow-lg">

                <canvas id="tramitesChart" style="width: 100%; height: 400px;"></canvas>

            </div>

        </div>

        @livewire('dashboard.administrador-dashboard', ['lazy' => true])

    @elseif(auth()->user()->hasRole(['Jefe de departamento']))

    @elseif(auth()->user()->hasRole(['Valuador predio ignorado', 'Valuador variación catastral', 'Valuador subdivisiones', 'Valuación']))

    @elseif(auth()->user()->hasRole(['Fiscal']))

    @elseif(auth()->user()->hasRole(['Gestion catastral']))

    @elseif(auth()->user()->hasRole(['Cartografía']))

    @elseif(auth()->user()->hasRole(['A y T Administrativos']))

    @endif

@endsection

@if(auth()->user()->hasRole('Administrador'))

    @push('scripts')

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>

            const colors = [
                ['#985F99', '#9684A1'],
                ['#595959', '#808F85'],
                ['#918868', '#CBD081'],
                ['#F7934C', '#CC5803'],
                ['#273043', '#9197AE'],
                ['#F02D3A', '#EFF6EE'],
                ['#000000', '#695B5C'],
                ['#4A5043', '#8AA1B1'],
                ['#A5B452', '#C8D96F'],
                ['#14591D', '#99AA38'],
                ['#003459', '#00A8E8'],
                ['#5C7457', '#C1BCAC'],
                ['#FF8360', '#E8E288'],
                ['#B96AC9', '#E980FC'],
                ['#63768D', '#8AC6D0'],
                ['#56445D', '#548687'],
                ['#8FBC94', '#C5E99B']
            ]

            const aux = {!! json_encode($data) !!}

            let dataArray = new Array();

            let aux2 = new Array();

            for(let key in aux){
                for (let key2 in aux[key]) {
                    aux2.push(aux[key][key2])
                }

                var color = colors[Math.floor(Math.random()*colors.length)]

                dataArray.push(
                    {
                        label: key,
                        data: aux2,
                        borderColor: color[0],
                        backgroundColor: color[1],
                        pointStyle: 'circle',
                        pointRadius: 5,
                        pointHoverRadius: 10
                    }
                )

                aux2 = new Array();
            }

            const labels=  ["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"];

            const data = {
                labels: labels,
                datasets:dataArray
            }

            const config = {
                type: 'line',
                data: data,
                options: {
                    locale:'es-MX',
                    responsive: true,
                    scales:{
                        y:{
                            ticks:{
                                callback:(value, index, values) => {
                                    return new Intl.NumberFormat('es-MX', {
                                        style: 'currency',
                                        currency: 'MXN',
                                    }).format(value);
                                }
                            },
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                        },
                        title: {
                            display: false,
                            text: 'Gráfica de entradas'
                        },
                        tooltip: {
                            callbacks: {
                                label: function(context){
                                    return `${context.dataset.label}: $${context.formattedValue}`;
                                }
                            }
                        }
                    }
                },
            };

            const myChart = new Chart(
                document.getElementById('tramitesChart'),
                config
            );

        </script>

    @endpush

@endif
