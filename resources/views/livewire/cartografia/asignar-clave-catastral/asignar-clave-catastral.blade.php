<div class="">

    <div class="mb-6">

        <x-header>Asignación de clave catastral</x-header>

        <div class="flex justify-between">

            <div>

                <input type="text" wire:model.live.debounce.500ms="search" placeholder="Buscar" class="bg-white rounded-full text-sm">

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

                <x-table.heading >Promovente</x-table.heading>
                <x-table.heading >Valuador</x-table.heading>
                @if(auth()->user()->hasRole(['Administrador', 'Jefe de departamento']))
                    <x-table.heading >Oficina</x-table.heading>
                @endif
                <x-table.heading >Acciones</x-table.heading>

            </x-slot>

            <x-slot name="body">

                @forelse ($this->prediosIgnorados as $predio)

                    <x-table.row wire:loading.class.delaylongest="opacity-50" wire:key="row-{{ $predio->id }}">

                        <x-table.cell title="Promovente">

                            {{ $predio->promovente }}

                        </x-table.cell>

                        <x-table.cell title="Valuador">

                            {{ $predio->valuadorAsignado->name }}

                        </x-table.cell>

                        @if(auth()->user()->hasRole(['Administrador', 'Jefe de departamento']))

                            <x-table.cell title="Oficina">

                                {{ $predio->oficina->nombre }}

                            </x-table.cell>

                        @endif

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
                                        wire:click="abrirModalAsignar({{ $predio->id }})"
                                        wire:loading.attr="disabled"
                                        class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                        role="menuitem">
                                        Asignar clave catastral
                                    </button>

                                    <a
                                        href="{{ $predio->archivo() }}"
                                        target="_blank"
                                        class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                        role="menuitem">
                                        Ver archivo
                                    </a>

                                </div>

                            </div>

                        </x-table.cell>

                    </x-table.row>

                @empty

                    <x-table.row wire:key="row-empty">

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

                        {{ $this->prediosIgnorados->links()}}

                    </x-table.cell>

                </x-table.row>

            </x-slot>

        </x-table>

    </div>

    <x-dialog-modal wire:model.live="modal" maxWidth="md">

        <x-slot name="title">

            Asignar clave catastral

        </x-slot>

        <x-slot name="content">

            <div class="">

                <div class="flex flex-col w-full md:flex-row justify-start md:space-x-1 mb-5">

                    <input placeholder="Estado" type="number" class="bg-white rounded text-xs w-24" title="Estado" value="16" readonly>

                    <input title="Región" placeholder="Región" type="number" class="bg-white rounded text-xs w-24  @error('region_catastral') border-1 border-red-500 @enderror" wire:model="region_catastral">

                    <input title="Municipio" placeholder="Municipio" type="number" class="bg-white rounded text-xs w-24 @error('municipio') border-1 border-red-500 @enderror" wire:model="municipio" readonly>

                    <input title="Zona" placeholder="Zona" type="number" class="bg-white rounded text-xs w-24 @error('zona_catastral') border-1 border-red-500 @enderror" wire:model="zona_catastral">

                </div>

                <div class="flex flex-col w-full md:flex-row justify-start md:space-x-1 mb-5">


                    <input title="Localidad" placeholder="Localidad" type="number" class="bg-white rounded text-xs w-24 @error('localidad') border-1 border-red-500 @enderror" wire:model.blur="localidad">

                    <input title="Sector" placeholder="Sector" type="number" class="bg-white rounded text-xs w-24 @error('sector') border-1 border-red-500 @enderror" wire:model="sector">

                    <input title="Manzana" placeholder="Manzana" type="number" class="bg-white rounded text-xs w-24 @error('manzana') border-1 border-red-500 @enderror" wire:model="manzana">

                    <input title="Predio" placeholder="Predio" type="number" class="bg-white rounded text-xs w-24 @error('predio') border-1 border-red-500 @enderror" wire:model.blur="predio">

                </div>

                <div class="flex flex-col w-full md:flex-row justify-start md:space-x-1 mb-5">

                    <input title="Edificio" placeholder="Edificio" type="number" class="bg-white rounded text-xs w-24 @error('edificio') border-1 border-red-500 @enderror" wire:model="edificio">

                    <input title="Departamento" placeholder="Departamento" type="number" class="bg-white rounded text-xs w-24 @error('departamento') border-1 border-red-500 @enderror" wire:model="departamento">

                    <input title="Oficina" placeholder="Oficina" type="number" class="bg-white rounded text-xs w-24 @error('oficina') border-1 border-red-500 @enderror" wire:model="oficina">

                    <input title="Tipo de predio" placeholder="Tipo predio" type="number" class="bg-white rounded text-xs w-24 @error('tipo_predio') border-1 border-red-500 @enderror" wire:model="tipo_predio">

                </div>

            </div>

        </x-slot>

        <x-slot name="footer">

            <div class="flex items-center gap-3">

                <x-button-blue
                    wire:click="asignarClaveCatastral"
                    wire:loading.attr="disabled"
                    wire:target="asignarClaveCatastral">

                    <img wire:loading wire:target="asignarClaveCatastral" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                    Asignar
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

</div>
