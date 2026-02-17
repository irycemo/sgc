<div>

    <x-header>Variaciones catastrales</x-header>

    <div class="mb-2 lg:mb-5">

        <div class="flex gap-3 overflow-auto p-1">

            <select class="bg-white rounded-full text-sm" wire:model.live="filters.año">

                <option value="" selected>Año</option>

                @foreach ($años as $año)

                    <option value="{{ $año }}">{{ $año }}</option>

                @endforeach

            </select>

            <input type="number" wire:model.live.debounce.500ms="filters.folio" placeholder="Folio" class="bg-white rounded-full text-sm w-24">

            <select class="bg-white rounded-full text-sm capitalize" wire:model.live="filters.estado">

                <option value="" selected>Estado</option>

                @foreach ($estados as $estados)

                    <option value="{{ $estados }}">{{ $estados }}</option>

                @endforeach

            </select>

            <select class="bg-white rounded-full text-sm" wire:model.live="filters.taño">

                <option value="" selected>T. Año</option>

                @foreach ($años as $año)

                    <option value="{{ $año }}">{{ $año }}</option>

                @endforeach

            </select>

            <input type="number" wire:model.live.debounce.500ms="filters.tfolio" placeholder="T. Folio" class="bg-white rounded-full text-sm w-24">

            <input type="number" wire:model.live.debounce.500ms="filters.tusuario" placeholder="T. Usuario" class="bg-white rounded-full text-sm w-24">

            <input type="number" wire:model.live.debounce.500ms="search" placeholder="Buscar" class="bg-white rounded-full text-sm">

            @can('Crear variación')

                <div class="ml-auto">

                    <button wire:click="abrirModalCrear" class="bg-gray-500 hover:shadow-lg hover:bg-gray-700 text-sm py-2 px-4 text-white rounded-full hidden md:block items-center justify-center focus:outline-gray-400 focus:outline-offset-2">

                        <img wire:loading wire:target="abrirModalCrear" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">
                        Agregar nueva variación

                    </button>

                    <button wire:click="abrirModalCrear" class="bg-gray-500 hover:shadow-lg hover:bg-gray-700 float-right text-sm py-2 px-4 text-white rounded-full md:hidden focus:outline-gray-400 focus:outline-offset-2">+</button>

                </div>

            @endcan

        </div>

    </div>

    <div class="rounded-lg shadow-xl border-t-2 border-t-gray-500">

        <x-table>

            <x-slot name="head">

                <x-table.heading sortable wire:click="sortBy('año')" :direction="$sort === 'año' ? $direction : null" >Año</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('folio')" :direction="$sort === 'folio' ? $direction : null" >Folio</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('estado')" :direction="$sort === 'estado' ? $direction : null" >Estado</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('tramite_id')" :direction="$sort === 'tramite_id' ? $direction : null" >Trámite</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('oficina_id')" :direction="$sort === 'oficina_id' ? $direction : null" >Municipio</x-table.heading>
                <x-table.heading >Promovente</x-table.heading>
                <x-table.heading >Finado</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('created_at')" :direction="$sort === 'created_at' ? $direction : null">Registro</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('updated_at')" :direction="$sort === 'updated_at' ? $direction : null">Actualizado</x-table.heading>
                <x-table.heading >Acciones</x-table.heading>

            </x-slot>

            <x-slot name="body">

                @forelse ($this->variaciones as $variacion)

                    <x-table.row wire:loading.class.delaylongest="opacity-50" wire:key="row-{{ $variacion->id }}">

                        <x-table.cell title="Año">

                            {{ $variacion->año }}

                        </x-table.cell>

                        <x-table.cell title="Folio">

                            {{ $variacion->folio }}

                        </x-table.cell>

                        <x-table.cell  title="Estado">

                            <span class="bg-{{ $variacion->estado_color }} py-1 px-2 rounded-full text-white text-xs">{{ ucfirst($variacion->estado) }}</span>

                        </x-table.cell>

                        <x-table.cell title="Trámite">

                            {{ $variacion->tramite->año }}-{{ $variacion->tramite->folio }}-{{ $variacion->tramite->usuario }}

                        </x-table.cell>

                        <x-table.cell title="Municipio">

                            {{ $variacion->oficina->nombre }}

                        </x-table.cell>

                        <x-table.cell title="Promovente">

                            <p class="mt-2">{{ $variacion->promovente }}</p>

                        </x-table.cell>

                        <x-table.cell title="Finado">

                            {{ $variacion->finado ?? 'N/A' }}

                        </x-table.cell>

                        <x-table.cell title="Registrado">

                            <span class="font-semibold">@if($variacion->creadoPor != null)Registrado por: {{$variacion->creadoPor->name}} @else Registro: @endif</span> <br>

                            {{ $variacion->created_at }}

                        </x-table.cell>

                        <x-table.cell title="Actualizado">

                            <span class="font-semibold">@if($variacion->actualizadoPor != null)Actualizado por: {{$variacion->actualizadoPor->name}} @else Actualizado: @endif</span> <br>

                            {{ $variacion->updated_at }}

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
                                        wire:click="abrirVerRequerimiento({{ $variacion->id }})"
                                        wire:loading.attr="disabled"
                                        class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                        role="menuitem">
                                        Ver requerimientos
                                    </button>

                                    @if(!$variacion->folio)

                                        @can('Asignar Folio')

                                            <button
                                                wire:click="asignarFolio({{ $variacion->id }})"
                                                wire:loading.attr="disabled"
                                                class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                                role="menuitem">
                                                Asignar Folio
                                            </button>

                                        @endif

                                    @endif

                                    @if(!in_array($variacion->estado, ['rechazado', 'aprovado']))

                                        @can('Editar variación')

                                            <button
                                                wire:click="abrirHacerRequerimiento({{ $variacion->id }})"
                                                wire:loading.attr="disabled"
                                                class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                                role="menuitem">
                                                Hacer requerimiento
                                            </button>

                                            <button
                                                wire:click="abrirAsignarValuador({{ $variacion->id }})"
                                                wire:loading.attr="disabled"
                                                class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                                role="menuitem">
                                                Asignar valuador
                                            </button>

                                        @endcan

                                        <button
                                            wire:click="abrirSubirArchivo({{ $variacion->id }})"
                                            wire:loading.attr="disabled"
                                            class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                            role="menuitem">
                                            Subir archivo
                                        </button>

                                        @if($variacion->archivo)

                                            <a href="{{ Storage::disk('variacionescatastrales')->url($variacion->archivo) }}" target="_blank" class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100" role="menuitem">
                                                Ver archivo
                                            </a>

                                        @endif

                                        @can('Editar variación')

                                            <button
                                                wire:click="abrirCambiarEstado({{ $variacion->id }})"
                                                wire:loading.attr="disabled"
                                                class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                                role="menuitem">
                                                Cambiar estado
                                            </button>

                                        @endcan

                                        @can('Borrar variación')

                                            <button
                                                wire:click="abrirModalBorrar({{ $variacion->id }})"
                                                wire:loading.attr="disabled"
                                                class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                                role="menuitem">
                                                Eliminar variación
                                            </button>

                                        @endcan

                                        <button
                                            wire:confirm="¿Esta seguro que desea rechazar la variacióin catastral?"
                                            wire:click="rechazar({{ $variacion->id }})"
                                            wire:loading.attr="disabled"
                                            class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                            role="menuitem">
                                            Rechazar
                                        </button>

                                    @endif

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

                        {{ $this->variaciones->links()}}

                    </x-table.cell>

                </x-table.row>

            </x-slot>

        </x-table>

    </div>

    @include('livewire.a-tramites-administrativos.comun.modal-crear-variacion')

    @include('livewire.a-tramites-administrativos.comun.modal-eliminar')

    @include('livewire.a-tramites-administrativos.comun.modal-hacer-requerimiento')

    @include('livewire.a-tramites-administrativos.comun.modal-ver-requerimiento')

    @include('livewire.a-tramites-administrativos.comun.modal-asignar-valuador')

    @include('livewire.a-tramites-administrativos.comun.modal-subir-archivo')

    @include('livewire.a-tramites-administrativos.comun.modal-cambiar-estado')

</div>
