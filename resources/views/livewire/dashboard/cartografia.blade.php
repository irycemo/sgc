<div>

    <x-header>Estadisticas del mes actual</x-header>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <div class="">

            <x-h4>Asignación de clave catastral</x-h4>

            <div class="grid grid-cols-2 gap-3 p-4 bg-white rounded-lg shadow-lg">

                @foreach ($predios_ignorados as $ignorado)

                    <span class="text-left text-sm text-gray-600 hover:underline ">Asignaciones pendientes</span>

                    <span class="text-right text-sm text-gray-600">{{ $ignorado['total'] }}</span>

                @endforeach

            </div>

        </div>

        <div class="">

            <x-h4>Peritos externos</x-h4>

            <div class="grid grid-cols-2 gap-3 p-4 bg-white rounded-lg shadow-lg">

                <a href="{{ route('conciliar')}}" class="text-left text-sm text-gray-600 hover:underline ">Revisión de cartografía</a>

                <a href="{{ route('conciliar_avaluos_peritos_externos')}}" class="text-left text-sm text-gray-600 hover:underline ">Conciliación</a>

            </div>

        </div>

    </div>

</div>