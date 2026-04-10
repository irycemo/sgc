<div wire:loading.class.delay.longest="opacity-50">

    <div class="bg-blue-400 w-full p-2 rounded-lg mb-5 flex gap-5 items-center justify-center" wire:loading.flex>

        <img class="h-4" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

        <span class="text-white">Cargando..</span>

    </div>

    <div class="space-y-5 mb-5">

        <div class="bg-white shadow-xl rounded-lg p-4">

            <h4 class="text-lg mb-5 text-center">Terrenos</h4>

            <div class="mb-5  divide-y">

                @foreach ($terrenos as $index => $terreno)

                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-12 gap-3 items-start mb-2 bg-gray-50 p-4 rounded-lg" wire:key="terreno-{{ $index }}">

                        <div class="flex-auto lg:col-span-2">

                            <div>

                                <label class="text-sm" >Superficie</label>

                            </div>

                            <div>

                                <input type="number" class="bg-white rounded text-xs w-full" wire:model.lazy="terrenos.{{ $index }}.superficie">

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

                                <input type="number" class="bg-white rounded text-xs w-full" wire:model.lazy="terrenos.{{ $index }}.valor_unitario">

                            </div>

                            <div>

                                @error('terrenos.' . $index . '.valor_unitario') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

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

                    <div class="w-full flex justify-start gap-3 mb-2 bg-gray-50 p-4 rounded-lg items-start" wire:key="construccion-"{{ $index }}>

                        <div class="flex-auto">

                            <div>

                                <label class="text-sm" >Referencia</label>

                            </div>

                            <div>

                                <input type="text" class="bg-white rounded text-xs w-full" wire:model.lazy="construcciones.{{ $index }}.referencia">

                            </div>

                            <div>

                                @error('construcciones.' .  $index . '.referencia') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                            </div>

                        </div>

                        <div class="flex-auto">

                            <div>

                                <label class="text-sm" >Clasificación</label>

                            </div>

                            <div class="flex gap-1">

                                <input type="number" class="bg-white rounded text-xs w-20 @error('construcciones.' . $index . '.uso') border-red-500 @enderror" wire:model.lazy="construcciones.{{ $index }}.uso">

                                <input type="number" class="bg-white rounded text-xs w-20 @error('construcciones.' . $index . '.tipo') border-red-500 @enderror" wire:model.lazy="construcciones.{{ $index }}.tipo">

                                <input type="number" class="bg-white rounded text-xs w-20 @error('construcciones.' . $index . '.estado') border-red-500 @enderror" wire:model.lazy="construcciones.{{ $index }}.estado">

                                <input type="number" class="bg-white rounded text-xs w-20 @error('construcciones.' . $index . '.calidad') border-red-500 @enderror" wire:model.lazy="construcciones.{{ $index }}.calidad">

                            </div>

                        </div>

                        <div class="flex-auto">

                            <div>

                                <label class="text-sm" >Valor unitario</label>

                            </div>

                            <div>

                                <input type="number" class="bg-white rounded text-xs w-full" wire:model.lazy="construcciones.{{ $index }}.valor_unitario">

                            </div>

                            <div>

                                @error('construcciones.' . $index . '.valor_unitario') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                            </div>

                        </div>

                        <div class="flex-auto">

                            <div>

                                <label class="text-sm" >Niveles</label>

                            </div>

                            <div>

                                <input type="number" class="bg-white rounded text-xs w-full" wire:model.lazy="construcciones.{{ $index }}.niveles">

                            </div>

                            <div>

                                @error('construcciones.' . $index . '.niveles') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                            </div>

                        </div>

                        <div class="flex-auto">

                            <div>

                                <label class="text-sm" >Superficie</label>

                            </div>

                            <div>

                                <input type="number" class="bg-white rounded text-xs w-full" wire:model.lazy="construcciones.{{ $index }}.superficie">

                            </div>

                            <div>

                                @error('construcciones.' . $index . '.superficie') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                            </div>

                        </div>

                        <div class="flex-auto">

                            <div>

                                <label class="text-sm" >Valor</label>

                            </div>

                            <div>

                                <input type="number" class="bg-white rounded text-xs w-full" wire:model.lazy="construcciones.{{ $index }}.valor_construccion" readonly>

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

                        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-6 gap-3 items-start mb-2 bg-gray-50 p-4 rounded-lg" wire:key="terrenoComun-"{{ $index }}>

                            <div class="flex-auto lg:col-span-1">

                                <div>

                                    <label class="text-sm" >Área común de terreno</label>

                                </div>

                                <div>

                                    <input type="number" class="bg-white rounded text-xs w-full" wire:model.lazy="terrenosComun.{{ $index }}.area_terreno_comun">

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

                                    <input type="number" max="100" step=".0001" class="bg-white rounded text-xs w-full" wire:model.lazy="terrenosComun.{{ $index }}.indiviso_terreno">

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

                                    <input  type="number" class="bg-white rounded text-xs w-full" wire:model.lazy="terrenosComun.{{ $index }}.valor_unitario">

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

                                    <input type="number" max="100" step=".0001" class="bg-white rounded text-xs w-full" wire:model.lazy="terrenosComun.{{ $index }}.superficie_proporcional" readonly>

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

                                    <input type="number" class="bg-white rounded text-xs w-full" wire:model.lazy="terrenosComun.{{ $index }}.valor_terreno_comun" readonly>

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

                </div>

                <x-button-blue
                    wire:click="agregarTerrenoComun"
                    wire:loading.attr="disabled"
                    wire:target="agregarTerrenoComun">

                    <img wire:loading wire:target="agregarTerrenoComun" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                    Agregar nuevo

                </x-button-blue>

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

                    <div class="w-full flex justify-start gap-3 mb-2 bg-gray-50 p-4 rounded-lg items-start" wire:key="construccion-"{{ $index }}>

                        <div class="flex-auto">

                            <div>

                                <label class="text-sm" >Clasificación</label>

                            </div>

                            <div class="flex gap-1">

                                <input type="number" class="bg-white rounded text-xs w-20 @error('construccionesComun.' . $index . '.uso') border-red-500 @enderror" wire:model.lazy="construccionesComun.{{ $index }}.uso">

                                <input type="number" class="bg-white rounded text-xs w-20 @error('construccionesComun.' . $index . '.tipo') border-red-500 @enderror" wire:model.lazy="construccionesComun.{{ $index }}.tipo">

                                <input type="number" class="bg-white rounded text-xs w-20 @error('construccionesComun.' . $index . '.estado') border-red-500 @enderror" wire:model.lazy="construccionesComun.{{ $index }}.estado">

                                <input type="number" class="bg-white rounded text-xs w-20 @error('construccionesComun.' . $index . '.calidad') border-red-500 @enderror" wire:model.lazy="construccionesComun.{{ $index }}.calidad">

                            </div>

                        </div>

                        <div class="flex-auto">

                            <div>

                                <label class="text-sm" >Valor unitario</label>

                            </div>

                            <div>

                                <input type="number" class="bg-white rounded text-xs w-full" wire:model.lazy="construccionesComun.{{ $index }}.valor_clasificacion_construccion">

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

                                <input type="number" class="bg-white rounded text-xs w-full" wire:model.lazy="construccionesComun.{{ $index }}.area_comun_construccion">

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

                                <input type="number" max="100" step=".0001" class="bg-white rounded text-xs w-full" wire:model.lazy="construccionesComun.{{ $index }}.indiviso_construccion">

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

                                <input type="number" max="100" step=".0001" class="bg-white rounded text-xs w-full" wire:model.lazy="construccionesComun.{{ $index }}.superficie_proporcional" readonly>

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

                                <input type="number" class="bg-white rounded text-xs w-full" wire:model.lazy="construccionesComun.{{ $index }}.valor_construccion_comun">

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

                </div>

                <x-button-blue
                    wire:click="agregarConstruccionComun"
                    wire:loading.attr="disabled"
                    wire:target="agregarConstruccionComun">

                    <img wire:loading wire:target="agregarConstruccionComun" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                    Agregar nuevo

                </x-button-blue>

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

    <div class="bg-white rounded-lg p-3 flex justify-end  shadow-xl mb-5">

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-3 items-center justify-center  mx-auto">

            <div class="bg-gray-100 p-4 rounded-xl  overflow-auto">

                <h4 class="text-lg mb-5 text-center">Superficies</h4>

                <table class=" w-full">

                    <thead>

                        <tr>
                            <th></th>
                            <th class="text-sm font-light tracking-widest rounded-xl border-gray-500">Privativa</th>
                            <th class="text-sm font-light tracking-widest rounded-xl border-gray-500">Proporcional</th>
                            <th class="text-sm font-light tracking-widest rounded-xl border-gray-500">Total</th>
                        </tr>

                    </thead>

                    <tbody>

                        <tr>
                            <td class="text-right text-xs lg:text-sm whitespace-nowrap">Superficie de terreno</td>
                            <td><input readonly class="bg-white rounded text-xs w-fit text-right" type="text" value="{{ $predio->superficie_terreno }}"></td>
                            <td><input readonly class="bg-white rounded text-xs w-fit text-right" type="text" value="{{ $predio->terrenosComun->sum('superficie_proporcional') }}"></td>
                            <td><input readonly class="bg-white rounded text-xs w-fit text-right" type="text" value="{{ $predio->superficie_terreno + $predio->terrenosComun->sum('superficie_proporcional') }}"></td>
                        </tr>

                        <tr>
                            <td class="text-right text-xs lg:text-sm whitespace-nowrap">Superficie de construcción</td>
                            <td><input readonly class="bg-white rounded text-xs w-fit text-right" type="text" value="{{ $predio->superficie_construccion }}"></td>
                            <td><input readonly class="bg-white rounded text-xs w-fit text-right" type="text" value="{{ $predio->construccionesComun->sum('superficie_proporcional') }}"></td>
                            <td><input readonly class="bg-white rounded text-xs w-fit text-right" type="text" value="{{ $predio->superficie_construccion  + $predio->construccionesComun->sum('superficie_proporcional') }}"></td>
                        </tr>

                    </tbody>

                </table>

            </div>

            <div class="bg-gray-100 p-4 rounded-xl">

                <h4 class="text-lg mb-5 text-center">Valores</h4>

                <table class="mr-3 lg:mr-0">

                    <tbody>

                        <tr>
                            <td class="text-xs lg:text-sm text-right">Privativa + Proporcional Terrno</td>
                            <td><input readonly class="bg-white rounded text-xs w-full ml-4 text-right" type="text" value="${{ number_format($predio->valor_total_terreno, 2) }}"></td>
                        </tr>
                        <tr>
                            <td class="text-xs lg:text-sm text-right">Privativa + Proporcional Construcción</td>
                            <td><input readonly class="bg-white rounded text-xs w-full ml-4 text-right" type="text" value="${{ number_format($predio->valor_total_construccion, 2) }}"></td>
                        </tr>

                        @if($this->predio->ubicacion_en_manzana == 'ESQUINA')

                            <tr>
                                <td class="text-xs lg:text-sm text-right">Sub Total</td>
                                <td><input readonly class="bg-white rounded text-xs w-full ml-4 text-right" type="text" value="${{ number_format($predio->valor_total_terreno + $predio->valor_total_construccion, 2) }}"></td>
                            </tr>

                            <tr>
                                <td class="text-xs lg:text-sm text-right">Ubicación en esquina</td>
                                <td><input readonly class="bg-white rounded text-xs w-full ml-4 text-right" type="text" value="${{ number_format(($predio->valor_total_terreno + $predio->valor_total_construccion) * 0.15, 2) }}"></td>
                            </tr>

                            <tr>
                                <td class="text-xs lg:text-sm text-right">Total</td>
                                <td><input readonly class="bg-white rounded text-xs w-full ml-4 text-right" type="text" value="${{ number_format(($predio->valor_total_terreno + $predio->valor_total_construccion) + ($predio->valor_total_terreno + $predio->valor_total_construccion) * 0.15, 2) }}"></td>
                            </tr>

                        @else

                            <tr>
                                <td class="text-sm text-right">Total</td>
                                <td><input readonly class="bg-white rounded text-xs w-full ml-4 text-right" type="text" value="${{ number_format($this->predio->valor_catastral, 2) }}"></td>
                            </tr>

                        @endif

                    </tbody>

                </table>

            </div>

        </div>

    </div>

    @include('livewire.comun.errores')

</div>
