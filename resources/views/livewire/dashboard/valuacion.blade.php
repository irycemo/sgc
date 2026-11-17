<div>

    <x-header>Estadisticas del mes actual</x-header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="">

            <x-h4>Avaluos</x-h4>

            <div class="grid grid-cols-2 gap-3 p-4 bg-white dark:bg-gray-800 rounded-lg shadow-lg">

                @foreach ($avaluos as $avaluo)

                    <span class="text-left text-sm text-gray-600 dark:text-gray-400 hover:underline ">{{ ucfirst($avaluo['estado']) }}</span>

                    <span class="text-right text-sm text-gray-600 dark:text-gray-400">{{ $avaluo['total'] }}</span>

                @endforeach

            </div>

        </div>

        <div class="">

            <x-h4>Predios ignorados</x-h4>

            <div class="grid grid-cols-2 gap-3 p-4 bg-white dark:bg-gray-800 rounded-lg shadow-lg">

                @foreach ($predios_ignorados as $ignorado)

                    <a href="{{ route('revision_traslados') .'?estado=' . $ignorado['estado'] }}" class="text-left text-sm text-gray-600 dark:text-gray-400 hover:underline ">{{ ucfirst($ignorado['estado']) }}</a>

                    <span class="text-right text-sm text-gray-600 dark:text-gray-400">{{ $ignorado['total'] }}</span>

                @endforeach

            </div>

        </div>

        <div>

            <x-h4>Variaciones catastrales</x-h4>

            <div class="grid grid-cols-2 gap-3 p-4 bg-white dark:bg-gray-800 rounded-lg shadow-lg">

                @foreach ($variaciones_catastrales as $variacion)

                    <a href="#" class="text-left text-sm text-gray-600 dark:text-gray-400 ">{{ ucfirst($variacion['estado']) }}</a>

                    <span class="text-right text-sm text-gray-600 dark:text-gray-400">{{ $variacion['total'] }}</span>

                @endforeach

            </div>

        </div>

    </div>

</div>
