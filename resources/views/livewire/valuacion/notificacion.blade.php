<div>

    <x-header>Notificación de avaluos</x-header>

    <div class="bg-white p-4 rounded-lg mb-5 shadow-lg">

        <div class="flex-auto text-center mb-3">

            <div >

                <Label class="text-base tracking-widest rounded-xl border-gray-500">Trámite de inspección ocular</Label>

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
                class="bg-blue-400 mx-auto hover:shadow-lg text-white font-bold px-4 py-2 rounded text-xs hover:bg-blue-700 focus:outline-none flex items-center justify-center focus:outline-blue-400 focus:outline-offset-2 mb-3">

                <img wire:loading wire:target="buscarTramite" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                Buscar trámite

            </button>

            @if($tramite && $flag_notificar)

                <button
                    wire:click="abrirModal"
                    wire:loading.attr="disabled"
                    wire:target="abrirModal"
                    class="bg-green-400 mx-auto hover:shadow-lg text-white font-bold px-4 py-2 rounded text-xs hover:bg-green-700 focus:outline-none flex items-center justify-center focus:outline-blue-400 focus:outline-offset-2">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                    </svg>

                    Notificar

                </button>

            @endif

        </div>

    </div>

    @if($this->avaluos)

        <div class="relative overflow-x-auto rounded-lg shadow-xl border-t-2 border-t-gray-500">

            <x-table>

                <x-slot name="head">

                    <x-table.heading >Folio</x-table.heading>

                    <x-table.heading >Cuenta predial</x-table.heading>

                    <x-table.heading >Clave catastral</x-table.heading>

                    <x-table.heading >Propietario</x-table.heading>

                    <x-table.heading >Valor catastral</x-table.heading>

                    </tr>

                </x-slot>

                <x-slot name="body">

                    @forelse($this->avaluos as $avaluo)

                        <x-table.row wire:key="row-{{ $propietario->id }}">

                            <x-table.cell title="Folio">

                                    {{ $avaluo->año }}-{{ $avaluo->folio }}-{{ $avaluo->usuario }}

                            </x-table.cell>

                            <x-table.cell title="Cuenta predial">

                                {{ $avaluo->predioAvaluo->cuentaPredial() }}

                            </x-table.cell>

                            <x-table.cell title="Clave catastral">

                                {{ $avaluo->predioAvaluo->claveCatastral()  }}

                            </x-table.cell>

                            <x-table.cell title="Propietario">

                                <p class="mt-2">{{ $avaluo->predioAvaluo->primerPropietario() }}</p>

                            </x-table.cell>

                            <x-table.cell title="Propietario">

                                ${{ number_format($avaluo->predioAvaluo->valor_catastral, 2) }}

                            </x-table.cell>

                        </x-table.row>

                    @empty

                        <tr>
                            <td colspan="6">
                                <p class="text-center text-xl tracking-widest text-gray-500 bg-white py-5"> No hay resultados.</p>
                            </td>
                        </tr>

                    @endforelse

                </x-slot>

                <x-slot name="tfoot">
                    <tr>

                        <td colspan="16" class="py-2 px-5">
                            {{ $this->avaluos->links()}}
                        </td>

                    </tr>
                </x-slot>

            </x-table>

        </div>

    @endif

    <x-dialog-modal wire:model="modal" maxWidth="sm">

        <x-slot name="title">

            Notificar avaluos

        </x-slot>

        <x-slot name="content">

            <div class="flex-auto ">

                <div>

                    <Label>Fecha de notificación</Label>

                </div>

                <div>

                    <input type="date" class="bg-white rounded text-sm w-full" wire:model.live="fecha_notificacion">

                </div>

                <div>

                    @error('fecha_notificacion') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                </div>

            </div>

        </x-slot>

        <x-slot name="footer">

            <div class="flex gap-3 items-center">

                <x-button-blue
                    wire:click="notificarTodos"
                    wire:loading.attr="disabled"
                    wire:target="notificarTodos">

                    <img wire:loading wire:target="notificarTodos" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                    Notificar
                </x-button-blue>

                <x-button-red
                    wire:click="$toggle('modal')"
                    wire:loading.attr="disabled"
                    wire:target="$toggle('modal')">
                    Cerrar
                </x-button-red>

            </div>

        </x-slot>

    </x-dialog-modal>

</div>
