<div>

    <x-header>Historico de movimientos</x-header>

    <div class="space-y-2 mb-5 bg-white rounded-lg p-2 shadow-lg">

        <div class="flex-auto ">

            <div class="">

                <div class="flex-col lg:flex lg:space-x-2 -y-2 lg:space-y-0 items-center justify-center" >

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

            </div>

            <div class="col sm:flex-row mx-auto mt-5 flex space-y-2 sm:space-y-0 sm:space-x-3 justify-center">

                <button
                    wire:click="buscarCuentaPredial"
                    wire:loading.attr="disabled"
                    wire:target="buscarCuentaPredial"
                    type="button"
                    class="bg-blue-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded text-xs hover:bg-blue-700 focus:outline-none flex items-center justify-center focus:outline-blue-400 focus:outline-offset-2">

                    <img wire:loading wire:target="buscarCuentaPredial" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                    Consultar cuenta predial

                </button>

            </div>

        </div>

    </div>

    @if(count($movimientos))

        <div class="text-sm">

            @foreach ($movimientos as $movimiento)

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-2 mb-5 bg-white rounded-lg p-2 shadow-lg w-full flex-1" wire:key="row-{{ $movimiento->id }}">

                    <div class="rounded-lg bg-gray-100 py-1 px-2 gap-2">

                        <strong>Cuenta predial</strong>

                        <p>{{ $movimiento->cuentapredial() }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2 gap-2">

                        <strong>Fecha de movimiento</strong>

                        <p>{{ $movimiento->fecha_movimiento?->format('d/m/Y') }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2 gap-2">

                        <strong>Fecha de actualización</strong>

                        <p>{{ $movimiento->fecha_actualizacion?->format('d/m/Y') }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2 gap-2">

                        <strong>Fecha de escritura</strong>

                        <p>{{ $movimiento->fecha_escritura?->format('d/m/Y') }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2 gap-2">

                        <strong>Descripción del movimiento</strong>

                        <p>{{ $movimiento->descripcion_origen_movimiento }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2 gap-2">

                        <strong>Adquiriente</strong>

                        <p>{{ $movimiento->adquiriente }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2 gap-2">

                        <strong>Transmitente</strong>

                        <p>{{ $movimiento->transmitente }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2 gap-2">

                        <strong>Valor catastral</strong>

                        <p>${{ number_format($movimiento->valor_catastral, 2) }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2 gap-2">

                        <strong>Número de documento</strong>

                        <p>{{ $movimiento->numero_documento }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2 gap-2">

                        <strong>Número de fojas</strong>

                        <p>{{ $movimiento->numero_fojas }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2 gap-2">

                        <strong>Número de tomo</strong>

                        <p>{{ $movimiento->numero_tomo }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2 gap-2">

                        <strong>Capital mayor de fojas</strong>

                        <p>{{ $movimiento->capital_mayor_fojas }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2 gap-2">

                        <strong>Capital mayor de tomo</strong>

                        <p>{{ $movimiento->capital_mayor_tomo }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2 gap-2">

                        <strong>Número de comprobante</strong>

                        <p>{{ $movimiento->numero_comprobante }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2 gap-2">

                        <strong>Superficie notarial</strong>

                        <p>{{ $movimiento->superficie_notarial }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2 gap-2">

                        <strong>Superficie de terreno</strong>

                        <p>{{ $movimiento->superficie_terreno }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2 gap-2">

                        <strong>Superficie de construcción</strong>

                        <p>{{ $movimiento->superficie_contruccion }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2 gap-2">

                        <strong>Registrado por</strong>

                        <p>{{ $movimiento->nombre_empleado_movimiento }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2 gap-2 md:col-span-2 lg:col-span-5">

                        <strong>Ubicación</strong>

                        <p>{{ $movimiento->ubicacion }}</p>

                    </div>

                    <div class="rounded-lg bg-gray-100 py-1 px-2 gap-2 md:col-span-2 lg:col-span-5">

                        <strong>Observaciones</strong>

                        <p>{{ $movimiento->observaciones }}</p>

                    </div>

                </div>

            @endforeach

        </div>

    @endif

</div>
