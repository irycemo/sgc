<div>

    <x-header>Consulta certificación</x-header>

    <div class="bg-white p-4 rounded-lg shadow-xl mb-5">

        <div class="lg:w-1/2 mx-auto text-center space-y-5">

            <div>

                <select class="bg-white rounded-full text-sm border @error('año') border-red-500 @enderror" wire:model="año">
                    @foreach ($años as $año)

                        <option value="{{ $año }}">{{ $año }}</option>

                    @endforeach
                </select>

                <input type="number" wire:model="folio" placeholder="Folio" class="bg-white rounded-full text-sm w-24 @error('folio') border-red-500 @enderror">

                <input type="number" wire:model="usuario" placeholder="Usuario" class="bg-white rounded-full text-sm w-24 mb-5 @error('usuario') border-red-500 @enderror">

                <x-button-blue
                    class="mx-auto"
                    wire:click="buscarTramite"
                    wire:loading.attr="disabled"
                    wire:target="buscarTramite"
                    type="button"
                    class="bg-blue-400 mx-auto hover:shadow-lg text-white font-bold px-4 py-2 rounded text-xs hover:bg-blue-700 focus:outline-none flex items-center justify-center focus:outline-blue-400 focus:outline-offset-2">

                    <img wire:loading wire:target="buscarTramite" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">
                    Buscar por trámite
                </x-button-blue>

            </div>

            <div>

                <input type="number" wire:model="localidad" placeholder="Localidad" class="bg-white rounded-full text-sm w-24 @error('localidad') border-red-500 @enderror">

                <input type="number" wire:model="oficina" placeholder="Oficina" class="bg-white rounded-full text-sm w-24 @error('oficina') border-red-500 @enderror">

                <input type="number" wire:model="t_predio" placeholder="T. Predio" class="bg-white rounded-full text-sm w-24 @error('t_predio') border-red-500 @enderror">

                <input type="number" wire:model="registro" placeholder="# Registro" class="bg-white rounded-full text-sm w-24 mb-5 @error('registro') border-red-500 @enderror">

                <x-button-blue
                    class="mx-auto"
                    class="mx-auto"
                    wire:click="buscarCuentaPredial"
                    wire:loading.attr="disabled"
                    wire:target="buscarCuentaPredial"
                    type="button"
                    class="bg-blue-400 mx-auto hover:shadow-lg text-white font-bold px-4 py-2 rounded text-xs hover:bg-blue-700 focus:outline-none flex items-center justify-center focus:outline-blue-400 focus:outline-offset-2">

                    <img wire:loading wire:target="buscarCuentaPredial" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">
                    Buscar por cuenta predial
                </x-button-blue>

            </div>


        </div>

    </div>

    <div class="overflow-x-auto rounded-lg shadow-xl border-t-2 border-t-gray-500">

        <x-table>

            <x-slot name="head">

                <x-table.heading >Tipo</x-table.heading>
                <x-table.heading >Año</x-table.heading>
                <x-table.heading >Folio</x-table.heading>
                <x-table.heading >Cuenta predial</x-table.heading>
                <x-table.heading >Estado</x-table.heading>
                <x-table.heading >Oficina</x-table.heading>
                <x-table.heading >Trámite</x-table.heading>
                <x-table.heading >Observaciones</x-table.heading>
                <x-table.heading >Registro</x-table.heading>
                <x-table.heading >Actualizado</x-table.heading>
                <x-table.heading ></x-table.heading>

            </x-slot>

            <x-slot name="body">

                @forelse ($this->certificaciones as $certificacion)

                    <x-table.row wire:loading.class.delaylongest="opacity-50" wire:key="row-{{ $certificacion->id }}">

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Documento</span>

                            {{ $certificacion->tipo->label() }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Año</span>

                            {{ $certificacion->año }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Folio</span>

                            {{ $certificacion->folio }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Cuenta Predial</span>

                            {{ $certificacion->predio ? $certificacion->predio->cuentaPredial() : 'N/A' }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Estado</span>

                            @if($certificacion->estado == 'activo')

                                <span class="bg-green-400 py-1 px-2 rounded-full text-white text-xs">{{ ucfirst($certificacion->estado) }}</span>

                            @elseif($certificacion->estado == 'caducado')

                                <span class="bg-gray-400 py-1 px-2 rounded-full text-white text-xs">{{ ucfirst($certificacion->estado) }}</span>

                            @else

                                <span class="bg-red-400 py-1 px-2 rounded-full text-white text-xs">{{ ucfirst($certificacion->estado) }}</span>

                            @endif

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Oficina</span>

                            {{ $certificacion->oficina->nombre }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Trámite</span>

                            {{ $certificacion->tramite?->año }}-{{ $certificacion->tramite?->folio }}-{{ $certificacion->tramite?->usuario }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Observaciones</span>

                            {{ $certificacion->observaciones ?? 'N/A' }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Registrado</span>


                            <span class="font-semibold">@if($certificacion->creadoPor != null)Registrado por: {{$certificacion->creadoPor->name}} @else Registro: @endif</span> <br>

                            {{ $certificacion->created_at }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="font-semibold">@if($certificacion->actualizadoPor != null)Actualizado por: {{$certificacion->actualizadoPor->name}} @else Actualizado: @endif</span> <br>

                            {{ $certificacion->updated_at }}

                        </x-table.cell>

                        <x-table.cell>

                            <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Acciones</span>

                            <div class="ml-3 " x-data="{ open_drop_down:false }">

                                <div>

                                    <button x-on:click="open_drop_down=true" type="button" class="rounded-full focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-800 focus:ring-white">

                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM12.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0ZM18.75 12a.75.75 0 1 1-1.5 0 .75.75 0 0 1 1.5 0Z" />
                                        </svg>

                                    </button>

                                </div>

                                <div x-cloak x-show="open_drop_down" x-on:click="open_drop_down=false" x-on:click.away="open_drop_down=false" class="z-50 origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg py-1 bg-white ring-1 ring-black ring-opacity-5 focus:outline-none" role="menu" aria-orientation="vertical" aria-labelledby="user-menu">

                                    @if($certificacion->estado != 'cancelado')

                                        <button
                                            wire:click="reimprimir('{{ $certificacion->uuid }}')"
                                            wire:loading.attr="disabled"
                                            class="w-full text-left block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 focus:outline-none focus:bg-gray-100"
                                            role="menuitem">
                                            Reimprimir
                                        </button>

                                    @endif

                                </div>

                            </div>

                        </x-table.cell>

                    </x-table.row>

                @empty

                    <x-table.row>

                        <x-table.cell colspan="11">

                            <div class="bg-white text-gray-500 text-center p-5 rounded-full text-lg">

                                No hay resultados.

                            </div>

                        </x-table.cell>

                    </x-table.row>

                @endforelse

            </x-slot>

            <x-slot name="tfoot">

                <x-table.row>


                </x-table.row>

            </x-slot>

        </x-table>

    </div>

</div>
