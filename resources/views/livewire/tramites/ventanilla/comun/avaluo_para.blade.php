@if ($flags['avaluo_para'])

    <div class="bg-white p-4 rounded-lg space-y-2 mb-3 shadow-md relative" wire:loading.class.delay.longest="opacity-50">

        <div class="flex-auto ">

            <div class="mb-2">

                <Label class="text-lg tracking-widest rounded-xl border-gray-500">Avaluo para</Label>

            </div>

            <div>

                <select class="bg-white rounded text-sm w-full" wire:model.lazy="modelo_editar.avaluo_para">

                    <option value="" selected>Seleccione una opción</option>
                    @foreach ($lista_avaluo_para as $item)

                        <option value="{{ $item->value }}">{{ $item->label() }}</option>

                    @endforeach

                </select>

            </div>

            <div>

                @error('modelo_editar.avaluo_para') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

            </div>

        </div>

    </div>

@endif