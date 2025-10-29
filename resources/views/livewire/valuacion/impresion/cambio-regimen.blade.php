<div>

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

            <input title="Localidad" placeholder="Localidad" type="number" class="bg-white rounded text-xs w-20 @error('localidad_origen') border-1 border-red-500 @enderror" wire:model.blur="localidad_origen">

            <input title="Oficina" placeholder="Oficina" type="number" class="bg-white rounded text-xs w-20 @error('oficina_origen') border-1 border-red-500 @enderror" wire:model.blur="oficina_origen" @if(auth()->user()->oficina->oficina != 101) readonly @endif>

            <input readonly title="Tipo de predio" placeholder="Tipo" type="number" class="bg-white rounded text-xs w-16 @error('tipo_origen') border-1 border-red-500 @enderror" wire:model="tipo_origen">

            <input title="Número de registro" placeholder="# de Registro" type="number" class="bg-white rounded text-xs mt-2 sm:mt-0 @error('registro_origen') border-1 border-red-500 @enderror" wire:model.live="registro_origen">

        </div>

    </div>

    <div class="p-4 flex-auto bg-white rounded-lg mb-3 shadow-md space-y-3">

        <h4 class="text-lg mb-5 text-center">Cuenta nueva</h4>

        <div class="flex flex-wrap space-x-1 justify-center items-center">

            <input title="Localidad" placeholder="Localidad" type="number" class="bg-white rounded text-xs w-20 @error('localidad_origen') border-1 border-red-500 @enderror" wire:model.blur="localidad_origen">

            <input title="Oficina" placeholder="Oficina" type="number" class="bg-white rounded text-xs w-20 @error('oficina_origen') border-1 border-red-500 @enderror" wire:model.blur="oficina_origen" readonly>

            <input readonly title="Tipo de predio" placeholder="Tipo" type="number" class="bg-white rounded text-xs w-16 @error('tipo_nuevo') border-1 border-red-500 @enderror" wire:model="tipo_nuevo">

            <input title="Registro inicial" placeholder="Registro" type="number" class="bg-white rounded text-xs mt-2 sm:mt-0 @error('registro_nuevo') border-1 border-red-500 @enderror" wire:model.live="registro_nuevo">

        </div>
    </div>

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
