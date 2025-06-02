<x-dialog-modal wire:model="modalAsignarValuador" maxWidth="sm">

    <x-slot name="title">

        Asignar valuador

    </x-slot>

    <x-slot name="content">

        @if($modelo_editar->valuadorAsignado)

            <p class="mb-4">Asignado a: {{ $modelo_editar->valuadorAsignado->name }}</p>

        @endif

        <x-input-group for="modelo_editar.valuador" label="Valuador" :error="$errors->first('modelo_editar.valuador')" class="w-full">

            <x-input-select id="modelo_editar.valuador" wire:model="modelo_editar.valuador" class="w-full">

                <option value="">Seleccione una opción</option>

                @if($modalAsignarValuador)

                    @foreach ($valuadores as $valuador)

                        <option value="{{ $valuador->id }}">{{ $valuador->name }}</option>

                    @endforeach

                @endif

            </x-input-select>

        </x-input-group>

    </x-slot>

    <x-slot name="footer">

        <div class="flex gap-3">

            <x-button-blue
                wire:click="asignar"
                wire:loading.attr="disabled"
                wire:target="asignar">

                <div wire:loading.flex class="flex items-center" wire:target="asignar">
                    <svg class="animate-spin h-4 w-4 mr-2 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>

                Asignar
            </x-button-blue>

            <x-button-red
                wire:click="$toggle('modalAsignarValuador')"
                wire:loading.attr="disabled"
                wire:target="$toggle('modalAsignarValuador')"
                type="button">
                Cerrar
            </x-button-red>

        </div>

    </x-slot>

</x-dialog-modal>
