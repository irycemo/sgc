<div class="">

    <div class="mb-6">

        <h1 class="text-3xl tracking-widest py-3 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-thin mb-6  bg-white">Avaluos</h1>

        <div class="flex justify-between">

            <div>

                <select class="bg-white rounded-full text-sm" wire:model.live="filters.año">

                    @foreach ($años as $año)

                        <option value="{{ $año }}">{{ $año }}</option>

                    @endforeach

                </select>

                <input type="number" wire:model.live.debounce.500ms="filters.folio" placeholder="Folio" class="bg-white rounded-full text-sm w-24">

                <input type="number" wire:model.live.debounce.500ms="filters.usuario" placeholder="Usuario" class="bg-white rounded-full text-sm w-24">

                <select class="bg-white rounded-full text-sm" wire:model.live="filters.estado">

                    <option value="" selected>Estado</option>
                    <option value="nuevo">Nuevo</option>
                    <option value="impreso">Impreso</option>
                    <option value="concluido">Concluido</option>
                    <option value="notificado">Notificado</option>

                </select>

                <select class="bg-white rounded-full text-sm" wire:model.live="filters.valuador">

                    <option value="" selected>Valuador</option>

                    @foreach ($valuadores as $valuador)

                        <option value="{{ $valuador->id }}">{{ $valuador->name }}</option>

                    @endforeach

                </select>

                <div class="flex gap-1 p-1">

                    <input type="number" wire:model.live.debounce.500ms="filters.tAño" placeholder="T. año" class="bg-white rounded-full text-sm w-24">

                    <input type="number" wire:model.live.debounce.500ms="filters.tFolio" placeholder="T. Folio" class="bg-white rounded-full text-sm w-24">

                    <input type="number" wire:model.live.debounce.500ms="filters.tUsuario" placeholder="T. Usuario" class="bg-white rounded-full text-sm w-24">

                    <input type="number" wire:model.live.debounce.500ms="filters.localidad" placeholder="Localidad" class="bg-white rounded-full text-sm w-24">

                    <input type="number" wire:model.live.debounce.500ms="filters.oficina" placeholder="Oficina" class="bg-white rounded-full text-sm w-24">

                    <select class="bg-white rounded-full text-sm" wire:model.live="filters.tipo">

                        <option value="" selected>Tipo</option>
                        <option value="1">1</option>
                        <option value="2">2</option>

                    </select>

                    <input type="number" wire:model.live.debounce.500ms="filters.registro" placeholder="# Registro" class="bg-white rounded-full text-sm w-24">

                    <select class="bg-white rounded-full text-sm" wire:model.live="pagination">

                        <option value="10">10</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="100">100</option>

                    </select>

                </div>

            </div>

            <div x-show="$wire.seleccionados.length > 0" x-cloak>

                <button wire:click="$toggle('modal')" class="bg-red-500 hover:shadow-lg hover:bg-red-700 float-right text-sm py-2 px-4 text-white rounded-full focus:outline-none hidden md:block focus:outline-red-400 focus:outline-offset-2">

                    <div wire:loading.flex wire:target="$toggle('modal')" class="flex absolute top-1 right-1 items-center">
                        <svg class="animate-spin h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>

                    <span>Eliminar</span>

                    <span x-text="$wire.seleccionados.length"></span>

                </button>

                <button wire:click="$toggle('modal')" class="bg-red-500 hover:shadow-lg hover:bg-red-700 float-right text-sm py-2 px-4 text-white rounded-full focus:outline-none md:hidden focus:outline-red-400 focus:outline-offset-2">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4 mr-2">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>

                </button>

            </div>

        </div>

    </div>

    <div class="overflow-x-auto rounded-lg shadow-xl border-t-2 border-t-gray-500">

        <x-table>

            <x-slot name="head">

                <x-table.heading >

                    <div x-data="checkAll">

                        <input x-ref="checkbox" @change="handleCheck" type="checkbox" class="rounded">

                    </div>

                </x-table.heading>
                <x-table.heading >Año</x-table.heading>
                <x-table.heading >Folio</x-table.heading>
                <x-table.heading >Usuario</x-table.heading>
                <x-table.heading >Estado</x-table.heading>
                <x-table.heading >Valuador</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('localidad')" :direction="$sort === 'localidad' ? $direction : null">Localidad</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('oficina')" :direction="$sort === 'oficina' ? $direction : null">Oficina</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('tipo_predio')" :direction="$sort === 'tipo_predio' ? $direction : null">Tipo de predio</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('numero_registro')" :direction="$sort === 'numero_registro' ? $direction : null">Número de registro</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('created_at')" :direction="$sort === 'created_at' ? $direction : null">Registro</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('updated_at')" :direction="$sort === 'updated_at' ? $direction : null">Actualizado</x-table.heading>
                <x-table.heading >Acciones</x-table.heading>

            </x-slot>

            <x-slot name="body">

                @forelse ($this->predios as $predio)

                    <x-table.row wire:loading.class.delaylongest="opacity-50" wire:key="row-{{ $predio->id }}">

                        <x-table.cell>

                            <div class="felx items-center">

                                <input type="checkbox" wire:model="seleccionados" value="{{ $predio->avaluo->id }}" class="rounded">

                            </div>

                        </x-table.cell>
                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Año</span>

                            {{ $predio->avaluo->año }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Folio</span>

                            {{ $predio->avaluo->folio }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Usuario</span>

                            {{ $predio->avaluo->usuario }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Estado</span>

                            <span class="bg-{{ $predio->avaluo->estado_color }} py-1 px-2 rounded-full text-white text-xs">{{ ucfirst($predio->avaluo->estado) }}</span>

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Valuador</span>

                            {{ $predio->avaluo->asignadoA->name }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Localidad</span>

                            {{ $predio->localidad }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Oficina</span>

                            {{ $predio->oficina }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Tipo de predio</span>

                            {{ $predio->tipo_predio }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Número de registro</span>

                            {{ $predio->numero_registro }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Registrado</span>

                            {{ $predio->created_at }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="font-semibold">@if($predio->actualizadoPor != null)Actualizado por: {{$predio->actualizadoPor->name}} @else Actualizado: @endif</span> <br>

                            {{ $predio->updated_at }}

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

                                    @can('Ver predio')

                                        <a
                                            href="{{ route('ver_predio_avaluo', $predio->id) }}"
                                            class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                            role="menuitem">
                                            Ver
                                        </a>

                                    @endcan

                                    @if(in_array($predio->avaluo->estado, ['notificado', 'impreso']))

                                        <button
                                            wire:click="imprimirAvaluo({{ $predio->id }})"
                                            wire:loading.attr="disabled"
                                            class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                            role="menuitem">
                                            Imprimir
                                        </button>

                                    @endif

                                    @if($predio->avaluo->estado != 'notificado')

                                        @can('Reasignar valuador')

                                            <button
                                                wire:click="abrirModal({{ $predio->id }})"
                                                wire:loading.attr="disabled"
                                                class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                                role="menuitem">
                                                Reasignar
                                            </button>

                                        @endcan

                                    @endif

                                </div>

                            </div>

                        </x-table.cell>

                    </x-table.row>

                @empty

                    <x-table.row wire:key="row-empty">

                        <x-table.cell colspan="13">

                            <div class="bg-white text-gray-500 text-center p-5 rounded-full text-lg">

                                No hay resultados.

                            </div>

                        </x-table.cell>

                    </x-table.row>

                @endforelse

            </x-slot>

            <x-slot name="tfoot">

                <x-table.row>

                    <x-table.cell colspan="13" class="bg-gray-50">

                        {{ $this->predios->links()}}

                    </x-table.cell>

                </x-table.row>

            </x-slot>

        </x-table>

    </div>

    <x-dialog-modal wire:model="modalReasignar" maxWidth="sm">

        <x-slot name="title">
            Reasignar avaluo
        </x-slot>

        <x-slot name="content">

            <x-input-group for="valuador_id" label="Valuador" :error="$errors->first('valuador_id')" class="w-full">

                <x-input-select id="valuador_id" wire:model="valuador_id" class="w-full">

                    <option value="">Seleccione una opción</option>

                    @foreach ($valuadores as $valuador)

                            <option value="{{ $valuador->id }}">{{ $valuador->name }}</option>

                    @endforeach

                </x-input-select>

            </x-input-group>

        </x-slot>

        <x-slot name="footer">

            <x-secondary-button
                wire:click="$toggle('modalReasignar')"
                wire:loading.attr="disabled"
            >
                Cancelar
            </x-secondary-button>

            <x-danger-button
                class="ml-2"
                wire:click="reasignar"
                wire:loading.attr="disabled"
                wire:target="reasignar"
            >
                Reasignar
            </x-danger-button>

        </x-slot>

    </x-dialog-modal>

    <x-confirmation-modal wire:model.live="modal" maxWidth="sm">

        <x-slot name="title">
            Eliminar avalúos
        </x-slot>

        <x-slot name="content">
            ¿Esta seguro que desea eliminar la información? No sera posible recuperarla.
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
                wire:click="eliminar"
                wire:loading.attr="disabled"
                wire:target="eliminar"
            >
                Borrar
            </x-danger-button>

        </x-slot>

    </x-confirmation-modal>

    @script

        <script>

            Alpine.data('checkAll', () => {

                return{

                    init(){

                        this.$wire.$watch('seleccionados', () => {

                            this.updateCheckAllState()

                        })

                        this.$wire.$watch('idsEnPagina', () => {

                            this.updateCheckAllState()

                        })

                    },

                    updateCheckAllState(){

                        if(this.pageIsSelected()){

                            this.$refs.checkbox.checked = true

                            this.$refs.checkbox.indeterminate = false

                        }else if(this.pageIsEmpty()){

                            this.$refs.checkbox.checked = false

                            this.$refs.checkbox.indeterminate = false

                        }else{

                            this.$refs.checkbox.checked = false

                            this.$refs.checkbox.indeterminate = true

                        }

                    },

                    pageIsSelected(){

                        return this.$wire.idsEnPagina.every(id => $wire.seleccionados.includes(id))

                    },

                    pageIsEmpty(){

                        return this.$wire.seleccionados.length === 0

                    },

                    handleCheck(e){

                        e.target.checked ? this.selectAll() : this.diselectAll()

                    },

                    selectAll(){

                        this.$wire.idsEnPagina.forEach(id => {

                            if(this.$wire.seleccionados.includes(id)) return

                            this.$wire.seleccionados.push(id)

                        })

                    },

                    diselectAll(){

                        this.$wire.seleccionados = []

                    },

                }

            })

        </script>

    @endscript

</div>
