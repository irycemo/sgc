<div>

    <div class="bg-white rounded-lg p-3 flex gap-3 mb-3 shadow-lg">

        <x-input-group for="predio.origen" label="Origen del movimiento" :error="$errors->first('predio.origen')" class="w-fit">

            <x-input-select id="predio.origen" wire:model="predio.origen" class="">

                <option value="">Seleccione una opción</option>

                @foreach ($acciones_padron as $item)

                        <option value="{{ $item }}">{{ $item }}</option>

                    @endforeach

            </x-input-select>

        </x-input-group>

    </div>

    <div class="bg-white rounded-lg p-3 flex gap-3 mb-3 shadow-lg">

        <x-input-group for="predio.superficie_terreno" label="Superficie de terreno" :error="$errors->first('predio.superficie_terreno')" class="w-full">

            <x-input-text type="number" id="predio.superficie_terreno" wire:model="predio.superficie_terreno" />

        </x-input-group>

        <x-input-group for="predio.superficie_construccion" label="Superficie de construcción" :error="$errors->first('predio.superficie_construccion')" class="w-full">

            <x-input-text type="number" id="predio.superficie_construccion" wire:model="predio.superficie_construccion" />

        </x-input-group>

        <x-input-group for="predio.superficie_notarial" label="Superficie notarial" :error="$errors->first('predio.superficie_notarial')" class="w-full">

            <x-input-text type="number" id="predio.superficie_notarial" wire:model="predio.superficie_notarial" />

        </x-input-group>

        <x-input-group for="predio.superficie_judicial" label="Superficie judicial" :error="$errors->first('predio.superficie_judicial')" class="w-full">

            <x-input-text type="number" id="predio.superficie_judicial" wire:model="predio.superficie_judicial" />

        </x-input-group>

        <x-input-group for="predio.valor_catastral" label="Valor catastral" :error="$errors->first('predio.valor_catastral')" class="w-full">

            <x-input-text type="number" id="predio.valor_catastral" wire:model="predio.valor_catastral" />

        </x-input-group>

    </div>

    @if(count($errors) > 0)

        <div class="mb-5 bg-white rounded-lg p-2 shadow-lg flex gap-2 flex-wrap ">

            <ul class="flex gap-2 felx flex-wrap list-disc ml-5">
            @foreach ($errors->all() as $error)

                <li class="text-red-500 text-xs md:text-sm ml-5">
                    {{ $error }}
                </li>

            @endforeach

        </ul>

        </div>

    @endif

    <div class="space-y-2 mb-5 bg-white rounded-lg p-2 shadow-lg flex justify-end">

        <x-button-green
            wire:click="guardar"
            wire:loading.attr="disabled"
            wire:target="guardar">

            <img wire:loading wire:target="guardar" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

            Guardar

        </x-button-green>

    </div>

</div>
