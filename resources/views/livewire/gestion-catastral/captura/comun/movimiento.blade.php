<div class="space-y-2 mb-5 bg-white rounded-lg p-4 shadow-xl flex gap-3 justify-center">

    <div>

        @if($actualizacion)

            <x-input-group for="accion" label="Origen del movimiento" :error="$errors->first('accion')" class="mb-2">

                <x-input-select id="accion" wire:model="accion" class="">

                    <option value="">Seleccione una opción</option>

                    @foreach ($acciones_actualizacion as $item)

                        <option value="{{ $item }}">{{ $item }}</option>

                    @endforeach

                </x-input-select>

            </x-input-group>

        @else

            <x-input-group for="accion" label="Origen del movimiento" :error="$errors->first('accion')" class="mb-2">

                <x-input-select id="accion" wire:model="accion" class="">

                    <option value="">Seleccione una opción</option>

                    @foreach ($acciones_alta as $item)

                        <option value="{{ $item }}">{{ $item }}</option>

                    @endforeach

                </x-input-select>

            </x-input-group>

        @endif

        <x-input-group for="observaciones" label="Descripción del movimiento" :error="$errors->first('observaciones')">

            <textarea class="bg-white rounded text-xs w-full " rows="4" wire:model="observaciones" placeholder="Se lo más especifico posible acerca del origen del movimiento"></textarea>

        </x-input-group>

    </div>

</div>