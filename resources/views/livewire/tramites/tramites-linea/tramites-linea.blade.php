<div id="tramties">

    <div class="mb-2 lg:mb-5">

        <x-header>Trámites en línea</x-header>

        <div class="flex gap-3 overflow-auto p-1">

            <select class="bg-white rounded-full text-sm" wire:model.live="filters.año">

                @foreach ($años as $año)

                    <option value="{{ $año }}">{{ $año }}</option>

                @endforeach

            </select>

            <input type="number" wire:model.live.debounce.500mse="filters.folio" placeholder="Folio" class="bg-white rounded-full text-sm w-24">
            {{-- <select class="bg-white rounded-full text-sm w-60" wire:model.live="filters.servicio">

                <option value="" selected>Servicio</option>

                @foreach ($servicios as $servicio)

                    <option value="{{ $servicio->id }}" class="truncate">{{ $servicio->nombre }}</option>

                @endforeach

            </select> --}}

            <input type="text" wire:model.live.debounce.500ms="filters.search" placeholder="Solicitante" class="bg-white rounded-full text-sm">

            <select class="bg-white rounded-full text-sm w-fit" wire:model.live="pagination">

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

                <x-table.heading sortable wire:click="sortBy('año')" :direction="$sort === 'año' ? $direction : null" >Año</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('folio')" :direction="$sort === 'folio' ? $direction : null" >Folio</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('usuario')" :direction="$sort === 'usuario' ? $direction : null" >Usuario</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('estado')" :direction="$sort === 'estado' ? $direction : null" >Estado</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('tipo_tramite')" :direction="$sort === 'tipo_tramite' ? $direction : null" >Tipo de trámite</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('servicio_id')" :direction="$sort === 'servicio_id' ? $direction : null" >Servicio</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('solicitante')" :direction="$sort === 'solicitante' ? $direction : null" >Solicitante</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('cantidad')" :direction="$sort === 'cantidad' ? $direction : null" >Cantidad</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('monto')" :direction="$sort === 'monto' ? $direction : null" >Monto</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('fecha_entrega')" :direction="$sort === 'fecha_entrega' ? $direction : null" >Fecha de entrega</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('fecha_pago')" :direction="$sort === 'fecha_pago' ? $direction : null" >Fecha de pago</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('created_at')" :direction="$sort === 'created_at' ? $direction : null">Registro</x-table.heading>

            </x-slot>

            <x-slot name="body">

                @forelse ($this->tramites as $tramite)

                    <x-table.row wire:loading.class.delaylongest="opacity-50" wire:key="row-{{ $tramite->id }}">

                        <x-table.cell title="Año">

                            {{ $tramite->año }}

                        </x-table.cell>

                        <x-table.cell title="Folio">

                            {{ $tramite->folio }}

                        </x-table.cell>

                        <x-table.cell title="Usuario">

                            {{ $tramite->usuario }}

                        </x-table.cell>

                        <x-table.cell title="Estado">

                            <span class="bg-{{ $tramite->estado_color }} py-1 px-2 rounded-full text-white text-xs">{{ ucfirst($tramite->estado) }}</span>

                        </x-table.cell>

                        <x-table.cell title="Tipo de trámite">

                            {{ $tramite->tipo_tramite }}

                        </x-table.cell>

                        <x-table.cell title="Servicio">

                            {{ $tramite->servicio->nombre }}

                        </x-table.cell>

                        <x-table.cell title="Nombre del solicitante">

                            {{ $tramite->nombre_solicitante }}

                        </x-table.cell>

                        <x-table.cell title="Cantidad">

                            {{ $tramite->cantidad }}

                        </x-table.cell>

                        <x-table.cell title="Monto">

                            ${{ number_format($tramite->monto, 2) }}

                        </x-table.cell>

                        <x-table.cell title="Fecha de entrega">

                            {{ $tramite->fecha_entrega?->format('d-m-Y') }}

                        </x-table.cell>

                        <x-table.cell title="Fecha de pago">

                            {{ $tramite->fecha_pago ? $tramite->fecha_pago->format('d-m-Y') : 'N/A'}}

                        </x-table.cell>

                        <x-table.cell title="Registrado">

                            <span class="font-semibold">@if($tramite->creadoPor != null)Registrado por: {{$tramite->creadoPor->name}} @else Registro: @endif</span> <br>

                            {{ $tramite->created_at }}

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

                        {{ $this->tramites->links(data: ['scrollTo' => '#tramties'])}}

                    </x-table.cell>

                </x-table.row>

            </x-slot>

        </x-table>

    </div>

    <x-dialog-modal wire:model.live="modal">

        <x-slot name="title">
            Predios asociados
        </x-slot>

        <x-slot name="content">



        </x-slot>

        <x-slot name="footer">

            <div class="flex gap-3">

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
