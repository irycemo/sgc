<div>

    <div class="bg-white p-4 rounded-lg shadow-lg mb-10">

        <ul class="grid w-full mx-auto gap-6 md:grid-cols-2">

            <li>

                <input type="radio" id="clave" name="hosting" value="clave" class="hidden peer" wire:model.live="radio" >

                <label for="clave" class="inline-flex items-center justify-between w-full p-1 px-3 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">

                    <div class="block">

                        <div class="w-full font-semibold">Cambio de regimen</div>

                    </div>

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 13.5 12 21m0 0-7.5-7.5M12 21V3" />
                    </svg>

                </label>

            </li>

            <li>

                <input type="radio" id="propietario" name="hosting" value="propietario" class="hidden peer" wire:model.live="radio">

                <label for="propietario" class="inline-flex items-center justify-between w-full p-1 px-3 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">

                    <div class="block">

                        <div class="w-full font-semibold">Desglose</div>

                    </div>

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 13.5 12 21m0 0-7.5-7.5M12 21V3" />
                    </svg>

                </label>

            </li>

        </ul>

    </div>

    @if(!auth()->user()->hasRole(['Convenio municipal']))

        <div class="bg-white rounded-lg shadow-xl p-4 mb-5">

            <div class="flex-col justify-center mx-auto space-y-3">

                <div class="flex-auto text-center">

                    <div class="text-center">

                        <Label class="text-base tracking-widest rounded-xl border-gray-500">Trámite de inspección ocular</Label>

                    </div>

                    <div class="inline-flex justify-center">

                        <select class="bg-white rounded-l text-sm border border-r-transparent  focus:ring-0" wire:model="inspeccion_año">
                            @foreach ($años as $año)

                                <option value="{{ $año }}">{{ $año }}</option>

                            @endforeach
                        </select>

                        <input type="number" class="bg-white text-sm w-20 focus:ring-0 @error('inspeccion_folio') border-red-500 @enderror" wire:model="inspeccion_folio">

                        <input type="number" class="bg-white text-sm w-20 border-l-0 rounded-r focus:ring-0 @error('inspeccion_usuario') border-red-500 @enderror" wire:model="inspeccion_usuario">

                    </div>

                </div>

                <div class="flex-auto  text-center">

                    <div >

                        <Label class="text-base tracking-widest rounded-xl border-gray-500">Trámite de desglose</Label>

                    </div>

                    <div class="inline-flex">

                        <select class="bg-white rounded-l text-sm border border-r-transparent  focus:ring-0" wire:model="desglose_año">
                            @foreach ($años as $año)

                                <option value="{{ $año }}">{{ $año }}</option>

                            @endforeach
                        </select>

                        <input type="number" class="bg-white text-sm w-20 focus:ring-0 @error('desglose_folio') border-red-500 @enderror" wire:model="desglose_folio">

                        <input type="number" class="bg-white text-sm w-20 border-l-0 rounded-r focus:ring-0 @error('desglose_usuario') border-red-500 @enderror" wire:model="desglose_usuario">

                    </div>

                </div>

            </div>

        </div>

    @endif

    <div class="p-4 flex-auto bg-white rounded-lg mb-3 shadow-md space-y-3">

        <h4 class="text-lg mb-5 text-center">Predio origen</h4>

        <div class="flex flex-wrap space-x-1 justify-center items-center">

            <input title="Localidad" placeholder="Localidad" type="number" class="bg-white rounded text-xs w-20 @error('localidad') border-1 border-red-500 @enderror" wire:model.blur="localidad">

            <input title="Oficina" placeholder="Oficina" type="number" class="bg-white rounded text-xs w-20 @error('oficina') border-1 border-red-500 @enderror" wire:model.blur="oficina" @if(auth()->user()->oficina->oficina != 101) readonly @endif>

            <input title="Tipo de predio" placeholder="Tipo" type="number" class="bg-white rounded text-xs w-16 @error('tipo_padre') border-1 border-red-500 @enderror" wire:model="tipo_padre">

            <input title="Número de registro" placeholder="# de Registro" type="number" class="bg-white rounded text-xs mt-2 sm:mt-0 @error('registro_padre') border-1 border-red-500 @enderror" wire:model.live="registro_padre">

        </div>

    </div>

    @if($radio)

        <div class="p-4 flex-auto bg-white rounded-lg mb-3 shadow-md space-y-3">

            <h4 class="text-lg mb-5 text-center">Cuentas prediales desglosadas</h4>

            <div class="flex flex-wrap justify-center items-center gap-2">

                <input title="Localidad" placeholder="Localidad" type="number" class="bg-white rounded text-xs w-20 @error('localidad') border-1 border-red-500 @enderror" wire:model.blur="localidad">

                <input title="Oficina" placeholder="Oficina" type="number" class="bg-white rounded text-xs w-20 @error('oficina') border-1 border-red-500 @enderror" wire:model.blur="oficina" @if(auth()->user()->oficina->oficina != 101) readonly @endif>

                <input title="Tipo de predio" placeholder="Tipo" type="number" class="bg-white rounded text-xs w-16 @error('tipo') border-1 border-red-500 @enderror" wire:model="tipo">

                <div class="sm:flex items-center gap-2">

                    <input title="Registro inicial" placeholder="Registro inicial" type="number" class="bg-white rounded text-xs @error('registro_inicio') border-1 border-red-500 @enderror" wire:model.live="registro_inicio">

                    <p class="text-sm text-center mb-0">a</p>

                    <input title="Registro final" placeholder="Registro final" type="number" class="bg-white rounded text-xs @error('registro_final') border-1 border-red-500 @enderror" wire:model="registro_final">

                </div>

            </div>

            <div class="flex flex-col justify-center items-center gap-2">

                @foreach ($predios_cuentas as $index => $predio)

                    <div class="flex flex-wrap space-x-1 justify-center items-center">

                        <input title="Localidad" placeholder="Localidad" type="number" class="bg-white rounded text-xs w-20 @error('predios_cuentas.' . $index . '.localidad') border-1 border-red-500 @enderror" wire:model="localidad">

                        <input title="Oficina" placeholder="Oficina" type="number" class="bg-white rounded text-xs w-20 @error('predios_cuentas.' . $index . '.oficina') border-1 border-red-500 @enderror" wire:model="oficina" @if(auth()->user()->oficina->oficina != 101) readonly @endif>

                        <input title="Tipo de predio" placeholder="Tipo" type="number" class="bg-white rounded text-xs w-16 @error('predios_cuentas.' . $index . '.tipo_predio') border-1 border-red-500 @enderror" wire:model="tipo">

                        <input title="Registro" placeholder="Registro" type="number" class="bg-white rounded text-xs @error('predios_cuentas.' . $index . '.numero_registro') border-1 border-red-500 @enderror" wire:model="predios_cuentas.{{ $index }}.numero_registro">

                        <div class="flex-auto lg:col-span-1 my-auto">

                            <x-button-red
                                wire:click="borrarPredio({{ $index }})"
                                wire:loading.attr="disabled"
                            >

                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>

                            </x-button-red>

                        </div>

                    </div>

                @endforeach

                <div class="flex justify-end lg:col-span-3">

                    <x-button-blue
                        wire:click="agregarPredio"
                        wire:loading.attr="disabled"
                    >

                        <img wire:loading wire:target="agregarPredio" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                        Agregar predio

                    </x-button-blue>

                </div>

            </div>

        </div>

    @endif

    @if($radio)

        <div class="p-4 flex-auto bg-white rounded-lg mb-3 shadow-md space-y-3">

            <h4 class="text-lg mb-5 text-center">Cuenta nueva</h4>

            <div class="flex flex-wrap space-x-1 justify-center items-center">

                <input title="Localidad" placeholder="Localidad" type="number" class="bg-white rounded text-xs w-20 @error('localidad_origen') border-1 border-red-500 @enderror" wire:model.blur="localidad_origen">

                <input title="Oficina" placeholder="Oficina" type="number" class="bg-white rounded text-xs w-20 @error('oficina_origen') border-1 border-red-500 @enderror" wire:model.blur="oficina_origen" readonly>

                <input readonly title="Tipo de predio" placeholder="Tipo" type="number" class="bg-white rounded text-xs w-16 @error('tipo_nuevo') border-1 border-red-500 @enderror" wire:model="tipo_nuevo">

                <input title="Registro inicial" placeholder="Registro" type="number" class="bg-white rounded text-xs mt-2 sm:mt-0 @error('registro_nuevo') border-1 border-red-500 @enderror" wire:model.live="registro_nuevo">

            </div>
        </div>

    @endif

    @include('livewire.comun.errores')

    <div class="bg-white rounded-lg p-3 flex justify-end shadow-md">

        <x-button-green
            wire:click="imprimir"
            wire:loading.attr="disabled"
            wire:target="imprimir">

            <img wire:loading wire:target="imprimir" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

            Imprimir

        </x-button-green>

    </div>

</div>
