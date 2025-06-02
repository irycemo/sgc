<div class="bg-white rounded-lg p-4 flex justify-end  shadow-xl">

    @if($actualizacion)

        <x-button-green
            wire:click="actualizar"
            wire:loading.attr="disabled"
            wire:target="actualizar">

            <img wire:loading wire:target="actualizar" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

            Actualizar

        </x-button-green>

    @else

        <x-button-green
            wire:click="crear"
            wire:loading.attr="disabled"
            wire:target="crear">

            <img wire:loading wire:target="crear" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

            Guardar

        </x-button-green>

    @endif

</div>