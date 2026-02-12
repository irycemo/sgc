<div class="">

    @include('livewire.comun.avaluo-folio')

    <div class="space-y-2 mb-5 bg-white rounded-lg p-2">

        <h4 class="text-lg mb-5 text-center">Consultar predio</h4>

        <div class="flex-auto ">

            @include('livewire.comun.cuenta-clave')

            <div class="mb-2 flex-col sm:flex-row mx-auto mt-5 flex space-y-2 sm:space-y-0 sm:space-x-3 justify-center">

                <button
                    wire:click="buscarClaveCatastral"
                    wire:loading.attr="disabled"
                    wire:target="buscarClaveCatastral"
                    type="button"
                    class="bg-blue-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded text-xs hover:bg-blue-700 focus:outline-blue-400 focus:outline-offset-2 flex items-center justify-center">

                    <img wire:loading wire:target="buscarClaveCatastral" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                    Consultar clave catastral

                </button>

                <button
                    wire:click="$set('modalPropietario', true)"
                    wire:loading.attr="disabled"
                    wire:target="$set('modalPropietario', true)"
                    type="button"
                    class="bg-blue-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded text-xs hover:bg-blue-700 focus:outline-blue-400 focus:outline-offset-2 flex items-center justify-center">

                    <img wire:loading wire:target="$set('modalPropietario', true)" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                    Consultar por propietario

                </button>

                <button
                    wire:click="abrirModalAsignar"
                    wire:loading.attr="disabled"
                    wire:target="abrirModalAsignar"
                    type="button"
                    class="bg-blue-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded text-xs hover:bg-blue-700 focus:outline-blue-400 focus:outline-offset-2 flex items-center justify-center">

                    <img wire:loading wire:target="abrirModalAsignar" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                    Asignar cuenta predial

                </button>

            </div>

        </div>

    </div>

    @include('livewire.comun.ubicacion-predio')

    @include('livewire.comun.coordenadas')

    @include('livewire.comun.errores')

    <div class="bg-white rounded-lg p-3 flex justify-end">

        @if(!$editar)

            <x-button-green
                wire:click="crear"
                wire:loading.attr="disabled"
                wire:target="crear">

                <img wire:loading wire:target="crear" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                Guardar

            </x-button-green>

        @else

            <x-button-green
                wire:click="actualizar"
                wire:loading.attr="disabled"
                wire:target="actualizar">

                <img wire:loading wire:target="actualizar" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                Actualizar

            </x-button-green>

        @endif

    </div>

    <x-dialog-modal wire:model="modalPropietario">

        <x-slot name="title">

            Buscar propietario

        </x-slot>

        <x-slot name="content">

            <div class="mb-4 flex gap-2 items-center">

                <x-input-group for="propietario_nombre" label="Nombre" :error="$errors->first('propietario_nombre')" class="w-full">

                    <x-input-text id="propietario_nombre" wire:model="propietario_nombre" />

                </x-input-group>

                <x-input-group for="propietario_ap_paterno" label="Apellido paterno" :error="$errors->first('propietario_ap_paterno')" class="w-full">

                    <x-input-text id="propietario_ap_paterno" wire:model="propietario_ap_paterno" />

                </x-input-group>

                <x-input-group for="propietario_ap_materno" label="Apellido materno" :error="$errors->first('propietario_ap_materno')" class="w-full">

                    <x-input-text id="propietario_ap_materno" wire:model="propietario_ap_materno" />

                </x-input-group>

            </div>

            <x-button-blue
                wire:click="busacarPropietario"
                wire:loading.attr="disabled"
                wire:target="busacarPropietario"
                class="ml-auto">

                <img wire:loading wire:target="busacarPropietario" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                Buscar

            </x-button-blue>

            <div class="mt-5">

                <x-table>

                    <x-slot name="head">

                        <x-table.heading >Folio avaluo</x-table.heading>
                        <x-table.heading >Propietario</x-table.heading>
                        <x-table.heading >Ubicación</x-table.heading>

                    </x-slot>

                    <x-slot name="body">

                        @forelse ($predios_propietario as $item)

                            <x-table.row wire:loading.class.delaylongest="opacity-50" wire:key="row-{{ $item->id }}">

                                <x-table.cell>

                                    {{ $item->propietarioable?->avaluo->folio }}

                                </x-table.cell>

                                <x-table.cell>

                                    {{ $item->persona->ap_paterno }} {{ $item->persona->ap_materno }} {{ $item->persona->nombre }}

                                </x-table.cell>

                                <x-table.cell>

                                    {{ $item->propietarioable?->nombre_asentamiento }} {{ $item->propietarioable?->nombre_vialidad }} {{ $item->propietarioable?->numero_exterior }}

                                </x-table.cell>

                                <x-table.cell>

                                    <x-button-blue
                                        wire:click="cargarAvaluoPropietario({{ $item->propietarioable->id }})"
                                        wire:loading.attr="disabled"
                                        wire:target="cargarAvaluoPropietario({{ $item->propietarioable->id }})">

                                        <img wire:loading wire:target="cargarAvaluoPropietario({{ $item->propietarioable->id }})" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                                        Cargar

                                    </x-button-blue>

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

                    </x-slot>

                </x-table>

            </div>

        </x-slot>

        <x-slot name="footer">

            <x-button-red
                wire:click="$toggle('modalPropietario')"
                wire:loading.attr="disabled"
                wire:target="$toggle('modalPropietario')">
                Cerrar
            </x-button-red>

        </x-slot>

    </x-dialog-modal>

    <x-dialog-modal wire:model="modalAsignarCuenta" maxWidth="md">

        <x-slot name="title">

            Asignar cuenta predial

        </x-slot>

        <x-slot name="content">

            <div class="relative p-1">

                <div class="flex flex-col md:flex-row justify-between md:space-x-3 mb-5 items-start">

                    <div class="flex-auto text-center mb-3">

                        <div >

                            <Label class="text-base tracking-widest rounded-xl border-gray-500">Trámite</Label>

                        </div>

                        <div class="inline-flex">

                            <select class="bg-white rounded-l text-sm border border-r-transparent  focus:ring-0" wire:model="año">
                                @foreach ($años as $año)

                                    <option value="{{ $año }}">{{ $año }}</option>

                                @endforeach
                            </select>

                            <input type="number" class="bg-white text-sm w-20 focus:ring-0 @error('folio') border-red-500 @enderror" wire:model="folio">

                            <input type="number" class="bg-white text-sm w-20 border-l-0 rounded-r focus:ring-0 @error('usuario') border-red-500 @enderror" wire:model="usuario">

                        </div>

                    </div>

                </div>

                <div class="flex flex-col md:flex-row justify-center gap-1 mb-5 items-end">

                    <x-input-group for="localidad" label="Localidad" :error="$errors->first('localidad')" class="w-min">

                        <x-input-text type="number" id="localidad" wire:model="localidad" readonly/>

                    </x-input-group>

                    <x-input-group for="oficina" label="Oficina" :error="$errors->first('oficina')" class="w-16">

                        <x-input-text type="number" id="oficina" wire:model="oficina" readonly/>

                    </x-input-group>

                    <x-input-group for="tipo" label="Tipo" :error="$errors->first('tipo')" class="w-10">

                        <x-input-text type="number" id="tipo" wire:model="tipo" max="2" min="1" readonly/>

                    </x-input-group>

                    <x-input-group for="numero_registro" label="Número de Registro" :error="$errors->first('numero_registro')" >

                        <x-input-text type="number" id="numero_registro" wire:model="numero_registro" min="1"/>

                    </x-input-group>

                </div>

            </div>

        </x-slot>

        <x-slot name="footer">

            <div class="flex gap-3">

                <x-button-blue>
                    wire:click="asignarCuenta"
                    wire:loading.attr="disabled"
                    wire:target="asignarCuenta">

                    <img wire:loading wire:target="asignarCuenta" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                    Asignar
                </x-button-blue>

                <x-button-red
                    wire:click="$toggle('modalAsignarCuenta')"
                    wire:loading.attr="disabled"
                    wire:target="$toggle('modalAsignarCuenta')">
                    Cerrar
                </x-button-red>

            </div>

        </x-slot>

    </x-dialog-modal>

</div>
