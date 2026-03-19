<div class="">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

        {{-- Campos --}}
        <div>

            @if (!$tramite)

                <div>

                    @include('livewire.tramites.ventanilla.comun.adiciona')

                    @include('livewire.tramites.ventanilla.comun.solicitante')

                    <div class="flex-row lg:flex lg:gap-3 ">

                        @include('livewire.tramites.ventanilla.comun.tipo_tramite')

                        @include('livewire.tramites.ventanilla.comun.tipo_servicio')

                        @include('livewire.tramites.ventanilla.comun.numero_oficio')

                    </div>

                    <div>

                        @if($servicio['nombre'] != 'Cédula de actualización regularización')

                            @include('livewire.tramites.ventanilla.comun.predios')

                        @endif

                    </div>

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
