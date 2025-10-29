@if ($flags['predios'])

    <div class="bg-white p-4 rounded-lg space-y-2 mb-3 shadow-md" wire:loading.class.delay.longest="opacity-50">

        <div class="flex-auto ">

            <div class="mb-2">

                <Label class="text-lg tracking-widest rounded-xl border-gray-500">Cuentas prediales involucradas</Label>

            </div>

            <div>

                @if($this->modelo_editar->tipo_tramite != 'complemento')

                    <div class="flex-row lg:flex lg:space-x-2 items-start justify-between space-y-2 lg:space-y-0">

                        <div>

                            <input placeholder="Localidad" type="number" class="bg-white rounded text-sm w-full" wire:model="localidad">

                            <div>

                                @error('localidad') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                            </div>


                        </div>

                        <div>

                            <input placeholder="Oficina rentistica" type="number" class="bg-white rounded text-sm w-full" wire:model="oficina" @if(auth()->user()->oficina->oficina != 101) readonly @endif>

                            <div>

                                @error('oficina') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                            </div>

                        </div>

                        <div>

                            <input placeholder="Tipo de predio" type="number" class="bg-white rounded text-sm w-full" wire:model="tipo">

                            <div>

                                @error('tipo') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                            </div>


                        </div>

                        <div>

                            <input placeholder="Número de registro" type="number" class="bg-white rounded text-sm w-full" wire:model="registro">

                            <div>

                                @error('registro') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                            </div>

                        </div>

                        <button
                            wire:click="buscarPredio"
                            wire:loading.attr="disabled"
                            wire:target="buscarPredio"
                            type="button"
                            class="bg-blue-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded text-sm hover:bg-blue-700 focus:outline-blue-400 focus:outline-offset-2 flex items-center w-fit">
                            <img wire:loading wire:target="buscarPredio" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">
                            <p class="mr-1"> Buscar</p>
                        </button>

                    </div>

                @endif

            </div>

            @if($predio)

                <div class="text-sm my-3 flex items-center justify-between bg-gray-100 rounded-lg p-3">

                    <div>

                        <p><strong>Propietario:</strong> {{ $predio->propietarios->first()->persona->nombre }} {{ $predio->propietarios->first()->persona->ap_paterno }} {{ $predio->propietarios->first()->persona->ap_materno }}</p>

                        <p><strong>Ubicacion:</strong> {{ $predio->nombre_vialidad }} #{{ $predio->numero_exterior }}</p>

                    </div>

                    <button
                        wire:click="agregarPredio"
                        wire:loading.attr="disabled"
                        wire:target="agregarPredio"
                        type="button"
                        class="bg-green-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded text-sm hover:bg-green-700 focus:outline-green-400 focus:outline-offset-2 flex items-center w-fit">
                        <img wire:loading wire:target="agregarPredio" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">
                        <p class="mr-1">Agregar</p>
                    </button>

                </div>

            @endif

            @if($predios)

                <div class="text-sm my-3 rounded-lg">

                    <table class="w-full rounded-lg">

                        <thead class="text-left bg-gray-100">

                            <tr>

                                <th class="px-2">Cuenta predial</th>
                                <th class="px-2">Propietario / Ubicación</th>
                                <th class="px-2"></th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach ($predios as $item)

                                <tr class="border-b py-1">

                                    <td class="px-2">{{ $item['localidad'] }}-{{ $item['oficina'] }}-{{ $item['tipo_predio'] }}-{{ $item['numero_registro'] }}</td>
                                    <td class="px-2">
                                        <p>{{ $item['propietarios'][0]['persona']['nombre'] }} {{ $item['propietarios'][0]['persona']['ap_paterno'] }} {{ $item['propietarios'][0]['persona']['ap_materno'] }}</p>
                                        <p>{{ $item['nombre_vialidad'] }} #{{ $item['numero_exterior'] }}</p>
                                    </td>
                                    <td class="px-2">

                                        @if($this->modelo_editar->tipo_tramite != 'complemento')

                                            <x-button-red
                                                wire:click="quitarPredio({{ $item['id'] }})"
                                                wire:loading.attr="disabled"
                                                wire:target="quitarPredio({{ $item['id'] }})">

                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>

                                            </x-button-red>

                                        @endif

                                    </td>

                                </tr>

                            @endforeach

                        </tbody>

                    </table>

                </div>

            @endif

            <div>

                @error('predios') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

            </div>

        </div>

    </div>

@endif