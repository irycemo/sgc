<h4 class="text-2xl tracking-widest py-1 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-thin mb-6  bg-white">Auditoria ({{ $predio->audits->count()}})</h4>

<div class="bg-white p-4 rounded-lg w-full shadow-lg mb-5">

    <table class="w-full overflow-x-auto table-fixed">

        <thead class="border-b border-gray-300 ">

            <tr class="text-sm text-gray-500 text-left traling-wider whitespace-nowrap">

                <th class="px-2">Usuario</th>
                <th class="px-2">Movimiento</th>
                <th class="px-2">Trámite</th>
                <th class="px-2">Fecha</th>

            </tr>

        </thead>

        <tbody class="divide-y divide-gray-200">

            @foreach ($predio->audits as $audit)

                <tr class="text-gray-500 text-sm leading-relaxed">
                    <td class=" px-2 w-full whitespace-nowrap">{{ $audit->user->name }}</td>
                    <td class=" px-2 w-full whitespace-nowrap">{{ Str::ucfirst($audit->event) }}: {{ $audit->tags }}</td>
                    <td class=" px-2 w-full whitespace-nowrap">{{ $audit->tramite ? $audit->tramite->numeroControl() : 'N/A' }}</td>
                    <td class=" px-2 w-full whitespace-nowrap">{{ $audit->created_at }}</td>
                </tr>

            @endforeach

        </tbody>

    </table>

</div>