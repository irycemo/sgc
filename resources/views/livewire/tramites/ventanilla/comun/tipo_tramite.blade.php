@if ($flags['tipo_de_tramite'])

    <div class="flex-auto bg-white dark:bg-gray-800 p-4 rounded-lg mb-3 shadow-md" wire:loading.class.delay.longest="opacity-50">

        <div class="mb-2">

            <Label class="text-lg tracking-widest rounded-xl border-gray-500 dark:border-gray-600">Tipo de trámite</Label>

        </div>

        <div>

            <select class="bg-white dark:bg-gray-800 rounded text-sm w-full" wire:model.live="modelo_editar.tipo_tramite">

                <option value="normal">Normal</option>
                <option value="exento">Exento</option>

            </select>

        </div>

        <div>

            @error('modelo_editar.tipo_tramite') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

        </div>

    </div>

@endif