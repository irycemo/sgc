<x-dialog-modal wire:model="modalVerRequerimiento" maxWidth="lg">

    <x-slot name="title">

        Requerimientos

    </x-slot>

    <x-slot name="content">

        @if($modalVerRequerimiento)

            @foreach ($modelo_editar->requerimientos as $requermiento)

                <div class="rounded-lg bg-gray-100 py-1 px-2 my-3">

                    <p class="font-semibold text-gray-900">Requerimiento</p>

                    <p class="text-gray-500 text-sm leading-relaxed">{{ $requermiento->descripcion }}</p>

                    <p class="font-semibold text-gray-900">Registrado por:</p>

                    <p class="text-gray-500 text-sm leading-relaxed">{{ $requermiento->creadoPor->nombreCompleto() }}, {{ $requermiento->created_at }}</p>

                </div>

            @endforeach

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
