<div>

    <x-header>Trámites administrativos</x-header>

    <div class="mb-2 lg:mb-5">

        <div class="flex gap-3 overflow-auto p-1">

            <select class="bg-white rounded-full text-sm" wire:model.live="filters.año">

                <option value="" selected>Año</option>

                @foreach ($años as $año)

                    <option value="{{ $año }}">{{ $año }}</option>

                @endforeach

            </select>

            <input type="number" wire:model.live.debounce.500ms="filters.folio" placeholder="Folio" class="bg-white rounded-full text-sm w-24">

            <select class="bg-white rounded-full text-sm" wire:model.live="filters.estado">

                <option value="" selected>Estado</option>

                <option value="nuevo">Nuevo</option>
                <option value="revisión">Revisión</option>
                <option value="requerimineto">Requerimineto</option>
                <option value="valuación">Valuación</option>
                <option value="publicación">Publicación</option>
                <option value="periódico oficial">Periódico oficial</option>
                <option value="firma">Firma</option>
                <option value="concluido">Concluido</option>

            </select>

            <select class="bg-white rounded-full text-sm" wire:model.live="filters.taño">

                <option value="" selected>T. Año</option>

                @foreach ($años as $año)

                    <option value="{{ $año }}">{{ $año }}</option>

                @endforeach

            </select>

            <input type="number" wire:model.live.debounce.500ms="filters.tfolio" placeholder="T. Folio" class="bg-white rounded-full text-sm w-24">

            <input type="number" wire:model.live.debounce.500ms="filters.tusuario" placeholder="T. Usuario" class="bg-white rounded-full text-sm w-24">

            <input wire:model.live.debounce.500ms="search" placeholder="Buscar" class="bg-white rounded-full text-sm">

            @can('Crear predio ignorado')

                <div class="ml-auto">

                    <button wire:click="abrirModalCrear" class="bg-gray-500 hover:shadow-lg hover:bg-gray-700 text-sm py-2 px-4 text-white rounded-full hidden md:block items-center justify-center focus:outline-gray-400 focus:outline-offset-2">

                        <img wire:loading wire:target="abrirModalCrear" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">
                        Agregar nuevo trámite administrativo

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
                <x-table.heading >Cuenta predial</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('created_at')" :direction="$sort === 'created_at' ? $direction : null">Registro</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('updated_at')" :direction="$sort === 'updated_at' ? $direction : null">Actualizado</x-table.heading>
                <x-table.heading >Acciones</x-table.heading>

            </x-slot>

            <x-slot name="body">

                @forelse ($this->tramitesAdministrativos as $tramiteAdministrativo)

                    <x-table.row wire:loading.class.delaylongest="opacity-50" wire:key="row-{{ $tramiteAdministrativo->id }}">

                        <x-table.cell title="Año">

                            {{ $tramiteAdministrativo->año }}

                        </x-table.cell>

                        <x-table.cell title="Folio">

                            {{ $tramiteAdministrativo->folio }}

                        </x-table.cell>

                        <x-table.cell title="Estado">

                            <span class="bg-{{ $tramiteAdministrativo->estado_color }} py-1 px-2 rounded-full text-white text-xs">{{ ucfirst($tramiteAdministrativo->estado) }}</span>

                        </x-table.cell>

                        <x-table.cell title="Trámite">

                            {{ $tramiteAdministrativo->tramite->año }}-{{ $tramiteAdministrativo->tramite->folio }}-{{ $tramiteAdministrativo->tramite->usuario }}

                        </x-table.cell>

                        <x-table.cell title="Municipio">

                            {{ $tramiteAdministrativo->oficinaRentistica->nombre }}

                        </x-table.cell>

                        <x-table.cell title="Promovente">

                            {{ $tramiteAdministrativo->promovente }}

                        </x-table.cell>

                        <x-table.cell title="Finado">

                            {{ $tramiteAdministrativo->finado ?? 'N/A' }}

                        </x-table.cell>

                        <x-table.cell title="Cuenta predial">

                            {{ $tramiteAdministrativo->localidad }}-{{ $tramiteAdministrativo->oficina }}-{{ $tramiteAdministrativo->tipo_predio }}-{{ $tramiteAdministrativo->numero_registro }}

                        </x-table.cell>

                        <x-table.cell title="Registrado">

                            <span class="font-semibold">@if($tramiteAdministrativo->creadoPor != null)Registrado por: {{$tramiteAdministrativo->creadoPor->name}} @else Registro: @endif</span> <br>

                            {{ $tramiteAdministrativo->created_at }}

                        </x-table.cell>

                        <x-table.cell  title="Actualizado">

                            <span class="font-semibold">@if($tramiteAdministrativo->actualizadoPor != null)Actualizado por: {{$tramiteAdministrativo->actualizadoPor->name}} @else Actualizado: @endif</span> <br>

                            {{ $tramiteAdministrativo->updated_at }}

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
                                        wire:click="abrirVerRequerimiento({{ $tramiteAdministrativo->id }})"
                                        wire:loading.attr="disabled"
                                        class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                        role="menuitem">
                                        Ver requerimientos
                                    </button>

                                    @can('Auditar')

                                        <button
                                            wire:click="abrirModalAuditoria({{ $tramiteAdministrativo->id }})"
                                            wire:loading.attr="disabled"
                                            class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                            role="menuitem">
                                            Auditar
                                        </button>

                                    @endcan

                                    @if(!$tramiteAdministrativo->folio)

                                        @can('Asignar Folio')

                                            <button
                                                wire:click="asignarFolio({{ $tramiteAdministrativo->id }})"
                                                wire:loading.attr="disabled"
                                                class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                                role="menuitem">
                                                Asignar Folio
                                            </button>

                                        @endif

                                    @endif

                                    @if($tramiteAdministrativo->estado !== 'concluido')

                                        @can('Editar predio ignorado')

                                            <button
                                                wire:click="abrirHacerRequerimiento({{ $tramiteAdministrativo->id }})"
                                                wire:loading.attr="disabled"
                                                class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                                role="menuitem">
                                                Hacer requerimiento
                                            </button>

                                            <button
                                                wire:click="abrirAsignarValuador({{ $tramiteAdministrativo->id }})"
                                                wire:loading.attr="disabled"
                                                class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                                role="menuitem">
                                                Asignar valuador
                                            </button>

                                        @endcan

                                        <button
                                            wire:click="abrirSubirArchivo({{ $tramiteAdministrativo->id }})"
                                            wire:loading.attr="disabled"
                                            class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                            role="menuitem">
                                            Subir archivo
                                        </button>

                                        @if($tramiteAdministrativo->archivos_count > 0)

                                            <button
                                                wire:click="abrirVerArchivos({{ $tramiteAdministrativo->id }})"
                                                wire:loading.attr="disabled"
                                                class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                                role="menuitem">
                                                Ver archivos
                                            </button>

                                        @endif

                                        @can('Editar predio ignorado')

                                            <button
                                                wire:click="abrirCambiarEstado({{ $tramiteAdministrativo->id }})"
                                                wire:loading.attr="disabled"
                                                class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                                role="menuitem">
                                                Cambiar estado
                                            </button>

                                        @endcan

                                        @can('Borrar predio ignorado')

                                            <button
                                                wire:click="abrirModalBorrar({{ $tramiteAdministrativo->id }})"
                                                wire:loading.attr="disabled"
                                                class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                                role="menuitem">
                                                Eliminar trámite administrativo
                                            </button>

                                        @endcan

                                    @endif

                                </div>

                            </div>

                        </x-table.cell>

                    </x-table.row>

                @empty

                    <x-table.row>

                        <x-table.cell colspan="11">

                            <div class="bg-white text-gray-500 text-center p-5 rounded-full text-lg">

                                No hay resultados.

                            </div>

                        </x-table.cell>

                    </x-table.row>

                @endforelse

            </x-slot>

            <x-slot name="tfoot">

                <x-table.row>

                    <x-table.cell colspan="11" class="bg-gray-50">

                        {{ $this->tramitesAdministrativos->links()}}

                    </x-table.cell>

                </x-table.row>

            </x-slot>

        </x-table>

    </div>

    @include('livewire.a-tramites-administrativos.comun.modal-eliminar')

    @include('livewire.a-tramites-administrativos.comun.modal-hacer-requerimiento')

    @include('livewire.a-tramites-administrativos.comun.modal-ver-requerimiento')

    @include('livewire.a-tramites-administrativos.comun.modal-asignar-valuador')

    @include('livewire.a-tramites-administrativos.comun.modal-subir-archivo')

    @include('livewire.a-tramites-administrativos.comun.modal-cambiar-estado')

    @include('livewire.a-tramites-administrativos.comun.modal-ver-archivos')

    @include('livewire.a-tramites-administrativos.comun.modal-auditar')

    <x-dialog-modal wire:model="modal">

        <x-slot name="title">

            Nuevo trámite administrativo

        </x-slot>

        <x-slot name="content">

            <div class="flex-auto text-center mb-3">

                <div >

                    <Label class="text-base tracking-widest rounded-xl border-gray-500">Trámite</Label>

                </div>

                <div class="inline-flex">

                    <select class="bg-white rounded-l text-sm border border-r-transparent focus:ring-0 @error('taño') border-red-500 @enderror" wire:model="taño">

                        @foreach ($años as $año)

                            <option value="{{ $año }}">{{ $año }}</option>

                        @endforeach

                    </select>

                    <input type="number" class="bg-white text-sm w-20 focus:ring-0 @error('tfolio') border-red-500 @enderror" wire:model="tfolio">

                    <input type="number" class="bg-white text-sm w-20 border-l-0 rounded-r focus:ring-0 @error('tusuario') border-red-500 @enderror" wire:model="tusuario">

                </div>

            </div>

            <div class="flex flex-col lg:space-x-2 mb-2 space-y-2 lg:space-y-0 items-center justify-center" >

                <div class="text-left">

                    <Label class="text-base tracking-widest rounded-xl border-gray-500">Cuenta predial</Label>

                </div>

                <div class="space-y-1">

                    <input title="Localidad" placeholder="Localidad" type="number" class="bg-white rounded text-xs w-20 @error('modelo_editar.localidad') border-1 border-red-500 @enderror" wire:model.lazy="modelo_editar.localidad">

                    <input title="Oficina" placeholder="Oficina" type="number" class="bg-white rounded text-xs w-20 @error('modelo_editar.oficina') border-1 border-red-500 @enderror" wire:model.lazy="modelo_editar.oficina">

                    <input title="Tipo de predio" placeholder="Tipo" type="number" class="bg-white rounded text-xs w-20 @error('modelo_editar.tipo_predio') border-1 border-red-500 @enderror" wire:model="modelo_editar.tipo_predio">

                    <input title="Número de registro" placeholder="Registro" type="number" class="bg-white rounded text-xs w-20 @error('modelo_editar.numero_registro') border-1 border-red-500 @enderror" wire:model.lazy="modelo_editar.numero_registro">

                </div>

            </div>

            <div class="space-y-3">

                <x-input-group for="modelo_editar.tipo" label="Tipo" :error="$errors->first('modelo_editar.tipo')" class="w-full">

                    <x-input-select id="modelo_editar.tipo" wire:model.live="modelo_editar.tipo" class="w-full" :disabled="auth()->user()->area == 'Oficina de rentas'">

                        <option value="">Seleccione una opción</option>
                        <option value="ignorado">Predio ignorado</option>
                        <option value="variacion">Variación catastral</option>

                    </x-input-select>

                </x-input-group>

                <x-input-group for="modelo_editar.promovente" label="Promovente" :error="$errors->first('modelo_editar.promovente')" class="w-full">

                    <x-input-text id="modelo_editar.promovente" wire:model="modelo_editar.promovente" />

                </x-input-group>

                @if($modelo_editar->tipo === 'variacion')

                    <x-input-group for="modelo_editar.finado" label="Finado" :error="$errors->first('modelo_editar.finado')" class="w-full">

                        <x-input-text id="modelo_editar.finado" wire:model="modelo_editar.finado" />

                    </x-input-group>

                @endif

                <x-input-group for="modelo_editar.oficina_id" label="Municipio" :error="$errors->first('modelo_editar.oficina_id')" class="w-full">

                    <x-input-select id="modelo_editar.oficina_id" wire:model="modelo_editar.oficina_id" class="w-full" :disabled="auth()->user()->area == 'Oficina de rentas'">

                        <option value="">Seleccione una opción</option>

                        @foreach ($oficinas as $oficina)

                            <option value="{{ $oficina->id }}">{{ $oficina->nombre }}</option>

                        @endforeach

                    </x-input-select>

                </x-input-group>

            </div>

        </x-slot>

        <x-slot name="footer">

            <div class="flex gap-3">

                <x-button-blue
                    wire:click="guardar"
                    wire:loading.attr="disabled"
                    wire:target="guardar">

                    <div wire:loading.flex class="flex items-center" wire:target="guardar">
                        <svg class="animate-spin h-4 w-4 mr-2 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>

                    Guardar
                </x-button-blue>

                <x-button-red
                    wire:click="resetearTodo"
                    wire:loading.attr="disabled"
                    wire:target="resetearTodo"
                    type="button">
                    Cerrar
                </x-button-red>

            </div>

        </x-slot>

    </x-dialog-modal>


</div>
