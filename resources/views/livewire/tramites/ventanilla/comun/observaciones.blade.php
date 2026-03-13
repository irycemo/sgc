@if ($flags['observaciones'])

    <div class="bg-white p-4 rounded-lg space-y-2 mb-3 shadow-md" wire:loading.class.delay.longest="opacity-50">

        <div class="flex-auto ">

            <div class="mb-2">

                <Label class="text-lg tracking-widest rounded-xl border-gray-500">Observaciones</Label>

            </div>

            <div>

                <textarea rows="5" wire:model.blur="modelo_editar.observaciones" class="bg-white rounded text-sm w-full" placeholder="Se lo mas especifico posible acerca de porque se genera el trámite."></textarea>

            </div>

            <div>

                @error('modelo_editar.observaciones') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

            </div>

        </div>

    </div>

@endif