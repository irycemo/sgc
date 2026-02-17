<x-dialog-modal wire:model="modalSubirArchivo" maxWidth="sm">

    <x-slot name="title">

        Subir archivo

    </x-slot>

    <x-slot name="content">

        <x-input-group for="descripcion_documento" label="Descripción" :error="$errors->first('descripcion_documento')" class="w-full">

            <x-input-text id="descripcion_documento" wire:model="descripcion_documento" />

        </x-input-group>

        <x-filepond wire:model.live="file" accept="['application/pdf']"/>

        @error('file') <p class="text-red-400 mt-3">{{ $message }}</p> @enderror

    </x-slot>

    <x-slot name="footer">

        <div class="flex gap-3">

            <x-button-blue
                wire:click="guardarArchivo"
                wire:loading.attr="disabled"
                wire:target="guardarArchivo">

                <div wire:loading.flex class="flex items-center" wire:target="guardarArchivo">
                    <svg class="animate-spin h-4 w-4 mr-2 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>

                Anexar
            </x-button-blue>

            <x-button-red
                wire:click="$toggle('modalSubirArchivo')"
                wire:loading.attr="disabled"
                wire:target="$toggle('modalSubirArchivo')"
                type="button">
                Cerrar
            </x-button-red>

        </div>

    </x-slot>

</x-dialog-modal>
