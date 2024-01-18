<div class="">

    <div class="mb-6">

        <h1 class="text-3xl tracking-widest py-3 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-thin mb-6  bg-white">Notificación</h1>

    </div>

    <div class="flex justify-center mx-auto  items-center space-x-4 space-y-2 mb-5 bg-white rounded-lg p-2 ">

        <p class="text-lg tracking-widest">Avaluos</p>

        <input type="number" class="bg-white rounded text-xs w-40 @error('inicio') border-1 border-red-500 @enderror" placeholder="Inicio" wire:model.live="inicio">

        <p class="text-lg tracking-widest">a</p>

        <input type="number" class="bg-white rounded text-xs w-40 @error('final') border-1 border-red-500 @enderror" placeholder="Final" wire:model.live="final">

    </div>

    @if($avaluos->count())

        <div class="relative overflow-x-auto rounded-lg shadow-xl border-t-2 border-t-gray-500">

            <table class="rounded-lg w-full">

                <thead class="border-b border-gray-300 bg-gray-50">

                    <tr class="text-xs font-medium text-gray-500 uppercase text-left traling-wider">

                        <th class="px-3 py-3 hidden lg:table-cell">
                            Folio
                        </th>

                        <th class="px-3 py-3 hidden lg:table-cell">
                            Cuenta predial
                        </th>

                        <th class="px-3 py-3 hidden lg:table-cell">
                            Clave catastral
                        </th>

                        <th class="px-3 py-3 hidden lg:table-cell">
                            Propietario
                        </th>

                        <th class="px-3 py-3 hidden lg:table-cell">
                            valor catastral
                        </th>

                        <th class="px-3 py-3 hidden lg:table-cell">Acciones</th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-gray-200 flex-1 sm:flex-none ">

                    @foreach($avaluos as $avaluo)

                        <tr class="text-sm font-medium text-gray-500 bg-white flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0">

                            <td class="px-3 py-3 w-full lg:w-auto p-3 text-gray-800 text-center lg:text-left lg:border-0 border border-b block lg:table-cell relative lg:static">

                                <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Folio</span>

                                {{ $avaluo->folio }}

                            </td>

                            <td class="px-3 py-3 w-full lg:w-auto p-3 text-gray-800 text-center lg:text-left lg:border-0 border border-b block lg:table-cell relative lg:static">

                                <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Cuenta predial</span>

                                {{ $avaluo->predio->localidad }}-{{ $avaluo->predio->oficina }}-{{ $avaluo->predio->tipo_predio }}-{{ $avaluo->predio->numero_registro }}

                            </td>

                            <td class="px-3 py-3 w-full lg:w-auto p-3 text-gray-800 text-center lg:text-left lg:border-0 border border-b block lg:table-cell relative lg:static">

                                <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Clave catastral</span>

                                {{ $avaluo->predio->estado }}-{{ $avaluo->predio->region_catastral }}-{{ $avaluo->predio->municipio }}-{{ $avaluo->predio->zona_catastral }}-{{ $avaluo->predio->localidad }}-{{ $avaluo->predio->sector }}-{{ $avaluo->predio->manzana }}-{{ $avaluo->predio->predio }}-{{ $avaluo->predio->edificio ?? '0' }}-{{ $avaluo->predio->departamento ?? '0' }}

                            </td>

                            <td class="px-3 py-3 w-full lg:w-auto p-3 text-gray-800 text-center lg:text-left lg:border-0 border border-b block lg:table-cell relative lg:static">

                                <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Propietario</span>

                                {{ $avaluo->predio->propietarios->first()->persona->nombre }} {{ $avaluo->predio->propietarios->first()->persona->ap_paterno }} {{ $avaluo->predio->propietarios->first()->persona->ap_materno }}

                            </td>

                            <td class="px-3 py-3 w-full lg:w-auto p-3 text-gray-800 text-center lg:text-left lg:border-0 border border-b block lg:table-cell relative lg:static">

                                <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Valor catastral</span>

                                ${{ number_format($avaluo->predio->valor_catastral, 2) }}

                            </td>

                            <td class="px-3 py-3 w-full lg:w-auto p-3 text-gray-800 text-center lg:text-left lg:border-0 border border-b lg:table-cell relative lg:static">

                                <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Acciones</span>

                                <button
                                    wire:click="abrirModal({{$avaluo->id}})"
                                    wire:loading.attr="disabled"
                                    wire:target="abrirModal({{$avaluo->id}})"
                                    class="md:w-full bg-blue-400 hover:shadow-lg text-white text-xs md:text-sm px-3 py-1 items-center rounded-full mr-2 hover:bg-blue-700 flex justify-center focus:outline-none"
                                >

                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6 mr-4">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                                    </svg>

                                    Notificar

                                </button>

                            </td>
                        </tr>

                    @endforeach

                </tbody>

                <tfoot class="border-gray-300 bg-gray-50">

                    <tr>

                        <td colspan="16" class="py-2 px-5">
                            {{ $avaluos->links()}}
                        </td>

                    </tr>

                </tfoot>

            </table>

            <div class="h-full w-full rounded-lg bg-gray-200 bg-opacity-75 absolute top-0 left-0" wire:loading.delay.longer>

                <img class="mx-auto h-16" src="{{ asset('storage/img/loading.svg') }}" alt="">

            </div>

        </div>

    @else

        <div class="border-b border-gray-300 bg-white text-gray-500 text-center p-5 rounded-full text-lg">

            No hay resultados.

        </div>

    @endif

    <x-dialog-modal wire:model.live="modal" maxWidth="sm">

        <x-slot name="title">

            Notificar avaluo

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

            <div class="float-righ">

                <button
                    wire:click="notificar"
                    wire:loading.attr="disabled"
                    wire:target="notificar"
                    class="bg-blue-400 text-white hover:shadow-lg font-bold px-4 py-2 rounded-full text-sm mb-2 hover:bg-blue-700 flaot-left mr-1 focus:outline-none">

                    <img wire:loading wire:target="notificar" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                    Notificar
                </button>

                <button
                    wire:click="$set('modal', false)"
                    wire:loading.attr="disabled"
                    wire:target="$set('modal', false)"
                    type="button"
                    class="bg-red-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded-full text-sm mb-2 hover:bg-red-700 flaot-left focus:outline-none">
                    Cerrar
                </button>

            </div>

        </x-slot>

    </x-dialog-modal>

</div>
