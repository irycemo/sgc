<x-dialog-modal wire:model="modalHacerRequerimiento" maxWidth="sm">

    <x-slot name="title">

        Nuevo requerimiento

    </x-slot>

    <x-slot name="content">

        <x-input-group for="requerimiento" label="Requerimineto" :error="$errors->first('requerimiento')" class="w-full">

            <textarea class="bg-white rounded text-xs w-full " rows="8" wire:model="requerimiento"></textarea>

        </x-input-group>

    </x-slot>

    <x-slot name="footer">

        <div class="flex gap-3">

            <x-button-blue
                wire:click="requerir"
                wire:loading.attr="disabled"
                wire:target="requerir">

                <div wire:loading.flex class="flex items-center" wire:target="requerir">
                    <svg class="animate-spin h-4 w-4 mr-2 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>

                Requerir
            </x-button-blue>

            <x-button-red
                wire:click="$toggle('modalHacerRequerimiento')"
                wire:loading.attr="disabled"
                wire:target="$toggle('modalHacerRequerimiento')"
                type="button">
                Cerrar
            </x-button-red>

        </div>

    </x-slot>

</x-dialog-modal>
