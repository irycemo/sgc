<x-dialog-modal wire:model="modal">

    <x-slot name="title">

        @if($crear)
            Nueva Variación Catastral
        @elseif($editar)
            Editar Variación Catastral
        @endif

    </x-slot>

    <x-slot name="content">

        <div class="flex-auto text-center mb-3">

            <div >

                <Label class="text-base tracking-widest rounded-xl border-gray-500">Trámite</Label>

            </div>

            <div class="inline-flex">

                <select class="bg-white rounded-l text-sm border border-r-transparent focus:ring-0 @error('taño') border-red-500 @enderror" wire:model="taño">

                    @foreach ($años as $año)

                        <option value="{{ $año }}">{{ $año }}</option>

                    @endforeach

                </select>

                <input type="number" class="bg-white text-sm w-20 focus:ring-0 @error('tfolio') border-red-500 @enderror" wire:model="tfolio">

                <input type="number" class="bg-white text-sm w-20 border-l-0 rounded-r focus:ring-0 @error('tusuario') border-red-500 @enderror" wire:model="tusuario">

            </div>

        </div>

        <div class="space-y-3">

            <x-input-group for="modelo_editar.promovente" label="Promovente" :error="$errors->first('modelo_editar.promovente')" class="w-full">

                <x-input-text id="modelo_editar.promovente" wire:model="modelo_editar.promovente" />

            </x-input-group>

            <x-input-group for="modelo_editar.finado" label="Finado" :error="$errors->first('modelo_editar.finado')" class="w-full">

                <x-input-text id="modelo_editar.finado" wire:model="modelo_editar.finado" />

            </x-input-group>

            @if(!auth()->user()->hasRole('Oficina rentistica'))

                <x-input-group for="modelo_editar.oficina_id" label="Municipio" :error="$errors->first('modelo_editar.oficina_id')" class="w-full">

                    <x-input-select id="modelo_editar.oficina_id" wire:model="modelo_editar.oficina_id" class="w-full">

                        <option value="">Seleccione una opción</option>

                        @foreach ($oficinas as $oficina)

                            <option value="{{ $oficina->id }}">{{ $oficina->nombre }}</option>

                        @endforeach

                    </x-input-select>

                </x-input-group>

            @endif

        </div>

    </x-slot>

    <x-slot name="footer">

        <div class="flex gap-3">

            <x-button-blue
                wire:click="guardar"
                wire:loading.attr="disabled"
                wire:target="guardar">

                <div wire:loading.flex class="flex items-center" wire:target="guardar">
                    <svg class="animate-spin h-4 w-4 mr-2 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </div>

                Guardar
            </x-button-blue>

            <x-button-red
                wire:click="resetearTodo"
                wire:loading.attr="disabled"
                wire:target="resetearTodo"
                type="button">
                Cerrar
            </x-button-red>

        </div>

    </x-slot>

</x-dialog-modal>
