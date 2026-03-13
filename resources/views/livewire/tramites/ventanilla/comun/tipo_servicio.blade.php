@if ($flags['tipo_de_servicio'])

    <div class="flex-auto bg-white p-4 rounded-lg mb-3 shadow-md" wire:loading.class.delay.longest="opacity-50">

        <div class="mb-2">

            <Label class="text-lg tracking-widest rounded-xl border-gray-500">Tipo de servicio</Label>

        </div>

        <div>

            <select class="bg-white rounded text-sm w-full" wire:model.live="modelo_editar.tipo_servicio">

                <option value="ordinario">Ordinario</option>
                <option value="urgente">Urgente</option>
                <option value="extra_urgente">Extra urgente</option>

            </select>

        </div>

        <div>

            @error('modelo_editar.tipo_servicio') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

        </div>

    </div>

@endif