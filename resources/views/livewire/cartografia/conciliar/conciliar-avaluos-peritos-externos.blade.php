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

            <input type="number" wire:model="localidad" placeholder="Localidad" class="bg-white rounded-full text-sm w-24">

            <input type="number" wire:model="oficina" placeholder="Oficina" class="bg-white rounded-full text-sm w-24">

            <input type="number" wire:model="t_predio" placeholder="T. Predio" class="bg-white rounded-full text-sm w-24">

            <input type="number" wire:model.live.debounce.500ms="registro" placeholder="# Registro" class="bg-white rounded-full text-sm w-24">

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
                <x-table.heading>Estado</x-table.heading>
                <x-table.heading>Perito externo</x-table.heading>
                <x-table.heading>Cuenta predial</x-table.heading>
                <x-table.heading>Clave catastral</x-table.heading>
                <x-table.heading>Acciones</x-table.heading>

            </x-slot>

            <x-slot name="body">

                @forelse ($avaluos as $avaluo)

                    <x-table.row wire:loading.class.delaylongest="opacity-50" wire:key="row-{{ $avaluo['id'] }}">

                        <x-table.cell title="Año">

                            {{ $avaluo['año'] }}

                        </x-table.cell>

                        <x-table.cell title="Folio">

                            {{ $avaluo['folio'] }}

                        </x-table.cell>

                        <x-table.cell title="Usuario">

                            {{ $avaluo['usuario'] }}

                        </x-table.cell>

                        <x-table.cell title="Estado">

                            @if(count($avaluo['requerimientos']) > 0)

                                <span class="bg-blue-400 py-1 px-2 rounded-full text-white text-xs">Atendido</span>

                            @else

                                <span class="bg-green-400 py-1 px-2 rounded-full text-white text-xs">Requerido</span>

                            @endif

                        </x-table.cell>

                        <x-table.cell title="Valuador">

                            <p class="mt-2">{{ $avaluo['valuador'] }}</p>

                        </x-table.cell>

                        <x-table.cell title="Cuenta predial">

                            {{ $avaluo['cuenta_predial'] }}

                        </x-table.cell>

                        <x-table.cell title="Clave catastral">

                            <p class="mt-2">{{ $avaluo['clave_catastral'] }}</p>

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

                                <div x-cloak x-show="open_drop_down" x-on:click="open_drop_down=false" x-on:click.away="open_drop_down=false" class="z-50 absolute origin-top-right mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu">

                                    <button
                                        wire:click="abrirModalConciliar({{ json_encode($avaluo) }})"
                                        wire:loading.attr="disabled"
                                        class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                        role="menuitem">
                                        Conciliar
                                    </button>

                                    <button
                                        wire:click="abrirModalRequerimiento({{ json_encode($avaluo) }})"
                                        wire:loading.attr="disabled"
                                        class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                        role="menuitem">
                                        Hacer requerimiento
                                    </button>

                                    @if (count($avaluo['requerimientos']))

                                        <button
                                            wire:click="abrirModalVerRequerimientos({{ json_encode($avaluo) }})"
                                            wire:loading.attr="disabled"
                                            class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                            role="menuitem">
                                            Ver requerimientos
                                        </button>

                                    @endif

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

            Conciliar: @if($avaluo_seleccionado){{ $avaluo_seleccionado['cuenta_predial'] }}@endif

        </x-slot>

        <x-slot name="content">

            @if($avaluo_seleccionado)

                <div class="flex gap-2 w-full items-center">

                    <div class="rounded-lg bg-gray-100 py-1 px-2 my-3">

                        <strong>Latitud:</strong>

                        <p>{{ $avaluo_seleccionado['lat'] }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2 my-3">

                        <strong>Longitud:</strong>

                        <p>{{ $avaluo_seleccionado['lon'] }}</p>

                    </div>

                </div>

                <div class="flex gap-2 w-full items-center">

                    <a target="_blank" href="{{ 'https://www.google.com/maps/?q=' . $avaluo_seleccionado['lat'] . ',' . $avaluo_seleccionado['lon'] . '&z=5&t=k' }}">

                        <img class="h-12" src="{{ asset('storage/img/GOOGLE.png') }}" alt="">

                    </a>

                    <a target="_blank" href="{{ 'http://mapa.catastro.michoacan.gob.mx:8080/index.html?pzoom=20&plat=' . $avaluo_seleccionado['lat'] . '&plon=' . $avaluo_seleccionado['lon'] }}">

                        <img class="h-12" src="{{ asset('storage/img/SIG.png') }}" alt="">

                    </a>

                    <livewire:comun.consultas.cartografia-consulta lazy :predio_id="$this->predio_id" />

                </div>

                <div class="flex gap-2 w-full">
                    <div class="rounded-lg bg-gray-100 py-1 px-2 my-3">

                        <strong>XUTM:</strong>

                        <p>{{ $avaluo_seleccionado['xutm'] }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2 my-3">

                        <strong>YUTM:</strong>

                        <p>{{ $avaluo_seleccionado['yutm'] }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2 my-3">

                        <strong>ZUTM:</strong>

                        <p>{{ $avaluo_seleccionado['zutm'] }}</p>

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

    <x-dialog-modal wire:model="modal_requerimiento" maxWidth="md">

        <x-slot name="title">
            Hacer Requerimiento
        </x-slot>

        <x-slot name="content">

            <x-input-group for="observaciones" label="Observación" :error="$errors->first('observaciones')">

                <x-input-select id="observaciones" wire:model="observaciones" class="w-full mb-5">

                    <option value="">Seleccione una opción</option>
                    <option value="CAMBIO DE LOCALIDAD. NUEVA CUENTA XXXXXXXX">
                        CAMBIO DE LOCALIDAD. NUEVA CUENTA XXXXXXXX
                    </option>
                    <option value="PRESENTAR ESCRITURA CERTIFICADA DEL DPTO. DE CARTOGRAFÍA PARA REALIZAR EL CAMBIO DE LOCALIDAD A XXXXXXX">
                        PRESENTAR ESCRITURA CERTIFICADA DEL DPTO. DE CARTOGRAFÍA PARA REALIZAR EL CAMBIO DE LOCALIDAD A XXXXXXX
                    </option>
                    <option value="RECTIFICAR COORDENADAS ATERRIZAN AL CENTRO DE LA CALLE">
                        RECTIFICAR COORDENADAS ATERRIZAN AL CENTRO DE LA CALLE
                    </option>
                    <option value="COORDENADAS FUERA DE RANGO">
                        COORDENADAS FUERA DE RANGO
                    </option>

                </x-input-select>

                <textarea class="bg-white rounded text-xs w-full " rows="4" wire:model="observaciones" placeholder="Se lo más especifico sobre la corrección que solicitas"></textarea>

            </x-input-group>

        </x-slot>

        <x-slot name="footer">

            <div class="flex gap-3">

                <x-button-blue
                    wire:click="hacerRequerimiento"
                    wire:loading.attr="disabled"
                    wire:target="hacerRequerimiento">
                    Solicitar corrección
                </x-button-blue>

                <x-button-red
                    wire:click="$toggle('modal_requerimiento')"
                    wire:loading.attr="disabled"
                    wire:target="$toggle('modal_requerimiento')">
                    Cerrar
                </x-button-red>

            </div>

        </x-slot>

    </x-dialog-modal>

    <x-dialog-modal wire:model="modal_ver_requerimientos" maxWidth="sm">

        <x-slot name="title">

            Requerimientos

        </x-slot>

        <x-slot name="content">

            @if(isset($avaluo_seleccionado) && count($avaluo_seleccionado['requerimientos']))

                @forelse ($avaluo_seleccionado['requerimientos'] as $requerimiento)

                    <div class="bg-gray-100 rounded-lg p-2 mb-2">

                        <div>
                            {{ $requerimiento['descripcion'] }}
                        </div>

                        <div class="text-xs text-right">

                            <div>

                                <p>{{ $requerimiento['usuario_sgc'] }}</p>

                                <p>{{ $requerimiento['created_at'] }}</p>

                            </div>

                        </div>

                    </div>

                @empty

                    <div class="bg-gray-100 rounded-lg p-4 text-center">

                        <p>No hay requerimientos</p>

                    </div>

                @endforelse

            @endif

        </x-slot>

        <x-slot name="footer">

            <div class="flex gap-3">

                <x-button-red
                    wire:click="$toggle('modal_ver_requerimientos')"
                    wire:loading.attr="disabled"
                    wire:target="$toggle('modal_ver_requerimientos')"
                    type="button">
                    Cerrar
                </x-button-red>

            </div>

        </x-slot>

    </x-dialog-modal>

</div>
