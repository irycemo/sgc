<div>

    <x-header>Certificado negativo de registro</x-header>

    <div class="bg-white p-4 rounded-lg mb-5 shadow-lg">

        <div class="flex-auto text-center mb-3">

            <div >

                <Label class="text-base tracking-widest rounded-xl border-gray-500">Propietario</Label>

            </div>

            <div class="flex flex-col lg:flex-row lg:inline-flex gap-3 ">

                <x-input-group for="nombre" label="Nombre" :error="$errors->first('nombre')" class="w-full">

                    <x-input-text id="nombre" wire:model.lazy="nombre" />

                </x-input-group>

                <x-input-group for="ap_paterno" label="Paterno" :error="$errors->first('ap_paterno')" class="w-full">

                    <x-input-text id="ap_paterno" wire:model.lazy="ap_paterno" />

                </x-input-group>

                <x-input-group for="ap_materno" label="Materno" :error="$errors->first('ap_materno')" class="w-full">

                    <x-input-text id="ap_materno" wire:model.lazy="ap_materno" />

                </x-input-group>

                <x-input-group for="razon_social" label="Razón social" :error="$errors->first('razon_social')" class="w-full">

                    <x-input-text id="razon_social" wire:model.lazy="razon_social" />

                </x-input-group>

            </div>

        </div>

        <div class="mb-3">

            <button
                wire:click="buscarPropietario"
                wire:loading.attr="disabled"
                wire:target="buscarPropietario"
                type="button"
                class="bg-blue-400 mx-auto hover:shadow-lg text-white font-bold px-4 py-2 rounded text-xs hover:bg-blue-700 focus:outline-none flex items-center justify-center focus:outline-blue-400 focus:outline-offset-2">

                <img wire:loading wire:target="buscarPropietario" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                Buscar propietario

            </button>

        </div>

        @if($predioFlag && $predio)

            <div class="mb-5 text-sm">

                <p class="p-2 border border-red-500 text-red-500 font-semibold rounded-xl text-center w-full mx-auto lg:w-1/2 mb-4">No se puede expedir un certificado negativo de registro, se encontro la siguiente información:</p>

                <div class="flex flex-col lg:flex-row gap-3 justify-center w-full mx-auto lg:w-1/2">

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <strong>Cuenta predial</strong>

                        <p>{{ $predio->cuentaPredial() }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <strong>Clave catastral</strong>

                        <p>{{ $predio->claveCatastral() }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <strong>Propietario</strong>

                        <p class="uppercase">
                            {{ $nombre }} {{ $ap_paterno }} {{ $ap_materno }} {{ $razon_social }}
                        </p>

                    </div>

                </div>

            </div>

        @endif

    </div>

    <div>

        @if($tramiteFlag)

            <div class="bg-white p-4 rounded-lg mb-5 shadow-lg">

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

                <div class="mb-3">

                    <button
                        wire:click="buscarTramite"
                        wire:loading.attr="disabled"
                        wire:target="buscarTramite"
                        type="button"
                        class="bg-blue-400 mx-auto hover:shadow-lg text-white font-bold px-4 py-2 rounded text-xs hover:bg-blue-700 focus:outline-none flex items-center justify-center focus:outline-blue-400 focus:outline-offset-2">

                        <img wire:loading wire:target="buscarTramite" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                        Buscar trámtie

                    </button>

                </div>

                @if($tramite)

                    <div class="flex flex-col lg:flex-row gap-3 justify-center text-sm mb-3">

                        <div class="rounded-lg bg-gray-100 py-1 px-2">

                            <strong>Trámite</strong>

                            <p>{{ $tramite->año . '-' . $tramite->folio . '-' . $tramite->usuario }}</p>

                        </div>

                        <div class="rounded-lg bg-gray-100 py-1 px-2">

                            <strong>Servicio</strong>

                            <p>{{ $tramite->servicio->nombre }}</p>

                        </div>

                        <div class="rounded-lg bg-gray-100 py-1 px-2">

                            <strong>Solicitante</strong>

                            <p>{{ $tramite->nombre_solicitante }}</p>

                        </div>

                    </div>

                @endif

            </div>

            @if($tramite)

                <div class="flex flex-col lg:flex-row gap-3 mb-5 bg-white rounded-lg p-2 shadow-lg justify-center lg:justify-end items-center">

                    <x-button-green
                        wire:click="generarCertificado"
                        wire:loading.attr="disabled"
                        wire:target="generarCertificado">

                        <img wire:loading wire:target="generarCertificado" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                        Generar certificado

                    </x-button-green>

                </div>

            @endif

        @endif

    </div>

</div>
