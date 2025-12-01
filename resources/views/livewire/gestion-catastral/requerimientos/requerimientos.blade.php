<div class="">

    <div class="mb-2 lg:mb-5">

        <x-header>Requerimientos</x-header>

        <div class="flex gap-3 overflow-auto p-1">

            @if(auth()->user()->hasRole(['Administrador']))

                <select class="bg-white rounded-full text-sm w-60" wire:model.live="oficina">

                    <option value="" selected>Oficina</option>

                    @foreach ($oficinas as $oficina)

                        <option value="{{ $oficina->id }}" class="truncate">{{ $oficina->nombre }}</option>

                    @endforeach

                </select>

            @endif

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

                <x-table.heading sortable wire:click="sortBy('estado')" :direction="$sort === 'estado' ? $direction : null" >Estado</x-table.heading>
                <x-table.heading >Descripción</x-table.heading>
                <x-table.heading >Link</x-table.heading>
                <x-table.heading >Registro</x-table.heading>
                <x-table.heading >Acciones</x-table.heading>

            </x-slot>

            <x-slot name="body">

                @forelse ($this->requerimientos as $requerimiento)

                    <x-table.row wire:loading.class.delaylongest="opacity-50" wire:key="row-{{ $requerimiento->id }}">

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Estado</span>

                            <span class="bg-{{ $requerimiento->estado_color }} py-1 px-2 rounded-full text-white text-xs">{{ ucfirst($requerimiento->estado) }}</span>

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Descripción</span>

                            {{ $requerimiento->descripcion }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Link</span>

                            @if($requerimiento->archivo_url)

                                <x-link-blue class="w-min" href="{{ $requerimiento->archivo_url }}">Link</x-link-blue>

                            @else

                                <span>N/A</span>

                            @endif

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Descripción</span>

                            {{ $requerimiento->created_at }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Acciones</span>

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
                                        wire:click="abrirModalRequerimiento('{{ $requerimiento->id }}')"
                                        wire:loading.attr="disabled"
                                        class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                        role="menuitem">
                                        Ver requermiento
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

                        {{ $this->requerimientos->links()}}

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

            @if($modelo_editar->getKey())

                <div class="bg-gray-100 rounded-lg p-2 mb-2">

                    <div>
                        {{ $modelo_editar->descripcion }}
                    </div>

                    <div class="text-xs text-right">

                        <div>

                            @if($modelo_editar->archivo_url)

                                <a class="text-blue-600 underline" href="{{ $modelo_editar->archivo_url }}" target="_blank">Archivo</a>

                            @endif

                        </div>

                        <div>

                            @if($modelo_editar->usuario_stl)

                                <p>{{ $modelo_editar->usuario_stl }}</p>

                            @else

                                <p>{{ $modelo_editar->creadoPor->name }}</p>

                            @endif

                            <p>{{ $modelo_editar->created_at }}</p>

                        </div>

                    </div>

                </div>

            @endif

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

            @endif

            <x-input-group for="observacion" label="Respuesta" :error="$errors->first('observacion')">

                <textarea class="bg-white rounded text-xs w-full " rows="4" wire:model="observacion" placeholder="Se lo más especifico sobre la corrección que solicitas"></textarea>

            </x-input-group>

        </x-slot>

        <x-slot name="footer">

            <div class="flex gap-3">

                <x-button-green
                    wire:click="finalizar"
                    wire:loading.attr="disabled"
                    wire:target="finalizar">
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
