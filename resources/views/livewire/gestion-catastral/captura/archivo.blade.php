<div>

    <div class="space-y-2 mb-5 bg-white rounded-lg p-2 shadow-xl">

        <div class="w-full md:w-1/2 lg:w-1/4 mx-auto items-center text-center">

            <x-input-group for="descripcion" label="Descripción" :error="$errors->first('descripcion')" class="w-full mb-3">

                <x-input-text id="descripcion" wire:model="descripcion" />

            </x-input-group>

            <div class="mb-5">

                <x-filepond wire:model.live="documento" accept="['application/pdf']"/>

            </div>

            <div>

                @error('documento') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

            </div>

        </div>

        <div class="w-full lg:w-1/2 mx-auto">

            @if($predio)

                <livewire:comun.consultas.archivo-consulta lazy :predio_id="$predio->id" />

            @endif

        </div>


    </div>

    @if($predio)

        <div class="mb-5 bg-white rounded-lg p-2 shadow-lg flex justify-end gap-4">

            <x-button-green
                wire:click="guardar"
                wire:loading.attr="disabled"
                wire:target="guardar">

                <img wire:loading wire:target="guardar" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                Guardar

            </x-button-green>

        </div>

    @endif

</div>
