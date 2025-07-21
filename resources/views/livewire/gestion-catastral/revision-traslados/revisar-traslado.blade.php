<div class="">

    <div class="mb-6">

        <x-header>Revisar traslado</x-header>

    </div>

    <div class="grid grid-cols-3 gap-3 mb-5 text-sm">

        @include('livewire.gestion-catastral.revision-traslados.padron')

        @include('livewire.gestion-catastral.revision-traslados.aviso')

        @if($this->traslado->tipo == 'aclaratorio')

            @include('livewire.gestion-catastral.revision-traslados.avaluo')

        @endif

    </div>

    <div class="mb-5 bg-white rounded-lg p-2 shadow-lg flex justify-end gap-4">

        @if($traslado->estado === 'autorizado')

            <x-button-blue
                wire:click="$toggle('modalOperar')"
                wire:loading.attr="disabled"
                wire:target="$toggle('modalOperar')">

                <img wire:loading wire:target="$toggle('modalOperar')" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                Operar
            </x-button-blue>

        @endif

        @if($traslado->estado != 'operado')

            <x-button-green
                wire:click="$toggle('modalAutorizar')"
                wire:loading.attr="disabled"
                wire:target="$toggle('modalAutorizar')">

                <img wire:loading wire:target="$toggle('modalAutorizar')" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                Autorizar

            </x-button-green>

        @endif

        <x-button-red
            wire:click="$toggle('modalRechazar')"
            wire:loading.attr="disabled"
            wire:target="$toggle('modalRechazar')">

            <img wire:loading wire:target="$toggle('modalRechazar')" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

            Rechazar

        </x-button-red>

    </div>

    <x-dialog-modal wire:model="modalAutorizar" >

        <x-slot name="title">

            Autorizar

        </x-slot>

        <x-slot name="content">

            <x-input-group for="observaciones" label="Observaciones" :error="$errors->first('observaciones')" class="w-full">

                <textarea class="bg-white rounded text-xs w-full " rows="4" wire:model="observaciones" placeholder="Se lo mas especifico posible si la autorización esta condicionada."></textarea>

            </x-input-group>

        </x-slot>

        <x-slot name="footer">

            <div class="flex gap-3">

                <x-button-blue
                    wire:click="autorizarTraslado"
                    wire:loading.attr="disabled"
                    wire:target="autorizarTraslado">

                    <img wire:loading wire:target="autorizarTraslado" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                    Autorizar
                </x-button-blue>

                <x-button-red
                    wire:click="$toggle('modalAutorizar')"
                    wire:loading.attr="disabled"
                    wire:target="$toggle('modalAutorizar')"
                    type="button">
                    Cerrar
                </x-button-red>

            </div>

        </x-slot>

    </x-dialog-modal>

    <x-dialog-modal wire:model="modalOperar" >

        <x-slot name="title">

            Definir porcentajes

        </x-slot>

        <x-slot name="content">

            <table class="w-full">

                <thead class="border-b border-gray-300 ">

                    <tr class="text-sm text-gray-500 text-left traling-wider whitespace-nowrap">

                        <th class="px-2">Nombre / Razón social</th>
                        <th class="px-2">% Porpiedad</th>
                        <th class="px-2">% Nuda</th>
                        <th class="px-2">% Usufructo</th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-gray-200">

                    @foreach ($transmitentes as $key => $transmitente)

                        <tr class="text-gray-500 text-sm leading-relaxed">
                            <td class="p-1">(Tra.) {{ $transmitente['nombre'] ?? '' }} {{ $transmitente['ap_paterno'] ?? '' }} {{ $transmitente['ap_materno'] ?? '' }} {{ $transmitente['razon_social'] ?? '' }}</td>
                            <td class="p-1">
                                <input wire:model.live="transmitentes.{{ $key }}.porcentaje_propiedad" type="number" class="bg-white text-sm w-full rounded-md p-2 border border-gray-500 outline-none ring-blue-600 focus:ring-1 focus:border-blue-600">
                            </td>
                            <td class="p-1">
                                <input wire:model.live="transmitentes.{{ $key }}.porcentaje_nuda" type="number" class="bg-white text-sm w-full rounded-md p-2 border border-gray-500 outline-none ring-blue-600 focus:ring-1 focus:border-blue-600">
                            </td>
                            <td class="p-1">
                                <input wire:model.live="transmitentes.{{ $key }}.porcentaje_usufructo" type="number" class="bg-white text-sm w-full rounded-md p-2 border border-gray-500 outline-none ring-blue-600 focus:ring-1 focus:border-blue-600">
                            </td>
                        </tr>

                    @endforeach

                    @foreach ($aviso['predio']['adquirientes'] as $adquiriente)

                        <tr class="text-gray-500 text-sm leading-relaxed">
                            <td class=" px-2">(Adq.){{ $adquiriente['nombre'] ?? '' }} {{ $adquiriente['ap_paterno'] ?? '' }} {{ $adquiriente['ap_materno'] ?? '' }} {{ $adquiriente['razon_social'] ?? '' }}</td>
                            <td class=" px-2">{{ $adquiriente['porcentaje_propiedad'] ?? '0' }}</td>
                            <td class=" px-2">{{ $adquiriente['porcentaje_nuda'] ?? '0' }} </td>
                            <td class=" px-2">{{ $adquiriente['porcentaje_usufructo'] ?? '0' }}</td>
                        </tr>

                    @endforeach

                </tbody>

            </table>

        </x-slot>

        <x-slot name="footer">

            <div class="flex gap-3">

                <x-button-blue
                    wire:click="operarTraslado"
                    wire:loading.attr="disabled"
                    wire:target="operarTraslado">

                    <img wire:loading wire:target="operarTraslado" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                    Operar
                </x-button-blue>

                <x-button-red
                    wire:click="$toggle('modalOperar')"
                    wire:loading.attr="disabled"
                    wire:target="$toggle('modalOperar')"
                    type="button">
                    Cerrar
                </x-button-red>

            </div>

        </x-slot>

    </x-dialog-modal>

    <x-dialog-modal wire:model="modalRechazar" >

        <x-slot name="title">

            Rechazar

        </x-slot>

        <x-slot name="content">

            <p class="font-semibold mb-2">Reglamento de la Ley de la Función Registral y Catastral del Estado de Michoacán de Ocampo</p>

            @if(!$rechazo)

                @foreach ($rechazos as $key => $item)

                    <div
                        wire:click="seleccionarMotivo('{{ $key }}')"
                        wire:loading.attr="disabled"
                        class="border rounded-lg text-sm mb-2 p-2 hover:bg-gray-100 cursor-pointer">

                        <p class="font-semibold">{{ $key }}</p>

                        <p>{{ $item }}</p>

                    </div>

                @endforeach

            @else

                <div class="border rounded-lg text-sm mb-2 p-2 relative">

                    <span
                        wire:click="$set('rechazo', null)"
                        wire:loading.attr="disabled"
                        class="rounded-full px-2 border hover:bg-gray-700 hover:text-white absolute top-1 right-1 cursor-pointer">x</span>

                    <p class="font-semibold">{{ $rechazo['key'] }}</p>

                    <p>{{ $rechazo['value'] }}</p>

                </div>

            @endif

            <x-input-group for="observaciones" label="Observaciones" :error="$errors->first('observaciones')" class="w-full">

                <textarea class="bg-white rounded text-xs w-full " rows="4" wire:model="observaciones" placeholder="Se lo mas especifico posible acerca del motivo del rechazo."></textarea>

            </x-input-group>

        </x-slot>

        <x-slot name="footer">

            <div class="flex gap-3">

                <x-button-blue
                    wire:click="rechazarTraslado"
                    wire:loading.attr="disabled"
                    wire:target="rechazarTraslado">

                    <img wire:loading wire:target="rechazarTraslado" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                    Rechazar
                </x-button-blue>

                <x-button-red
                    wire:click="$toggle('modalRechazar')"
                    wire:loading.attr="disabled"
                    wire:target="$toggle('modalRechazar')"
                    type="button">
                    Cerrar
                </x-button-red>

            </div>

        </x-slot>

    </x-dialog-modal>

</div>
