@if ($flags['cantidad'])

    <div class="flex-auto bg-white p-4 rounded-lg mb-3 shadow-md " wire:loading.class.delay.longest="opacity-50">

        <div class="mb-2">

            <Label class="text-lg tracking-widest rounded-xl border-gray-500">Cantidad</Label>

        </div>

        <div>

            <input type="number" min="1" class="bg-white rounded text-sm w-full" wire:model.blur="modelo_editar.cantidad">

        </div>

        <div>

            @error('modelo_editar.cantidad') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

        </div>

    </div>

@endif