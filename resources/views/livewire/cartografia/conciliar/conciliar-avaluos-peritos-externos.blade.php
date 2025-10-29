<div x-ref="tramites">

    <div class="mb-2 lg:mb-5">

        <x-header>Conciliar <small>(peritos externos)</small></x-header>

        <div class="flex gap-3 overflow-auto p-1">

            <select class="bg-white rounded-full text-sm" wire:model.live="año">

                @foreach ($años as $item)

                    <option value="{{ $item }}">{{ $item }}</option>

                @endforeach

            </select>

            <input type="number" wire:model.live.debounce.500mse="folio" placeholder="Folio" class="bg-white rounded-full text-sm w-24">

            <input type="number" wire:model.live.debounce.500mse="usuario" placeholder="Usuario" class="bg-white rounded-full text-sm w-24">

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

                <x-table.heading>Año</x-table.heading>
                <x-table.heading>Folio</x-table.heading>
                <x-table.heading>Usuario</x-table.heading>
                <x-table.heading>Perito externo</x-table.heading>
                <x-table.heading>Cuenta predial</x-table.heading>
                <x-table.heading>Clave catastral</x-table.heading>
                <x-table.heading>Acciones</x-table.heading>

            </x-slot>

            <x-slot name="body">

                @forelse ($avaluos as $avaluo)

                    <x-table.row wire:loading.class.delaylongest="opacity-50" wire:key="row-{{ $avaluo['id'] }}">

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Año</span>

                            {{ $avaluo['año'] }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Folio</span>

                            {{ $avaluo['folio'] }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Usuario</span>

                            {{ $avaluo['usuario'] }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Valuador</span>

                            <p class="mt-2">{{ $avaluo['valuador'] }}</p>

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Cuenta predial</span>

                            {{ $avaluo['cuenta_predial'] }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Clave catastral</span>

                            <p class="mt-2">{{ $avaluo['clave_catastral'] }}</p>

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

                                <div x-cloak x-show="open_drop_down" x-on:click="open_drop_down=false" x-on:click.away="open_drop_down=false" class="z-50 absolute origin-top-right mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu">

                                    <button
                                        wire:click="abrirModalConciliar({{ json_encode($avaluo) }})"
                                        wire:loading.attr="disabled"
                                        class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                        role="menuitem">
                                        Conciliar
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

                        <div>
                            <nav role="navigation" aria-label="Pagination Navigation" class="flex gap-3 justify-between">
                                <span>
                                    @if ($paginaAnterior)
                                        <button
                                         wire:click="previousPage"
                                         wire:loading.attr="disabled"
                                         rel="prev"
                                         class="flex items-center justify-center px-3 h-8 me-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                                         x-on:click="$refs.tramites.scrollIntoView()">

                                            <svg class="w-3.5 h-3.5 me-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5H1m0 0 4 4M1 5l4-4"/>
                                            </svg>
                                          Anterior

                                        </button>
                                    @endif
                                </span>

                                <span>
                                    @if ($paginaSiguiente)
                                        <button
                                            wire:click="nextPage"
                                            wire:loading.attr="disabled"
                                            rel="next"
                                            class="flex items-center justify-center px-3 h-8 me-3 text-sm font-medium text-gray-500 bg-white border border-gray-300 rounded-lg hover:bg-gray-100 hover:text-gray-700 dark:bg-gray-800 dark:border-gray-700 dark:text-gray-400 dark:hover:bg-gray-700 dark:hover:text-white"
                                            x-on:click="$refs.tramites.scrollIntoView()">

                                            Siguiente

                                            <svg class="w-3.5 h-3.5 ms-2 rtl:rotate-180" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 10">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 5h12m0 0L9 1m4 4L9 9"/>
                                            </svg>

                                        </button>
                                    @endif
                                </span>
                            </nav>
                        </div>

                    </x-table.cell>

                </x-table.row>

            </x-slot>

        </x-table>

    </div>

    <x-dialog-modal wire:model.live="modalConciliar" maxWidth="md">

        <x-slot name="title">

            Conciliar

        </x-slot>

        <x-slot name="content">

            @if($avaluo_seleccionado)

                <div class="flex gap-2 w-full">

                    <div class="rounded-lg bg-gray-100 py-1 px-2 my-3">

                        <strong>Latitud:</strong>

                        <p>{{ $avaluo_seleccionado['lat'] }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2 my-3">

                        <strong>Longitud:</strong>

                        <p>{{ $avaluo_seleccionado['lon'] }}</p>

                    </div>

                </div>

            @endif

            <div class="">

                <div class="flex flex-col md:flex-row justify-start md:space-x-1 mb-5">

                    <input placeholder="Estado" type="number" class="bg-white rounded text-xs w-24" title="Estado" value="16" readonly>

                    <input title="Región" placeholder="Región" type="number" class="bg-white rounded text-xs w-24  @error('region_catastral') border-1 border-red-500 @enderror" wire:model="region_catastral" readonly>

                    <input title="Municipio" placeholder="Municipio" type="number" class="bg-white rounded text-xs w-24 @error('municipio') border-1 border-red-500 @enderror" wire:model="municipio" readonly>

                    <input title="Zona" placeholder="Zona" type="number" class="bg-white rounded text-xs w-24 @error('zona_catastral') border-1 border-red-500 @enderror" wire:model="zona_catastral" readonly>

                </div>

                <div class="flex flex-col md:flex-row justify-start md:space-x-1 mb-5">


                    <input title="Localidad" placeholder="Localidad" type="number" class="bg-white rounded text-xs w-24 @error('localidad') border-1 border-red-500 @enderror" wire:model.blur="localidad" readonly>

                    <input title="Sector" placeholder="Sector" type="number" class="bg-white rounded text-xs w-24 @error('sector') border-1 border-red-500 @enderror" wire:model="sector">

                    <input title="Manzana" placeholder="Manzana" type="number" class="bg-white rounded text-xs w-24 @error('manzana') border-1 border-red-500 @enderror" wire:model="manzana">

                    <input title="Predio" placeholder="Predio" type="number" class="bg-white rounded text-xs w-24 @error('predio') border-1 border-red-500 @enderror" wire:model.blur="predio">

                </div>

                <div class="flex flex-col md:flex-row justify-start md:space-x-1 mb-5">

                    <input title="Edificio" placeholder="Edificio" type="number" class="bg-white rounded text-xs w-24 @error('edificio') border-1 border-red-500 @enderror" wire:model="edificio">

                    <input title="Departamento" placeholder="Departamento" type="number" class="bg-white rounded text-xs w-24 @error('departamento') border-1 border-red-500 @enderror" wire:model="departamento">

                </div>

            </div>

        </x-slot>

        <x-slot name="footer">

            <div class="flex items-center gap-3">

                <x-button-blue
                    wire:click="conciliar"
                    wire:loading.attr="disabled"
                    wire:target="conciliar">

                    <img wire:loading wire:target="conciliar" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                    Conciliar
                </x-button-blue>

                <x-button-red
                    wire:click="$toggle('modalConciliar')"
                    wire:loading.attr="disabled"
                    wire:target="$toggle('modalConciliar')">
                    Cerrar
                </x-button-red>

            </div>

        </x-slot>

    </x-dialog-modal>

</div>
