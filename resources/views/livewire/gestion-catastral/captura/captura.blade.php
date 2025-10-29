<div>

    <x-header>Captura al padrón</x-header>

    <div class="tab-wrapper max-h-full" x-data="{ activeTab: 0 }">

        <div class="flex py-4 space-x-4 items-center border-b-2 border-gray-500 mb-6 flex-wrap justify-center">

            <label
                @click="activeTab = 0"
                class="px-6 py-1 text-gray-600 rounded-xl border-b-2 border-gray-500 font-semibold mb-3 cursor-pointer bg-white"
                :class="{'active  bg-gray-200 rounded-full px-3 py-1 text-gray-500 no-underline': activeTab === 0 }"
            >Información del inmueble
            </label>

            <label
                @click="activeTab = 1"
                class="px-6 py-1 text-gray-600 rounded-xl border-b-2 border-gray-500 font-semibold mb-3 cursor-pointer bg-white"
                :class="{'active  bg-gray-200 rounded-full px-3 py-1 text-gray-500 no-underline': activeTab === 1 }"
            >Colindancias
            </label>

            <label
                @click="activeTab = 2"
                class="px-6 py-1 text-gray-600 rounded-xl border-b-2 border-gray-500 font-semibold mb-3 cursor-pointer bg-white"
                :class="{'active  bg-gray-200 rounded-full px-3 py-1 text-gray-500 no-underline': activeTab === 2 }"
            >Propietarios
            </label>

            <label
                @click="activeTab = 3"
                class="px-6 py-1 text-gray-600 rounded-xl border-b-2 border-gray-500 font-semibold mb-3 cursor-pointer bg-white"
                :class="{'active  bg-gray-200 rounded-full px-3 py-1 text-gray-500 no-underline': activeTab === 3 }"
            >Archivo
            </label>

            @if($predio?->edificio)

                <label
                    @click="activeTab = 4"
                    class="px-6 py-1 text-gray-600 rounded-xl border-b-2 border-gray-500 font-semibold mb-3 cursor-pointer bg-white"
                    :class="{'active  bg-gray-200 rounded-full px-3 py-1 text-gray-500 no-underline': activeTab === 4 }"
                >Terrenos - Construcciones
                </label>

            @endif

        </div>

        <div x-cloak class="tab-panel" :class="{ 'active': activeTab === 0 }" x-show.transition.in.opacity.duration.800="activeTab === 0"  wire:key="tab-0">

            <div class="space-y-2 mb-5 bg-white rounded-lg p-4 shadow-xl">

                <div class="flex items-center justify-center mb-8">

                    <x-input-group for="actualizacion" label="Actualización" :error="$errors->first('actualizacion')" class="flex gap-3 items-center">

                        <x-checkbox wire:model.live="actualizacion" id="actualizacion"/>

                    </x-input-group>

                </div>

                <h4 class="text-lg mb-5 text-center">Consultar predio</h4>

                <div class="flex-auto ">

                    @include('livewire.comun.cuenta-clave-captura')

                    @if($actualizacion)

                        <div class="mb-2 flex-col sm:flex-row mx-auto mt-5 flex space-y-2 sm:space-y-0 sm:space-x-3 justify-center">

                            <button
                                wire:click="buscarCuentaPredial"
                                wire:loading.attr="disabled"
                                wire:target="buscarCuentaPredial"
                                type="button"
                                class="bg-blue-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded text-xs hover:bg-blue-700 focus:outline-none flex items-center justify-center focus:outline-blue-400 focus:outline-offset-2">

                                <img wire:loading wire:target="buscarCuentaPredial" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                                Consultar cuenta predial

                            </button>

                            <button
                                wire:click="buscarClaveCatastral"
                                wire:loading.attr="disabled"
                                wire:target="buscarClaveCatastral"
                                type="button"
                                class="bg-blue-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded text-xs hover:bg-blue-700 focus:outline-none flex items-center justify-center focus:outline-blue-400 focus:outline-offset-2">

                                <img wire:loading wire:target="buscarClaveCatastral" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                                Consultar clave catastral

                            </button>

                            @if($predio->id)

                                <button
                                    wire:click="$toggle('modalIndexar')"
                                    wire:loading.attr="disabled"
                                    wire:target="$toggle('modalIndexar')"
                                    type="button"
                                    class="bg-gray-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded text-xs hover:bg-gray-700 focus:outline-none flex items-center justify-center focus:outline-gray-400 focus:outline-offset-2">

                                    <img wire:loading wire:target="$toggle('modalIndexar')" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                                    Indexar

                                </button>

                                <button
                                    wire:click="$toggle('modalBaja')"
                                    wire:loading.attr="disabled"
                                    wire:target="$toggle('modalBaja')"
                                    type="button"
                                    class="bg-red-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded text-xs hover:bg-red-700 focus:outline-none flex items-center justify-center focus:outline-red-400 focus:outline-offset-2">

                                    <img wire:loading wire:target="$toggle('modalBaja')" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                                    Dar de baja

                                </button>

                            @endif

                        </div>

                    @endif

                </div>

            </div>

            @include('livewire.comun.ubicacion-predio')

            <div class="md:grid md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-3 items-end space-y-2 md:space-y-0 p-4 bg-white shadow-lg mb-5">

                <x-input-group for="predio.superficie_total_terreno" label="Superficie total de terreno {{ $predio->tipo_predio == 2 ? '(has.)' : '(mts.)' }}" :error="$errors->first('predio.superficie_total_terreno')" class="w-full">

                    <x-input-text type="number" id="predio.superficie_total_terreno" wire:model="predio.superficie_total_terreno" />

                </x-input-group>

                <x-input-group for="predio.superficie_total_construccion" label="Superficie total de construcción {{ $predio->tipo_predio == 2 ? '(has.)' : '(mts.)' }}" :error="$errors->first('predio.superficie_total_construccion')" class="w-full">

                    <x-input-text type="number" id="predio.superficie_total_construccion" wire:model="predio.superficie_total_construccion" />

                </x-input-group>

                <x-input-group for="predio.superficie_notarial" label="Superficie notarial {{ $predio->tipo_predio == 2 ? '(has.)' : '(mts.)' }}" :error="$errors->first('predio.superficie_notarial')" class="w-full">

                    <x-input-text type="number" id="predio.superficie_notarial" wire:model="predio.superficie_notarial" />

                </x-input-group>

                <x-input-group for="predio.superficie_judicial" label="Superficie judicial {{ $predio->tipo_predio == 2 ? '(has.)' : '(mts.)' }}" :error="$errors->first('predio.superficie_judicial')" class="w-full">

                    <x-input-text type="number" id="predio.superficie_judicial" wire:model="predio.superficie_judicial" />

                </x-input-group>

                <x-input-group for="predio.valor_catastral" label="Valor catastral" :error="$errors->first('predio.valor_catastral')" class="w-full">

                    <x-input-text type="number" id="predio.valor_catastral" wire:model="predio.valor_catastral" />

                </x-input-group>

            </div>

            @include('livewire.comun.coordenadas')

            <div class="space-y-2 mb-5 bg-white rounded-lg p-4 shadow-lg">

                <h4 class="text-lg mb-5 text-center">Documento de entrada</h4>

                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4  gap-3 items-start">

                    <div class="flex-auto">

                        <div>

                            <Label class="text-sm">Tipo de documento</Label>
                        </div>

                        <div>

                            <select class="bg-white rounded text-xs w-full" wire:model.live="predio.documento_entrada">
                                <option value="" selected>Seleccione una opción</option>

                                @foreach ($documentos as $item)

                                    <option value="{{ $item }}" selected>{{ $item }}</option>

                                @endforeach

                            </select>

                        </div>

                        <div>

                            @error('predio.documento_entrada') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                        </div>

                    </div>

                    <div class="flex-auto">

                        <div>

                            <Label class="text-sm">Declarante</Label>
                        </div>

                        <div>

                            @if(in_array($predio->documento_entrada, ['ESCRITURA PÚBLICA', 'ESCRITURA PRIVADA']))

                                <select class="bg-white rounded text-xs w-full" wire:model="predio.declarante">
                                    <option value="" selected>Seleccione una opción</option>

                                    @foreach ($notarias as $notaria)

                                        <option value="{{ $notaria->numero . ' ' . $notaria->notario }}" selected>{{ $notaria->numero . ' ' . $notaria->notario }}</option>

                                    @endforeach

                                </select>

                            @else

                                <input type="number" class="bg-white rounded text-xs w-full" wire:model="predio.declarante">

                            @endif

                        </div>

                        <div>

                            @error('predio.declarante') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                        </div>

                    </div>

                    <div class="flex-auto">

                        <div class="">

                            <label class="text-sm " >{{ $label }}</label>

                        </div>

                        <div>

                            <input type="number" class="bg-white rounded text-xs w-full" wire:model="predio.documento_numero">

                        </div>

                        <div>

                            @error('predio.documento_numero') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                        </div>

                    </div>

                    <div class="flex-auto ">

                        <div>

                            <Label class="text-sm">Fecha de efectos</Label>
                        </div>

                        <div>

                            <input type="date" class="bg-white rounded text-xs w-full" wire:model="predio.fecha_efectos">

                        </div>

                        <div>

                            @error('predio.fecha_efectos') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                        </div>

                    </div>

                </div>

            </div>

            <div class="space-y-2 mb-5 bg-white rounded-lg p-4 shadow-lg">

                <x-input-group for="predio.observaciones" label="Observaciones del predio" :error="$errors->first('predio.observaciones')">

                    <textarea class="bg-white rounded text-xs w-full " rows="4" wire:model="predio.observaciones"></textarea>

                </x-input-group>

            </div>

            @include('livewire.gestion-catastral.captura.comun.movimiento')

            @include('livewire.comun.errores')

            @include('livewire.gestion-catastral.captura.comun.guardar-actualizar')

        </div>

        <div x-cloak class="tab-panel" :class="{ 'active': activeTab === 1 }" x-show.transition.in.opacity.duration.800="activeTab === 1"  wire:key="tab-1">

            @livewire('valuacion.colindancias')

            @include('livewire.gestion-catastral.captura.comun.movimiento')

            @include('livewire.comun.errores')

            <div class="bg-white rounded-lg p-4 flex justify-end  shadow-xl">

                <x-button-green
                    wire:click="actualizarConColindancias"
                    wire:loading.attr="disabled"
                    wire:target="actualizarConColindancias">

                    <img wire:loading wire:target="actualizarConColindancias" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                    Actualizar

                </x-button-green>

            </div>

        </div>

        <div x-cloak class="tab-panel" :class="{ 'active': activeTab === 2 }" x-show.transition.in.opacity.duration.800="activeTab === 2"  wire:key="tab-2">

            @livewire('comun.propietarios')

            @include('livewire.gestion-catastral.captura.comun.movimiento')

            @include('livewire.comun.errores')

            @include('livewire.gestion-catastral.captura.comun.guardar-actualizar')

        </div>

        <div x-cloak class="tab-panel" :class="{ 'active': activeTab === 3 }" x-show.transition.in.opacity.duration.800="activeTab === 3"  wire:key="tab-3">

            @livewire('gestion-catastral.captura.archivo')

        </div>

        <div x-cloak class="tab-panel" :class="{ 'active': activeTab === 4 }" x-show.transition.in.opacity.duration.800="activeTab === 4"  wire:key="tab-4">

            @livewire('gestion-catastral.captura.terrenos-construcciones')

        </div>

    </div>

    <x-confirmation-modal wire:model="modalIndexar" maxWidth="sm">

        <x-slot name="title">
            Indexar valor catastral
        </x-slot>

        <x-slot name="content">
            ¿Esta seguro que desea indexar el valor catastral?
        </x-slot>

        <x-slot name="footer">

            <x-danger-button
                wire:click="$toggle('modalIndexar')"
                wire:loading.attr="disabled"
            >
                No
            </x-danger-button>

            <x-secondary-button
                class="ml-2"
                wire:click="indexar"
                wire:loading.attr="disabled"
                wire:target="indexar"
            >
                Indexar
            </x-secondary-button>

        </x-slot>

    </x-confirmation-modal>

    <x-dialog-modal wire:model="modalBaja" maxWidth="sm">

        <x-slot name="title">
            Dar de baja el predio
        </x-slot>

        <x-slot name="content">

            <x-input-group for="accion" label="Motivo" :error="$errors->first('accion')" class="w-full">

                <x-input-select id="accion" wire:model="accion">

                    <option value="" selected>Seleccione una opción</option>

                    @foreach ($acciones_baja as $accion)

                        <option value="{{ $accion }}">{{ $accion }}</option>

                    @endforeach

                </x-input-select>

            </x-input-group>

            <x-input-group for="observaciones" label="Observaciones" :error="$errors->first('observaciones')" class="w-full">

                <textarea class="bg-white rounded text-xs w-full " rows="4" wire:model="observaciones" placeholder="Se lo más explicito en el motivo por el cual se da de baja el predio mencionando oficio si se ha presentado."></textarea>

            </x-input-group>

        </x-slot>

        <x-slot name="footer">

            <div class="flex gap-3">

                <x-button-blue
                    wire:click="darDeBaja"
                    wire:loading.attr="disabled"
                    wire:target="darDeBaja">

                    <img wire:loading wire:target="darDeBaja" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                    <span>Dar de baja</span>
                </x-button-blue>

                <x-button-red
                    wire:click="$toggle('modalBaja')"
                    wire:loading.attr="disabled"
                    wire:target="$toggle('modalBaja')"
                    type="button">
                    Cerrar
                </x-button-red>

            </div>

        </x-slot>

    </x-dialog-modal>

</div>
