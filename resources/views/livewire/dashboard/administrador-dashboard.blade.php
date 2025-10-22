    <div>

    <x-header>Estadisticas del mes actual</x-header>

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

        <div class="">

            <x-h4>Certificaciones</x-h4>

            <div class="grid grid-cols-2 gap-3 p-4 bg-white rounded-lg shadow-lg">

                @foreach ($certificaciones as $certificacion)

                    <span class="text-left text-sm text-gray-600 hover:underline ">{{ ucfirst($certificacion['estado']) }}</span>

                    <span class="text-right text-sm text-gray-600">{{ $certificacion['total'] }}</span>

                @endforeach

                @foreach ($certificados as $certificado)

                    @if($certificado['estado'] == 'A')

                        <a href="{{ route('tramites_linea') }}" class="text-left text-sm text-gray-600 hover:underline ">Pendientes</a>

                        <span class="text-right text-sm text-gray-600">{{ $certificado['total'] }}</span>

                    @endif

                @endforeach

            </div>

        </div>

        <div class="">

            <x-h4>Avisos</x-h4>

            <div class="grid grid-cols-2 gap-3 p-4 bg-white rounded-lg shadow-lg">

                @foreach ($traslados as $aviso)

                    <a href="{{ route('revision_traslados') .'?estado=' . $aviso['estado'] }}" class="text-left text-sm text-gray-600 hover:underline ">{{ ucfirst($aviso['estado']) }}</a>

                    <span class="text-right text-sm text-gray-600">{{ $aviso['total'] }}</span>

                @endforeach

            </div>

        </div>

        <div>

            <x-h4>Avalúos</x-h4>

            <div class="grid grid-cols-2 gap-3 p-4 bg-white rounded-lg shadow-lg">

                @foreach ($avaluos as $avaluo)

                    <a href="{{ route('avaluos_lista') .'?estado=' . $avaluo['estado'] }}" class="text-left text-sm text-gray-600 hover:underline ">{{ ucfirst($avaluo['estado']) }}</a>

                    <span class="text-right text-sm text-gray-600">{{ $avaluo['total'] }}</span>

                @endforeach

            </div>

        </div>

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
