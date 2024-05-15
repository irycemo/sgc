<div class="">

    <div class="mb-6">

        <x-header>Mis avaluos</x-header>

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
                <x-table.heading sortable wire:click="sortBy('estado')" :direction="$sort === 'estado' ? $direction : null" >Estado</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('año')" :direction="$sort === 'año' ? $direction : null" >Año</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('folio')" :direction="$sort === 'folio' ? $direction : null" >Folio</x-table.heading>
                <x-table.heading >Cuenta predial</x-table.heading>
                <x-table.heading >Clave catastral</x-table.heading>
                <x-table.heading >Propietario</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('created_at')" :direction="$sort === 'created_at' ? $direction : null">Registro</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('updated_at')" :direction="$sort === 'updated_at' ? $direction : null">Actualizado</x-table.heading>
                <x-table.heading >Acciones</x-table.heading>

            </x-slot>

            <x-slot name="body">

                @forelse ($avaluos as $avaluo)

                    <x-table.row wire:loading.class.delaylongest="opacity-50" wire:key="row-{{ $avaluo->id }}">

                        <x-table.cell>

                            <div class="felx items-center">

                                <input type="checkbox" wire:model="seleccionados" value="{{ $avaluo->id }}" class="rounded">

                            </div>

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Estado</span>

                            <span class="bg-{{ $avaluo->estado_color }} py-1 px-2 rounded-full text-white text-xs">{{ ucfirst($avaluo->estado) }}</span>

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Año</span>

                            {{ $avaluo->año }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Folio</span>

                            {{ $avaluo->folio }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Cuenta predial</span>

                            {{ $avaluo->predioAvaluo->cuentaPredial() }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Clave catastral</span>

                            {{ $avaluo->predioAvaluo->claveCatastral() }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Propietario</span>

                            {{ $avaluo->predioAvaluo->primerPropietario() }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Registrado</span>


                            <span class="font-semibold">@if($avaluo->creadoPor != null)Registrado por: {{$avaluo->creadoPor->name}} @else Registro: @endif</span> <br>

                            {{ $avaluo->created_at }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="font-semibold">@if($avaluo->actualizadoPor != null)Actualizado por: {{$avaluo->actualizadoPor->name}} @else Actualizado: @endif</span> <br>

                            {{ $avaluo->updated_at }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Acciones</span>

                            <div class="flex justify-center lg:justify-start gap-2">

                                @if($avaluo->predioAvaluo->numero_registro)

                                    <x-link-blue href="{{ route('valuacion_y_desglose', $avaluo) }}" >
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        Ver
                                    </x-link-blue>

                                @else

                                    <x-link-blue href="{{ route('avaluo_predio_ignorado', $avaluo) }}" >
                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                        Ver
                                    </x-link-blue>

                                @endif

                                @if($avaluo->estado == 'impreso')

                                    <x-button-red
                                        wire:click="imprimirAvaluo({{ $avaluo->id }})"
                                        wire:loading.attr="disabled">
                                        Imprimir
                                    </x-button-red>

                                @endif

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

                        {{ $avaluos->links()}}

                    </x-table.cell>

                </x-table.row>

            </x-slot>

        </x-table>

    </div>

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
