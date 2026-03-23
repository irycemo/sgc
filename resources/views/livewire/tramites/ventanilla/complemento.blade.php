<div class="">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

        {{-- Campos --}}
        <div>

            @if (!$tramite)

                <div>

                    @include('livewire.tramites.ventanilla.comun.adiciona')

                    <div class="flex justify-around space-x-3 bg-white p-4 rounded-lg mb-3 shadow-md relative" wire:loading.class.delay.longest="opacity-50">

                        {{ $tramiteAdicionado?->servicio->nombre }}

                    </div>

                    @include('livewire.tramites.ventanilla.comun.monto')

                    @include('livewire.tramites.ventanilla.comun.observaciones')

                </div>

            @endif

        </div>

        <div>

            @if($tramite)

                @include('livewire.tramites.ventanilla.comun.tramite_encontrado')

            @else

                @include('livewire.tramites.ventanilla.comun.tramite_nuevo')

            @endif

        </div>

    </div>

</div>
