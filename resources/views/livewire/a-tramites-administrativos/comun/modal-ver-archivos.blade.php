<x-dialog-modal wire:model="modalVerArchivos" maxWidth="sm">

    <x-slot name="title">

        Archivos

    </x-slot>

    <x-slot name="content">

        <div class="bg-white p-4 rounded-lg w-full shadow-lg mb-5 overflow-x-auto">

            <table class="table-auto lg:table-fixed w-full">

                <thead class="border-b border-gray-300 ">

                    <tr class="text-sm text-gray-500 text-left traling-wider whitespace-nowrap">

                        <th class="px-2">Descripción</th>
                        <th class="px-2">Link</th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-gray-200">

                    @foreach ($this->modelo_editar->archivos as $archivo)

                        <tr class="text-gray-500 text-sm leading-relaxed">
                            <td class=" px-2 w-full ">{{ $archivo->descripcion }}</td>
                            <td class=" px-2 w-full ">
                                <x-link-blue href="{{ $archivo->getLinkArchivo() }}" target="_blank">Ver archivo</x-link-blue>
                            </td>
                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    </x-slot>

    <x-slot name="footer">

        <div class="flex gap-3">

            <x-button-red
                wire:click="$toggle('modalVerArchivos')"
                wire:loading.attr="disabled"
                wire:target="$toggle('modalVerArchivos')"
                type="button">
                Cerrar
            </x-button-red>

        </div>

    </x-slot>

</x-dialog-modal>
