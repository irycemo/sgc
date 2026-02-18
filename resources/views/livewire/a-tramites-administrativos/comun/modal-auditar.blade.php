<x-dialog-modal wire:model="modalVerAudits" maxWidth="sm">

    <x-slot name="title">

        Movimientos

    </x-slot>

    <x-slot name="content">

        <table class="table-auto lg:table-fixed w-full">

            <thead class="border-b border-gray-300 ">

                <tr class="text-sm text-gray-500 text-left traling-wider whitespace-nowrap">

                    <th class="px-2">Usuario</th>
                    <th class="px-2">Acción</th>
                    <th class="px-2">fecha</th>

                </tr>

            </thead>

            <tbody class="divide-y divide-gray-200">

                @foreach ($audits as $audit)

                    <tr class="text-gray-500 text-sm leading-relaxed">
                        <td class=" px-2 w-full ">{{ $audit->user->name }}</td>
                        <td class=" p-2 w-full ">{{ $audit->tags }}</td>
                        <td class=" p-2 w-full ">{{ $audit->created_at }}</td>
                    </tr>

                @endforeach

            </tbody>

        </table>

    </x-slot>

    <x-slot name="footer">

        <div class="flex gap-3">

            <x-button-red
                wire:click="$toggle('modalVerAudits')"
                wire:loading.attr="disabled"
                wire:target="$toggle('modalVerAudits')"
                type="button">
                Cerrar
            </x-button-red>

        </div>

    </x-slot>

</x-dialog-modal>
