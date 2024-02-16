<div>

    <div class="mb-6">

        <h1 class="text-3xl tracking-widest py-3 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-thin mb-6  bg-white">Trámites</h1>

        <div class="flex  w-full gap-2">

            <select class="bg-white rounded-full text-sm" wire:model.live="filters.año">

                @foreach ($años as $año)

                    <option value="{{ $año }}">{{ $año }}</option>

                @endforeach

            </select>

            <input type="number" wire:model.live.debounce.500mse="filters.folio" placeholder="Folio" class="bg-white rounded-full text-sm w-24">

            <select class="bg-white rounded-full text-sm" wire:model.live="filters.tipoTramite">

                <option value="" selected>Tipo de trámtie</option>
                <option value="parcial">Parcial</option>
                <option value="exento">Exento</option>
                <option value="complemento">Complemento</option>
                <option value="normal">Normal</option>

            </select>

            <select class="bg-white rounded-full text-sm w-60" wire:model.live="filters.servicio">

                <option value="" selected>Servicio</option>

                @foreach ($servicios as $servicio)

                    <option value="{{ $servicio->id }}" class="truncate">{{ $servicio->nombre }}</option>

                @endforeach

            </select>

            <input type="text" wire:model.live.debounce.500ms="filters.search" placeholder="Solicitante" class="bg-white rounded-full text-sm">

            <select class="bg-white rounded-full text-sm" wire:model.live="pagination">

                <option value="10">10</option>
                <option value="25">25</option>
                <option value="50">50</option>
                <option value="100">100</option>

            </select>

        </div>

    </div>

    <div class="overflow-x-auto rounded-lg shadow-xl border-t-2 border-t-gray-500">

        <x-table>

            <x-slot name="head">

                <x-table.heading sortable wire:click="sortBy('año')" :direction="$sort === 'año' ? $direction : null" >Año</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('folio')" :direction="$sort === 'folio' ? $direction : null" >Folio</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('usuario')" :direction="$sort === 'usuario' ? $direction : null" >Usuario</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('estado')" :direction="$sort === 'estado' ? $direction : null" >Estado</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('tipo_tramite')" :direction="$sort === 'tipo_tramite' ? $direction : null" >Tipo de trámite</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('servicio_id')" :direction="$sort === 'servicio_id' ? $direction : null" >Servicio</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('solicitante')" :direction="$sort === 'solicitante' ? $direction : null" >Solicitante</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('cantidad')" :direction="$sort === 'cantidad' ? $direction : null" >Cantidad</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('monto')" :direction="$sort === 'monto' ? $direction : null" >Monto</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('fecha_entrega')" :direction="$sort === 'fecha_entrega' ? $direction : null" >Fecha de entrega</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('fecha_pago')" :direction="$sort === 'fecha_pago' ? $direction : null" >Fecha de pago</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('tipo_servicio')" :direction="$sort === 'tipo_servicio' ? $direction : null" >Tipo de servicio</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('created_at')" :direction="$sort === 'created_at' ? $direction : null">Registro</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('updated_at')" :direction="$sort === 'updated_at' ? $direction : null">Actualizado</x-table.heading>
                <x-table.heading >Acciones</x-table.heading>

            </x-slot>

            <x-slot name="body">

                @forelse ($tramites as $tramite)

                    <x-table.row wire:loading.class.delaylongest="opacity-50" wire:key="row-{{ $tramite->id }}">

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Año</span>

                            {{ $tramite->año }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Folio</span>

                            {{ $tramite->folio }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Usuario</span>

                            {{ $tramite->usuario }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Estado</span>

                            <span class="bg-{{ $tramite->estado_color }} py-1 px-2 rounded-full text-white text-xs">{{ ucfirst($tramite->estado) }}</span>

                        </x-table.cell>

                        <x-table.cell class="capitalize">

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Tipo de trámite</span>

                            {{ $tramite->tipo_tramite }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Servicio</span>

                            {{ $tramite->servicio->nombre }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Nombre del solicitante</span>

                            {{ $tramite->nombre_solicitante }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Cantidad</span>

                            {{ $tramite->cantidad }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Monto</span>

                            ${{ number_format($tramite->monto, 2) }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Fecha de entrega</span>

                            {{ $tramite->fecha_entrega->format('d-m-Y') }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Fecha de pago</span>

                            {{ $tramite->fecha_pago ? $tramite->fecha_pago->format('d-m-Y') : 'N/A'}}

                        </x-table.cell>

                        <x-table.cell class="capitalize">

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Tipo de servicio</span>

                            {{ $tramite->tipo_servicio }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Registrado</span>


                            <span class="font-semibold">@if($tramite->creadoPor != null)Registrado por: {{$tramite->creadoPor->name}} @else Registro: @endif</span> <br>

                            {{ $tramite->created_at }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="font-semibold">@if($tramite->actualizadoPor != null)Actualizado por: {{$tramite->actualizadoPor->name}} @else Actualizado: @endif</span> <br>

                            {{ $tramite->updated_at }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Acciones</span>

                            <div class="flex flex-col justify-center lg:justify-start gap-2">

                                <x-button-green
                                    wire:click="abrirModalVer({{ $tramite->id }})"
                                    wire:loading.attr="disabled"
                                >

                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    </svg>

                                    <span>Ver</span>

                                </x-button-green>

                                @can('Editar trámite')

                                    <x-button-blue
                                        wire:click="abrirModalEditar({{ $tramite->id }})"
                                        wire:loading.attr="disabled"
                                    >
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4 mr-2">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>

                                        <span>Editar</span>

                                    </x-button-blue>

                                @endcan

                            </div>

                        </x-table.cell>

                    </x-table.row>

                @empty

                    <x-table.row>

                        <x-table.cell colspan="15">

                            <div class="bg-white text-gray-500 text-center p-5 rounded-full text-lg">

                                No hay resultados.

                            </div>

                        </x-table.cell>

                    </x-table.row>

                @endforelse

            </x-slot>

            <x-slot name="tfoot">

                <x-table.row>

                    <x-table.cell colspan="15" class="bg-gray-50">

                        {{ $tramites->links()}}

                    </x-table.cell>

                </x-table.row>

            </x-slot>

        </x-table>

    </div>

    <x-dialog-modal wire:model.live="modal">

        <x-slot name="title">
                Editar Trámite
        </x-slot>

        <x-slot name="content">

            <div class="relative p-1">

                <div class="flex flex-col md:flex-row justify-between md:space-x-3 mb-5">

                    <x-input-group for="modelo_editar.solicitante" label="Solicitante" :error="$errors->first('modelo_editar.solicitante')" class="w-full">

                        <x-input-text id="modelo_editar.solicitante" wire:model="modelo_editar.solicitante" />

                    </x-input-group>

                    <x-input-group for="modelo_editar.estado" label="Estado" :error="$errors->first('modelo_editar.estado')" class="w-full">

                        <x-input-select id="modelo_editar.estado" wire:model="modelo_editar.estado" class="w-full">

                            <option value="">Seleccione una opción</option>
                            <option value="activo">Activo</option>
                            <option value="inactivo">Inactivo</option>

                        </x-input-select>

                    </x-input-group>

                </div>

                @if($modelo_editar->predios->count())

                    <div class="flex flex-col md:flex-row justify-between md:space-x-3 mb-5">

                        <div class="flex-auto ">

                            <div>

                                <Label class="text-base">Cuentas prediales involucradas</Label>

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
                                        class="bg-blue-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded text-sm hover:bg-blue-700 focus:outline-none flex items-center w-fit">
                                        <img wire:loading wire:target="buscarPredio" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">
                                        <p class="mr-1"> Buscar</p>
                                    </button>

                                </div>

                                @if($predio)

                                    <div class="text-sm my-3 flex items-center justify-between bg-gray-100 rounded-lg p-3">

                                        <div>

                                            <p><strong>Propietario:</strong> {{ $predio->primerPropietario }}</p>

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

                                                        <td class="px-2 w-1/4">
                                                            <span class="rounded-full px-1 text-white @if($item->pivot->estado === 'A') bg-green-500 @else bg-gray-500 @endif">{{ $item->pivot->estado }}</span>
                                                            {{ $item->cuentaPredial() }}
                                                        </td>
                                                        <td class="px-2">
                                                            <p>{{ $item->primerPropietario() }}</p>
                                                            <p>{{ $item['nombre_vialidad'] }}, #{{ $item['numero_exterior'] }}</p>
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

                            <div>

                                @error('predios') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                            </div>

                        </div>

                    </div>

                @endif

                <div class="flex flex-col md:flex-row justify-between md:space-x-3 mb-5">

                    <x-input-group for="modelo_editar.observaciones" label="Observaciones" :error="$errors->first('modelo_editar.observaciones')" class="w-full">

                        <textarea rows="5" wire:model.blur="modelo_editar.observaciones" class="bg-white rounded text-sm w-full" placeholder="Se lo mas especifico posible acerca de porque se genera el trámite."></textarea>

                    </x-input-group>

                </div>

                <div class="h-full w-full rounded-lg bg-gray-200 bg-opacity-75 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2" wire:loading.delay.longer>

                    <img class="mx-auto h-16" src="{{ asset('storage/img/loading.svg') }}" alt="">

                </div>

            </div>

        </x-slot>

        <x-slot name="footer">

            <div class="flex gap-3">

                <x-button-blue
                    wire:click="actualizar"
                    wire:loading.attr="disabled"
                    wire:target="actualizar">

                    <img wire:loading wire:target="actualizar" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                    Actualizar
                </x-button-blue>

                <x-button-red
                    wire:click="resetearTodo"
                    wire:loading.attr="disabled"
                    wire:target="resetearTodo">
                    Cerrar
                </x-button-red>

            </div>

        </x-slot>

    </x-dialog-modal>

    <x-dialog-modal wire:model.live="modalVer">

        <x-slot name="title">

            <h1 class="text-lg tracking-widest rounded-xl border-gray-500 text-center mb-5">Trámite</h1>

        </x-slot>

        <x-slot name="content">

            <div class="">

                @if ($modelo_editar->id)

                    <div class="grid grid-cols-1 lg:grid-cols-2 gap-2">

                        <div class="rounded-lg bg-gray-100 py-1 px-2">

                            <p><strong>Folio:</strong> {{ $modelo_editar->año }}-{{ $modelo_editar->folio }}</p>

                        </div>

                        <div class="rounded-lg bg-gray-100 py-1 px-2">

                            <p><strong>Estado:</strong> {{ Str::ucfirst($modelo_editar->estado) }}</p>

                        </div>

                        <div class="rounded-lg bg-gray-100 py-1 px-2">

                            <p><strong>Categoría:</strong> {{ $modelo_editar->servicio->categoria->nombre }}</p>

                        </div>

                        <div class="rounded-lg bg-gray-100 py-1 px-2">

                            <p><strong>Servicio:</strong> {{ $modelo_editar->servicio->nombre }}</p>

                        </div>

                        <div class="rounded-lg bg-gray-100 py-1 px-2">

                            <p><strong>Tipo de servicio:</strong> {{ Str::ucfirst($modelo_editar->tipo_servicio) }}</p>

                        </div>

                        <div class="rounded-lg bg-gray-100 py-1 px-2">

                            <p><strong>Solicitante:</strong>{{ $modelo_editar->solicitante }}</p>

                        </div>

                        @if ($modelo_editar->numero_oficio)

                            <div class="rounded-lg bg-gray-100 py-1 px-2">

                                <p><strong>Número de oficio:</strong> {{ $modelo_editar->numero_oficio }}</p>

                            </div>

                        @endif

                        @if ($modelo_editar->cantidad)

                            <div class="rounded-lg bg-gray-100 py-1 px-2">

                                <p><strong>Cantidad:</strong> {{ $modelo_editar->cantidad }}</p>

                            </div>

                        @endif

                        @if ($modelo_editar->usados)

                            <div class="rounded-lg bg-gray-100 py-1 px-2">

                                <p><strong>Usados:</strong> {{ $modelo_editar->usados }}</p>

                            </div>

                        @endif

                        @if ($modelo_editar->avaluo_para)

                            <div class="rounded-lg bg-gray-100 py-1 px-2">

                                <p><strong>Avalúo para:</strong> {{ $modelo_editar->avaluoPara->nombre }}</p>

                            </div>

                        @endif

                        @if ($modelo_editar->fecha_entrega)

                            <div class="rounded-lg bg-gray-100 py-1 px-2">

                                <p><strong>Fecha de entrega:</strong> {{ $modelo_editar->fecha_entrega->format('d-m-Y') }}</p>

                            </div>

                        @endif

                        @if ($modelo_editar->fecha_pago)

                            <div class="rounded-lg bg-gray-100 py-1 px-2">

                                <p><strong>Fecha de pago:</strong> {{ $modelo_editar->fecha_pago }}</p>

                            </div>

                        @endif

                        @if ($modelo_editar->fecha_vencimiento)

                            <div class="rounded-lg bg-gray-100 py-1 px-2">

                                <p><strong>Fecha de vencimiento:</strong> {{ $modelo_editar->fecha_vencimiento }}</p>

                            </div>

                        @endif

                        <div class="rounded-lg bg-gray-100 py-1 px-2">

                            <p><strong>Orden de pago:</strong> {{ $modelo_editar->orden_de_pago }}</p>

                        </div>

                        <div class="rounded-lg bg-gray-100 py-1 px-2">

                            <p><strong>Linea de captura:</strong> {{ $modelo_editar->linea_de_captura }}</p>

                        </div>

                        <div class="rounded-lg bg-gray-100 py-1 px-2">

                            <p><strong>Registrado por:</strong> {{ $modelo_editar->creadoPor?->name }} el {{ $modelo_editar->created_at }}</p>

                        </div>

                    </div>

                    @if($modelo_editar->predios()->count() > 0)

                        <div class="flex justify-center mt-3">
                            <span class="col-span-1 lg:col-span-2">Cuentas prediales</span>
                        </div>

                        <ul class="rounded-lg bg-gray-100 my-3 list-disc flex gap-2">

                            @foreach ($modelo_editar->predios as $predio)

                                    <li class="ml-5">{{ $predio->cuentaPredial() }} </li>

                            @endforeach

                        </ul>

                    @endif

                    @if ($modelo_editar->observaciones)

                        <div class="rounded-lg bg-gray-100 py-1 px-2 my-3">

                            <strong>Observaciones:</strong>

                            <p>{{ $modelo_editar->observaciones }}</p>

                        </div>

                    @endif

                    @if($modelo_editar->adicionaA?->count())

                        <div class="rounded-lg bg-gray-100 py-1 px-2 my-3">

                            <p>Adiciona a:</p>

                            <div class="flex space-x-2 flex-row">

                                <p><strong>NC:</strong>{{ $modelo_editar->adicionaA->folio }}</p>

                            </div>

                        </div>

                    @endif

                @endif

            </div>

        </x-slot>

        <x-slot name="footer">

        </x-slot>

    </x-dialog-modal>

    <x-confirmation-modal wire:model.live="modalBorrar" maxWidth="sm">

        <x-slot name="title">
            Eliminar Servicio
        </x-slot>

        <x-slot name="content">
            ¿Esta seguro que desea eliminar al servicio? No sera posible recuperar la información.
        </x-slot>

        <x-slot name="footer">

            <x-secondary-button
                wire:click="$toggle('modalBorrar')"
                wire:loading.attr="disabled"
            >
                No
            </x-secondary-button>

            <x-danger-button
                class="ml-2"
                wire:click="borrar()"
                wire:loading.attr="disabled"
                wire:target="borrar"
            >
                Borrar
            </x-danger-button>

        </x-slot>

    </x-confirmation-modal>

</div>
