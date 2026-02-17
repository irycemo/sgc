<div class="">

    <div class="mb-2 lg:mb-5">

        <x-header>Valores unitarios de construcción</x-header>

        <div class="flex gap-3 overflow-auto p-1">

            <input type="text" wire:model.live.debounce.500ms="tipo" placeholder="Tipo" class="bg-white rounded-full text-sm">

            <input type="text" wire:model.live.debounce.500ms="uso" placeholder="Uso" class="bg-white rounded-full text-sm">

            <input type="text" wire:model.live.debounce.500ms="categoria" placeholder="Categoría" class="bg-white rounded-full text-sm">

            <input type="text" wire:model.live.debounce.500ms="calidad" placeholder="Calidad" class="bg-white rounded-full text-sm">

            <select class="bg-white rounded-full text-sm" wire:model.live="pagination">

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

                <x-table.heading sortable wire:click="sortBy('tipo')" :direction="$sort === 'tipo' ? $direction : null" >Tipo</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('uso')" :direction="$sort === 'uso' ? $direction : null" >Uso</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('estado')" :direction="$sort === 'estado' ? $direction : null" >Categoría</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('calidad')" :direction="$sort === 'calidad' ? $direction : null" >Calidad</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('valor')" :direction="$sort === 'valor' ? $direction : null" >Valor</x-table.heading>
                <x-table.heading sortable wire:click="sortBy('valor_aterior')" :direction="$sort === 'valor' ? $direction : null" >Valor anterior</x-table.heading>

            </x-slot>

            <x-slot name="body">

                @forelse ($this->valores as $valor)

                    <x-table.row wire:loading.class.delaylongest="opacity-50" wire:key="row-{{ $valor->id }}">

                        <x-table.cell title="Tipo">

                            {{ $valor->tipo }}

                        </x-table.cell>

                        <x-table.cell title="Uso">

                            {{ $valor->uso }}

                        </x-table.cell>

                        <x-table.cell title="Categoría">

                            {{ $valor->estado }}

                        </x-table.cell>

                        <x-table.cell title="Calidad">

                            {{ $valor->calidad }}

                        </x-table.cell>

                        <x-table.cell title="Valor">

                            ${{ number_format($valor->valor, 2) }}

                        </x-table.cell>

                        <x-table.cell title="Valor anterior">

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

                        {{ $this->valores->links()}}

                    </x-table.cell>

                </x-table.row>

            </x-slot>

        </x-table>

    </div>

</div>
