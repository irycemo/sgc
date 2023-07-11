@push('styles')

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@endpush

<div>

    <h1 class="text-3xl tracking-widest py-3 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-thin mb-6  bg-white">Ventanilla</h1>

    {{ $errors }}

    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

        <div>

            <div class="flex-row lg:flex lg:space-x-3">

                <div class="flex-auto bg-white p-3 rounded-lg mb-3 shadow-md">

                    <div class="mb-2">

                        <Label class="text-lg tracking-widest rounded-xl border-gray-500">Categoría</Label>

                    </div>

                    <div>

                        <select class="bg-white rounded text-sm w-full" wire:model="categoria_select">

                            <option selected value="">Selecciona una opción</option>

                            @foreach ($categorias as $item)

                                <option value="{{ $item }}">{{ $item->nombre }}</option>

                            @endforeach

                        </select>

                    </div>

                    <div>

                        @error('categoria_select') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                    </div>

                </div>

                @if($this->categoria != "")

                    <div class="bg-white p-3 rounded-lg space-y-2 mb-3 shadow-md">

                        <div class="">

                            <div class="mb-2">

                            <Label class="text-lg tracking-widest rounded-xl border-gray-500">Servicio</Label>

                            </div>

                            <div>

                                <select class="bg-white rounded text-sm w-full" wire:model="servicio_select">

                                    <option selected value="">Selecciona una opción</option>

                                    @foreach ($servicios as $item)

                                        <option value="{{ $item }}">{{ $item->nombre }}</option>

                                    @endforeach

                                </select>

                            </div>

                            <div>

                                @error('servicio_select') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                            </div>

                        </div>

                    </div>

                @endif

            </div>

            <div>

                @if ($flags['adiciona'])

                    <div class="flex space-x-3 bg-white p-4 rounded-lg mb-3 shadow-md">

                        <div class="flex space-x-4 items-center">

                            <Label>¿Adiciona a otro trámite?</Label>

                            <x-checkbox wire:model="adicionaTramite"></x-checkbox>

                        </div>

                        @if($adicionaTramite)

                            <div class="flex-auto mr-1 ">

                                <div class="flex space-x-4 items-center">

                                    <Label>Seleccione el trámite</Label>

                                </div>

                                <div class="" wire:ignore>

                                    <select class="select2 bg-white rounded text-sm w-full  z-50" wire:model="tramiteAdiciona">

                                        @foreach ($tramitesAdiciones as $item)

                                            <option value="{{ $item }}">{{ $item->folio }}</option>

                                        @endforeach

                                    </select>

                                </div>

                            </div>

                        @endif

                        <div class="">

                            @error('tramiteAdicionaSelected') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                        </div>

                    </div>

                @endif

            </div>

            <div class="flex-row lg:flex lg:space-x-3">

                @if ($flags['flag_tipo_de_tramite'])

                    <div class="flex-auto bg-white p-4 rounded-lg mb-3 shadow-md">

                        <div class="mb-2">

                            <Label class="text-lg tracking-widest rounded-xl border-gray-500">Tipo de trámite</Label>

                        </div>

                        <div>

                            <select class="bg-white rounded text-sm w-full" wire:model="modelo_editar.tipo_tramite">

                                <option value="normal">Normal</option>
                                <option value="complemento">Complemento</option>
                                <option value="exento">Exento</option>
                                <option value="porcentaje">Porcentaje</option>
                                <option value="parcial">Parcial</option>

                            </select>

                        </div>

                        <div>

                            @error('modelo_editar.tipo_tramite') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                        </div>

                    </div>

                @endif

                @if ($flags['flag_tipo_de_servicio'])

                    <div class="flex-auto bg-white p-4 rounded-lg mb-3 shadow-md">

                        <div class="mb-2">

                            <Label class="text-lg tracking-widest rounded-xl border-gray-500">Tipo de servicio</Label>

                        </div>

                        <div>

                            <select class="bg-white rounded text-sm w-full" wire:model="modelo_editar.tipo_servicio">

                                <option value="ordinario">Ordinario</option>
                                <option value="urgente">Urgente</option>
                                <option value="extra_urgente">Extra urgente</option>

                            </select>

                        </div>

                        <div>

                            @error('modelo_editar.tipo_servicio') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                        </div>

                    </div>

                @endif

                @if ($flags['cantidad'])

                    <div class="flex-auto bg-white p-4 rounded-lg mb-3 shadow-md">

                        <div class="mb-2">

                            <Label class="text-lg tracking-widest rounded-xl border-gray-500">Cantidad</Label>

                        </div>

                        <div>

                            <input type="number" min="1" class="bg-white rounded text-sm w-full" wire:model.lazy="modelo_editar.cantidad" @if($flags['predios']) readonly @endif>

                        </div>

                        <div>

                            @error('modelo_editar.cantidad') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                        </div>

                    </div>

                @endif

                @if ($flags['importe_base'])

                    <div class="flex-auto bg-white p-4 rounded-lg mb-3 shadow-md">

                        <div class="mb-2">

                            <Label class="text-lg tracking-widest rounded-xl border-gray-500">Importe Base</Label>

                        </div>

                        <div>

                            <input type="number" min="1" class="bg-white rounded text-sm w-full" wire:model.lazy="importe_base">

                        </div>

                        <div>

                            @error('importe_base') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                        </div>

                    </div>

                @endif

                @if ($flags['angulo'])

                    <div class="flex-auto bg-white p-4 rounded-lg mb-3 shadow-md">

                        <div class="mb-2">

                            <Label class="text-lg tracking-widest rounded-xl border-gray-500">Pendiente</Label>

                        </div>

                        <div>

                            <select class="bg-white rounded text-sm w-full" wire:model.lazy="angulo">

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

            </div>

            @if ($flags['solicitante'])

                <div class="bg-white p-4 rounded-lg space-y-2 mb-3 shadow-md">

                    <div class="flex-auto ">

                        <div class="mb-2">

                            <Label class="text-lg tracking-widest rounded-xl border-gray-500">Solicitante</Label>

                        </div>

                        <div>

                            <input type="text" class="bg-white rounded text-sm w-full" wire:model.lazy="modelo_editar.solicitante">

                        </div>

                        <div>

                            @error('modelo_editar.solicitante') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                        </div>

                    </div>

                </div>

            @endif

            @if ($flags['solicitante'])

                <div class="bg-white p-4 rounded-lg space-y-2 mb-3 shadow-md">

                    <div class="flex-auto ">

                        <div class="mb-2">

                            <Label class="text-lg tracking-widest rounded-xl border-gray-500">Avaluo para</Label>

                        </div>

                        <div>

                            <select class="bg-white rounded text-sm w-full" wire:model.lazy="modelo_editar.avaluo_para">

                                <option value="" selected>Seleccione una opción</option>
                                <option value="46">Variación Catastral</option>
                                <option value="43">Avaluos de desglose de fraccionamientos, condominios, conjuntos habitacionales y subdivisiones</option>
                                <option value="44">Avaluos de desglose de cualquier otro tipo de inmueble</option>
                                <option value="">Avaluos de actualización</option>
                                <option value="">Avaluos de fusión</option>
                                <option value="">Avaluos de cambio de régimen</option>

                            </select>

                        </div>

                        <div>

                            @error('modelo_editar.avaluo_para') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                        </div>

                    </div>

                </div>

            @endif

            @if ($flags['predios'])

                <div class="bg-white p-4 rounded-lg space-y-2 mb-3 shadow-md">

                    <div class="flex-auto ">

                        <div class="mb-2">

                            <Label class="text-lg tracking-widest rounded-xl border-gray-500">Cuentas prediales involucradas</Label>

                        </div>

                        <div>

                            <div class="flex-row lg:flex lg:space-x-2 items-start justify-between ">

                                <div>

                                    <input placeholder="Localidad" type="number" class="bg-white rounded text-sm w-full" wire:model.defer="localidad">

                                    <div>

                                        @error('localidad') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                                    </div>


                                </div>

                                <div>

                                    <input placeholder="Oficina rentistica" type="number" class="bg-white rounded text-sm w-full" wire:model.defer="oficina" @if(auth()->user()->oficina != 101) readonly @endif>

                                    <div>

                                        @error('oficina') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                                    </div>

                                </div>

                                <div>

                                    <input placeholder="Tipo de predio" type="number" class="bg-white rounded text-sm w-full" wire:model.defer="tipo">

                                    <div>

                                        @error('tipo') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                                    </div>


                                </div>

                                <div>

                                    <input placeholder="Número de registro" type="number" class="bg-white rounded text-sm w-full" wire:model.defer="registro">

                                    <div>

                                        @error('registro') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                                    </div>

                                </div>

                                <button
                                    wire:click="buscarPredio"
                                    wire:loading.attr="disabled"
                                    wire:target="buscarPredio"
                                    type="button"
                                    class="bg-blue-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded text-sm hover:bg-blue-700 focus:outline-none flex items-center w-fit">
                                    <img wire:loading wire:target="buscarPredio" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">
                                    <p class="mr-1"> Buscar</p>
                                </button>

                            </div>

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
                                    class="bg-green-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded text-sm hover:bg-green-700 focus:outline-none flex items-center w-fit">
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
                                                    <button
                                                        wire:click="quitarPredio({{ $item['id'] }})"
                                                        wire:loading.attr="disabled"
                                                        wire:target="quitarPredio({{ $item['id'] }})"
                                                        class="md:w-full bg-red-400 hover:shadow-lg text-white text-xs md:text-sm px-1 py-1 items-center rounded-full hover:bg-red-700 flex justify-center focus:outline-none"
                                                    >

                                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                        </svg>

                                                    </button>
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

                <div class="bg-white p-4 rounded-lg space-y-2 mb-3 shadow-md">

                    <div class="flex-auto ">

                        <div class="mb-2">

                            <Label class="text-lg tracking-widest rounded-xl border-gray-500">Observaciones</Label>

                        </div>

                        <div>

                            <textarea rows="5" wire:model.lazy="modelo_editar.observaciones" class="bg-white rounded text-sm w-full" placeholder="Se lo mas especifico posible acerca de porque se genera el trámite."></textarea>

                        </div>

                        <div>

                            @error('modelo_editar.observaciones') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                        </div>

                    </div>

                </div>

            @endif

        </div>

        <div class="">

            <div class="bg-white p-3 rounded-lg text-center shadow-md mb-3">

                <div class="mb-2">

                    <Label class="text-lg tracking-widest rounded-xl border-gray-500">Buscar trámite</Label>

                </div>

                <div class="flex lg:w-1/2 mx-auto">

                    <input type="number" placeholder="Número de trámite" min="1" class="bg-white rounded-l text-sm w-full focus:ring-0" wire:model.defer="tramite_folio">

                    <button
                        wire:click="buscarTramite"
                        wire:loading.attr="disabled"
                        wire:target="buscarTramite"
                        type="button"
                        class="bg-blue-400 hover:shadow-lg text-white font-bold px-4 rounded-r text-sm hover:bg-blue-700 focus:outline-none ">

                        <img wire:loading wire:target="buscarTramite" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">
                        <svg wire:loading.remove wire:target="buscarTramite" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>
                    </button>

                </div>

            </div>

            @if($modelo_editar->servicio_id)

                <div class="bg-white p-3 rounded-lg  shadow-md">

                    <h1 class="text-lg tracking-widest rounded-xl border-gray-500 text-center mb-5">Trámite Nuevo</h1>

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-2">

                        <div class="rounded-lg bg-gray-100 py-1 px-2">

                            <p><strong>Categoría:</strong> {{ $this->categoria['nombre'] }}</p>

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

                            <p><strong>Solicitante:</strong> {{ $modelo_editar->solicitante }}</p>

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

                            <p><strong>Solicitante:</strong> {{ $tramite->solicitante }}</p>

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

            @endif

        </div>

    </div>
</div>

@push('scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>


    <script>

        window.addEventListener('imprimir_recibo', event => {

            const tramite = event.detail.tramite;

            var url_orden = "{{ route('tramites.orden', '')}}" + "/" + tramite;

            window.open(url_orden, '_blank');

        });

        document.addEventListener('select2', function(){

            $('.select2').select2({
                placeholder: "Número de control",
                width: '100%',
            })

            $('.select2').val(@this.tramiteAdiciona);
            $('.select2').trigger('change');

            $('.select2').on('change', function(){
                @this.set('tramiteAdiciona', $(this).val())
            })

            $('.select2').on("keyup", function(e) {
                if (e.keyCode === 13){
                    @this.set('tramiteAdiciona', $('.select2').val())
                }
            });

        });

    </script>

@endpush
