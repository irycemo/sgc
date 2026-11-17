@extends('layouts.admin')

@section('content')

    @if(auth()->user()->hasRole(['Administrador', 'Jefe de departamento', 'Director']))

        <div class="mb-10">

            <x-header>Gráfica de trámites</x-header>

            <div class="bg-white dark:bg-gray-800 rounded-lg p-2 shadow-lg">

                <canvas id="tramitesChart" style="width: 100%; height: 400px;"></canvas>

            </div>

        </div>

        @livewire('dashboard.administrador-dashboard', ['lazy' => true])

    @elseif(auth()->user()->hasRole(['Oficina rentistica']))

        @livewire('dashboard.administrador-dashboard', ['lazy' => true])

    @elseif(auth()->user()->hasRole(['Valuador predio ignorado', 'Valuador variación catastral', 'Valuador subdivisiones', 'Valuación']))

        @livewire('dashboard.valuacion', ['lazy' => true])

    @elseif(auth()->user()->hasRole(['Fiscal', 'Gestión Catastral']))

        @livewire('dashboard.gestion-catastral', ['lazy' => true])

    @elseif(auth()->user()->hasRole(['Cartografía']))

        @livewire('dashboard.cartografia', ['lazy' => true])

    @elseif(auth()->user()->hasRole(['A y T Administrativos']))

        @livewire('dashboard.a-t-administrativos', ['lazy' => true])

    @endif

    <x-header class="mt-5">Nuevas preguntas frecuentes</x-header>

    <div class="bg-white dark:bg-gray-800 shadow-xl rounded-lg p-4 mt-5" wire:loading.class.delaylongest="opacity-50">

        <div class="w-full lg:w-1/2 mx-auto ">

            <ul class="w-full space-y-3">

                @foreach ($preguntas as $item)

                    <li class="cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 rounded-lg text-gray-700 dark:text-gray-300 border border-gray-300 dark:border-gray-700 flex justify-between">

                        <a href="{{ route('preguntas_frecuentes') . '?search=' . $item->titulo }}" class="w-full h-full p-3 flex justify-between items-center">

                            <span>{{ $item->titulo }}</span>

                        </a>

                    </li>

                @endforeach

                <li class="cursor-pointer bg-gray-200 dark:bg-gray-700 rounded-lg text-gray-700 dark:text-gray-300 border border-gray-400 dark:border-gray-600 flex justify-between ">

                    <a href="{{ route('preguntas_frecuentes') }}" class="w-full h-full p-1 flex justify-center items-center text-gray-700 dark:text-gray-300">

                       Ver mas

                    </a>

                </li>

            </ul>

        </div>

    </div>

@endsection

@if(auth()->user()->hasRole('Administrador'))

    @push('scripts')

        <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

        <script>

            function generateRandomHexColor() {

                // Generate a random number between 0 and 16777215 (0xFFFFFF)
                const randomColor = Math.floor(Math.random() * 16777215).toString(16);

                // Pad the hex string with leading zeros if necessary to ensure 6 characters
                return `#${randomColor.padStart(6, '0')}`;

            }

            function getInverseHexColor(hexColor) {

                // Remove the '#' if present
                const cleanHex = hexColor.startsWith('#') ? hexColor.slice(1) : hexColor;

                // Convert the hex color to a decimal integer
                const num = parseInt(cleanHex, 16);

                // Invert the color by XORing with 0xFFFFFF (white)
                const invertedNum = 0xFFFFFF ^ num;

                // Convert the inverted decimal back to a hex string
                const invertedHex = invertedNum.toString(16);

                // Pad with leading zeros and add '#'
                return `#${invertedHex.padStart(6, '0')}`;

            }

            const aux = {!! json_encode($data) !!}

            let dataArray = new Array();

            let aux2 = new Array();

            for(let key in aux){

                for (let key2 in aux[key]) {

                    aux2.push(aux[key][key2])

                }

                var color = generateRandomHexColor();

                var inverse_color = getInverseHexColor(color);

                dataArray.push(
                    {
                        label: key,
                        data: aux2,
                        borderColor: color,
                        backgroundColor: inverse_color,
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

            const themeColors = () => document.documentElement.classList.contains('dark')
                ? { ticks: '#a1a1aa', legend: '#e4e4e7' }   // zinc-400 / zinc-200 sobre fondo oscuro
                : { ticks: '#52525b', legend: '#3f3f46' };  // zinc-600 / zinc-700 sobre fondo claro

            const tc = themeColors();

            const config = {
                type: 'line',
                data: data,
                options: {
                    locale:'es-MX',
                    responsive: true,
                    scales:{
                        x:{
                            ticks:{ color: tc.ticks }
                        },
                        y:{
                            ticks:{
                                    color: tc.ticks,
                                    display: window.screen.width > 500,
                                    callback:(value, index, values) => {
                                        return new Intl.NumberFormat('es-MX', {
                                                                                style: 'currency',
                                                                                currency: 'MXN',
                                                                            }
                                                                    ).format(value);
                                    }
                            },
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            position: 'top',
                            labels: {
                                color: tc.legend
                            }
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

            /* Reajusta los colores de la gráfica al cambiar el tema en vivo */
            const applyChartTheme = () => {
                const c = themeColors();
                if (myChart.options.scales.x) myChart.options.scales.x.ticks.color = c.ticks;
                if (myChart.options.scales.y) myChart.options.scales.y.ticks.color = c.ticks;
                if (myChart.options.plugins.legend.labels) myChart.options.plugins.legend.labels.color = c.legend;
                myChart.update();
            };
            new MutationObserver(applyChartTheme)
                .observe(document.documentElement, { attributes: true, attributeFilter: ['class'] });

        </script>

    @endpush

@endif
