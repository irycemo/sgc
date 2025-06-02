<div class="">

    <x-header>Oficina ({{ $oficina->nombre }})</x-header>

    <h4 class="text-2xl tracking-widest py-1 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-thin mb-6  bg-white">Datos generales</h4>

    <div class="p-4 bg-white rounded-lg mb-5 text-sm">

        @if($editar)

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-2 mb-3">

                <div class="">

                    <div>

                        <Label>Titular</Label>
                    </div>

                    <div>

                        <input type="text" class="bg-white rounded text-sm w-full" wire:model="titular">

                    </div>

                    <div>

                        @error('titular') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                    </div>

                </div>

                <div class="">

                    <div>

                        <Label>Email</Label>
                    </div>

                    <div>

                        <input type="email" class="bg-white rounded text-sm w-full" wire:model="email">

                    </div>

                    <div>

                        @error('email') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                    </div>

                </div>

                <div class="">

                    <div>

                        <Label>Teléfonos</Label>
                    </div>

                    <div>

                        <input type="text" class="bg-white rounded text-sm w-full" wire:model="telefonos">

                    </div>

                    <div>

                        @error('telefonos') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                    </div>

                </div>

                <div class="">

                    <div>

                        <Label>Autoridad municipal</Label>
                    </div>

                    <div>

                        <input type="text" class="bg-white rounded text-sm w-full" wire:model="autoridad_municipal">

                    </div>

                    <div>

                        @error('autoridad_municipal') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                    </div>

                </div>

                <div class="">

                    <div>

                        <Label>Valuador municipal</Label>
                    </div>

                    <div>

                        <input type="text" class="bg-white rounded text-sm w-full" wire:model="valuador_municipal">

                    </div>

                    <div>

                        @error('valuador_municipal') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                    </div>

                </div>

            </div>

            <div class="mb-3">

                <div>

                    <Label>Ubicación</Label>
                </div>

                <div>

                    <textarea rows="3" class="bg-white rounded text-sm w-full" wire:model="ubicacion"></textarea>

                </div>

                <div>

                    @error('ubicacion') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                </div>

            </div>

            <div class="flex items-center gap-3 justify-end">

                <x-button-blue
                    wire:click="actualizar"
                    wire:loading.attr="disabled"
                    wire:target="actualizar">

                    <img wire:loading wire:target="actualizar" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                    Actualizar
                </x-button-blue>

                <x-button-red
                    wire:click="$toggle('editar')"
                    wire:loading.attr="disabled"
                    wire:target="$toggle('editar')">
                    Cerrar
                </x-button-red>

            </div>

        @else

            <div class=" flex justify-end mb-3">

                <button wire:click="$toggle('editar')" class=" bg-blue-400 hover:shadow-lg text-white font-bold p-2 rounded-full text-xs hover:bg-blue-700 focus:outline-none flex items-center justify-center focus:outline-blue-400 focus:outline-offset-2">

                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                    </svg>

                </button>

            </div>

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-2 mb-3">

                <div class="rounded-lg bg-gray-100 py-1 px-2">

                    <p><strong>Municipio:</strong> {{ $oficina->municipio }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2">

                    <p><strong>Número de oficina:</strong> {{ $oficina->oficina }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2">

                    <p><strong>Localidad:</strong> {{ $oficina->localidad }}</p>

                </div>

                @if($oficina->cabecera)

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <p><strong>Cabecera municipal:</strong> {{ $oficina->cabeceraMunicipal->nombre }}</p>

                    </div>

                @endif

                <div class="rounded-lg bg-gray-100 py-1 px-2">

                    <p><strong>Titular:</strong> {{ $oficina->titular }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2">

                    <p><strong>Autoridad municipal:</strong> {{ $oficina->autoridad_municipal }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2">

                    <p><strong>Valuador municipal:</strong> {{ $oficina->valuador_municipal }}</p>

                </div>

                @if($sectores)

                    <div class="rounded-lg bg-gray-100 py-1 px-2">

                        <p>

                            <strong>Sectores:</strong>

                            @foreach ($sectores as $sector)

                                {{ $sector }},

                            @endforeach
                        </p>

                    </div>

                @endif

                <div class="rounded-lg bg-gray-100 py-1 px-2">

                    <p><strong>Email:</strong> {{ $oficina->email }}</p>

                </div>

                <div class="rounded-lg bg-gray-100 py-1 px-2">

                    <p><strong>Teléfonos:</strong> {{ $oficina->telefonos }}</p>

                </div>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <p><strong>Dirección:</strong> {{ $oficina->ubicacion }}</p>

            </div>

        @endif

    </div>

    <h4 class="text-2xl tracking-widest py-1 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-thin mb-6  bg-white">Usuarios</h4>

    <div class="p-4 bg-white rounded-lg mb-5 overflow-auto">

        <table class="w-full table">

            <thead class="border-b border-gray-300 bg-gray-50">

                <tr class="text-xs font-medium text-gray-600 uppercase text-left traling-wider">
                    <th class="px-3 py-3">Clave</th>
                    <th class="px-3 py-3">Nombre</th>
                    <th class="px-3 py-3">Email</th>
                    <th></th>
                </tr>

            </thead>

            <tbody class="divide-y divide-gray-200 flex-1 sm:flex-none ">

                @foreach ($usuarios as $usuario)

                    <tr class="text-sm font-medium text-gray-600 bg-white ">

                        <td class="p-2">{{ $usuario->clave }}</td>
                        <td class="p-2">{{ $usuario->name }} {{ $usuario->ap_paterno }} {{ $usuario->ap_materno }}</td>
                        <td class="p-2">{{ $usuario->email }}</td>
                        <td class="p-2">
                            <button
                                wire:click="abrirModalVer({{ $usuario->id }})"
                                wire:loading.attr="disabled"
                                wire:target="abrirModalVer({{ $usuario->id }})"
                                class="bg-blue-400 hover:shadow-lg text-white text-xs  px-3 py-1 items-center rounded-full mr-2 hover:bg-blue-700 flex flex-1 justify-center focus:outline-none"
                            >

                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-4 h-4 mr-2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 010-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>

                                Ver permisos

                            </button>
                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

    {{-- <h4 class="text-2xl tracking-widest py-1 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-thin mb-6  bg-white">Estadísticos del municipio (@if($oficina->cabeceraMunicipal) {{ $oficina->cabeceraMunicipal->nombre }} @else {{ $oficina->nombre }} @endif)</h4>

    <div class="p-4 bg-white rounded-lg mb-5 overflow-auto">

        <table class="w-full">

            <thead class="border-b border-gray-300 bg-gray-50">

                <tr class="text-xs font-medium text-gray-600 uppercase text-left traling-wider">
                    <th class="px-3 py-3">Total de predios</th>
                    <th class="px-3 py-3">Predios urbanos</th>
                    <th class="px-3 py-3">Predios rústicos</th>
                    <th class="px-3 py-3">Predios en sector 88</th>
                    <th class="px-3 py-3">Predios en sector 99</th>
                    <th class="px-3 py-3">Predios con clave definitiva</th>
                </tr>

            </thead>

            <tbody class="divide-y divide-gray-200 flex-1 sm:flex-none ">

                <tr class="text-sm font-medium text-gray-600 bg-white text-center">
                    <td>{{ number_format($predios) }}</td>
                    <td>{{ number_format($predios_urbanos) }}</td>
                    <td>{{ number_format($predios_rusticos) }}</td>
                    <td>{{ number_format($predios_88) }}</td>
                    <td>{{ number_format($predios_99) }}</td>
                    <td>{{ number_format($predios - $predios_99 - $predios_88) }}</td>
                </tr>
                <tr>
                    <td colspan="6">
                        <div class="bg-gray-50 p-1 text-center"><span class="text-sm font-medium text-gray-600">Porcentaje sobre el total de predios del estado ({{ number_format($total_predios, 2) }})</span></div>
                    </td>
                </tr>
                <tr class="text-sm font-medium text-gray-600 bg-white text-center">
                    <td>{{ number_format(($predios / $total_predios) * 100, 2) }}%</td>
                    <td>{{ number_format(($predios_urbanos / $total_predios) * 100, 2) }}%</td>
                    <td>{{ number_format(($predios_rusticos / $total_predios) * 100, 2) }}%</td>
                    <td>{{ number_format(($predios_88 / $total_predios) * 100, 2) }}%</td>
                    <td>{{ number_format(($predios_99 / $total_predios) * 100, 2) }}%</td>
                    <td>{{ number_format((($predios - $predios_99 - $predios_88) / $total_predios) * 100, 2) }}%</td>
                </tr>
                <tr>
                    <td colspan="6">
                        <div class="bg-gray-50 p-1 text-center"><span class="text-sm font-medium text-gray-600">Valores catastrales</span></div>
                    </td>
                </tr>
                <tr class="text-sm font-medium text-gray-600 bg-white text-center">
                    <td>${{ number_format($valor_urbanos + $valor_rusticos) }}</td>
                    <td>${{ number_format($valor_urbanos, 2) }}</td>
                    <td>${{ number_format($valor_rusticos, 2) }}</td>
                    <td>-</td>
                    <td>-</td>
                    <td>-</td>
                </tr>

            </tbody>

        </table>

    </div> --}}

    <x-dialog-modal wire:model.live="modal">

        <x-slot name="title">

            Permisos asignados al usuario

        </x-slot>

        <x-slot name="content">

            @if($permisos)

                <div class="flex flex-col md:flex-row justify-between md:space-x-3 mb-5">

                    <div class="flex-auto ">

                        <div class="overflow-y-auto">

                            @foreach($permisos as $nombre => $area)

                                <p class="my-2 text-md text-black">Área de {{ $nombre }}:</p>

                                <div class="mb-2 flex flex-wrap gap-2">

                                    @foreach ($area as $permission)

                                        <label class="border border-gray-40000 text-gray-500 px-2 rounded-full py-1 text-xs flex items-center">

                                            <p class="">{{ $permission['name'] }}</p>

                                        </label>

                                    @endforeach

                                </div>

                                <hr>

                            @endforeach

                        </div>

                    </div>

                </div>

            @endif

        </x-slot>

        <x-slot name="footer">

            <div class="float-righ">

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
