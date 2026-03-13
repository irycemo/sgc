<div class="">

    <div class="mb-2 lg:mb-5">

        <x-header>Certificaciones</x-header>

        <div class="">

            <div class="flex gap-3 overflow-auto p-1">

                <select class="bg-white rounded-full text-sm" wire:model.live="filters.tAño">

                    @foreach ($años as $item)

                        <option value="{{ $item }}">{{ $item }}</option>

                    @endforeach

                </select>

                <input type="number" wire:model.live.debounce.500ms="filters.tFolio" placeholder="T. Folio" class="bg-white rounded-full text-sm w-24">

                <input type="number" wire:model.live.debounce.500ms="filters.localidad" placeholder="Localidad" class="bg-white rounded-full text-sm w-24">

                <input type="number" wire:model.live.debounce.500ms="filters.p_oficina" placeholder="Oficina" class="bg-white rounded-full text-sm w-24">

                <input type="number" wire:model.live.debounce.500ms="filters.t_predio" placeholder="T. Predio" class="bg-white rounded-full text-sm w-24">

                <input type="number" wire:model.live.debounce.500ms="filters.registro" placeholder="# Registro" class="bg-white rounded-full text-sm w-24">

                <select class="bg-white rounded-full text-sm" wire:model.live="pagination">

                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>

                </select>

            </div>

        </div>

    </div>

    <div class="overflow-x-auto rounded-lg shadow-xl border-t-2 border-t-gray-500">

        <x-table>

            <x-slot name="head">

                <x-table.heading sortable wire:click="sortBy('tipo')" :direction="$sort === 'tipo' ? $direction : null" >Tipo</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('año')" :direction="$sort === 'año' ? $direction : null" >Año</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('folio')" :direction="$sort === 'folio' ? $direction : null" >Folio</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('predio_id')" :direction="$sort === 'predio_id' ? $direction : null" >Cuenta predial</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('tramite_id')" :direction="$sort === 'tramite_id' ? $direction : null" >Trámite</x-table.heading>
                <x-table.heading >Acciones</x-table.heading>

            </x-slot>

            <x-slot name="body">

                @forelse ($this->certificaciones as $certificacion)

                    <x-table.row wire:loading.class.delaylongest="opacity-50" wire:key="row-{{ $certificacion->id }}">

                        <x-table.cell title="Documento">

                            {{ $certificacion->tipo->label() }}

                        </x-table.cell>

                        <x-table.cell title="Año">

                            {{ $certificacion->año }}

                        </x-table.cell>

                        <x-table.cell title="Folio">

                            {{ $certificacion->folio }}

                        </x-table.cell>

                        <x-table.cell  title="Cuenta Predial">

                            {{ $certificacion->predio ? $certificacion->predio->cuentaPredial() : 'N/A' }}

                        </x-table.cell>

                        <x-table.cell  title="Trámite">

                            {{ $certificacion->tramite?->año }}-{{ $certificacion->tramite?->folio }}-{{ $certificacion->tramite?->usuario }}

                        </x-table.cell>

                        <x-table.cell title="Acciones">

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
                                        wire:click="abrirModalEditar('{{ $certificacion->uuid }}')"
                                        wire:loading.attr="disabled"
                                        class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                        role="menuitem">
                                        Ver requermientos
                                    </button>

                                </div>

                            </div>

                        </x-table.cell>

                    </x-table.row>

                @empty

                    <x-table.row>

                        <x-table.cell colspan="10">

                            <div class="bg-white text-gray-500 text-center p-5 rounded-full text-lg">

                                No hay resultados.

                            </div>

                        </x-table.cell>

                    </x-table.row>

                @endforelse

            </x-slot>

            <x-slot name="tfoot">

                <x-table.row>

                    <x-table.cell colspan="10" class="bg-gray-50">

                        {{ $this->certificaciones->links()}}

                    </x-table.cell>

                </x-table.row>

            </x-slot>

        </x-table>

    </div>

    <x-dialog-modal wire:model="modal" maxWidth="sm">

        <x-slot name="title">

            Requerimientos

        </x-slot>

        <x-slot name="content">

            @if($modelo_editar->requerimientos->count())

                @forelse ($modelo_editar->requerimientos as $requerimiento)

                    <div class="bg-gray-100 rounded-lg p-2 mb-2">

                        <div>
                            {{ $requerimiento->descripcion }}
                        </div>

                        <div class="text-xs text-right">

                            <div>

                                @if($requerimiento->archivo_url)

                                    <a class="text-blue-600 underline" href="{{ $requerimiento->archivo_url }}" target="_blank">Archivo</a>

                                @endif

                            </div>

                            <div>

                                @if($requerimiento->usuario_stl)

                                    <p>{{ $requerimiento->usuario_stl }}</p>

                                @else

                                    <p>{{ $requerimiento->creadoPor->name }}</p>

                                @endif

                                <p>{{ $requerimiento->created_at }}</p>

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="bg-gray-100 rounded-lg p-4 text-center">

                        <p>No hay requerimientos</p>

                    </div>

                @endforelse

                <x-input-group for="observacion" label="Respuesta" :error="$errors->first('observacion')">

                    <textarea class="bg-white rounded text-xs w-full " rows="4" wire:model="observacion" placeholder="Se lo más especifico sobre la corrección que solicitas"></textarea>

                </x-input-group>

            @endif

        </x-slot>

        <x-slot name="footer">

            <div class="flex gap-3">

                <x-button-green
                    wire:click="responder('finalizado')"
                    wire:loading.attr="disabled"
                    wire:target="responder('finalizado')">
                    Finalizar
                </x-button-green>

                <x-button-blue
                    wire:click="responder"
                    wire:loading.attr="disabled"
                    wire:target="responder">
                    Responder
                </x-button-blue>

                <x-button-red
                    wire:click="$toggle('modal')"
                    wire:loading.attr="disabled"
                    wire:target="$toggle('modal')"
                    type="button">
                    Cerrar
                </x-button-red>

            </div>

        </x-slot>

    </x-dialog-modal>


</div>
