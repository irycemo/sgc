<div class="">

    <div class="mb-6">

        <x-header>Oficinas</x-header>

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

            @can('Crear oficina')

                <button wire:click="abrirModalCrear" class="bg-gray-500 hover:shadow-lg hover:bg-gray-700 text-sm py-2 px-4 text-white rounded-full hidden md:block items-center justify-center focus:outline-gray-400 focus:outline-offset-2">

                    <img wire:loading wire:target="abrirModalCrear" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">
                    Agregar nueva oficina

                </button>

                <button wire:click="abrirModalCrear" class="bg-gray-500 hover:shadow-lg hover:bg-gray-700 float-right text-sm py-2 px-4 text-white rounded-full focus:outline-none md:hidden">+</button>

            @endcan

        </div>

    </div>

    <div class="overflow-x-auto rounded-lg shadow-xl border-t-2 border-t-gray-500">

        <x-table>

            <x-slot name="head">

                <x-table.heading sortable wire:click="sortBy('municipio')" :direction="$sort === 'municipio' ? $direction : null" >Municipio</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('nombre')" :direction="$sort === 'nombre' ? $direction : null" >Nombre</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('oficina')" :direction="$sort === 'oficina' ? $direction : null" >Oficina</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('localidad')" :direction="$sort === 'localidad' ? $direction : null" >Localidad</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('titular')" :direction="$sort === 'titular' ? $direction : null" >Titular</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('created_at')" :direction="$sort === 'created_at' ? $direction : null">Registro</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('updated_at')" :direction="$sort === 'updated_at' ? $direction : null">Actualizado</x-table.heading>
                <x-table.heading >Acciones</x-table.heading>

            </x-slot>

            <x-slot name="body">

                @forelse ($oficinas as $oficina)

                    <x-table.row wire:loading.class.delaylongest="opacity-50" wire:key="row-{{ $oficina->id }}">

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Municipio</span>

                            {{ $oficina->municipio }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Nombre</span>

                            {{ $oficina->nombre }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Oficina</span>

                            {{ $oficina->oficina }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Localidad</span>

                            {{ $oficina->localidad }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">titular</span>

                            {{ $oficina->titular }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Registrado</span>


                            <span class="font-semibold">@if($oficina->creadoPor != null)Registrado por: {{$oficina->creadoPor->name}} @else Registro: @endif</span> <br>

                            {{ $oficina->created_at }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="font-semibold">@if($oficina->actualizadoPor != null)Actualizado por: {{$oficina->actualizadoPor->name}} @else Actualizado: @endif</span> <br>

                            {{ $oficina->updated_at }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Acciones</span>

                            <div class="flex justify-center lg:justify-start gap-2">

                                @can('Ver oficina')

                                    <x-link-green href="{{ route('ver_oficina', $oficina) }}">

                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>

                                        Ver

                                    </x-link-green>

                                @endcan

                                @can('Editar oficina')

                                    <x-button-blue
                                        wire:click="abrirModalEditar({{$oficina->id}})"
                                        wire:loading.attr="disabled"
                                        wire:target="abiriModalEditar({{$oficina->id}})"
                                    >


                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4 mr-2">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>

                                        Editar

                                    </x-button-blue>

                                @endcan

                                @can('Borrar oficina')

                                    <x-button-red
                                        wire:click="abrirModalBorrar({{$oficina->id}})"
                                        wire:loading.attr="disabled"
                                        wire:target="abrirModalBorrar({{$oficina->id}})"
                                    >

                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4 mr-2">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                        </svg>

                                        Eliminar

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

                        {{ $oficinas->links()}}

                    </x-table.cell>

                </x-table.row>

            </x-slot>

        </x-table>

    </div>

    <x-dialog-modal wire:model.live="modal">

        <x-slot name="title">

            @if($crear)
                Nueva Oficina
            @elseif($editar)
                Editar Oficina
            @endif

        </x-slot>

        <x-slot name="content">

            <div class="relative p-1">

                <div class="flex flex-col md:flex-row justify-between md:space-x-3 mb-3">

                    <x-input-group for="modelo_editar.municipio" label="Municipio" :error="$errors->first('modelo_editar.municipio')" class="w-full">

                        <x-input-text type="number" id="modelo_editar.municipio" wire:model="modelo_editar.municipio" />

                    </x-input-group>

                    <x-input-group for="modelo_editar.oficina" label="Oficina" :error="$errors->first('modelo_editar.oficina')" class="w-full">

                        <x-input-text type="number" id="modelo_editar.oficina" wire:model="modelo_editar.oficina" />

                    </x-input-group>

                    <x-input-group for="modelo_editar.localidad" label="Localidad" :error="$errors->first('modelo_editar.localidad')" class="w-full">

                        <x-input-text type="number" id="modelo_editar.localidad" wire:model="modelo_editar.localidad" />

                    </x-input-group>

                </div>

                <div class="flex flex-col md:flex-row justify-between md:space-x-3 mb-3">

                    <x-input-group for="modelo_editar.nombre" label="Nombre" :error="$errors->first('modelo_editar.nombre')" class="w-full">

                        <x-input-text id="modelo_editar.nombre" wire:model="modelo_editar.nombre" />

                    </x-input-group>

                    <x-input-group for="modelo_editar.titular" label="Titular" :error="$errors->first('modelo_editar.titular')" class="w-full">

                        <x-input-text id="modelo_editar.titular" wire:model="modelo_editar.titular" />

                    </x-input-group>

                </div>

                <div class="flex flex-col md:flex-row justify-between md:space-x-3 mb-3">

                    <x-input-group for="modelo_editar.telefonos" label="Teléfonos" :error="$errors->first('modelo_editar.telefonos')" class="w-full">

                        <x-input-text id="modelo_editar.telefonos" wire:model="modelo_editar.telefonos" />

                    </x-input-group>

                    <x-input-group for="modelo_editar.email" label="Teléfonos" :error="$errors->first('modelo_editar.email')" class="w-full">

                        <x-input-text type="email" id="modelo_editar.email" wire:model="modelo_editar.email" />

                    </x-input-group>

                </div>


                <div class="flex flex-col md:flex-row justify-between md:space-x-3 mb-3">

                    <x-input-group for="modelo_editar.valuador_municipal" label="Valuador municipal" :error="$errors->first('modelo_editar.valuador_municipal')" class="w-full">

                        <x-input-text id="modelo_editar.valuador_municipal" wire:model="modelo_editar.valuador_municipal" />

                    </x-input-group>

                    <x-input-group for="modelo_editar.autoridad_municipal" label="Autoridad municipal" :error="$errors->first('modelo_editar.autoridad_municipal')" class="w-full">

                        <x-input-text id="modelo_editar.autoridad_municipal" wire:model="modelo_editar.autoridad_municipal" />

                    </x-input-group>

                </div>

                <div class="flex-auto ">

                    <x-input-group for="modelo_editar.ubicacion" label="Ubicación" :error="$errors->first('modelo_editar.ubicacion')" class="w-full">

                        <x-input-text wire:model="modelo_editar.ubicacion"></x-input-text>

                    </x-input-group>

                </div>

                <div class="h-full w-full rounded-lg bg-gray-200 bg-opacity-75 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2" wire:loading.delay.longer>

                    <img class="mx-auto h-16" src="{{ asset('storage/img/loading.svg') }}" alt="">

                </div>

                <div class="flex flex-col md:flex-row justify-between md:space-x-3 mb-3">

                    <x-input-group for="sectorInicial" label="Sector inicial" :error="$errors->first('sectorInicial')" class="w-full">

                        <x-input-text type="number" id="sectorInicial" wire:model="sectorInicial" />

                    </x-input-group>

                    <x-input-group for="sectorFinal" label="Sector final" :error="$errors->first('sectorFinal')" class="w-full">

                        <x-input-text type="number" id="sectorFinal" wire:model="sectorFinal" />

                    </x-input-group>

                </div>

                @if($sectores)

                    <div>

                        <p>Sectores:</p>
                        <p>
                            @foreach ($sectores as $sector)

                                {{ $sector }},

                            @endforeach
                        </p>

                    </div>

                @endif

                <div class="h-full w-full rounded-lg bg-gray-200 bg-opacity-75 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2" wire:loading.delay.longer>

                    <img class="mx-auto h-16" src="{{ asset('storage/img/loading.svg') }}" alt="">

                </div>

            </div>

        </x-slot>

        <x-slot name="footer">

            <div class="flex items-center gap-3">

                @if($crear)

                    <x-button-blue
                        wire:click="guardar"
                        wire:loading.attr="disabled"
                        wire:target="guardar">

                        <img wire:loading wire:target="guardar" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                        Guardar
                    </x-button-blue>

                @elseif($editar)

                    <x-button-blue
                        wire:click="actualizar"
                        wire:loading.attr="disabled"
                        wire:target="actualizar">

                        <img wire:loading wire:target="actualizar" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                        Actualizar
                    </x-button-blue>

                @endif

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

    <x-confirmation-modal wire:model.live="modalBorrar" maxWidth="sm">

        <x-slot name="title">
            Eliminar Oficina
        </x-slot>

        <x-slot name="content">
            ¿Esta seguro que desea eliminar la oficina? No sera posible recuperar la información.
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
                wire:click="borrar()"
                wire:loading.attr="disabled"
                wire:target="borrar"
            >
                Borrar
            </x-danger-button>

        </x-slot>

    </x-confirmation-modal>

</div>
