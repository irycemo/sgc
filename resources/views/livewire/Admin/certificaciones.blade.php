<div class="">

    <div class="mb-6">

        <x-header>Certificaciones</x-header>

        <div class="flex justify-between">

            <div class="flex gap-3">

                <select class="bg-white rounded-full text-sm" wire:model.live="filters.año">

                    <option value="" selected>Año</option>

                    @foreach ($años as $año)

                        <option value="{{ $año }}">{{ $año }}</option>

                    @endforeach

                </select>

                <input type="number" wire:model.live.debounce.500ms="filters.folio" placeholder="Folio" class="bg-white rounded-full text-sm w-24">

                <select class="bg-white rounded-full text-sm" wire:model.live="filters.estado">

                    <option value="" selected>Estado</option>
                    <option value="activo">Activo</option>
                    <option value="cancelado">Cancelado</option>
                    <option value="caducado">Caducado</option>

                </select>

                <select class="bg-white rounded-full text-sm w-60" wire:model.live="filters.documento">

                    <option value="" selected>Documento</option>

                    @foreach ($documentos as $docuemnto)

                        <option value="{{ $docuemnto }}">{{ $docuemnto }}</option>

                    @endforeach

                </select>

                <select class="bg-white rounded-full text-sm w-60" wire:model.live="filters.oficina">

                    <option value="" selected>Oficina</option>

                    @foreach ($oficinas as $oficina)

                        <option value="{{ $oficina->id }}">{{ $oficina->nombre }}</option>

                    @endforeach

                </select>

                <input type="number" wire:model.live.debounce.500ms="filters.tAño" placeholder="T. año" class="bg-white rounded-full text-sm w-24">

                <input type="number" wire:model.live.debounce.500ms="filters.tFolio" placeholder="T. Folio" class="bg-white rounded-full text-sm w-24">

                <input type="number" wire:model.live.debounce.500ms="filters.tUsuario" placeholder="T. Usuario" class="bg-white rounded-full text-sm w-24">

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

                <x-table.heading sortable wire:click="sortBy('año')" :direction="$sort === 'año' ? $direction : null" >Año</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('folio')" :direction="$sort === 'folio' ? $direction : null" >Folio</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('documento')" :direction="$sort === 'documento' ? $direction : null" >Documento</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('estado')" :direction="$sort === 'estado' ? $direction : null" >Estado</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('oficina_id')" :direction="$sort === 'oficina_id' ? $direction : null" >Oficina</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('tramite_id')" :direction="$sort === 'tramite_id' ? $direction : null" >Trámite</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('created_at')" :direction="$sort === 'created_at' ? $direction : null">Registro</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('updated_at')" :direction="$sort === 'updated_at' ? $direction : null">Actualizado</x-table.heading>
                <x-table.heading >Acciones</x-table.heading>

            </x-slot>

            <x-slot name="body">

                @forelse ($certificaciones as $certificacion)

                    <x-table.row wire:loading.class.delaylongest="opacity-50" wire:key="row-{{ $certificacion->id }}">

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Año</span>

                            {{ $certificacion->año }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Folio</span>

                            {{ $certificacion->folio }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Documento</span>

                            {{ $certificacion->documento }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Estado</span>

                            @if($certificacion->estado == 'activo')

                                <span class="bg-green-400 py-1 px-2 rounded-full text-white text-xs">{{ ucfirst($certificacion->estado) }}</span>

                            @else

                                <span class="bg-red-400 py-1 px-2 rounded-full text-white text-xs">{{ ucfirst($certificacion->estado) }}</span>

                            @endif

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Oficina</span>

                            {{ $certificacion->oficina->nombre }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Trámite</span>

                            {{ $certificacion->tramite->año }}-{{ $certificacion->tramite->folio }}-{{ $certificacion->tramite->usuario }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Registrado</span>


                            <span class="font-semibold">@if($certificacion->creadoPor != null)Registrado por: {{$certificacion->creadoPor->name}} @else Registro: @endif</span> <br>

                            {{ $certificacion->created_at }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="font-semibold">@if($certificacion->actualizadoPor != null)Actualizado por: {{$certificacion->actualizadoPor->name}} @else Actualizado: @endif</span> <br>

                            {{ $certificacion->updated_at }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Acciones</span>

                            <div class="flex justify-center lg:justify-start gap-2">

                                <x-button-red
                                    wire:click="imprimir('{{ $certificacion->uuid }}')"
                                    wire:loading.attr="disabled">

                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.72 13.829c-.24.03-.48.062-.72.096m.72-.096a42.415 42.415 0 0 1 10.56 0m-10.56 0L6.34 18m10.94-4.171c.24.03.48.062.72.096m-.72-.096L17.66 18m0 0 .229 2.523a1.125 1.125 0 0 1-1.12 1.227H7.231c-.662 0-1.18-.568-1.12-1.227L6.34 18m11.318 0h1.091A2.25 2.25 0 0 0 21 15.75V9.456c0-1.081-.768-2.015-1.837-2.175a48.055 48.055 0 0 0-1.913-.247M6.34 18H5.25A2.25 2.25 0 0 1 3 15.75V9.456c0-1.081.768-2.015 1.837-2.175a48.041 48.041 0 0 1 1.913-.247m10.5 0a48.536 48.536 0 0 0-10.5 0m10.5 0V3.375c0-.621-.504-1.125-1.125-1.125h-8.25c-.621 0-1.125.504-1.125 1.125v3.659M18 10.5h.008v.008H18V10.5Zm-3 0h.008v.008H15V10.5Z" />
                                    </svg>

                                    <span>Reimprimir</span>

                                </x-button-red>

                                @can('Editar permiso')

                                    <x-button-blue
                                        wire:click="abrirModalEditar('{{ $certificacion->uuid }}')"
                                        wire:loading.attr="disabled">

                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4 mr-2">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                        </svg>

                                        <span>Editar</span>

                                    </x-button-blue>

                                @endcan

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

                        {{ $certificaciones->links()}}

                    </x-table.cell>

                </x-table.row>

            </x-slot>

        </x-table>

    </div>

    <x-dialog-modal wire:model="modal" maxWidth="sm">

        <x-slot name="title">

                Editar Certificación

        </x-slot>

        <x-slot name="content">
        </x-slot>

        <x-slot name="footer">

            <div class="flex gap-3">

                <x-button-blue
                    wire:click="actualizar"
                    wire:loading.attr="disabled"
                    wire:target="actualizar">

                    <img wire:loading wire:target="actualizar" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                    <span>Actualizar</span>
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

    <x-confirmation-modal wire:model="modalBorrar" maxWidth="sm">

        <x-slot name="title">
            Eliminar Certificación
        </x-slot>

        <x-slot name="content">
            ¿Esta seguro que desea eliminar la certificación? No sera posible recuperar la información.
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
                wire:click="borrar"
                wire:loading.attr="disabled"
                wire:target="borrar"
            >
                Borrar
            </x-danger-button>

        </x-slot>

    </x-confirmation-modal>

</div>
