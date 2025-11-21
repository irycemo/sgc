<x-dialog-modal wire:model="modalCambiarEstado" maxWidth="sm">

    <x-slot name="title">

        Cambiar estado

    </x-slot>

    <x-slot name="content">

        <x-input-group for="estado" label="Estado" :error="$errors->first('estado')" class="w-full">

            <x-input-select id="estado" wire:model="estado" class="w-full">

                <option value="">Seleccione una opción</option>
                <option value="publicación">Publicación</option>
                @if($this->modelo_editar->tramite?->servicio->nombre === 'Solicitud de Predio Ignorado')
                    <option value="asignar clave">Asignar clave catastral</option>
                    <option value="periódico oficial">Periódico oficial</option>
                @endif
                <option value="oposición">Oposición</option>
                <option value="firma">Firma</option>
                <option value="concluido">Concluido</option>

            </x-input-select>

        </x-input-group>

    </x-slot>

    <x-slot name="footer">

        <div class="flex gap-3">

            <x-button-blue
                wire:click="actualizar"
                wire:loading.attr="disabled"
                wire:target="actualizar">

                <div wire:loading.flex class="flex items-center" wire:target="actualizar">
                    <svg class="animate-spin h-4 w-4 mr-2 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>

                Actualizar
            </x-button-blue>

            <x-button-red
                wire:click="$toggle('modalCambiarEstado')"
                wire:loading.attr="disabled"
                wire:target="$toggle('modalCambiarEstado')"
                type="button">
                Cerrar
            </x-button-red>

        </div>

    </x-slot>

</x-dialog-modal>
