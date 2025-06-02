<div class="">

    <div class="mb-6">

        <x-header>Valores unitarios por hectarea de predios rusticos</x-header>

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

        </div>

    </div>

    <div class="overflow-x-auto rounded-lg shadow-xl border-t-2 border-t-gray-500">

        <x-table>

            <x-slot name="head">

                <x-table.heading sortable wire:click="sortBy('concepto')" :direction="$sort === 'concepto' ? $direction : null" >Concepto</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('valor')" :direction="$sort === 'valor' ? $direction : null">Valor</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('valor_aterior')" :direction="$sort === 'valor' ? $direction : null">Valor anterior</x-table.heading>

            </x-slot>

            <x-slot name="body">

                @forelse ($valores as $valor)

                    <x-table.row wire:loading.class.delaylongest="opacity-50" wire:key="row-{{ $valor->id }}">

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Concepto</span>

                            {{ $valor->concepto }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Valor</span>

                            ${{ number_format($valor->valor, 2) }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Valor anterior</span>

                            ${{ number_format($valor->valor_aterior, 2) }}

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

                        {{ $valores->links()}}

                    </x-table.cell>

                </x-table.row>

            </x-slot>

        </x-table>

    </div>

</div>
