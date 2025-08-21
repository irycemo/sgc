<div class="">

    <div class="mb-6">

        <x-header>Revisión de traslados</x-header>

        <div class="flex justify-between">

            <div class="flex gap-3">

                <x-input-select class="bg-white rounded-full text-sm w-min" wire:model.live="estado">

                    <option value="cerrado">Cerrado</option>
                    <option value="rechazado">Rechazado</option>
                    <option value="autorizado">Autorizado</option>
                    <option value="operado">Operado</option>

                </x-input-select>

                <input type="text" wire:model.live.debounce.500ms="search" placeholder="Buscar" class="bg-white rounded-full text-sm">

                <x-input-select class="bg-white rounded-full text-sm w-min" wire:model.live="oficina">

                    @foreach ($oficinas as $item)

                        <option value="{{ $item->oficina }}">{{ $item->oficina }} - {{ $item->nombre }}</option>

                    @endforeach

                </x-input-select>

                <x-input-select class="bg-white rounded-full text-sm w-min" wire:model.live="pagination">

                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>

                </x-input-select>

            </div>

        </div>

    </div>

    <div class="overflow-x-auto rounded-lg shadow-xl border-t-2 border-t-gray-500">

        <x-table>

            <x-slot name="head">

                <x-table.heading sortable wire:click="sortBy('name')" :direction="$sort === 'name' ? $direction : null" >Estado</x-table.heading>
                <x-table.heading >Cuenta predial</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('entidad_nombre')" :direction="$sort === 'entidad_nombre' ? $direction : null" >Entidad</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('asignado_a')" :direction="$sort === 'area' ? $direction : null" >Asignado A</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('created_at')" :direction="$sort === 'created_at' ? $direction : null">Registro</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('updated_at')" :direction="$sort === 'updated_at' ? $direction : null">Actualizado</x-table.heading>
                <x-table.heading >Acciones</x-table.heading>

            </x-slot>

            <x-slot name="body">

                @forelse ($this->traslados as $traslado)

                    <x-table.row wire:loading.class.delaylongest="opacity-50" wire:key="row-{{ $traslado->id }}">

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Estado</span>

                            <span class="bg-{{ $traslado->estado_color }} py-1 px-2 rounded-full text-white text-xs">{{ ucfirst($traslado->estado) }}</span>

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Cuenta predial</span>

                            {{ $traslado->predio->cuentaPredial() }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Entidad</span>

                            {{ $traslado->entidad_nombre }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Asignado a</span>

                            {{ $traslado->asignadoA->name }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Registrado</span>

                            {{ $traslado->created_at }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="font-semibold">@if($traslado->actualizadoPor != null)Actualizado por: {{$traslado->actualizadoPor->name}} @else Actualizado: @endif</span> <br>

                            {{ $traslado->updated_at }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Acciones</span>

                            <div class="ml-3 relative" x-data="{ open_drop_down:false }">

                                <div>

                                    <button x-on:click="open_drop_down=true" type="button" class="rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">

                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                        </svg>

                                    </button>

                                </div>

                                <div x-cloak x-show="open_drop_down" x-on:click="open_drop_down=false" x-on:click.away="open_drop_down=false" class="z-50 origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu">

                                    @can('Reasignar traslados')

                                        <button
                                            wire:click="abrirModalReasignar({{ $traslado->id }})"
                                            wire:loading.attr="disabled"
                                            class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                            role="menuitem">
                                            Reasignar fiscal
                                        </button>

                                    @endcan

                                    <a
                                        href="{{ route('revisar_traslado', $traslado) }}"
                                        class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                        role="menuitem">

                                        <span>Revisar</span>

                                    </a>

                                    @if($traslado->rechazos_count)

                                        <button
                                            wire:click="abrirModalRechazos({{ $traslado->id }})"
                                            wire:loading.attr="disabled"
                                            class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                            role="menuitem">
                                            Ver rechazos
                                        </button>

                                    @endif

                                </div>

                            </div>

                        </x-table.cell>

                    </x-table.row>

                @empty

                    <x-table.row>

                        <x-table.cell colspan="9">

                            <div class="bg-white text-gray-500 text-center p-5 rounded-full text-lg">

                                No hay resultados.

                            </div>

                        </x-table.cell>

                    </x-table.row>

                @endforelse

            </x-slot>

            <x-slot name="tfoot">

                <x-table.row>

                    <x-table.cell colspan="9" class="bg-gray-50">

                        {{ $this->traslados->links()}}

                    </x-table.cell>

                </x-table.row>

            </x-slot>

        </x-table>

    </div>

    <x-dialog-modal wire:model="modalReasignar" maxWidth="sm">

        <x-slot name="title">

            Reasignar fiscal

        </x-slot>

        <x-slot name="content">

            <x-input-group for="modelo_editar.asignado_a" label="Fiscal" :error="$errors->first('modelo_editar.asignado_a')" class="w-full">

                <x-input-select id="modelo_editar.asignado_a" wire:model="modelo_editar.asignado_a" class="w-full">

                    <option value="">Seleccione una opción</option>

                    @foreach ($fiscales as $fiscal)

                        <option value="{{ $fiscal->id }}">{{ $fiscal->name }}</option>

                    @endforeach

                </x-input-select>

            </x-input-group>

        </x-slot>

        <x-slot name="footer">

            <div class="flex gap-3">

                <x-button-blue
                    wire:click="reasignarFiscal"
                    wire:loading.attr="disabled"
                    wire:target="reasignarFiscal">

                    <img wire:loading wire:target="reasignarFiscal" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                    Reasignar
                </x-button-blue>

                <x-button-red
                    wire:click="$toggle('modalReasignar')"
                    wire:loading.attr="disabled"
                    wire:target="$toggle('modalReasignar')"
                    type="button">
                    Cerrar
                </x-button-red>

            </div>

        </x-slot>

    </x-dialog-modal>

    <x-dialog-modal wire:model="modalRechazos" maxWidth="sm">

        <x-slot name="title">

            Rechazos

        </x-slot>

        <x-slot name="content">

            @foreach ($modelo_editar->rechazos as $rechazo)

                <div class="bg-gray-100 rounded-lg p-2 mb-2">

                    <div>
                        <p class="text-xs mb-1">Ley de la Función Registral y Catastral del Estado de Michoacán de Ocampo</p>
                        <br>
                        {!! $rechazo->observaciones !!}
                    </div>

                    <div class="text-xs text-right">

                        <p>{{ $rechazo->creadoPor->name }}</p>
                        <p>{{ $rechazo->created_at }}</p>

                    </div>

                </div>

            @endforeach

        </x-slot>

        <x-slot name="footer">

            <div class="flex gap-3">

                <x-button-red
                    wire:click="$toggle('modalRechazos')"
                    wire:loading.attr="disabled"
                    wire:target="$toggle('modalRechazos')"
                    type="button">
                    Cerrar
                </x-button-red>

            </div>

        </x-slot>

    </x-dialog-modal>

</div>
