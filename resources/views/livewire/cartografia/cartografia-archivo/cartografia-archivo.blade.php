<div>

    @push('styles')

        <link href="https://unpkg.com/filepond@^4/dist/filepond.css" rel="stylesheet" />

    @endpush

    <x-header>Cartografía</x-header>

    <div class="space-y-2 mb-5 bg-white rounded-lg p-2 shadow-lg">

        <div class="flex-col lg:flex lg:space-x-2 mb-2 space-y-4 items-center justify-center" >

            <select class="bg-white rounded-full text-sm w-60" wire:model.live="oficina">

                <option value="" selected>Oficina</option>

                @foreach ($oficinas as $oficina_item)

                    <option value="{{ $oficina_item->oficina }}">{{ $oficina_item->nombre }} ({{ $oficina_item->oficina }})</option>

                @endforeach

            </select>

            <input title="Sector" placeholder="Sector" type="number" class="bg-white rounded text-xs w-20 @error('sector') border-1 border-red-500 @enderror" wire:model.blur="sector">

            <div class="mb-2 flex-col sm:flex-row mx-auto mt-5 flex space-y-2 sm:space-y-0 sm:space-x-3 justify-center">

                <button
                    wire:click="buscarCartografia"
                    wire:loading.attr="disabled"
                    wire:target="buscarCartografia"
                    type="button"
                    class="bg-blue-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded text-xs hover:bg-blue-700 focus:outline-none flex items-center justify-center focus:outline-blue-400 focus:outline-offset-2">

                    <img wire:loading wire:target="buscarCartografia" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                    Buscar

                </button>

            </div>

        </div>

    </div>

    @if(count($cartografia))

        <div class="overflow-x-auto rounded-lg shadow-xl border-t-2 border-t-gray-500">

            <x-table>

                <x-slot name="head">

                    <x-table.heading sortable >Oficina</x-table.heading>
                    <x-table.heading >Sector</x-table.heading>
                    <x-table.heading >Manzana</x-table.heading>
                    <x-table.heading >Cartografía</x-table.heading>
                    <x-table.heading >Actualizado por</x-table.heading>
                    <x-table.heading >Acciones</x-table.heading>

                </x-slot>

                <x-slot name="body">

                    @foreach ($cartografia as $key => $cartografia)

                        <x-table.row wire:loading.class.delaylongest="opacity-50" wire:key="row-{{ $key }}">

                            <x-table.cell title="Oficina">

                                {{ $cartografia->oficina->nombre }}

                            </x-table.cell>

                            <x-table.cell title="Sector">

                                {{ $cartografia->sector }}

                            </x-table.cell>

                            <x-table.cell title="Sector">

                                {{ $cartografia->manzana ?? 'N/A' }}

                            </x-table.cell>

                            <x-table.cell title="Cartografía">

                                <a href="{{ $cartografia->getLink() }}" target="_blank" class="text-blue-500 underline hover:cursor-pointer">

                                    {{ str_replace("sgc/cartografia/", "", $cartografia->url) }}

                                </a>

                            </x-table.cell>

                            <x-table.cell title="Actualizado">

                                <p class="mt-2">

                                    <span class="font-semibold">@if($cartografia->actualizadoPor != null)Actualizado por: {{$cartografia->actualizadoPor->name}} @else Actualizado: @endif</span> <br>

                                    {{ $cartografia->updated_at }}

                                </p>

                            </x-table.cell>

                            <x-table.cell title="Acciones">

                                <div class="ml-3 relative" x-data="{ open_drop_down:false }">

                                    <div>

                                        <button x-on:click="open_drop_down=true" type="button" class="rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">

                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                            </svg>

                                        </button>

                                    </div>

                                    <div x-cloak x-show="open_drop_down" x-on:click="open_drop_down=false" x-on:click.away="open_drop_down=false" class="z-50 origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu">

                                        <button
                                            wire:click="abrirModalEditar({{ $cartografia->id }})"
                                            wire:target="abrirModalEditar({{ $cartografia->id }})"
                                            wire:loading.attr="disabled"
                                            class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                            role="menuitem">
                                            Editar
                                        </button>

                                        @can('Borrar uma')

                                            <button
                                                wire:click="borrarCartografia({{ $cartografia->id }})"
                                                wire:target="abrirModalBorrar({{ $cartografia->id }})"
                                                wire:loading.attr="disabled"
                                                wire:confirm="¿Estas seguro que quieres borrar la información? No será posible volver a recuperarla."
                                                class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                                role="menuitem">
                                                Borrar
                                            </button>

                                        @endcan

                                    </div>

                                </div>

                            </x-table.cell>

                        </x-table.row>

                    @endforeach

                </x-slot>

                <x-slot name="tfoot"></x-slot>

            </x-table>

        </div>

    @else

        <div class="bg-white text-gray-500 text-center p-5 rounded-full text-lg">

            No hay resultados.

        </div>

    @endif

    <x-dialog-modal wire:model="modal" maxWidth="sm">

        <x-slot name="title">

            Editar cartografía

        </x-slot>

        <x-slot name="content">

            <x-input-group for="modelo_editar.manzana" label="Manzana" :error="$errors->first('modelo_editar.manzana')" class="w-full">

                <x-input-text type="number" id="modelo_editar.manzana" wire:model="modelo_editar.manzana" />

            </x-input-group>

            <div class="mt-5">

                <x-filepond wire:model.live="documento" accept="['application/pdf']"/>

            </div>

            <div>

                @error('documento') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

            </div>

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
            Eliminar cartografía
        </x-slot>

        <x-slot name="content">
            ¿Esta seguro que desea eliminar la cartografía? No sera posible recuperar la información.
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

    @push('scripts')

        <script src="https://unpkg.com/filepond-plugin-file-validate-type/dist/filepond-plugin-file-validate-type.js"></script>
        <script src="https://unpkg.com/filepond-plugin-file-validate-size/dist/filepond-plugin-file-validate-size.js"></script>
        <script src="https://unpkg.com/filepond@^4/dist/filepond.js"></script>

    @endpush

</div>
