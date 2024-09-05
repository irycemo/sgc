<x-confirmation-modal wire:model="modalBorrar" maxWidth="sm">

    <x-slot name="title">
        Eliminar registro
    </x-slot>

    <x-slot name="content">
        ¿Esta seguro que desea eliminar el registro? No sera posible recuperar la información.
    </x-slot>

    <x-slot name="footer">

        <x-secondary-button
            wire:click="$toggle('modalBorrar')"
            wire:loading.attr="disabled"
        >
            No
        </x-secondary-button>

        <x-danger-button
            class="ml-2"
            wire:click="borrar()"
            wire:loading.attr="disabled"
            wire:target="borrar"
        >
            Borrar
        </x-danger-button>

    </x-slot>

</x-confirmation-modal>
