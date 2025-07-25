<div class="">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

        {{-- Campos --}}
        <div>

            @if (!$tramite)

                <div>

                    @include('livewire.tramites.ventanilla.comun.solicitante')

                    <div class="flex-row lg:flex lg:gap-3 ">

                        @include('livewire.tramites.ventanilla.comun.tipo_tramite')

                        @include('livewire.tramites.ventanilla.comun.numero_oficio')

                    </div>

                    @if ($servicio['nombre'] == 'Inscripción o registro de predios ignorados')

                        @include('livewire.tramites.ventanilla.comun.clave_catastral')

                    @endif

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
