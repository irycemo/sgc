<h4 class="text-2xl tracking-widest py-1 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-thin mb-6  bg-white">Propietarios ({{ $predio->propietarios->count() }})</h4>

<div class="bg-white p-4 rounded-lg w-full shadow-lg mb-5">

    <table class="w-full overflow-x-auto table-fixed">

        <thead class="border-b border-gray-300 ">

            <tr class="text-sm text-gray-500 text-left traling-wider whitespace-nowrap">

                <th class="px-2">Tipo de persona</th>
                <th class="px-2">Nombre / Razón social</th>
                <th class="px-2">Porcentaje de propiedad</th>
                <th class="px-2">Porcentaje de nuda</th>
                <th class="px-2">Porcentaje de usufructo</th>

            </tr>

        </thead>

        <tbody class="divide-y divide-gray-200">

            @foreach ($predio->propietarios as $propietario)

                <tr class="text-gray-500 text-sm leading-relaxed">
                    <td class=" px-2 w-full ">{{ $propietario->persona->tipo }}</td>
                    <td class=" px-2 w-full ">{{ $propietario->persona->nombre }} {{ $propietario->persona->ap_paterno }} {{ $propietario->persona->ap_materno }} {{ $propietario->persona->razon_social }}</td>
                    <td class=" px-2 w-full ">{{ $propietario->porcentaje_propiedad }}%</td>
                    <td class=" px-2 w-full ">{{ $propietario->porcentaje_nuda }}%</td>
                    <td class=" px-2 w-full ">{{ $propietario->porcentaje_usufructo }}%</td>
                </tr>

            @endforeach

        </tbody>

    </table>

</div>