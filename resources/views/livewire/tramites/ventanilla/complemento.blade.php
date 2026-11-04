<div class="">

    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

        {{-- Campos --}}
        <div>

            @if (!$tramite)

                <div>

                    @include('livewire.tramites.ventanilla.comun.adiciona')

                    @if(!$adicionaTramite)

                        @include('livewire.tramites.ventanilla.comun.solicitante')

                    @else

                        <div class="flex justify-around space-x-3 bg-white p-4 rounded-lg mb-3 shadow-md relative" wire:loading.class.delay.longest="opacity-50">

                            Tramite original: {{ $tramiteAdicionado?->servicio->nombre }}

                        </div>

                    @endif

                    @if(in_array($tramiteAdicionado?->servicio->clave_ingreso, ['DM31']))

                        <div class="flex justify-around space-x-3 bg-white p-4 rounded-lg mb-3 shadow-md relative" wire:loading.class.delay.longest="opacity-50">

                            Tramite complemento: urgente

                        </div>

                    @else

                        @if(in_array($tramiteAdicionado?->servicio->categoria->nombre, ['Inspecciones Oculares', 'Desglose de predios y valuación']))

                            @include('livewire.tramites.ventanilla.comun.cantidad')

                        @elseif(! in_array($this->tramiteAdicionado?->servicio->clave_ingreso, ['D924', 'D925', 'D926']))

                            @include('livewire.tramites.ventanilla.comun.monto')

                        @endif

                    @endif

                    @if($show_servicios_historia)

                        <div class="flex-row lg:flex lg:space-x-3 relative" wire:loading.class.delay.longest="opacity-50">

                            <div class="flex-auto bg-white p-3 rounded-lg mb-3 shadow-md">

                                <div class="flex-auto ">

                                    <div class="mb-2">

                                        <Label class="text-lg tracking-widest rounded-xl border-gray-500">Servicios de historia</Label>

                                    </div>

                                    <div>

                                        <select class="bg-white rounded text-sm w-full" wire:model.live="servicio_historia_seleccionado">

                                            <option value="" selected>Seleccione una opción</option>

                                            @foreach ($servicios_historia as $servicio_historia)

                                                <option value="{{ $servicio_historia->id }}">{{ $servicio_historia->nombre }}</option>

                                            @endforeach

                                        </select>

                                    </div>

                                    <div>

                                        @error('servicio_historia_seleccionado') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                                    </div>

                                    <div>

                                        @error('modelo_editar.monto') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                                    </div>

                                </div>

                            </div>

                        </div>

                    @endif

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
