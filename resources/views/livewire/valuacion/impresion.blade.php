<div class="">

    <div class="mb-6">

        <h1 class="text-3xl tracking-widest py-3 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-thin mb-6  bg-white">Impresión de avaluos</h1>

    </div>

    <div class="space-y-2 mb-5 bg-white rounded-lg p-2">

        <div class="grid grid-cols-1 sm:grid-cols-12 gap-3 items-end mx-auto mb-4">

            <div class="flex-auto col-span-4">

                <div class="text-center">

                    <Label class="text-base tracking-widest rounded-xl border-gray-500">Trámite de inspección ocular</Label>

                </div>

                <div class="text-center">

                    <input type="number" class="bg-white rounded text-xs w-40 @error('tramiteInspeccion') border-1 border-red-500 @enderror" wire:model.defer="tramiteInspeccion">

                </div>

            </div>

            <div class="flex-auto col-span-4">

                <div class="text-center">

                    <Label class="text-base tracking-widest rounded-xl border-gray-500">Trámite que ampara la impresión de los avaluos</Label>

                </div>

                <div class="text-center">

                    <input type="number" class="bg-white rounded text-xs w-40 @error('tramiteAvaluo') border-1 border-red-500 @enderror" wire:model.defer="tramiteAvaluo">

                </div>

            </div>

            <div class="flex-auto  col-span-4">

                <div class="text-center">

                    <Label class="text-base tracking-widest rounded-xl border-gray-500">Formato juridico</Label>

                </div>

                <div class="text-center flex flex-row space-x-4">

                    <label>

                        <input type="radio" wire:model="formato" value="0">
                        Dirección de catastro

                    </label>

                    <label class="">

                        <input type="radio" wire:model="formato" value="1">
                        Programa de actualización catastral

                    </label>

                </div>

            </div>

        </div>

    </div>


    <div class="p-4 flex-auto bg-white rounded-lg mb-3 shadow-md space-y-3">

        <h4 class="text-lg mb-5 text-center">Cuentas prediales</h4>

        <div class="flex flex-wrap space-x-1 justify-center items-center">

            <input placeholder="Localidad" type="number" class="bg-white rounded text-xs w-20 @error('localidad') border-1 border-red-500 @enderror" wire:model.lazy="localidad">

            <input placeholder="Oficina" type="number" class="bg-white rounded text-xs w-20 @error('oficina') border-1 border-red-500 @enderror" wire:model.lazy="oficina" @if(auth()->user()->oficina != 101) readonly @endif>

            <input placeholder="Tipo" type="number" class="bg-white rounded text-xs w-16 @error('tipo') border-1 border-red-500 @enderror" wire:model.defer="tipo">

            <input placeholder="Registro inicial" type="number" class="bg-white rounded text-xs @error('registro_inicio') border-1 border-red-500 @enderror" wire:model.defer="registro_inicio">
            <p class="text-sm mb-0">a</p>
            <input placeholder="Registro final" type="number" class="bg-white rounded text-xs" wire:model.defer="registro_final">

        </div>

    </div>

    <div class="p-4 flex-auto bg-white rounded-lg mb-3 shadow-md space-y-3">

        <h4 class="text-lg mb-5 text-center">Firmas</h4>

        @if(!$formato)

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 items-end mx-auto mb-4">

                <div class="flex-auto">

                    <div class="text-center">

                        <Label class="text-base tracking-widest rounded-xl border-gray-500">Director de catastro</Label>

                    </div>

                    <div class="text-center">

                        <input type="text" class="bg-white rounded text-xs w-full" wire:model.defer="director" readonly>

                    </div>

                </div>

                <div class="flex-auto">

                    <div class="text-center">

                        <Label class="text-base tracking-widest rounded-xl border-gray-500">Jefe de departamento</Label>

                    </div>

                    <div class="text-center">

                        <input type="text" class="bg-white rounded text-xs w-full" wire:model.defer="jefe_departamento" readonly>

                    </div>

                </div>

                <div class="flex-auto">

                    <div class="text-center">

                        <Label class="text-base tracking-widest rounded-xl border-gray-500 ">Notificador</Label>

                    </div>

                    <div class="text-center">

                        <input type="text" class="bg-white rounded text-xs w-full @error('notificador') border-1 border-red-500 @enderror" wire:model.defer="notificador">

                    </div>

                </div>

                <div class="flex-auto">

                    <div class="text-center">

                        <Label class="text-base tracking-widest rounded-xl border-gray-500">Valuador</Label>

                    </div>

                    <div class="text-center">

                        <select wire:model.defer="valuador" class="bg-white rounded text-xs w-full @error('valuador') border-1 border-red-500 @enderror">

                            <option value="" selected>Seleccione una opción</option>

                            @foreach ($valuadores as $valuador)

                                <option value="{{ $valuador->name }} {{ $valuador->ap_paterno }} {{ $valuador->ap_materno }}">{{ $valuador->name }} {{ $valuador->ap_paterno }} {{ $valuador->ap_materno }}</option>

                            @endforeach

                        </select>

                    </div>

                </div>

            </div>

        @else

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 items-end mx-auto mb-4">

                <div class="flex-auto">

                    <div class="text-center">

                        <Label class="text-base tracking-widest rounded-xl border-gray-500">Autoridad municipal</Label>

                    </div>

                    <div class="text-center">

                        <input type="text" class="bg-white rounded text-xs w-full lg:w-1/2" wire:model.defer="autoridad_municipal" readonly>

                    </div>

                </div>

                <div class="flex-auto">

                    <div class="text-center">

                        <Label class="text-base tracking-widest rounded-xl border-gray-500">Valuador municipal</Label>

                    </div>

                    <div class="text-center">

                        <input type="text" class="bg-white rounded text-xs w-full lg:w-1/2" wire:model.defer="valuador_municipal" readonly>

                    </div>

                </div>

            </div>

        @endif

    </div>

    <div class="p-4 flex-auto bg-white rounded-lg mb-3 shadow-md space-y-3">

        <h4 class="text-lg mb-5 text-center">Datos de notificación</h4>

        <div class="flex items-center space-x-1 mx-auto mb-4">

            <p>En la ciudad de </p>

            <input type="text" class="bg-white rounded text-xs @error('ciudad') border-1 border-red-500 @enderror" wire:model.defer="ciudad">

            <p>a las</p>

            <input type="text" class="bg-white rounded text-xs @error('hora') border-1 border-red-500 @enderror" wire:model.defer="hora">

            <p>del día</p>

            <input type="text" class="bg-white rounded text-xs @error('dia') border-1 border-red-500 @enderror" wire:model.defer="dia">

            <p>del mes</p>

            <input type="text" class="bg-white rounded text-xs @error('mes') border-1 border-red-500 @enderror" wire:model.defer="mes">

            <p>del año</p>

            <input type="text" class="bg-white rounded text-xs @error('año') border-1 border-red-500 @enderror" wire:model.defer="año">

        </div>

        <div class="flex items-center space-x-1 mx-auto mb-4 w-full">

            <div class="flex-auto">

                <div class="text-center">

                    <Label class="text-base tracking-widest rounded-xl border-gray-500">Nombre completo</Label>

                </div>

                <div class="text-center">

                    <input type="text" class="bg-white rounded text-xs w-full @error('nombre') border-1 border-red-500 @enderror" wire:model.defer="nombre">

                </div>

            </div>

            <div class="flex-auto">

                <div class="text-center">

                    <Label class="text-base tracking-widest rounded-xl border-gray-500">Recibí en calidad de</Label>

                </div>

                <div class="text-center">

                    <input type="text" class="bg-white rounded text-xs w-full @error('calidad') border-1 border-red-500 @enderror" wire:model.defer="calidad">

                </div>

            </div>

        </div>

    </div>

    <div class="bg-white rounded-lg p-3 flex justify-end">

        @if(count($errors) > 0)

            <span class="bg-red-400 hover:shadow-lg text-white text-xs md:text-sm px-3 py-1 ml-auto rounded-full  hover:bg-red-700 flex items-center justify-center focus:outline-none ">
                Campos incorrectos
                @error('predio') <span class="error text-sm text-white">{{ $message }}</span> @enderror
            </span>

        @endif

        <button
            wire:click="imprimir"
            wire:loading.attr="disabled"
            wire:target="imprimir"
            class=" bg-green-400 hover:shadow-lg text-white text-xs md:text-sm px-3 py-1 ml-auto rounded-full  hover:bg-green-700 flex items-center justify-center focus:outline-none "
        >

            <img wire:loading wire:target="imprimir" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

            Imprimir

        </button>

    </div>

</div>
