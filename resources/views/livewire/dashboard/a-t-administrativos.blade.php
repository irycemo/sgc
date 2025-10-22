<div>

    <x-header>Estadisticas del mes actual</x-header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div>

            <x-h4>Predios ignorados</x-h4>

            <div class="grid grid-cols-2 gap-3 p-4 bg-white rounded-lg shadow-lg">

                @foreach ($predios_ignorados as $predio)

                    <a href="{{ route('predios_ignorados') .'?estado=' . $predio['estado'] }}" class="text-left text-sm text-gray-600 hover:underline ">{{ ucfirst($predio['estado']) }}</a>

                    <span class="text-right text-sm text-gray-600">{{ $predio['total'] }}</span>

                @endforeach

            </div>

        </div>

        <div>

            <x-h4>Variaciones catastrales</x-h4>

            <div class="grid grid-cols-2 gap-3 p-4 bg-white rounded-lg shadow-lg">

                @foreach ($variaciones_catastrales as $variacion)

                    <a href="{{ route('variaciones_catastrales') .'?estado=' . $variacion['estado'] }}" class="text-left text-sm text-gray-600 hover:underline ">{{ ucfirst($variacion['estado']) }}</a>

                    <span class="text-right text-sm text-gray-600">{{ $variacion['total'] }}</span>

                @endforeach

            </div>

        </div>

    </div>

</div>
