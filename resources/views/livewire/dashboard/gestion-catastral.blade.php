<div>

    <x-header>Estadisticas del mes actual</x-header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

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

    </div>

</div>