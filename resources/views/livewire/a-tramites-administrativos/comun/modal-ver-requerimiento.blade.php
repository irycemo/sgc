<x-dialog-modal wire:model="modalVerRequerimiento" maxWidth="md">

    <x-slot name="title">

        Requerimientos

    </x-slot>

    <x-slot name="content">

        @if($modalVerRequerimiento)

            @forelse ($modelo_editar->requerimientos as $requermiento)

                <div class="rounded-lg bg-gray-100 py-1 px-2 my-3">

                    <div>

                        <p>{{ $requermiento->descripcion }}</p>

                    </div>

                    <div class="text-xs text-right">

                        <p>{{ $requermiento->creadoPor->name }}</p>
                        <p>{{ $requermiento->created_at }}</p>

                    </div>

                </div>

            @empty

                <p class="text-lg text-center">No hay requerimientos</p>

            @endforelse

        @endif

    </x-slot>

    <x-slot name="footer">

        <div class="flex gap-3">

            <x-button-red
                wire:click="$toggle('modalVerRequerimiento')"
                wire:loading.attr="disabled"
                wire:target="$toggle('modalVerRequerimiento')"
                type="button">
                Cerrar
            </x-button-red>

        </div>

    </x-slot>

</x-dialog-modal>
