@if($flags['numero_oficio'])

    <div class="flex-auto bg-white dark:bg-gray-800 p-4 rounded-lg mb-3 shadow-md" wire:loading.class.delay.longest="opacity-50">

        <div class="mb-2">

            <Label class="text-lg tracking-widest rounded-xl border-gray-500 dark:border-gray-600">Número de oficio</Label>
        </div>

        <div>

            <input type="text" class="bg-white dark:bg-gray-800 rounded text-sm w-full" wire:model.lazy="modelo_editar.numero_oficio">

        </div>

        <div>

            @error('modelo_editar.numero_oficio') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

        </div>

    </div>

@endif