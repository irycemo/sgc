<div>

    <x-header>Estadisticas del mes actual</x-header>

    <div class="grid grid-cols-1 lg:grid-cols-5 gap-6">

        <div class="">

            <x-h4>Certificaciones</x-h4>

            <div class="grid grid-cols-2 gap-3 p-4 bg-white rounded-lg shadow-lg">

                @foreach ($certificaciones as $certificacion)

                    @if($certificacion['estado'] == 'activo')

                        <a href="#" class="text-left text-sm text-green-700 hover:underline ">Activos</a>

                        <span class="text-right text-sm text-green-700">{{ $certificacion['total'] }}</span>

                    @else

                        <span class=" text-left text-sm text-red-700 hover:underline">Cancelados</span>

                        <span class="text-right text-sm text-red-700">{{ $certificacion['total'] }}</span>

                    @endif

                @endforeach

                @foreach ($certificados as $certificado)

                    @if($certificado['estado'] == 'A')

                        <a href="{{ route('tramites_linea') }}" class="text-left text-sm text-yellow-700 hover:underline">Pendientes</a>

                        <span class="text-right text-sm text-yellow-700">{{ $certificado['total'] }}</span>

                    @elseif($certificado['estado'] == 'O')

                        <span class=" text-left text-sm text-red-700">Operados</span>

                        <span class="text-right text-sm text-red-700">{{ $certificado['total'] }}</span>

                    @endif

                @endforeach

            </div>

        </div>

        <div class="">

            <x-h4>Avisos</x-h4>

            <div class="grid grid-cols-2 gap-3 p-4 bg-white rounded-lg shadow-lg">

                @foreach ($traslados as $aviso)

                    @if($aviso['estado'] == 'cerrado')

                        <span class="text-left text-sm text-blue-700 hover:underline">Cerrados</span>

                        <span class="text-right text-sm text-blue-700">{{ $aviso['total'] }}</span>

                    @elseif($aviso['estado'] == 'autorizado')

                        <span class=" text-left text-sm text-indigo-700 hover:underline">Autorizados</span>

                        <span class="text-right text-sm text-indigo-700">{{ $aviso['total'] }}</span>

                    @elseif($aviso['estado'] == 'rechazado')

                        <span class=" text-left text-sm text-red-700 hover:underline">Rechazados</span>

                        <span class="text-right text-sm text-red-700">{{ $aviso['total'] }}</span>

                    @elseif($aviso['estado'] == 'operado')

                        <span class=" text-left text-sm text-gray-700 hover:underline">Operados</span>

                        <span class="text-right text-sm text-gray-700">{{ $aviso['total'] }}</span>

                    @endif

                @endforeach

            </div>

        </div>

        <div>

            <x-h4>Avalúos</x-h4>

            <div class="grid grid-cols-2 gap-3 p-4 bg-white rounded-lg shadow-lg">

                @foreach ($avaluos as $avaluo)

                    @if($avaluo['estado'] == 'nuevo')

                        <span class="text-left text-sm text-green-700 hover:underline">Nuevos</span>

                        <span class="text-right text-sm text-green-700">{{ $avaluo['total'] }}</span>

                    @elseif($avaluo['estado'] == 'impreso')

                        <span class=" text-left text-sm text-red-700 hover:underline">Impreso</span>

                        <span class="text-right text-sm text-red-700">{{ $avaluo['total'] }}</span>

                    @elseif($avaluo['estado'] == 'notificado')

                        <span class=" text-left text-sm text-red-700 hover:underline">Notificado</span>

                        <span class="text-right text-sm text-red-700">{{ $avaluo['total'] }}</span>

                    @endif

                @endforeach

            </div>

        </div>

        <div>

            <x-h4>Predios ignorados</x-h4>

            <div class="grid grid-cols-2 gap-3 p-4 bg-white rounded-lg shadow-lg">

                @foreach ($predios_ignorados as $predio)

                    <span class="text-left text-sm text-gary-700 hover:underline">{{ ucfirst($predio['estado']) }}</span>

                    <span class="text-right text-sm text-gary-700">{{ $predio['total'] }}</span>

                @endforeach

            </div>

        </div>

        <div>

            <x-h4>Variaciones catastrales</x-h4>

            <div class="grid grid-cols-2 gap-3 p-4 bg-white rounded-lg shadow-lg">

                @foreach ($variaciones_catastrales as $variacion)

                    <span class="text-left text-sm text-gary-700 hover:underline">{{ ucfirst($variacion['estado']) }}</span>

                    <span class="text-right text-sm text-gary-700">{{ $variacion['total'] }}</span>

                @endforeach

            </div>

        </div>

    </div>

</div>
