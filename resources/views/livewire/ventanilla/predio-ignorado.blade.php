<div class="grid grid-cols-1 md:grid-cols-2 gap-3">

    <div class="relative">
        {{ $errors }}
        @if(!$tramite)

            @if ($flags['solicitante'])

                <div class="flex-row lg:flex lg:space-x-3 relative" wire:loading.class.delay.longest="opacity-50">

                    <div class="flex-auto bg-white p-3 rounded-lg mb-3 shadow-md">

                        <div class="flex-auto ">

                            <div class="mb-2">

                                <Label class="text-lg tracking-widest rounded-xl border-gray-500">Solicitante</Label>

                            </div>

                            <div>

                                <select class="bg-white rounded text-sm w-full" wire:model.live="modelo_editar.solicitante">

                                    <option value="" selected>Seleccione una opción</option>

                                    @foreach ($solicitantes as $solicitante)

                                        <option value="{{ $solicitante }}">{{ $solicitante }}</option>

                                    @endforeach

                                </select>

                            </div>

                            <div>

                                @error('modelo_editar.solicitante') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                            </div>

                        </div>

                    </div>

                    @if ($flags['nombre_solicitante'])

                        <div class="flex-auto bg-white p-3 rounded-lg mb-3 shadow-md">

                            <div class="mb-2">

                                <Label class="text-lg tracking-widest rounded-xl border-gray-500">Nombre del solicitante</Label>

                            </div>

                            <div>

                                <input type="text" class="bg-white rounded text-sm w-full" wire:model.lazy="modelo_editar.nombre_solicitante">

                            </div>

                            <div>

                                @error('modelo_editar.nombre_solicitante') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                            </div>

                        </div>

                    @endif

                    @if ($flags['dependencias'])

                        <div class="flex-auto bg-white p-3 rounded-lg mb-3 shadow-md">

                            <div class="mb-2">

                                <Label class="text-lg tracking-widest rounded-xl border-gray-500">Dependencia</Label>

                            </div>

                            <div>

                                <select class="bg-white rounded text-sm w-full" wire:model.lazy="modelo_editar.nombre_solicitante">

                                    <option value="" selected>Seleccione una opción</option>

                                    @foreach ($dependencias as $item)

                                        <option value="{{ $item->nombre }}">{{ $item->nombre }}</option>

                                    @endforeach

                                </select>

                            </div>

                            <div>

                                @error('modelo_editar.nombre_solicitante') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                            </div>

                        </div>

                    @endif

                    @if ($flags['notarias'])

                        <div class="flex-auto bg-white p-3 rounded-lg mb-3 shadow-md">

                            <div class="mb-2">

                                <Label class="text-lg tracking-widest rounded-xl border-gray-500">Notaria</Label>

                            </div>

                            <div>

                                <select class="bg-white rounded text-sm w-full" wire:model.lazy="notaria">

                                    <option value="" selected>Seleccione una opción</option>

                                    @foreach ($notarias as $item)

                                        <option value="{{ $item }}">{{ $item->numero }} - {{ $item->notario }}</option>

                                    @endforeach

                                </select>

                            </div>

                            <div>

                                @error('modelo_editar.nombre_solicitante') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                            </div>

                        </div>

                    @endif

                </div>

            @endif

            <div class="flex-row lg:flex lg:space-x-3 ">

                @if ($flags['tipo_de_tramite'])

                    <div class="flex-auto bg-white p-4 rounded-lg mb-3 shadow-md" wire:loading.class.delay.longest="opacity-50">

                        <div class="mb-2">

                            <Label class="text-lg tracking-widest rounded-xl border-gray-500">Tipo de trámite</Label>

                        </div>

                        <div>

                            <select class="bg-white rounded text-sm w-full" wire:model.live="modelo_editar.tipo_tramite">

                                <option value="normal">Normal</option>
                                <option value="complemento">Complemento</option>
                                <option value="exento">Exento</option>

                            </select>

                        </div>

                        <div>

                            @error('modelo_editar.tipo_tramite') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                        </div>

                    </div>

                @endif

            </div>

            @if ($servicio['id'] == 292)

                <div class="bg-white p-4 rounded-lg space-y-2 mb-3 shadow-md" wire:loading.class.delay.longest="opacity-50">

                    <div class="mb-2">

                        <Label class="text-lg tracking-widest rounded-xl border-gray-500">Clave catastral</Label>

                    </div>

                    <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-2">

                        <input placeholder="Estado" type="number" class="bg-white rounded text-xs w-full" title="Estado" value="16" readonly>

                        <input title="Región" placeholder="Región" type="number" class="bg-white rounded text-xs w-full  @error('region_catastral') border-1 border-red-500 @enderror" wire:model="region_catastral">

                        <input title="Municipio" placeholder="Municipio" type="number" class="bg-white rounded text-xs w-full @error('municipio') border-1 border-red-500 @enderror" wire:model="municipio">

                        <input title="Zona" placeholder="Zona" type="number" class="bg-white rounded text-xs w-full @error('zona_catastral') border-1 border-red-500 @enderror" wire:model="zona_catastral">

                        <input title="Localidad" placeholder="Localidad" type="number" class="bg-white rounded text-xs w-full @error('localidad') border-1 border-red-500 @enderror" wire:model="localidad">

                        <input title="Sector" placeholder="Sector" type="number" class="bg-white rounded text-xs w-full @error('sector') border-1 border-red-500 @enderror" wire:model="sector">

                        <input title="Manzana" placeholder="Manzana" type="number" class="bg-white rounded text-xs w-full @error('manzana') border-1 border-red-500 @enderror" wire:model="manzana">

                        <input title="Predio" placeholder="Predio" type="number" class="bg-white rounded text-xs w-full @error('predio') border-1 border-red-500 @enderror" wire:model="predio">

                        <input title="Edificio" placeholder="Edificio" type="number" class="bg-white rounded text-xs w-full @error('edificio') border-1 border-red-500 @enderror" wire:model="edificio">

                        <input title="Departamento" placeholder="Departamento" type="number" class="bg-white rounded text-xs w-full @error('departamento') border-1 border-red-500 @enderror" wire:model="departamento">

                    </div>

                    <div>

                        @error('predioAvaluo') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                    </div>

                    <div class="text-right">

                        <button
                            wire:click="buscarPredio"
                            wire:loading.attr="disabled"
                            wire:target="buscarPredio"
                            type="button"
                            class="bg-blue-400  hover:shadow-lg text-white font-bold px-4 py-2 rounded text-sm hover:bg-blue-700 focus:outline-none items-center w-fit">
                            <img wire:loading wire:target="buscarPredio" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">
                            <p class="mr-1"> Buscar</p>
                        </button>

                    </div>

                </div>

            @endif

            @if ($flags['observaciones'])

                <div class="bg-white p-4 rounded-lg space-y-2 mb-3 shadow-md" wire:loading.class.delay.longest="opacity-50">

                    <div class="flex-auto ">

                        <div class="mb-2">

                            <Label class="text-lg tracking-widest rounded-xl border-gray-500">Observaciones</Label>

                        </div>

                        <div>

                            <textarea rows="5" wire:model.blur="modelo_editar.observaciones" class="bg-white rounded text-sm w-full" placeholder="Se lo mas especifico posible acerca de porque se genera el trámite."></textarea>

                        </div>

                        <div>

                            @error('modelo_editar.observaciones') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                        </div>

                    </div>

                </div>

            @endif

        @endif

        <div wire:loading.flex class="flex absolute top-1 right-1 items-center">
            <svg class="animate-spin h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>

    </div>

    <div>

        @if($tramite)

            <div class="bg-white p-3 rounded-lg  shadow-md">

                <h1 class="text-lg tracking-widest rounded-xl border-gray-500 text-center mb-5">Trámite</h1>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-2">

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <p><strong>Folio:</strong> {{ $tramite->folio }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <p><strong>Estado:</strong> {{ Str::ucfirst($tramite->estado) }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <p><strong>Categoría:</strong> {{ $tramite->servicio->categoria->nombre }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <p><strong>Servicio:</strong> {{ $tramite->servicio->nombre }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <p><strong>Tipo de trámite:</strong> {{ Str::ucfirst($tramite->tipo_tramite) }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <p><strong>Tipo de servicio:</strong> {{ Str::ucfirst($tramite->tipo_servicio) }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <p><strong>Cantidad:</strong> {{ $tramite->cantidad }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <p><strong>Solicitante:</strong>{{ $tramite->solicitante }} / {{ $tramite->nombre_solicitante }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <p><strong>Fecha de entrega:</strong> {{ $tramite->fecha_entrega?->format('d-m-Y') }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <p><strong>Monto:</strong> ${{ number_format($tramite->monto, 2) }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <p><strong>Orden de pago:</strong> {{ $tramite->orden_de_pago }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <p><strong>Linea de captura:</strong> {{ $tramite->linea_de_captura }}</p>

                    </div>

                    @if($tramite->fecha_pago)

                        <div class="rounded-lg bg-gray-100 py-1 px-2">

                            <p><strong>Fecha de pago:</strong> {{ $tramite->fecha_pago->format('d-m-Y') }}</p>

                        </div>

                    @endif

                    @if($tramite->folio_pago)

                        <div class="rounded-lg bg-gray-100 py-1 px-2">

                            <p><strong>Folio de pago:</strong> {{ $tramite->folio_pago }}</p>

                        </div>

                    @endif



                    @if($tramite->adiciona)

                        <div class="rounded-lg bg-gray-100 py-1 px-2">

                            <p><strong>Adiciona al trámite:</strong> {{ $tramite->adicionaA->folio }}</p>

                        </div>

                    @endif

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2 my-3">

                    <strong>Observaciones:</strong>

                    <p>{{ $tramite->observaciones }}</p>

                </div>

                <div class="mt-4 text-right space-x-4">

                    @if ($tramite->estado == 'nuevo')

                        <button
                            wire:click="editar"
                            wire:loading.attr="disabled"
                            wire:target="editar"
                            type="button"
                            class="bg-green-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded text-sm hover:bg-green-700 focus:outline-none ">
                            <img wire:loading wire:target="editar" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">
                            Editar
                        </button>

                        <button
                            wire:click="reimprimir"
                            wire:loading.attr="disabled"
                            wire:target="reimprimir"
                            type="button"
                            class="bg-blue-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded text-sm hover:bg-blue-700 focus:outline-none ">
                            <img wire:loading wire:target="reimprimir" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">
                            Reimprimir
                        </button>

                    @endif

                </div>

            </div>

        @else

            <div class="bg-white p-3 rounded-lg  shadow-md">

                <h1 class="text-lg tracking-widest rounded-xl border-gray-500 text-center mb-5">Trámite Nuevo</h1>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-2">

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <p><strong>Categoría:</strong> {{ $this->servicio['categoria']['nombre'] }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <p><strong>Servicio:</strong> {{ $servicio['nombre'] }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <p><strong>Tipo de trámite:</strong> {{ Str::ucfirst($modelo_editar->tipo_tramite) }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <p><strong>Tipo de servicio:</strong> {{ Str::ucfirst($modelo_editar->tipo_servicio) }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <p><strong>Cantidad:</strong> {{ $modelo_editar->cantidad }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <p><strong>Solicitante:</strong>{{ $modelo_editar->solicitante }} / {{ $modelo_editar->nombre_solicitante }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <p><strong>Monto:</strong>${{ number_format($modelo_editar->monto, 2) }}</p>

                    </div>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2 my-3">

                    <strong>Observaciones:</strong>

                    <p>{{ $modelo_editar->observaciones }}</p>

                </div>

                <div class="mt-4 text-right">

                    @if ($editar)

                            <button
                                wire:click="actualizar"
                                wire:loading.attr="disabled"
                                wire:target="actualizar"
                                type="button"
                                class="bg-blue-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded text-sm hover:bg-blue-700 focus:outline-blue-400 focus:outline-offset-2">
                                <img wire:loading wire:target="actualizar" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">
                                Actualizar trámite
                            </button>

                        @else

                            <button
                                wire:click="crear"
                                wire:loading.attr="disabled"
                                wire:target="crear"
                                type="button"
                                class="bg-blue-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded text-sm hover:bg-blue-700 focus:outline-blue-400 focus:outline-offset-2">
                                <img wire:loading wire:target="crear" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">
                                Crear nuevo trámite
                            </button>

                        @endif

                </div>

            </div>

        @endif

    </div>

</div>

<script>

    document.addEventListener('select2', function(){

        $('.select2').select2({
            placeholder: "Número de control",
            width: '100%',
        })

        $('.select2').val(@this.tramiteAdicionadoSeleccionado);
        $('.select2').trigger('change');

        $('.select2').on('change', function(){
            @this.set('tramiteAdicionadoSeleccionado', $(this).val())
        })

        $('.select2').on("keyup", function(e) {
            if (e.keyCode === 13){
                @this.set('tramiteAdicionadoSeleccionado', $('.select2').val())
            }
        });

    });

</script>


