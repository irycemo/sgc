<div class="">

    <div class="mb-6">

        <h1 class="text-3xl tracking-widest py-3 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-thin mb-6  bg-white">Predios</h1>

        <div class="flex justify-between">

            <div>

                <input type="number" wire:model.live.debounce.500ms="filters.localidad" placeholder="Localidad" class="bg-white rounded-full text-sm">

                <input type="number" wire:model.live.debounce.500ms="filters.oficina" placeholder="Oficina" class="bg-white rounded-full text-sm">

                <select class="bg-white rounded-full text-sm" wire:model.live="filters.tipo">

                    <option value="" selected>Tipo de predio</option>
                    <option value="1">1</option>
                    <option value="2">2</option>

                </select>

                <input type="number" wire:model.live.debounce.500ms="filters.registro" placeholder="Número de registro" class="bg-white rounded-full text-sm">

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

                <x-table.heading sortable wire:click="sortBy('estado')" :direction="$sort === 'estado' ? $direction : null" >Estado</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('localidad')" :direction="$sort === 'localidad' ? $direction : null" >Localidad</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('oficina')" :direction="$sort === 'oficina' ? $direction : null" >Oficina</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('tipo_predio')" :direction="$sort === 'tipo_predio' ? $direction : null" >Tipo de predio</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('numero_registro')" :direction="$sort === 'numero_registro' ? $direction : null" >Número de registro</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('created_at')" :direction="$sort === 'created_at' ? $direction : null">Registro</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('updated_at')" :direction="$sort === 'updated_at' ? $direction : null">Actualizado</x-table.heading>
                <x-table.heading >Acciones</x-table.heading>

            </x-slot>

            <x-slot name="body">

                @forelse ($predios as $predio)

                    <x-table.row wire:loading.class.delaylongest="opacity-50" wire:key="row-{{ $predio->id }}">

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Estado</span>

                            <span class="bg-{{ $predio->estado_color }} py-1 px-2 rounded-full text-white text-xs">{{ ucfirst($predio->status) }}</span>

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

                            <div class="flex justify-center lg:justify-start gap-2">

                                @can('Ver predio')

                                    <x-link-blue href="{{ route('ver_predio', $predio) }}">

                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>

                                        <span>Ver</span>

                                    </x-link-blue>

                                @endcan

                                @can('Bloquear predio')

                                    <x-button-red
                                        wire:click="abrirModal({{ $predio->id }})"
                                        wire:loading.attr="disabled">

                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M16.5 10.5V6.75a4.5 4.5 0 1 0-9 0v3.75m-.75 11.25h10.5a2.25 2.25 0 0 0 2.25-2.25v-6.75a2.25 2.25 0 0 0-2.25-2.25H6.75a2.25 2.25 0 0 0-2.25 2.25v6.75a2.25 2.25 0 0 0 2.25 2.25Z" />
                                        </svg>

                                        <span>Bloqueo</span>

                                    </x-button-red>

                                @endcan

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

                        {{ $predios->links()}}

                    </x-table.cell>

                </x-table.row>

            </x-slot>

        </x-table>

    </div>

    <x-dialog-modal wire:model="modal" maxWidth="sm">

        <x-slot name="title">
            Bloqueo
        </x-slot>

        <x-slot name="content">

            @if($this->modelo_editar->bloqueadoActivo())

                <div class="rounded-lg bg-gray-100 p-2 mb-3">

                    <p>El predio se encuentra bloqueado por el siguiente motivo:</p>

                    <p>{{ $this->modelo_editar->bloqueos->where('estado', 'activo')->first()->observaciones }}</p>

                </div>

            @endif

            <x-input-group for="observaciones" label="Observaciones" :error="$errors->first('observaciones')" class="w-full">

                <textarea class="bg-white rounded w-full" rows="5" wire:model="observaciones" placeholder="Menciona el oficio mediante el cual se solicita el bloqueo o desbloqueo"></textarea>

            </x-input-group>

        </x-slot>

        <x-slot name="footer">

            <x-secondary-button
                wire:click="$toggle('modal')"
                wire:loading.attr="disabled"
            >
                No
            </x-secondary-button>

            <x-danger-button
                class="ml-2"
                wire:click="bloquear"
                wire:loading.attr="disabled"
                wire:target="bloquear"
            >
                @if($this->modelo_editar->bloqueadoActivo())Desbloquear @else Bloquear @endif
            </x-danger-button>

        </x-slot>

    </x-dialog-modal>

</div>
