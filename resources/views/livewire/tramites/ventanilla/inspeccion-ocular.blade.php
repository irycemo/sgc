<div class="">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

        {{-- Campos --}}
        <div>

            @if (!$tramite)

                <div>

                    @include('livewire.tramites.ventanilla.comun.solicitante')

                    <div class="flex-row lg:flex lg:gap-3 ">

                        @include('livewire.tramites.ventanilla.comun.tipo_tramite')

                        @include('livewire.tramites.ventanilla.comun.cantidad')

                        @include('livewire.tramites.ventanilla.comun.numero_oficio')

                    </div>

                    <div class="space-y-2 mb-5 bg-white rounded-lg p-2 text-right shadow-xl">

                        <x-input-group for="porcentaje" label="Aplicar porcentaje de 20%" :error="$errors->first('porcentaje')" class="flex gap-3 items-center mr-auto">

                            <x-checkbox wire:model.live="porcentaje"/>

                        </x-input-group>

                    </div>

                    @include('livewire.tramites.ventanilla.comun.avaluo_para')

                    @include('livewire.tramites.ventanilla.comun.observaciones')

                </div>

            @endif

        </div>

        {{-- Tramtie --}}
        <div>

            @if($tramite)

                @include('livewire.tramites.ventanilla.comun.tramite_encontrado')

            @else

                @include('livewire.tramites.ventanilla.comun.tramite_nuevo')

            @endif

        </div>

    </div>

</div>
