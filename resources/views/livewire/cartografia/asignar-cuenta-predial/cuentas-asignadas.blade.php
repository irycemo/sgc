<div class="">

    <div class="mb-6">

        <h1 class="text-3xl tracking-widest py-3 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-thin mb-6  bg-white">Cuentas asignadas</h1>

        <div class=" space-y-2">

            <div>

                <select class="bg-white rounded-full text-sm" wire:model.live="filters.valuador">

                    <option value="" selected>Valuador</option>

                    @foreach ($valuadoresAsignados as $valuador)

                        <option value="{{ $valuador->id }}">{{ $valuador->name }}</option>

                    @endforeach

                </select>

                <input type="number" wire:model.live.debounce.500ms="filters.localidad" placeholder="Localidad" class="bg-white rounded-full text-sm">

                <input type="number" wire:model.live.debounce.500ms="filters.oficina" placeholder="Oficina" class="bg-white rounded-full text-sm">

                <select class="bg-white rounded-full text-sm" wire:model.live="filters.tipo">

                    <option value="" selected>Tipo de predio</option>
                    <option value="1">1</option>
                    <option value="2">2</option>

                </select>

                <input type="number" wire:model.live.debounce.500ms="filters.registro" placeholder="Número de registro" class="bg-white rounded-full text-sm">

                <input type="number" wire:model.live.debounce.500ms="filters.documento" placeholder="# de documento" class="bg-white rounded-full text-sm">

                <select class="bg-white rounded-full text-sm" wire:model.live="pagination">

                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>

                </select>

            </div>

            <input wire:model.live.debounce.500ms="filters.observaciones" placeholder="Observaciones" class="bg-white rounded-full text-sm lg:w-1/2">

        </div>

    </div>

    <div class="overflow-x-auto rounded-lg shadow-xl border-t-2 border-t-gray-500">

        <x-table>

            <x-slot name="head">

                <x-table.heading >Valuador</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('localidad')" :direction="$sort === 'localidad' ? $direction : null" >Localidad</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('oficina')" :direction="$sort === 'oficina' ? $direction : null" >Oficina</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('tipo_predio')" :direction="$sort === 'tipo_predio' ? $direction : null" >Tipo de predio</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('numero_registro')" :direction="$sort === 'numero_registro' ? $direction : null" >Número de registro</x-table.heading>
                <x-table.heading >Documento</x-table.heading>
                <x-table.heading >Observaciones</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('created_at')" :direction="$sort === 'created_at' ? $direction : null">Registro</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('updated_at')" :direction="$sort === 'updated_at' ? $direction : null">Actualizado</x-table.heading>
                <x-table.heading >Acciones</x-table.heading>

            </x-slot>

            <x-slot name="body">

                @forelse ($this->predios as $predio)

                    <x-table.row wire:loading.class.delaylongest="opacity-50" wire:key="row-{{ $predio->id }}">

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Valuador</span>

                            {{ $predio->asignadoA->name }}

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

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Documento</span>

                            {{ $predio->tipo_titulo ?? 'N/A' }}-{{ $predio->titulo_propiedad }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Observaciones</span>

                            {{ $predio->observaciones }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Registrado</span>


                            <span class="font-semibold">@if($predio->creadoPor != null)Registrado por: {{$predio->creadoPor->name}} @else Registro: @endif</span> <br>

                            {{ $predio->created_at }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="font-semibold">@if($predio->actualizadoPor != null)Actualizado por: {{$predio->actualizadoPor->name}} @else Actualizado: @endif</span> <br>

                            {{ $predio->updated_at }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Acciones</span>

                            <div class="flex justify-center lg:justify-start gap-2">

                                @can('Reasignar valuador')

                                    <x-button-blue
                                        wire:click="abrirModalReasignar({{$predio->id}})"
                                        wire:loading.attr="disabled"
                                        wire:target="abrirModalReasignar({{$predio->id}})"
                                    >

                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0l3.181 3.183a8.25 8.25 0 0013.803-3.7M4.031 9.865a8.25 8.25 0 0113.803-3.7l3.181 3.182m0-4.991v4.99" />
                                        </svg>

                                        Reasignar

                                    </x-button-blue>

                                @endcan

                            </div>

                        </x-table.cell>

                    </x-table.row>

                @empty

                    <x-table.row wire:key="row-empty">

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

                        {{ $this->predios->links()}}

                    </x-table.cell>

                </x-table.row>

            </x-slot>

        </x-table>

    </div>

    <x-dialog-modal wire:model.live="modal" maxWidth="sm">

        <x-slot name="title">

            Reasignar valuador

        </x-slot>

        <x-slot name="content">

            <div class="relative p-1">

                <div class="flex flex-col md:flex-row justify-between md:space-x-3 mb-5">

                    <x-input-group for="valuador" label="Valuador" :error="$errors->first('valuador')" class="w-full">

                        <x-input-select id="valuador" wire:model="valuador" class="w-full">

                            <option value="">Seleccione una opción</option>

                            @if($valuadores)

                                @foreach ($valuadores as $valuador)

                                    <option value="{{ $valuador->id }}">{{ $valuador->name }}</option>

                                @endforeach

                            @endif

                        </x-input-select>

                    </x-input-group>

                </div>

                <div class="h-full w-full rounded-lg bg-gray-200 bg-opacity-75 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2" wire:loading.delay.longer>

                    <img class="mx-auto h-16" src="{{ asset('storage/img/loading.svg') }}" alt="">

                </div>

            </div>

        </x-slot>

        <x-slot name="footer">

            <div class="flex gap-3">

                <x-button-blue
                    wire:click="reasignar"
                    wire:loading.attr="disabled"
                    wire:target="reasignar">

                    <img wire:loading wire:target="reasignar" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                    Resaiganr
                </x-button-blue>

                <x-button-red
                    wire:click="$set('modal', false)"
                    wire:loading.attr="disabled"
                    wire:target="$set('modal', false)">
                    Cerrar
                </x-button-red>

        </x-slot>

    </x-dialog-modal>

</div>
