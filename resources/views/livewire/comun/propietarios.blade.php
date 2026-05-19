<div class="">

    <div class="bg-blue-400 w-full p-2 rounded-lg mb-5 flex gap-5 items-center justify-center" wire:loading.flex>

        <img class="h-4" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

        <span class="text-white">Cargando..</span>

    </div>

    @include('livewire.comun.avaluo-folio')

    <div class="" wire:loading.class.delay.longest="opacity-50">

        <div class="mb-3 bg-white rounded-lg p-3 shadow-lg">

            <span class="flex items-center justify-center text-lg text-gray-700 mb-5">Propietarios</span>

            <div class="flex justify-end mb-2">

                @if($this->editar_propietarios)

                    <div class="flex justify-end mb-2">

                        @livewire('comun.propietario-crear', ['modelo' => $predio])

                    </div>

                @endif

            </div>

            <x-table>

                <x-slot name="head">
                    <x-table.heading >Nombre / Razón social</x-table.heading>
                    <x-table.heading >Porcentaje propiedad</x-table.heading>
                    <x-table.heading >Porcentaje nuda</x-table.heading>
                    <x-table.heading >Porcentaje usufructo</x-table.heading>
                    <x-table.heading >Acciones</x-table.heading>
                </x-slot>

                <x-slot name="body">

                    @if($predio)

                        @foreach ($predio->propietarios->sortBy('persona.nombre') as $propietario)

                            <x-table.row wire:key="row-{{ $propietario->id }}">

                                <x-table.cell>{{ $propietario->persona->nombre }} {{ $propietario->persona->ap_paterno }} {{ $propietario->persona->ap_materno }} {{ $propietario->persona->razon_social }}</x-table.cell>
                                <x-table.cell>{{ $propietario->porcentaje_propiedad }}%</x-table.cell>
                                <x-table.cell>{{ $propietario->porcentaje_nuda }}%</x-table.cell>
                                <x-table.cell>{{ $propietario->porcentaje_usufructo }}%</x-table.cell>
                                <x-table.cell>
                                    <div class="flex items-center gap-3">

                                        @if($this->editar_propietarios)

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
                                                        wire:click="borrarActor({{ $propietario->id }})"
                                                        wire:loading.attr="disabled"
                                                        wire:confirm="¿Esta seguro que desea borrar el propietario?"
                                                        class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                                        role="menuitem">
                                                        Borrar
                                                    </button>

                                                    <button
                                                        wire:click="abrirModalPorcentajes({{ $propietario->id }})"
                                                        wire:loading.attr="disabled"
                                                        class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                                        role="menuitem">
                                                        Actualizar porcentajes
                                                    </button>

                                                </div>

                                            </div>

                                        @endif

                                    </div>
                                </x-table.cell>

                            </x-table.row>

                        @endforeach

                        <x-table.row wire:key="row-porcentajes">
                                <x-table.cell> <span class="font-semibold text-gray-600 text-sm bg-gray-200 px-3 rounded-lg">PORCENTAJES TOTALES</span> </x-table.cell>
                                <x-table.cell><span class="font-semibold text-gray-600 text-sm bg-gray-200 px-3 rounded-lg">{{ $predio->propietarios->sum('porcentaje_propiedad') }}%</span></x-table.cell>
                                <x-table.cell><span class="font-semibold text-gray-600 text-sm bg-gray-200 px-3 rounded-lg">{{ $predio->propietarios->sum('porcentaje_nuda') }}%</span></x-table.cell>
                                <x-table.cell><span class="font-semibold text-gray-600 text-sm bg-gray-200 px-3 rounded-lg">{{ $predio->propietarios->sum('porcentaje_usufructo') }}%</span></x-table.cell>
                                <x-table.cell>
                                </x-table.cell>
                        </x-table.row>

                    @endif

                </x-slot>

                <x-slot name="tfoot"></x-slot>

            </x-table>

        </div>

    </div>

    <x-dialog-modal wire:model.live="modal_porcentajes" maxWidth="sm">

        <x-slot name="title">

            Editar porcentajes

        </x-slot>

        <x-slot name="content">

                <x-input-group for="porcentaje_propiedad" label="Porcentaje de propiedad" :error="$errors->first('porcentaje_propiedad')" class="w-full">

                    <x-input-text type="number" id="porcentaje_propiedad" wire:model="porcentaje_propiedad" />

                </x-input-group>

                <x-input-group for="porcentaje_nuda" label="Porcentaje de nuda" :error="$errors->first('porcentaje_nuda')" class="w-full">

                    <x-input-text type="number" id="porcentaje_nuda" wire:model="porcentaje_nuda" />

                </x-input-group>

                <x-input-group for="porcentaje_usufructo" label="Porcentaje de usufructo" :error="$errors->first('porcentaje_usufructo')" class="w-full">

                    <x-input-text type="number" id="porcentaje_usufructo" wire:model="porcentaje_usufructo" />

                </x-input-group>

        </x-slot>

        <x-slot name="footer">

            <div class="flex items-center gap-3">

                <x-button-blue
                    wire:click="atualizarPorcentajes"
                    wire:loading.attr="disabled"
                    wire:target="atualizarPorcentajes">

                    <img wire:loading wire:target="atualizarPorcentajes" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                    Actualizar
                </x-button-blue>

                <x-button-red
                    wire:click="$toggle('modal_porcentajes')"
                    wire:loading.attr="disabled"
                    wire:target="$toggle('modal_porcentajes')">
                    Cerrar
                </x-button-red>

            </div>

        </x-slot>

    </x-dialog-modal>

</div>