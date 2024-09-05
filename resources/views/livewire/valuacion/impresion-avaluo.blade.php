<div>

    <div class="mb-6">

        <x-header>Impresión de avalúos</x-header>

    </div>

    @if(auth()->user()->hasRole('Convenio municipal'))

        <div class="p-4 flex-auto bg-white rounded-lg mb-3 shadow-md gap-3">

            <h4 class="text-lg mb-5 text-center">Cuentas prediales</h4>

            <div class="flex flex-wrap gap-1 justify-center items-center">

                <input placeholder="Localidad" type="number" class="bg-white rounded text-xs w-20 @error('localidad') border-1 border-red-500 @enderror" wire:model.blur="localidad">

                <input placeholder="Oficina" type="number" class="bg-white rounded text-xs w-20 @error('oficina') border-1 border-red-500 @enderror" wire:model.blur="oficina" @if(auth()->user()->oficina->oficina != 101) readonly @endif>

                <input placeholder="Tipo" type="number" class="bg-white rounded text-xs w-16 @error('tipo') border-1 border-red-500 @enderror" wire:model="tipo">

                <div class="flex gap-2 items-center">

                    <input placeholder="Registro inicial" type="number" class="bg-white rounded text-xs @error('registro_inicio') border-1 border-red-500 @enderror" wire:model="registro_inicio">
                    <p class="text-sm mb-0">a</p>
                    <input placeholder="Registro final" type="number" class="bg-white rounded text-xs @error('registro_final') border-1 border-red-500 @enderror" wire:model="registro_final">

                </div>

            </div>

        </div>

    @else

        <div class="space-y-2 mb-5 bg-white rounded-lg p-2 shadow-md">

            <div class="flex-col justify-center mx-auto mb-4">

                <div class="flex-auto text-center mb-4">

                    <div class="text-center">

                        <Label class="text-base tracking-widest rounded-xl border-gray-500">Trámite que ampara la impresión de los avalúos</Label>

                    </div>

                    <div class="inline-flex justify-center">

                        <select class="bg-white rounded-l text-sm border border-r-transparent  focus:ring-0" wire:model="añoAvaluo">
                            @foreach ($años as $año)

                                <option value="{{ $año }}">{{ $año }}</option>

                            @endforeach
                        </select>

                        <input type="number" class="bg-white text-sm w-20 focus:ring-0 @error('folioAvaluo') border-red-500 @enderror" wire:model="folioAvaluo">

                        <input type="number" class="bg-white text-sm w-20 border-l-0 rounded-r focus:ring-0 @error('usuarioAvaluo') border-red-500 @enderror" wire:model="usuarioAvaluo">

                    </div>

                </div>

                <div class="flex-auto  text-center">

                    <div >

                        <Label class="text-base tracking-widest rounded-xl border-gray-500">Trámite de inspección ocular</Label>

                    </div>

                    <div class="inline-flex">

                        <select class="bg-white rounded-l text-sm border border-r-transparent  focus:ring-0" wire:model="añoInspeccion">
                            @foreach ($años as $año)

                                <option value="{{ $año }}">{{ $año }}</option>

                            @endforeach
                        </select>

                        <input type="number" class="bg-white text-sm w-20 focus:ring-0 @error('folioInspeccion') border-red-500 @enderror" wire:model="folioInspeccion">

                        <input type="number" class="bg-white text-sm w-20 border-l-0 rounded-r focus:ring-0 @error('usuarioInspeccion') border-red-500 @enderror" wire:model="usuarioInspeccion">

                    </div>

                    <div>

                        @error('folioInspeccion') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                    </div>

                </div>

            </div>

        </div>

        <div class="p-4 flex-auto bg-white rounded-lg mb-3 shadow-md space-y-3">

            <h4 class="text-lg mb-5 text-center">Cuentas prediales</h4>

            <div class="flex flex-wrap space-x-1 justify-center items-center">

                <input title="Localidad" placeholder="Localidad" type="number" class="bg-white rounded text-xs w-20 @error('localidad') border-1 border-red-500 @enderror" wire:model.blur="localidad">

                <input title="Oficina" placeholder="Oficina" type="number" class="bg-white rounded text-xs w-20 @error('oficina') border-1 border-red-500 @enderror" wire:model.blur="oficina" @if(auth()->user()->oficina->oficina != 101) readonly @endif>

                <input title="Tipo de predio" placeholder="Tipo" type="number" class="bg-white rounded text-xs w-16 @error('tipo') border-1 border-red-500 @enderror" wire:model="tipo">

                <input title="Registro inicial" placeholder="Registro inicial" type="number" class="bg-white rounded text-xs @error('registro_inicio') border-1 border-red-500 @enderror" wire:model.live="registro_inicio">
                <p class="text-sm mb-0">a</p>
                <input title="Registro final" placeholder="Registro final" type="number" class="bg-white rounded text-xs @error('registro_final') border-1 border-red-500 @enderror" wire:model="registro_final">

            </div>

        </div>

        <div class="p-4 flex-auto bg-white rounded-lg mb-3 shadow-md space-y-3">

            <div class="text-center">

                <Label class="text-lg mb-5 text-center">Clave catastral </Label>

            </div>

            <div class="space-y-1 text-center">

                <input placeholder="Estado" type="number" class="bg-white rounded text-xs w-20" title="Estado" value="16" readonly>

                <input title="Región catastral" data-tooltip-target="tooltip-default" placeholder="Región" type="number" class="bg-white rounded text-xs w-20  @error('region_catastral') border-1 border-red-500 @enderror" wire:model.live="region_catastral">

                <input title="Municipio" placeholder="Municipio" type="number" class="bg-white rounded text-xs w-20 @error('municipio') border-1 border-red-500 @enderror" wire:model="municipio">

                <input title="Zona catastral" placeholder="Zona" type="number" class="bg-white rounded text-xs w-20 @error('zona_catastral') border-1 border-red-500 @enderror" wire:model="zona_catastral">

                <input title="Localidad" placeholder="Localidad" type="number" class="bg-white rounded text-xs w-20 @error('localidad') border-1 border-red-500 @enderror" wire:model.blur="localidad">

                <input title="Sector" placeholder="Sector" type="number" class="bg-white rounded text-xs w-20 @error('sector') border-1 border-red-500 @enderror" wire:model="sector">

                <input title="Manzana" placeholder="Manzana" type="number" class="bg-white rounded text-xs w-20 @error('manzana') border-1 border-red-500 @enderror" wire:model="manzana">

                <input title="Predio" placeholder="Predio" type="number" class="bg-white rounded text-xs w-20 @error('predio') border-1 border-red-500 @enderror" wire:model.blur="predio">

                <input title="Edificio" placeholder="Edificio" type="number" class="bg-white rounded text-xs w-20 @error('edificio') border-1 border-red-500 @enderror" wire:model="edificio">

                <input title="Departamento" placeholder="Departamento" type="number" class="bg-white rounded text-xs w-20 @error('departamento') border-1 border-red-500 @enderror" wire:model="departamento">

            </div>

        </div>

    @endif

    @if(count($errors) > 0)

        <div class="mb-5 bg-white rounded-lg p-2 shadow-lg flex gap-2 flex-wrap ">

            <ul class="flex gap-2 felx flex-wrap list-disc ml-5">
            @foreach ($errors->all() as $error)

                <li class="text-red-500 text-xs md:text-sm ml-5">
                    {{ $error }}
                </li>

            @endforeach

        </ul>

        </div>

    @endif

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
