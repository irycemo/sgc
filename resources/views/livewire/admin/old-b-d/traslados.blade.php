
<div class="">

    <div class="mb-6">

        <x-header>Traslados</x-header>

        <div class=" mx-auto">

            <div class="flex gap-1 p-1 justify-center">

                <input type="number" wire:model.live.debounce.500ms="filters.locl" placeholder="Localidad" class="bg-white rounded-full text-sm w-24">

                <input type="number" wire:model.live.debounce.500ms="filters.ofna" placeholder="Oficina" class="bg-white rounded-full text-sm w-24">

                <input type="number" wire:model.live.debounce.500ms="filters.tpre" placeholder="T. Predio" class="bg-white rounded-full text-sm w-24">

                <input type="number" wire:model.live.debounce.500ms="filters.nreg" placeholder="# Registro" class="bg-white rounded-full text-sm w-24">

            </div>

            <div class="flex gap-1 p-1 justify-center">

                <input type="number" wire:model.live.debounce.500ms="filters.anit" placeholder="Año" class="bg-white rounded-full text-sm w-24">

                <input type="number" wire:model.live.debounce.500ms="filters.cont" placeholder="Cont" class="bg-white rounded-full text-sm w-24">

                <input type="number" wire:model.live.debounce.500ms="filters.cnot" placeholder="Not" class="bg-white rounded-full text-sm w-24">

            </div>

            {{-- <div class="flex gap-1 p-1 justify-center">

                <input wire:model.live.debounce.500ms="search" placeholder="Tipo / Empleado" class="bg-white rounded-full text-sm">

            </div> --}}

            <div class="flex gap-1 p-1 justify-center">

                <x-button-blue
                    wire:click="buscar"
                    wire:target="buscar"
                    wire:loading.attr="disabled"
                >

                    <img wire:loading wire:target="buscar" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                    <span>Buscar</span>

                </x-button-blue>

            </div>

        </div>

    </div>

    <div class="overflow-x-auto rounded-lg shadow-xl border-t-2 border-t-gray-500">

        <x-table>

            <x-slot name="head">

                <x-table.heading >Cuenta predial</x-table.heading>
                <x-table.heading >Folio</x-table.heading>
                <x-table.heading >Status</x-table.heading>
                <x-table.heading >Acto</x-table.heading>
                <x-table.heading >Fecha firma</x-table.heading>
                <x-table.heading >Transmitente</x-table.heading>
                <x-table.heading >Adquiriente</x-table.heading>

            </x-slot>

            <x-slot name="body">

                @forelse ($traslados as $traslado)

                    <x-table.row wire:loading.class.delaylongest="opacity-50" wire:key="row-{{ $traslado->id }}">

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Cuenta predial</span>

                            {{ $traslado->locl }}-{{ $traslado->ofna }}-{{ $traslado->tpre }}-{{ $traslado->nreg }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Folio</span>

                            {{ $traslado->anit }}-{{ $traslado->cont }}-{{ $traslado->cnot }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Status</span>

                            {{ $traslado->stat }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Acto</span>

                            {{ $traslado->act1 }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Fecha firma</span>

                            {{ $traslado->ffir }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Transmitente</span>

                            {{ $traslado->nven }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Adquiriente</span>

                            {{ $traslado->adquiriente }}

                        </x-table.cell>


                    </x-table.row>

                @empty

                    <x-table.row>

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



                    </x-table.cell>

                </x-table.row>

            </x-slot>

        </x-table>

    </div>

</div>
