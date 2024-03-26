<div>

    <x-header>Reactivación de trámties</x-header>

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

                    <p>{{ $tramite->servicio->categoria->nombre }} - {{ $tramite->servicio->nombre }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2">

                    <strong>Solicitante</strong>

                    <p>{{ $tramite->nombre_solicitante }}</p>

                </div>

            </div>

            @can('Autorizar tramite')

                <button
                    wire:click="autorizarTramite"
                    wire:loading.attr="disabled"
                    wire:target="autorizarTramite"
                    type="button"
                    class="bg-blue-400 mx-auto hover:shadow-lg text-white font-bold px-4 py-2 rounded text-xs hover:bg-blue-700 focus:outline-none flex items-center justify-center focus:outline-blue-400 focus:outline-offset-2">

                    <img wire:loading wire:target="autorizarTramite" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                    Autorizar impresión del trámtie

                </button>

            @endcan

        @endif

    </div>

    @if($tramite)

        <div class="bg-white p-4 rounded-lg mb-5 shadow-lg text-sm my-3">

            @if($tramite->predios()->count() > 0)

                <div class="overflow-auto">

                    <table class="w-full lg:w-1/2 rounded-lg mx-auto">

                        <thead class="text-left bg-gray-100">

                            <tr>

                                <th class="px-2">Estado</th>
                                <th class="px-2">Localidad</th>
                                <th class="px-2">Oficina</th>
                                <th class="px-2">Tipo de predio</th>
                                <th class="px-2">Número de registro</th>
                                <th class="px-2"></th>

                            </tr>

                        </thead>

                        <tbody>

                            @foreach ($tramite->predios as $item)

                                <tr class="border-b py-1">

                                    <td class="px-2">
                                        <span class="rounded-full px-1 text-white @if($item->pivot->estado === 'A') bg-green-500 @else bg-gray-500 @endif">{{ $item->pivot->estado }}</span>
                                    </td>
                                    <td class="px-2">
                                        {{ $item->localidad }}
                                    </td>
                                    <td class="px-2">
                                        <p>{{ $item->oficina }}</p>
                                    </td>
                                    <td class="px-2">
                                        <p>{{ $item->tipo_predio }}</p>
                                    </td>
                                    <td class="px-2">
                                        <p>{{ $item->numero_registro }}</p>
                                    </td>
                                    <td class="px-2 flex items-center space-x-2">

                                        @if($item->pivot->estado === 'I')

                                            <button
                                                wire:click="reactivarPredio({{ $item['id'] }})"
                                                wire:loading.attr="disabled"
                                                wire:target="reactivarPredio({{ $item['id'] }})"
                                                class=" bg-blue-400 text-white text-xs p-1 items-center rounded-full hover:bg-blue-700 flex justify-center focus:outline-none"
                                            >

                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                                                </svg>

                                            </button>

                                        @endif

                                    </td>

                                </tr>

                            @endforeach

                            <tr>
                                <td colspan="6">Total: {{ $tramite->predios()->count() }}</td>
                            </tr>

                        </tbody>

                    </table>

                </div>

            @else

                <div class="flex justify-center gap-3 mb-3">

                    <x-input-group for="cantidad" label="Cantidad">

                        <x-input-text id="cantidad" value="{{ $tramite->cantidad }}" readonly/>

                    </x-input-group>

                    <x-input-group for="usados" label="Usados">

                        <x-input-text id="usados" value="{{ $tramite->usados }}" readonly/>

                    </x-input-group>

                    <x-input-group for="cantidad" label="Cantidad a reactivar" :error="$errors->first('cantidad')">

                        <x-input-text id="cantidad" wire:model="cantidad" />

                    </x-input-group>

                </div>

                <button
                    wire:click="reactivarCantidad"
                    wire:loading.attr="disabled"
                    wire:target="reactivarCantidad"
                    type="button"
                    class="bg-blue-400 mx-auto hover:shadow-lg text-white font-bold px-4 py-2 rounded text-xs hover:bg-blue-700 focus:outline-none flex items-center justify-center focus:outline-blue-400 focus:outline-offset-2">

                    <img wire:loading wire:target="reactivarCantidad" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                    Reactivar

                </button>

            @endif

        </div>

    @endif

</div>
