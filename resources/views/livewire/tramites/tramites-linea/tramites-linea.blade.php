<div id="tramties">

    <div class="mb-2 lg:mb-5">

        <x-header>Trámites en línea</x-header>

        <div class="flex justify-between">

            <div class="flex gap-3 overflow-auto p-1">

                <select class="bg-white rounded-full text-sm" wire:model.live="filters.año">

                    @foreach ($años as $año)

                        <option value="{{ $año }}">{{ $año }}</option>

                    @endforeach

                </select>

                <input type="number" wire:model.live.debounce.500mse="filters.folio" placeholder="Folio" class="bg-white rounded-full text-sm w-24">

                <select class="bg-white rounded-full text-sm" wire:model.live="filters.estado">

                    <option value="" selected>Estado</option>
                    <option value="pagado" selected>Pagado</option>
                    <option value="concluido" selected>Concluido</option>

                </select>

                <select class="bg-white rounded-full text-sm w-60" wire:model.live="filters.mes">

                    <option value="" selected>Mes</option>
                    <option value="1" selected>Enero</option>
                    <option value="2" selected>Febrero</option>
                    <option value="3" selected>Marzo</option>
                    <option value="4" selected>Abril</option>
                    <option value="5" selected>Mayo</option>
                    <option value="6" selected>Junio</option>
                    <option value="7" selected>Julio</option>
                    <option value="8" selected>Agosto</option>
                    <option value="9" selected>Septiembre</option>
                    <option value="10" selected>Octubre</option>
                    <option value="11" selected>Noviembre</option>
                    <option value="12" selected>Diciembre</option>

                </select>

                <input type="text" wire:model.live.debounce.500ms="filters.search" placeholder="Solicitante" class="bg-white rounded-full text-sm">

                <select class="bg-white rounded-full text-sm w-fit" wire:model.live="pagination">

                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>

                </select>

            </div>

            <button wire:click="$set('modalCarga', '!modalCarga')" wire:loading.attr="disabled" class="bg-gray-500 hover:shadow-lg hover:bg-gray-700 text-sm py-2 px-4 text-white rounded-full hidden md:block items-center justify-center focus:outline-gray-400 focus:outline-offset-2">

                <img wire:loading wire:target="modalCarga" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">
                Imprimir carga de trabajo

            </button>

            <button wire:click="$set('modalCarga', '!modalCarga')" class="bg-gray-500 hover:shadow-lg hover:bg-gray-700 float-right text-sm py-2 px-4 text-white rounded-full focus:outline-none md:hidden">+</button>

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
                <x-table.heading sortable wire:click="sortBy('created_at')" :direction="$sort === 'created_at' ? $direction : null">Registro</x-table.heading>
                <x-table.heading>Acciones</x-table.heading>

            </x-slot>

            <x-slot name="body">

                @forelse ($this->tramites as $tramite)

                    <x-table.row wire:loading.class.delaylongest="opacity-50" wire:key="row-{{ $tramite->id }}">

                        <x-table.cell title="Año">

                            {{ $tramite->año }}

                        </x-table.cell>

                        <x-table.cell title="Folio">

                            {{ $tramite->folio }}

                        </x-table.cell>

                        <x-table.cell title="Usuario">

                            {{ $tramite->usuario }}

                        </x-table.cell>

                        <x-table.cell title="Estado">

                            <span class="bg-{{ $tramite->estado_color }} py-1 px-2 rounded-full text-white text-xs">{{ ucfirst($tramite->estado) }}</span>

                        </x-table.cell>

                        <x-table.cell title="Tipo de trámite">

                            {{ $tramite->tipo_tramite }}

                        </x-table.cell>

                        <x-table.cell title="Servicio">

                            {{ $tramite->servicio->nombre }}

                        </x-table.cell>

                        <x-table.cell title="Nombre del solicitante">

                            {{ $tramite->nombre_solicitante }}

                        </x-table.cell>

                        <x-table.cell title="Cantidad">

                            {{ $tramite->cantidad }}

                        </x-table.cell>

                        <x-table.cell title="Monto">

                            ${{ number_format($tramite->monto, 2) }}

                        </x-table.cell>

                        <x-table.cell title="Fecha de entrega">

                            {{ $tramite->fecha_entrega?->format('d-m-Y') }}

                        </x-table.cell>

                        <x-table.cell title="Fecha de pago">

                            {{ $tramite->fecha_pago ? $tramite->fecha_pago->format('d-m-Y') : 'N/A'}}

                        </x-table.cell>

                        <x-table.cell title="Registrado">

                            <span class="font-semibold">@if($tramite->creadoPor != null)Registrado por: {{$tramite->creadoPor->name}} @else Registro: @endif</span> <br>

                            {{ $tramite->created_at }}

                        </x-table.cell>

                        <x-table.cell title="Registrado">

                            <div class="ml-3 relative" x-data="{ open_drop_down:false }">

                                <div>

                                    <button x-on:click="open_drop_down=true" type="button" class="rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">

                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                        </svg>

                                    </button>

                                </div>

                                <div x-cloak x-show="open_drop_down" x-on:click="open_drop_down=false" x-on:click.away="open_drop_down=false" class="z-50 origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu">

                                    <button
                                        wire:click="abrirModal({{ $tramite->id }})"
                                        wire:target="abrirModal({{ $tramite->id }})"
                                        wire:loading.attr="disabled"
                                        class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                        role="menuitem">
                                        Ver predios
                                    </button>

                                </div>

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

                        {{ $this->tramites->links(data: ['scrollTo' => '#tramties'])}}

                    </x-table.cell>

                </x-table.row>

            </x-slot>

        </x-table>

    </div>

    <x-dialog-modal wire:model.live="modal" maxWidth="sm">

        <x-slot name="title">
            Predios asociados
        </x-slot>

        <x-slot name="content">

            @foreach ($modelo_editar->predios as $predio)

                <div class="rounded-lg bg-gray-100 py-1 px-2">

                    <p> {{ $predio->cuentaPredial() }}</p>

                </div>

            @endforeach

        </x-slot>

        <x-slot name="footer">

            <div class="flex gap-3">

                <x-button-red
                    wire:click="$toggle('modal')"
                    wire:loading.attr="disabled"
                    wire:target="$toggle('modal')">
                    Cerrar
                </x-button-red>

            </div>

        </x-slot>

    </x-dialog-modal>

    <x-dialog-modal wire:model.live="modalCarga" maxWidth="sm">

        <x-slot name="title">
            Carga de trabajo
        </x-slot>

        <x-slot name="content">

            <div class="flex flex-col md:flex-row justify-between md:space-x-3 mb-5">

                <div class="flex-auto ">

                    <div>

                        <Label>Fecha inicial</Label>
                    </div>

                    <div>

                        <input type="date" class="bg-white rounded text-sm w-full" wire:model="fecha_inicio">

                    </div>

                    <div>

                        @error('fecha_inicio') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                    </div>

                </div>

                <div class="flex-auto ">

                    <div>

                        <Label>Fecha final</Label>
                    </div>

                    <div>

                        <input type="date" class="bg-white rounded text-sm w-full" wire:model="fecha_final">

                    </div>

                    <div>

                        @error('fecha_final') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                    </div>

                </div>

            </div>

        </x-slot>

        <x-slot name="footer">

            <div class="flex gap-3">

                <x-button-blue
                    wire:click="imprimirCarga"
                    wire:loading.attr="disabled"
                    wire:target="imprimirCarga">

                    <img wire:loading wire:target="imprimirCarga" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                    <span>Imprimir</span>
                </x-button-blue>


                <x-button-red
                    wire:click="$toggle('modalCarga')"
                    wire:loading.attr="disabled"
                    wire:target="$toggle('modalCarga')">
                    Cerrar
                </x-button-red>

            </div>

        </x-slot>

    </x-dialog-modal>

</div>
