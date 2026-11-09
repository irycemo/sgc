<div>

    @if(!auth()->user()->hasRole(['Convenio municipal']))

        <div class="bg-white rounded-lg shadow-xl p-4 mb-5">

            <div class="flex justify-center mx-auto gap-33">

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

                @if (in_array($avaluo_para, [3,4,5,6,9,10]))

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

                @endif

            </div>

        </div>

    @endif

    <div class="p-4 flex-auto bg-white rounded-lg mb-3 shadow-md space-y-3">

        <h4 class="text-lg mb-5 text-center">Cuentas prediales</h4>

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

                <div class="flex flex-wrap justify-start items-center gap-2">

                    <input title="Localidad" placeholder="Localidad" type="number" class="bg-white rounded text-xs w-20 @error('predios_cuentas.' . $index . '.localidad') border-1 border-red-500 @enderror" wire:model="localidad">

                    <input title="Oficina" placeholder="Oficina" type="number" class="bg-white rounded text-xs w-20 @error('predios_cuentas.' . $index . '.oficina') border-1 border-red-500 @enderror" wire:model="oficina" @if(auth()->user()->oficina->oficina != 101) readonly @endif>

                    <input title="Tipo de predio" placeholder="Tipo" type="number" class="bg-white rounded text-xs w-16 @error('predios_cuentas.' . $index . '.tipo_predio') border-1 border-red-500 @enderror" wire:model="predios_cuentas.{{ $index }}.tipo_predio">

                    <input title="Registro" placeholder="Registro" type="number" class="bg-white rounded text-xs @error('predios_cuentas.' . $index . '.numero_registro') border-1 border-red-500 @enderror" wire:model="predios_cuentas.{{ $index }}.numero_registro">

                    <div class="flex-auto my-auto">

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

    @include('livewire.comun.errores')

    <div class="bg-white rounded-lg p-3 flex flex-col justify-center shadow-md">

        @if(! in_array($estadoProceso, ['generando', 'listo']))

            <div class="flex justify-center w-full mb-5">

                <x-button-green
                    wire:click="imprimir"
                    wire:loading.attr="disabled"
                    wire:target="imprimir">

                    <img wire:loading wire:target="imprimir" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                    Imprimir

                </x-button-green>

            </div>

        @endif

        @if($estadoProceso === 'generando')

            {{-- wire:poll se activa solo mientras este bloque existe; al pasar a
                "listo"/"error" el bloque desaparece y el polling se detiene. --}}
            <div
                wire:poll.5s="consultarEstado"
                class="mb-5 text-sm flex flex-col items-center gap-3 text-gray-600">

                <img class="h-4" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                <p class="font-semibold text-base">Generando notificación…</p>

                <svg class="animate-spin h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                </svg>

            </div>

        @endif

        @if($estadoProceso === 'listo' && $urlDescarga)

            <div class="mb-5 text-sm flex flex-col items-center gap-3 text-gray-700">

                <p class="font-semibold text-base text-green-700">La notificación está lista.</p>

                <a
                    href="{{ $urlDescarga }}"
                    target="_blank"
                    rel="noopener"
                    class="bg-green-500 hover:bg-green-600 text-white font-bold px-6 py-2 rounded">

                    Descargar notificación… (PDF)

                </a>

            </div>

        @endif

        @if($estadoProceso === 'error')

            <div class="mb-5 text-sm flex flex-col items-center gap-3">

                <p class="font-semibold text-base text-red-700">
                    {{ $mensajeError ?? 'No fue posible generar la notificación.' }}
                </p>

            </div>

        @endif

    </div>

</div>
