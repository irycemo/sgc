<div>

    <div class="shadow-lg md:flex flex-col md:flex-row justify-between md:space-x-3 items-center bg-white rounded-xl mb-5 p-4 relative z-40 mb-5" wire:loading.class.delay.longest="opacity-50">

        <div wire:loading.flex class="flex absolute top-1 right-1 items-center z-50">
            <svg class="animate-spin h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>

        <div class="md:flex md:flex-row flex-col md:space-x-4 items-end bg-white rounded-xl">

            <div>

                <div>

                    <Label>Fecha inicial</Label>

                </div>

                <div>

                    <input type="date" class="bg-white rounded text-sm " wire:model.live="fecha1">

                </div>

                <div>

                    @error('fecha1') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                </div>

            </div>

            <div class="mt-2 md:mt-0">

                <div>

                    <Label>Fecha final</Label>

                </div>

                <div>

                    <input type="date" class="bg-white rounded text-sm " wire:model.live="fecha2">

                </div>

                <div>

                    @error('fecha2') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                </div>

            </div>

        </div>

        <div class="flex-auto ">

            <div>

                <Label>Categorías</Label>
            </div>

            <div>

                <select class="rounded text-sm w-full" wire:model.live="categoria">

                    <option value="" selected>Seleccione una opción</option>

                    @foreach ($categorias as $categoria)

                        <option value="{{$categoria->id}}" >{{$categoria->nombre}}</option>

                    @endforeach

                </select>

            </div>

            <div>

                @error('categoria') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

            </div>

        </div>

        <div class="w-full ">

            <div>

                <Label>Tipo de trámite</Label>
            </div>

            <div>

                <select class="rounded text-sm w-full" wire:model.live="tipo_tramite">

                    <option value="" selected>Seleccione una opción</option>
                    <option value="normal" selected>Normal</option>
                    <option value="complemento" selected>Complemento</option>

                </select>

            </div>

            <div>

                @error('tipo_tramite') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

            </div>

        </div>

        <div class="w-full ">

            <div>

                <Label>Servicio</Label>
            </div>

            <div>

                <select class="rounded text-sm w-full" wire:model.live="servicio_id">

                    <option value="" selected>Seleccione una opción</option>

                    @foreach ($servicios as $servicio)

                        <option value="{{$servicio->id}}" >{{$servicio->nombre}}</option>

                    @endforeach

                </select>

            </div>

            <div>

                @error('servicio_id') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

            </div>

        </div>

    </div>

    <div class="md:flex md:flex-row flex-col p-4 bg-white rounded-xl mb-5">

        <span class="text-xl tracking-widest">Total ${{ number_format($total, 2) }}</span>

    </div>

    <div class="shadow-lg bg-white rounded-xl mb-5 p-4">

        <table class="table-fixed mx-auto w-1/2">

            <tbody class="divide-y divide-gray-200">

                @php
                    $total1 = 0;
                    $total2 = 0;
                @endphp

                @foreach ($tramites as $key => $item)

                    <tr class="text-gray-500 text-sm leading-relaxed">
                        <td class=" px-2 w-1/12"><p>{{ $item['cantidad'] }}</p></td>
                        <td class=" px-2 w-full whitespace-nowrap overflow-hidden text-ellipsis"><p>{{ $key }}</p></td>
                        <td class=" px-2 w-3/12 whitespace-nowrap text-right"><p>${{ number_format($item['monto'], 2) }}</p></td>
                    </tr>

                    @php

                        $total1 = $total1 + $item['monto'];
                        $total2 = $total2 + $item['cantidad']

                    @endphp

                @endforeach

                @php

                    echo " <tr class='text-gray-500 text-sm leading-relaxed'>
                                <td class='px-2 w-full font-bold'>" . $total2 . "</td>
                                <td class='px-2 w-full whitespace-nowrap font-bold'>Total</td>
                                <td class='px-2 w-full whitespace-nowrap font-bold text-right'><p>$"  . number_format($total1, 2) . "</p></td>
                            </tr>
                        ";
                @endphp

            </tbody>

        </table>

    </div>

</div>
