<div>

    <div class="space-y-5 mb-5">

        <div class="bg-white shadow-xl rounded-lg p-4">

            <h4 class="text-lg mb-5 text-center">Terrenos</h4>

            <div class="mb-5  divide-y">

                @foreach ($terrenos as $index => $terreno)

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-12 gap-3 items-start mb-2 bg-gray-50 p-4 rounded-lg" wire:key="row-{{ $loop->index }}">

                        <div class="flex-auto lg:col-span-2">

                            <div>

                                <label class="text-sm" >Superficie</label>

                            </div>

                            <div>

                                <input type="number" class="bg-white rounded text-xs w-full" wire:model.blur="terrenos.{{ $index }}.superficie">

                            </div>

                            <div>

                                @error('terrenos.' . $index . '.superficie') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                            </div>

                        </div>

                        @if($predio && $predio->tipo_predio == 2)

                            <div class="flex-auto lg:col-span-2">

                                <div>

                                    <label class="text-sm" >Valor por hectarea</label>

                                </div>

                                <div>

                                    <select class="bg-white rounded text-xs w-full" wire:model.live="terrenos.{{ $index }}.valor_unitario">

                                        <option value="" selected>Seleccione una opción</option>

                                        @foreach ($valores_rusticos as $item)

                                            <option value="{{ $item->valor }}" selected>{{ $item->concepto }} - ${{ number_format($item->valor, 2) }}</option>

                                        @endforeach

                                    </select>

                                </div>

                                <div>

                                    @error('terrenos.{{ $index }}.valor_unitario') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                                </div>

                            </div>

                        @endif

                        <div class="flex-auto lg:col-span-2">

                            <div>

                                <label class="text-sm" >Valor unitario</label>

                            </div>

                            <div>

                                <input type="number" class="bg-white rounded text-xs w-full" wire:model.blur="terrenos.{{ $index }}.valor_unitario" @if($predio && $predio->tipo_predio == 2) readonly @endif>

                            </div>

                            <div>

                                @error('terrenos.' . $index . '.valor_unitario') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                            </div>

                        </div>

                        <div class="flex-auto lg:col-span-2 xl:col-span-1">

                            <div>

                                <label class="text-sm" >Demérito</label>

                            </div>

                            <div>

                                <input type="number" min="0" class="bg-white rounded text-xs w-full" wire:model.blur="terrenos.{{ $index }}.demerito">

                            </div>

                            <div>

                                @error('terrenos.' . $index . '.demerito') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                            </div>

                        </div>

                        <div class="flex-auto lg:col-span-2">

                            <div>

                                <label class="text-sm" >Valor demeritado</label>

                            </div>

                            <div>

                                <input type="number" class="bg-white rounded text-xs w-full" wire:model="terrenos.{{ $index }}.valor_demeritado" readonly>

                            </div>

                        </div>

                        <div class="flex-auto lg:col-span-2">

                            <div>

                                <label class="text-sm" >Valor del terreno</label>

                            </div>

                            <div>

                                <input type="number" class="bg-white rounded text-xs w-full" wire:model="terrenos.{{ $index }}.valor_terreno" readonly>

                            </div>

                        </div>

                        <div class="flex-auto lg:col-span-1 my-auto">

                            <x-button-red
                                wire:click="borrarTerreno({{ $index }})"
                                wire:loading.attr="disabled"
                                wire:target="borrarTerreno({{ $index }})">

                                <img wire:loading wire:target="borrarTerreno({{ $index }})" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                                Borrar

                            </x-button-red>

                        </div>

                    </div>

                @endforeach

            </div>

            <x-button-blue
                wire:click="agregarTerreno"
                wire:loading.attr="disabled"
                wire:target="agregarTerreno">

                <img wire:loading wire:target="agregarTerreno" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                Agregar nuevo

            </x-button-blue>

            <div class="flex justify-end">

                <x-button-green
                    wire:click="guardarTerrenos"
                    wire:loading.attr="disabled"
                    wire:target="guardarTerrenos">

                    <img wire:loading wire:target="guardarTerrenos" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                    Guardar terrenos

                </x-button-green>

            </div>

        </div>

        <div class="bg-white shadow-xl rounded-lg p-4">

            <h4 class="text-lg mb-5 text-center">Construcciones</h4>

            <div class="mb-5  divide-y">

                @foreach ($construcciones as $index => $construccion)

                    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-12 gap-3 mb-2 bg-gray-50 p-4 rounded-lg items-start">

                        <div class="flex-auto lg:col-span-1">

                            <div>

                                <label class="text-sm" >Referencia</label>

                            </div>

                            <div>

                                <input type="text" class="bg-white rounded text-xs w-full" wire:model.blur="construcciones.{{ $index }}.referencia">

                            </div>

                            <div>

                                @error('construcciones.' . $index . '.referencia') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                            </div>

                        </div>

                        <div class="flex-auto lg:col-span-3">

                            <div>

                                <label class="text-sm" >Clasificación de construcción</label>

                            </div>

                            <div>

                                <select class="bg-white rounded text-xs w-full" wire:model.live="construcciones.{{ $index }}.valores">

                                    <option value="" selected>Seleccione una opción</option>

                                    @foreach ($valores_construccion as $item)

                                        <option value="{{ $item }}" selected>{{ $item->tipo }}{{ $item->uso }}{{ $item->calidad }}{{ $item->estado }} - ${{ number_format($item->valor, 2) }}</option>

                                    @endforeach

                                </select>

                            </div>

                            <div>

                                @error('construcciones.{{ $index }}.valores') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                            </div>

                        </div>

                        <div class="flex space-x-1 lg:col-span-2">

                            <div class="flex-auto">

                                <div>

                                    <label class="text-sm" >Tipo</label>

                                </div>

                                <div>

                                    <input type="number" class="bg-white rounded text-xs w-full" readonly wire:model.blur="construcciones.{{ $index }}.tipo">

                                </div>

                            </div>

                            <div class="flex-auto">

                                <div>

                                    <label class="text-sm" >Uso</label>

                                </div>

                                <div>

                                    <input type="number" class="bg-white rounded text-xs w-full" readonly wire:model.blur="construcciones.{{ $index }}.uso">

                                </div>

                            </div>

                            <div class="flex-auto">

                                <div>

                                    <label class="text-sm" >Calidad</label>

                                </div>

                                <div>

                                    <input type="number" class="bg-white rounded text-xs w-full" readonly wire:model.blur="construcciones.{{ $index }}.calidad">

                                </div>

                            </div>

                            <div class="flex-auto">

                                <div>

                                    <label class="text-sm" >Estado</label>

                                </div>

                                <div>

                                    <input type="number" class="bg-white rounded text-xs w-full" readonly wire:model.blur="construcciones.{{ $index }}.estado">

                                </div>

                            </div>

                        </div>

                        <div class="flex-auto lg:col-span-2">

                            <div>

                                <label class="text-sm" >Valor unitario</label>

                            </div>

                            <div>

                                <input type="number" class="bg-white rounded text-xs w-full" wire:model.blur="construcciones.{{ $index }}.valor_unitario" readonly>

                            </div>

                            <div>

                                @error('construcciones.' . $index . '.valor_unitario') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                            </div>

                        </div>

                        <div class="flex-auto lg:col-span-1">

                            <div>

                                <label class="text-sm" >Niveles</label>

                            </div>

                            <div>

                                <input type="number" class="bg-white rounded text-xs w-full" wire:model.blur="construcciones.{{ $index }}.niveles">

                            </div>

                            <div>

                                @error('construcciones.' . $index . '.niveles') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                            </div>

                        </div>

                        <div class="flex-auto lg:col-span-1">

                            <div>

                                <label class="text-sm" >Superficie</label>

                            </div>

                            <div>

                                <input type="number" class="bg-white rounded text-xs w-full" wire:model.blur="construcciones.{{ $index }}.superficie">

                            </div>

                            <div>

                                @error('construcciones.' . $index . '.superficie') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                            </div>

                        </div>

                        <div class="flex-auto lg:col-span-1">

                            <div>

                                <label class="text-sm" >Valor</label>

                            </div>

                            <div>

                                <input type="number" class="bg-white rounded text-xs w-full" wire:model.blur="construcciones.{{ $index }}.valor_construccion" readonly>

                            </div>

                            <div>

                                @error('construcciones.' . $index . '.valor_construccion') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                            </div>

                        </div>

                        <div class="flex-auto lg:col-span-1 my-auto">

                            <x-button-red
                                wire:click="borrarConstruccion({{ $index }})"
                                wire:loading.attr="disabled"
                                wire:target="borrarConstruccion({{ $index }})">

                                <img wire:loading wire:target="borrarConstruccion({{ $index }})" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                                Borrar

                            </x-button-red>

                        </div>

                    </div>

                @endforeach

            </div>

            <x-button-blue
                wire:click="agregarConstruccion"
                wire:loading.attr="disabled"
                wire:target="agregarConstruccion">

                <img wire:loading wire:target="agregarConstruccion" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                Agregar nuevo

            </x-button-blue>

            <div class="flex justify-end">

                <x-button-green
                    wire:click="guardarConstrucciones"
                    wire:loading.attr="disabled"
                    wire:target="guardarConstrucciones">

                    <img wire:loading wire:target="guardarConstrucciones" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                    Guardar construcciones

                </x-button-green>

            </div>

        </div>

        @if($predio->edificio != 0)

            <div class="bg-white shadow-xl rounded-lg p-4">

                <h4 class="text-lg mb-5 text-center">Terrenos de área común</h4>

                <div class="mb-5  divide-y">

                    @foreach ($terrenosComun as $index => $item)

                        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-6 gap-3 items-start mb-2 bg-gray-50 p-4 rounded-lg">

                            <div class="flex-auto lg:col-span-1">

                                <div>

                                    <label class="text-sm" >Área común de terreno</label>

                                </div>

                                <div>

                                    <input type="number" class="bg-white rounded text-xs w-full" wire:model.blur="terrenosComun.{{ $index }}.area_terreno_comun">

                                </div>

                                <div>

                                    @error('terrenosComun.' .  $index . '.area_terreno_comun') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                                </div>

                            </div>

                            <div class="flex-auto lg:col-span-1">

                                <div>

                                    <label class="text-sm" >Indiviso de terreno</label>

                                </div>

                                <div>

                                    <input type="number" max="100" step=".0001" class="bg-white rounded text-xs w-full" wire:model.blur="terrenosComun.{{ $index }}.indiviso_terreno">

                                </div>

                                <div>

                                    @error('terrenosComun.' . $index . '.indiviso_terreno') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                                </div>

                            </div>

                            <div class="flex-auto lg:col-span-1">

                                <div>

                                    <label class="text-sm" >Valor unitario</label>

                                </div>

                                <div>

                                    <input type="number" class="bg-white rounded text-xs w-full" wire:model.blur="terrenosComun.{{ $index }}.valor_unitario">

                                </div>

                                <div>

                                    @error('terrenosComun.' . $index . '.valor_unitario') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                                </div>

                            </div>

                            <div class="flex-auto lg:col-span-1">

                                <div>

                                    <label class="text-sm" >Superficie proporcional</label>

                                </div>

                                <div>

                                    <input type="number" max="100" step=".0001" class="bg-white rounded text-xs w-full" wire:model.blur="terrenosComun.{{ $index }}.superficie_proporcional" readonly>

                                </div>

                                <div>

                                    @error('terrenosComun.' . $index . '.superficie_proporcional') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                                </div>

                            </div>

                            <div class="flex-auto lg:col-span-1">

                                <div>

                                    <label class="text-sm" >Valor de terreno común</label>

                                </div>

                                <div>

                                    <input type="number" class="bg-white rounded text-xs w-full" wire:model.blur="terrenosComun.{{ $index }}.valor_terreno_comun" readonly>

                                </div>

                                <div>

                                    @error('terrenosComun.' . $index . '.valor_terreno_comun') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                                </div>

                            </div>

                            <div class="flex-auto lg:col-span-1 my-auto">

                                <x-button-red
                                    wire:click="borrarTerrenoComun({{ $index }})"
                                    wire:loading.attr="disabled"
                                    wire:target="borrarTerrenoComun({{ $index }})">

                                    <img wire:loading wire:target="borrarTerrenoComun({{ $index }})" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                                    Borrar

                                </x-button-red>

                            </div>

                        </div>

                    @endforeach

                    <x-button-blue
                        wire:click="agregarTerrenoComun"
                        wire:loading.attr="disabled"
                        wire:target="agregarTerrenoComun">

                        <img wire:loading wire:target="agregarTerrenoComun" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                        Agregar nuevo

                    </x-button-blue>

                </div>

                <div class="flex justify-end">

                    <x-button-green
                        wire:click="guardarTerrenosComun"
                        wire:loading.attr="disabled"
                        wire:target="guardarTerrenosComun">

                        <img wire:loading wire:target="guardarTerrenosComun" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                        Guardar terrenos en común

                    </x-button-green>

                </div>

            </div>

            <div class="bg-white shadow-xl rounded-lg p-4">

                <h4 class="text-lg mb-5 text-center">Construcciones de área común</h4>

                <div class="mb-5  divide-y">

                    @foreach ($construccionesComun as $index => $item)

                        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-6 gap-3 items-end mb-2 bg-gray-50 p-4 rounded-lg">

                            <div class="flex-auto lg:col-span-1">

                                <div>

                                    <label class="text-sm" >Clasificación de construccion</label>

                                </div>

                                <div>

                                    <select class="bg-white rounded text-xs w-full" wire:model.blur="construccionesComun.{{ $index }}.valor_clasificacion_construccion">

                                        <option value="" selected>Seleccione una opción</option>

                                        @foreach ($valores_construccion as $item)

                                            <option value="{{ $item->valor }}" selected>{{ $item->tipo }}{{ $item->uso }}{{ $item->calidad }}{{ $item->estado }} - ${{ number_format($item->valor, 2) }}</option>

                                        @endforeach

                                    </select>

                                </div>

                                <div>

                                    @error('construccionesComun.' . $index . '.valor_clasificacion_construccion') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                                </div>

                            </div>

                            <div class="flex-auto lg:col-span-1">

                                <div>

                                    <label class="text-sm" >Área común de construcción</label>

                                </div>

                                <div>

                                    <input type="number" class="bg-white rounded text-xs w-full" wire:model.blur="construccionesComun.{{ $index }}.area_comun_construccion">

                                </div>

                                <div>

                                    @error('construccionesComun.' .  $index . '.area_comun_construccion') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                                </div>

                            </div>

                            <div class="flex-auto lg:col-span-1">

                                <div>

                                    <label class="text-sm" >Indiviso de construcción</label>

                                </div>

                                <div>

                                    <input type="number" max="100" step=".0001" class="bg-white rounded text-xs w-full" wire:model.blur="construccionesComun.{{ $index }}.indiviso_construccion">

                                </div>

                                <div>

                                    @error('construccionesComun.' . $index . '.indiviso_construccion') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                                </div>

                            </div>

                            <div class="flex-auto lg:col-span-1">

                                <div>

                                    <label class="text-sm" >Superficie proporcional</label>

                                </div>

                                <div>

                                    <input type="number" max="100" step=".0001" class="bg-white rounded text-xs w-full" wire:model.blur="construccionesComun.{{ $index }}.superficie_proporcional" readonly>

                                </div>

                                <div>

                                    @error('construccionesComun.' . $index . '.superficie_proporcional') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                                </div>

                            </div>

                            <div class="flex-auto lg:col-span-1">

                                <div>

                                    <label class="text-sm" >Valor de construcción común</label>

                                </div>

                                <div>

                                    <input type="number" class="bg-white rounded text-xs w-full" wire:model.blur="construccionesComun.{{ $index }}.valor_construccion_comun" readonly>

                                </div>

                                <div>

                                    @error('construccionesComun.' . $index . '.valor_construccion_comun') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                                </div>

                            </div>

                            <div class="flex-auto lg:col-span-1 my-auto">

                                <x-button-red
                                    wire:click="borrarConstruccionComun({{ $index }})"
                                    wire:loading.attr="disabled"
                                    wire:target="borrarConstruccionComun({{ $index }})">

                                    <img wire:loading wire:target="borrarConstruccionComun({{ $index }})" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                                    Borrar

                                </x-button-red>

                            </div>

                        </div>

                    @endforeach

                    <x-button-blue
                        wire:click="agregarConstruccionComun"
                        wire:loading.attr="disabled"
                        wire:target="agregarConstruccionComun">

                        <img wire:loading wire:target="agregarConstruccionComun" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                        Agregar nuevo

                    </x-button-blue>

                </div>

                <div class="flex justify-end">

                    <x-button-green
                        wire:click="guardarConstruccionComun"
                        wire:loading.attr="disabled"
                        wire:target="guardarCoonstruccionComun">

                        <img wire:loading wire:target="guardarConstruccionComun" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                        Guardar construcciones en común

                    </x-button-green>

                </div>

            </div>

        @endif

    </div>

    @include('livewire.comun.errores')

</div>
