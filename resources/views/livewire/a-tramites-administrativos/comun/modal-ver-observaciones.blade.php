<x-dialog-modal wire:model="modal_observaciones" maxWidth="sm">

    <x-slot name="title">

        Observaciones

    </x-slot>

    <x-slot name="content">

        <x-input-group for="observaciones" label="Requerimineto" :error="$errors->first('observaciones')" class="w-full">

            <textarea class="bg-white dark:bg-gray-800 rounded text-xs w-full " rows="8" wire:model="observaciones"></textarea>

        </x-input-group>

    </x-slot>

    <x-slot name="footer">

        <div class="flex gap-3">

            <x-button-blue
                wire:click="guardarObservaciones"
                wire:loading.attr="disabled"
                wire:target="guardarObservaciones">

                <div wire:loading.flex class="flex items-center" wire:target="guardarObservaciones">
                    <svg class="animate-spin h-4 w-4 mr-2 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>

                Guardar
            </x-button-blue>

            <x-button-red
                wire:click="$toggle('modal_observaciones')"
                wire:loading.attr="disabled"
                wire:target="$toggle('modal_observaciones')"
                type="button">
                Cerrar
            </x-button-red>

        </div>

    </x-slot>

</x-dialog-modal>
