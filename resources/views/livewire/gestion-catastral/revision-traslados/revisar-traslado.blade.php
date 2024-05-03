<div class="">

    <div class="mb-6">

        <x-header>Revisar traslado</x-header>

    </div>

    <div class="grid grid-cols-3 gap-3 mb-5 text-sm">

        @include('livewire.gestion-catastral.revision-traslados.padron')

        @include('livewire.gestion-catastral.revision-traslados.aviso')

        @include('livewire.gestion-catastral.revision-traslados.avaluo')

    </div>

    <div class="mb-5 bg-white rounded-lg p-2 shadow-lg flex justify-end gap-4">

        <x-button-green
            wire:click="$toggle('modalAutorizar')"
            wire:loading.attr="disabled"
            wire:target="$toggle('modalAutorizar')">

            <img wire:loading wire:target="$toggle('modalAutorizar')" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

            Autorizar

        </x-button-green>

        <x-button-red
            wire:click="$toggle('modalRechazar')"
            wire:loading.attr="disabled"
            wire:target="$toggle('modalRechazar')">

            <img wire:loading wire:target="$toggle('modalRechazar')" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

            Rechazar

        </x-button-red>

    </div>

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

</div>
