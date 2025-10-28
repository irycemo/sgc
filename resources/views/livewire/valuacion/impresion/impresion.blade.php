<div>

    <x-header>Impresión de notificación de valor catastral</x-header>

    <div class="bg-white rounded-lg shadow-xl p-4 mb-5">

        <x-input-group for="avaluo_para" label="Avalúo para" :error="$errors->first('avaluo_para')" class="w-fit mx-auto">

            <x-input-select id="avaluo_para" wire:model.live="avaluo_para" class="w-full">

                <option value="" selected>Seleccione una opción</option>

                @foreach ($lista_avaluo_para as $item)

                    <option value="{{ $item->value }}">{{ $item->label() }}</option>

                @endforeach

            </x-input-select>

        </x-input-group>

    </div>

    @if(in_array($avaluo_para, [1,2,7]))

        @livewire('valuacion.impresion.general', ['avaluo_para' => $avaluo_para])

    @elseif(in_array($avaluo_para, [3,4,5]))

        @livewire('valuacion.impresion.desglose', ['avaluo_para' => $avaluo_para])

    @elseif(in_array($avaluo_para, [8]))

        @livewire('valuacion.impresion.fusion', ['avaluo_para' => $avaluo_para])

    @elseif(in_array($avaluo_para, [9]))

        @livewire('valuacion.impresion.cambio-regimen', ['avaluo_para' => $avaluo_para])

    @elseif(in_array($avaluo_para, [6]))

        @livewire('valuacion.impresion.predio-ignorado', ['avaluo_para' => $avaluo_para])

    @endif

</div>
