<div>

    <x-header>Certificado de historia</x-header>

    <div class="bg-white p-4 rounded-lg shadow-lg mb-5">

        <ul class="grid w-full lg:w-1/2 mx-auto gap-6 md:grid-cols-2">

            <li>

                <input type="radio" id="hosting-small" name="hosting" value="movimiento" class="hidden peer" wire:model.live="radio" required>

                <label for="hosting-small" class="inline-flex items-center justify-between w-full p-3 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">

                    <div class="block">

                        <div class="w-full text-lg font-semibold">Ingresar movimientos</div>

                    </div>

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 13.5 12 21m0 0-7.5-7.5M12 21V3" />
                    </svg>

                </label>

            </li>

            <li>

                <input type="radio" id="hosting-big" name="hosting" value="certificado" class="hidden peer" wire:model.live="radio">

                <label for="hosting-big" class="inline-flex items-center justify-between w-full p-3 text-gray-500 bg-white border border-gray-200 rounded-lg cursor-pointer dark:hover:text-gray-300 dark:border-gray-700 dark:peer-checked:text-blue-500 peer-checked:border-blue-600 peer-checked:text-blue-600 hover:text-gray-600 hover:bg-gray-100 dark:text-gray-400 dark:bg-gray-800 dark:hover:bg-gray-700">

                    <div class="block">

                        <div class="w-full text-lg font-semibold">Generar certificado</div>

                    </div>

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 13.5 12 21m0 0-7.5-7.5M12 21V3" />
                    </svg>

                </label>

            </li>

        </ul>

    </div>

    @if($radio === 'movimiento')

        <div class="bg-white p-4 rounded-lg shadow-lg mb-5">

            <div class="flex-auto ">

                <div class="">

                    <div class="flex-row lg:flex lg:space-x-2 mb-2 space-y-2 lg:space-y-0 items-center justify-center" >

                        <div class="text-left">

                            <Label class="text-base tracking-widest rounded-xl border-gray-500">Cuenta predial</Label>

                        </div>

                        <div class="space-y-1">

                            <input title="Localidad" placeholder="Localidad" type="number" class="bg-white rounded text-xs w-20 @error('localidad') border-1 border-red-500 @enderror" wire:model.blur="localidad">

                            <input title="Oficina" placeholder="Oficina" type="number" class="bg-white rounded text-xs w-20 @error('oficina') border-1 border-red-500 @enderror" wire:model="oficina" @if(auth()->user()->oficina->oficina != 101) readonly @endif>

                            <input title="Tipo de predio" placeholder="Tipo" type="number" class="bg-white rounded text-xs w-20 @error('tipo_predio') border-1 border-red-500 @enderror" wire:model="tipo_predio">

                            <input title="Número de registro" placeholder="Registro" type="number" class="bg-white rounded text-xs w-20 @error('numero_registro') border-1 border-red-500 @enderror" wire:model.blur="numero_registro">

                        </div>

                    </div>

                    <div class="flex-row lg:flex lg:space-x-2 space-y-2 lg:space-y-0 items-center justify-center">

                        <div class="text-left">

                            <Label class="text-base tracking-widest rounded-xl border-gray-500">Clave catastral </Label>

                        </div>

                        <div class="space-y-1">

                            <input placeholder="Estado" type="number" class="bg-white rounded text-xs w-20" title="Estado" value="16" readonly>

                            <input title="Región catastral" placeholder="Región" type="number" class="bg-white rounded text-xs w-20  @error('region_catastral') border-1 border-red-500 @enderror" wire:model="region_catastral">

                            <input title="Municipio" placeholder="Municipio" type="number" class="bg-white rounded text-xs w-20 @error('municipio') border-1 border-red-500 @enderror" wire:model="municipio">

                            <input title="Zona" placeholder="Zona" type="number" class="bg-white rounded text-xs w-20 @error('zona_catastral') border-1 border-red-500 @enderror" wire:model="zona_catastral">

                            <input title="Localidad" placeholder="Localidad" type="number" class="bg-white rounded text-xs w-20 @error('localidad') border-1 border-red-500 @enderror" wire:model.blur="localidad">

                            <input title="Sector" placeholder="Sector" type="number" class="bg-white rounded text-xs w-20 @error('sector') border-1 border-red-500 @enderror" wire:model="sector">

                            <input title="Manzana" placeholder="Manzana" type="number" class="bg-white rounded text-xs w-20 @error('manzana') border-1 border-red-500 @enderror" wire:model="manzana">

                            <input title="Predio" placeholder="Predio" type="number" class="bg-white rounded text-xs w-20 @error('predio_clave') border-1 border-red-500 @enderror" wire:model.blur="predio_clave">

                            <input title="Edificio" placeholder="Edificio" type="number" class="bg-white rounded text-xs w-20 @error('edificio') border-1 border-red-500 @enderror" wire:model="edificio">

                            <input title="Departamento" placeholder="Departamento" type="number" class="bg-white rounded text-xs w-20 @error('departamento') border-1 border-red-500 @enderror" wire:model="departamento">

                        </div>

                    </div>

                </div>

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

                </div>

            </div>

        </div>

        <div>

            @if($predio)

                <div class="bg-white p-4 rounded-lg mb-5 text-center shadow-lg">

                    <span class="text-lg text-gray-800">Movimimientos</span>

                    <div class="flex flex-col lg:flex-row gap-3 justify-center text-sm mt-5">

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

                            <p>{{ $predio->primerPropietario() }}</p>

                        </div>

                    </div>

                </div>

                <div class=" flex justify-end mb-5">

                    <button wire:click="abrirModalCrear" class="bg-gray-500 hover:shadow-lg hover:bg-gray-700 text-sm py-2 px-4 text-white rounded-full hidden md:block items-center justify-center focus:outline-gray-400 focus:outline-offset-2">

                        <img wire:loading wire:target="abrirModalCrear" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">
                        Agregar nuevo movimiento

                    </button>

                    <button wire:click="abrirModalCrear" class="bg-gray-500 hover:shadow-lg hover:bg-gray-700 float-right text-sm py-2 px-4 text-white rounded-full focus:outline-none md:hidden">+</button>

                </div>

                @foreach ($predio->movimientos->reverse() as $movimiento)

                    <div class="bg-white p-2 rounded-lg mb-3 shadow-lg space-y-2 text-sm">

                        <div class="flex flex-col md:flex-row items-center justify-between gap-2">

                            <div class="flex flex-col md:flex-row items-center gap-3 order-2 md:order-1 w-full">

                                <div class="rounded-lg bg-gray-100 py-1 px-2 w-full">

                                    <strong>Movimiento</strong>

                                    <p>{{ $movimiento->nombre }}</p>

                                </div>

                                <div class="rounded-lg bg-gray-100 py-1 px-2 w-full">

                                    <strong>Fecha</strong>

                                    <p>{{ $movimiento->fecha->format('d-m-Y') }}</p>

                                </div>

                            </div>

                            <div class="flex items-center gap-3 order-1 md:order-2">

                                <button
                                    wire:click="abrirModalEditar({{ $movimiento->id }})"
                                    wire:loading.attr="disabled"
                                    class="bg-blue-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded-full text-xs hover:bg-blue-700 focus:outline-none flex items-center justify-center focus:outline-blue-400 focus:outline-offset-2">

                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>

                                </button>

                                <button
                                    wire:click="abrirModalBorrar({{$movimiento->id}})"
                                    wire:loading.attr="disabled"
                                    class="bg-red-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded-full text-xs hover:bg-red-700 focus:outline-none flex items-center justify-center focus:outline-red-400 focus:outline-offset-2">

                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>

                                </button>

                            </div>

                        </div>

                        <div class="rounded-lg bg-gray-100 py-1 px-2 w-full">

                            <strong>Descripción</strong>

                            <p>{{ $movimiento->descripcion }}</p>

                        </div>

                    </div>

                @endforeach

            @endif

        </div>

    @elseif($radio === 'certificado')

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

                    Buscar trámite

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

                <div class="flex flex-col lg:flex-row gap-3 justify-center text-sm">

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

                        <p>{{ $predio->primerPropietario() }}</p>

                    </div>

                </div>

            @endif

        </div>

        @if($predio && $tramite)

            <div class="bg-white p-4 rounded-lg mb-5 shadow-lg">

                <div class="text-center mb-5">

                    <span class="text-lg text-gray-800">Historia</span>

                </div>

                <div class="w-full lg:w-1/2 mx-auto bg-gray-50 p-4 rounded-lg text-sm">

                    {!! $historia !!}

                </div>

            </div>

            <div class="flex flex-col lg:flex-row gap-3 mb-5 bg-white rounded-lg p-2 shadow-lg justify-center lg:justify-between items-center">

                <div>

                    {{-- <div class="flex space-x-4 items-center">

                        <x-checkbox wire:model="impresionDirector"></x-checkbox>

                        <Label>Imprimir certificado con firma del director de catastro</Label>

                    </div> --}}

                </div>

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

    <x-dialog-modal wire:model="modal">

        <x-slot name="title">

            @if($crear)
                Nuevo Movimiento
            @elseif($editar)
                Editar Movimiento
            @endif

        </x-slot>

        <x-slot name="content">

            <div class="relative p-1">

                <div class="flex flex-col md:flex-row justify-between md:space-x-3 mb-5">

                    <x-input-group for="nombre" label="Movimiento" :error="$errors->first('nombre')" class="w-full">

                        <x-input-select id="nombre" wire:model="nombre" class="">

                            <option value="">Seleccione una opción</option>

                            @foreach ($acciones_padron as $item)

                                    <option value="{{ $item }}">{{ $item }}</option>

                                @endforeach

                        </x-input-select>

                    </x-input-group>

                    <x-input-group for="fecha" label="Fecha" :error="$errors->first('fecha')" class="w-full">

                        <x-input-text type=date id="fecha" wire:model="fecha" />

                    </x-input-group>

                </div>

                <div class="flex flex-col md:flex-row justify-between md:space-x-3 mb-5">

                    <x-input-group for="fecha" label="Descripción" :error="$errors->first('fecha')" class="w-full">

                        <textarea rows="5" wire:model="descripcion" class="bg-white rounded text-xs w-full "></textarea>

                    </x-input-group>

                </div>

            </div>

        </x-slot>

        <x-slot name="footer">

            <div class="flex gap-3">

                @if($crear)

                    <x-button-blue
                        wire:click="guardar"
                        wire:loading.attr="disabled"
                        wire:target="guardar">

                        <img wire:loading wire:target="guardar" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                        Guardar
                    </x-button-blue>

                @elseif($editar)

                    <x-button-blue
                        wire:click="actualizar"
                        wire:loading.attr="disabled"
                        wire:target="actualizar">

                        <img wire:loading wire:target="actualizar" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                        Actualizar
                    </x-button-blue>

                @endif

                <x-button-red
                    wire:click="$toggle('modal')"
                    wire:loading.attr="disabled"
                    wire:target="$toggle('modal')"
                    type="button">
                    Cerrar
                </x-button-red>

            </div>

        </x-slot>

    </x-dialog-modal>

    <x-confirmation-modal wire:model="modalBorrar" maxWidth="sm">

        <x-slot name="title">
            Eliminar Movimiento
        </x-slot>

        <x-slot name="content">
            ¿Esta seguro que desea eliminar el movimiento? No sera posible recuperar la información.
        </x-slot>

        <x-slot name="footer">

            <x-secondary-button
                wire:click="$toggle('modalBorrar')"
                wire:loading.attr="disabled"
            >
                No
            </x-secondary-button>

            <x-danger-button
                class="ml-2"
                wire:click="borrar()"
                wire:loading.attr="disabled"
                wire:target="borrar"
            >
                Borrar
            </x-danger-button>

        </x-slot>

    </x-confirmation-modal>

</div>
