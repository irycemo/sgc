<div class="grid grid-cols-1 md:grid-cols-2 gap-3">

    <div>
        {{ $errors }}
        @if(!$tramite)

            <div>

                @if ($flags['adiciona'])

                    <div class="flex space-x-3 bg-white p-4 rounded-lg mb-3 shadow-md relative" wire:loading.class.delay.longest="opacity-50">

                        <div class="flex space-x-4 items-center">

                            <Label>¿Adiciona a otro trámite?</Label>

                            <x-checkbox wire:model.live="adicionaTramite"></x-checkbox>

                        </div>

                        @if($adicionaTramite)

                            <div class="flex-auto mr-1">

                                <div class="flex space-x-4 items-center">

                                    <Label>Seleccione el trámite</Label>

                                </div>

                                <div class="" wire:ignore>

                                    <select class="select2 bg-white rounded text-sm w-full z-50" wire:model.live="tramiteAdicionadoSeleccionado">

                                        @foreach ($tramitesAdicionados as $item)

                                            <option value="{{ $item }}">{{ $item->folio }}</option>

                                        @endforeach

                                    </select>

                                </div>

                            </div>

                        @endif

                        <div class="">

                            @error('tramiteAdicionado') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                        </div>

                        <div wire:loading.flex class="flex absolute top-1 right-1 items-center">
                            <svg class="animate-spin h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                            </svg>
                        </div>

                    </div>

                @endif

            </div>

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

                @if ($flags['cantidad'])

                    <div class="flex-auto bg-white p-4 rounded-lg mb-3 shadow-md " wire:loading.class.delay.longest="opacity-50">

                        <div class="mb-2">

                            <Label class="text-lg tracking-widest rounded-xl border-gray-500">Cantidad</Label>

                        </div>

                        <div>

                            <input type="number" min="1" class="bg-white rounded text-sm w-full" wire:model.blur="modelo_editar.cantidad" readonly>

                        </div>

                        <div>

                            @error('modelo_editar.cantidad') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                        </div>

                    </div>

                @endif

                @if ($flags['angulo'])

                    <div class="flex-auto bg-white p-4 rounded-lg mb-3 shadow-md" wire:loading.class.delay.longest="opacity-50">

                        <div class="mb-2">

                            <Label class="text-lg tracking-widest rounded-xl border-gray-500">Pendiente</Label>

                        </div>

                        <div>

                            <select class="bg-white rounded text-sm w-full" wire:model.live="angulo">

                                <option value="" selected>Selecciona una opción</option>
                                <option value="min">16° a 45°</option>
                                <option value="max">Mayor a 45°</option>
                            </select>

                        </div>

                        <div>

                            @error('angulo') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                        </div>

                    </div>

                @endif

                @if($flags['numero_oficio'])

                    <div class="flex-auto bg-white p-4 rounded-lg mb-3 shadow-md" wire:loading.class.delay.longest="opacity-50">

                        <div class="mb-2">

                            <Label class="text-lg tracking-widest rounded-xl border-gray-500">Número de oficio</Label>
                        </div>

                        <div>

                            <input type="text" class="bg-white rounded text-sm w-full" wire:model.lazy="modelo_editar.numero_oficio">

                        </div>

                        <div>

                            @error('modelo_editar.numero_oficio') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                        </div>

                    </div>

                @endif

            </div>

            @if ($flags['predios'])

                <div class="bg-white p-4 rounded-lg space-y-2 mb-3 shadow-md" wire:loading.class.delay.longest="opacity-50">

                    <div class="flex-auto ">

                        <div class="mb-2">

                            <Label class="text-lg tracking-widest rounded-xl border-gray-500">Cuentas prediales involucradas</Label>

                        </div>

                        <div>

                            @if($this->modelo_editar->tipo_tramite != 'complemento')

                                <div class="flex-row lg:flex lg:space-x-2 items-start justify-between ">

                                    <div>

                                        <input placeholder="Localidad" type="number" class="bg-white rounded text-sm w-full" wire:model="localidad">

                                        <div>

                                            @error('localidad') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                                        </div>


                                    </div>

                                    <div>

                                        <input placeholder="Oficina rentistica" type="number" class="bg-white rounded text-sm w-full" wire:model="oficina" @if(auth()->user()->oficina->oficina != 101) readonly @endif>

                                        <div>

                                            @error('oficina') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                                        </div>

                                    </div>

                                    <div>

                                        <input placeholder="Tipo de predio" type="number" class="bg-white rounded text-sm w-full" wire:model="tipo">

                                        <div>

                                            @error('tipo') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                                        </div>


                                    </div>

                                    <div>

                                        <input placeholder="Número de registro" type="number" class="bg-white rounded text-sm w-full" wire:model="registro">

                                        <div>

                                            @error('registro') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                                        </div>

                                    </div>

                                    <button
                                        wire:click="buscarPredio"
                                        wire:loading.attr="disabled"
                                        wire:target="buscarPredio"
                                        type="button"
                                        class="bg-blue-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded text-sm hover:bg-blue-700 focus:outline-blue-400 focus:outline-offset-2 flex items-center w-fit">
                                        <img wire:loading wire:target="buscarPredio" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">
                                        <p class="mr-1"> Buscar</p>
                                    </button>

                                </div>

                            @endif

                        </div>

                        @if($predio)

                            <div class="text-sm my-3 flex items-center justify-between bg-gray-100 rounded-lg p-3">

                                <div>

                                    <p><strong>Propietario:</strong> {{ $predio->propietarios->first()->persona->nombre }} {{ $predio->propietarios->first()->persona->ap_paterno }} {{ $predio->propietarios->first()->persona->ap_materno }}</p>

                                    <p><strong>Ubicacion:</strong> {{ $predio->nombre_vialidad }} #{{ $predio->numero_exterior }}</p>

                                </div>

                                <button
                                    wire:click="agregarPredio"
                                    wire:loading.attr="disabled"
                                    wire:target="agregarPredio"
                                    type="button"
                                    class="bg-green-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded text-sm hover:bg-green-700 focus:outline-green-400 focus:outline-offset-2 flex items-center w-fit">
                                    <img wire:loading wire:target="agregarPredio" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">
                                    <p class="mr-1">Agregar</p>
                                </button>

                            </div>

                        @endif

                        @if($predios)

                            <div class="text-sm my-3 rounded-lg">

                                <table class="w-full rounded-lg">

                                    <thead class="text-left bg-gray-100">

                                        <tr>

                                            <th class="px-2">Cuenta predial</th>
                                            <th class="px-2">Propietario / Ubicación</th>
                                            <th class="px-2"></th>

                                        </tr>

                                    </thead>

                                    <tbody>

                                        @foreach ($predios as $item)

                                            <tr class="border-b py-1">

                                                <td class="px-2">{{ $item['localidad'] }}-{{ $item['oficina'] }}-{{ $item['tipo_predio'] }}-{{ $item['numero_registro'] }}</td>
                                                <td class="px-2">
                                                    <p>{{ $item['propietarios'][0]['persona']['nombre'] }} {{ $item['propietarios'][0]['persona']['ap_paterno'] }} {{ $item['propietarios'][0]['persona']['ap_materno'] }}</p>
                                                    <p>{{ $item['nombre_vialidad'] }} #{{ $item['numero_exterior'] }}</p>
                                                </td>
                                                <td class="px-2">
                                                    @if($this->modelo_editar->tipo_tramite != 'complemento')

                                                        <x-button-red
                                                            wire:click="quitarPredio({{ $item['id'] }})"
                                                            wire:loading.attr="disabled"
                                                            wire:target="quitarPredio({{ $item['id'] }})">

                                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4">
                                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                            </svg>

                                                        </x-button-red>
                                                    @endif
                                                </td>

                                            </tr>

                                        @endforeach

                                    </tbody>

                                </table>

                            </div>

                        @endif

                        <div>

                            @error('predios') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                        </div>

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

    </div>

    <div>

        @if($tramite)

            <div class="bg-white p-3 rounded-lg  shadow-md">

                <h1 class="text-lg tracking-widest rounded-xl border-gray-500 text-center mb-5">Trámite</h1>

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-2">

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <p><strong>Folio:</strong>{{ $tramite->año }}-{{ $tramite->folio }}-{{ $tramite->usuario }}</p>

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

                @if($tramite->predios->count() > 0)

                    <div class="text-sm my-3 rounded-lg">

                        <p class="mb-2"><strong class="text-base">Predios:</strong>

                        <table class="w-full rounded-lg">

                            <thead class="text-left bg-gray-100">

                                <tr>

                                    <th class="px-2">Cuenta predial</th>
                                    <th class="px-2">Propietario / Ubicación</th>

                                </tr>

                            </thead>

                            <tbody>

                                @foreach ($tramite->predios as $item)

                                    <tr class="border-b py-1">

                                        <td class="px-2">{{ $item['localidad'] }}-{{ $item['oficina'] }}-{{ $item['tipo_predio'] }}-{{ $item['numero_registro'] }}</td>
                                        <td class="px-2">
                                            <p>{{ $item['propietarios'][0]['persona']['nombre'] }} {{ $item['propietarios'][0]['persona']['ap_paterno'] }} {{ $item['propietarios'][0]['persona']['ap_materno'] }}</p>
                                            <p>{{ $item['nombre_vialidad'] }} #{{ $item['numero_exterior'] }}</p>
                                        </td>

                                    </tr>

                                @endforeach

                            </tbody>

                        </table>

                    </div>

                @endif

                <div class="mt-4 text-right space-x-4">

                    @if ($tramite->estado === 'nuevo')

                        <button
                            wire:click="validar"
                            wire:loading.attr="disabled"
                            wire:target="validar"
                            type="button"
                            class="bg-red-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded text-sm hover:bg-red-700 focus:outline-red-400 focus:outline-offset-2">
                            <img wire:loading wire:target="validar" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">
                            Validar pago
                        </button>

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
                                class="bg-blue-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded text-sm hover:bg-blue-700 focus:outline-none ">
                                <img wire:loading wire:target="actualizar" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">
                                Actualizar trámite
                            </button>

                        @else

                            <button
                                wire:click="crear"
                                wire:loading.attr="disabled"
                                wire:target="crear"
                                type="button"
                                class="bg-blue-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded text-sm hover:bg-blue-700 focus:outline-none ">
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


