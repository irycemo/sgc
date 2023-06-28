<div class="">

    <div class="mb-6">

        <h1 class="text-3xl tracking-widest py-3 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-thin mb-6  bg-white">Asignación de cuentas prediales</h1>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

        <div class="p-4 flex-auto bg-white rounded-lg mb-3 shadow-md space-y-3">

            <div class="flex justify-center space-x-2 mb-6">

                <input placeholder="Localidad" type="number" class="bg-white rounded text-xs w-20 @error('localidad') border-1 border-red-500 @enderror" wire:model.lazy="localidad">

                <input placeholder="Oficina" type="number" class="bg-white rounded text-xs w-20 @error('oficina') border-1 border-red-500 @enderror" wire:model.defer="oficina" @if(auth()->user()->oficina != 101) readonly @endif>

                <input placeholder="Tipo" type="number" class="bg-white rounded text-xs w-20 @error('tipo') border-1 border-red-500 @enderror" wire:model.defer="tipo">

                <select class="bg-white rounded text-xs @error('valuador') border-1 border-red-500 @enderror" wire:model.defer="valuador">

                    <option value="" selected>Seleccione un valuador</option>

                    @foreach ($valuadores as $item)

                        <option value="{{ $item->id }}">{{ $item->ap_paterno }} {{ $item->ap_materno }} {{ $item->name }}</option>

                    @endforeach

                </select>

            </div>

            <div class="flex-row flex">

                <div class="flex-auto ">

                    <div>

                        <label class="text-sm" >Título de propiedad</label>

                    </div>

                    <div>

                        <input type="text" class="bg-white rounded text-xs" wire:model.defer="titulo">

                    </div>

                    <div>

                        @error('titulo') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                    </div>

                </div>

                <div class="flex-auto ">

                    <div>

                        <label class="text-sm" >Cantidad solicitada</label>

                    </div>

                    <div>

                        <input type="text" class="bg-white rounded text-xs" wire:model.defer="cantidad">

                    </div>

                    <div>

                        @error('cantidad') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                    </div>

                </div>

                <div class="flex-auto ">

                    <div>

                        <label class="text-sm" >Predio de origen</label>

                    </div>

                    <div>

                        <input type="text" class="bg-white rounded text-xs" wire:model.defer="origen">

                    </div>

                    <div>

                        @error('origen') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                    </div>

                </div>
            </div>

            <div class="flex-auto ">

                <div>

                    <label class="text-sm" >Observaciones</label>

                </div>

                <div>

                    <select class="bg-white rounded text-xs w-full mb-1" wire:model="observaciones">
                        <option value="" selected> Seleccione una opción</option>
                        <option value="AVALUO PARA EFECTOS DE ACTULIZACION DE VALOR CATASTRAL POR SUBDIVICION AUTORIZADA POR LA SUOP OFICIO SUOP-DOU-RU-XXXXX  DE FECHA XX/XX/XXXX">
                            AVALUO PARA EFECTOS DE ACTULIZACION DE VALOR CATASTRAL POR SUBDIVICION AUTORIZADA POR LA SUOP OFICIO SUOP-DOU-RU-XXXXX  DE FECHA XX/XX/XXXX
                        </option>
                        <option value="SURGE POR SUB-DIVISION AUTORIZADO POR EL MUNICIPIO EN OFICIO XXXX/XXXX, DE FECHA XX DE XXXXXXX DEL XXXX">
                            SURGE POR SUB-DIVISION AUTORIZADO POR EL MUNICIPIO EN OFICIO XXXX/XXXX, DE FECHA XX DE XXXXXXX DEL XXXX
                        </option>
                        <option value="SE ASIGNA CUENTA PREDIAL POR DESGLOSE AUTORIZADO POR EL MPIO MEDIANTE OFICIO SUOP/DOU/FRACC/2039/2019 DE FECHA XX DE XXXXXX DE XXXX">
                            SE ASIGNA CUENTA PREDIAL POR DESGLOSE AUTORIZADO POR EL MPIO MEDIANTE OFICIO SUOP/DOU/FRACC/2039/2019 DE FECHA XX DE XXXXXX DE XXXX
                        </option>
                        <option value="SE ASIGNA CUENTA PREDIAL POR CAMBIO DE LOCALIDAD PASA DE XXXXXXX CON CUENTA X-XXX-X-XXXX     A       XXXXXXXXX">
                            SE ASIGNA CUENTA PREDIAL POR CAMBIO DE LOCALIDAD PASA DE XXXXXXX CON CUENTA X-XXX-X-XXXX     A       XXXXXXXXX
                        </option>
                        <option value="SE ASIGNA CUENTA PREDIAL POR ALTA EN EL RAN DEL TITULO NO. xxxxxxx QUE AMPARA EL SOLAR LOTE xxx MZNA xxxx ZONA x ubicado en POBLADO CON SUPERFICIE xxxxxxxxxxxx A NOMBRE DE xxxxxxxxxxxxxxxx">
                            SE ASIGNA CUENTA PREDIAL POR ALTA EN EL RAN DEL TITULO NO. xxxxxxx QUE AMPARA EL SOLAR LOTE xxx MZNA xxxx ZONA x ubicado en POBLADO CON SUPERFICIE xxxxxxxxxxxx A NOMBRE DE xxxxxxxxxxxxxxxx
                        </option>
                    </select>

                    <textarea rows="5" wire:model.defer="observaciones" class="bg-white rounded text-xs w-full"></textarea>

                </div>

                <div>

                    @error('observaciones') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                </div>

            </div>

            <button wire:click="crearCuentas" class="bg-gray-500 hover:shadow-lg hover:bg-gray-700 float-right text-sm py-2 px-4 text-white rounded-full focus:outline-none hidden md:block">
                <img wire:loading wire:target="crearCuentas" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">
                Crear cuentas
            </button>

        </div>

        <div class="p-4 flex-auto bg-white rounded-lg mb-3 shadow-md space-y-3">

            <h4 class="text-lg mb-5 text-center">Busqueda de cuentas prediales asignadas</h4>

            <div class="flex flex-wrap space-x-1 justify-center items-center">

                <input placeholder="Localidad" type="number" class="bg-white rounded text-xs w-20 @error('localidad_busqueda') border-1 border-red-500 @enderror" wire:model.lazy="localidad_busqueda">

                <input placeholder="Oficina" type="number" class="bg-white rounded text-xs w-20 @error('oficina_busqueda') border-1 border-red-500 @enderror" wire:model.defer="oficina_busqueda" @if(auth()->user()->oficina != 101) readonly @endif>

                <input placeholder="Tipo" type="number" class="bg-white rounded text-xs w-16 @error('tipo_busqueda') border-1 border-red-500 @enderror" wire:model.defer="tipo_busqueda">

                <input placeholder="Registro inicial" type="number" class="bg-white rounded text-xs @error('registro_inicio') border-1 border-red-500 @enderror" wire:model.defer="registro_inicio">
                <p class="text-sm mb-0">a</p>
                <input placeholder="Registro final" type="number" class="bg-white rounded text-xs @error('registro_final') border-1 border-red-500 @enderror" wire:model.defer="registro_final">

            </div>

            <button wire:click="buscarCuentas" class="bg-gray-500 hover:shadow-lg hover:bg-gray-700 mx-auto text-sm py-2 px-4 text-white rounded-full focus:outline-none hidden md:block">
                <img wire:loading wire:target="buscarCuentas" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">
                Buscar
            </button>

        </div>

    </div>

    @if($cuentasAsignadas)

        <div class="relative overflow-x-auto rounded-lg shadow-xl border-t-2 border-t-gray-500">

            <table class="rounded-lg w-full">

                <thead class="border-b border-gray-300 bg-gray-50">

                    <tr class="text-xs font-medium text-gray-500 uppercase text-left traling-wider">

                        <th class="px-3 py-3 hidden lg:table-cell">

                            Localidad

                        </th>

                        <th class="px-3 py-3 hidden lg:table-cell">

                            Oficina

                        </th>

                        <th class="px-3 py-3 hidden lg:table-cell">

                            Tipo de predio

                        </th>

                        <th class="px-3 py-3 hidden lg:table-cell">

                            Número de registro

                        </th>

                        <th class="px-3 py-3 hidden lg:table-cell">

                            Observaciones

                        </th>

                        <th class="px-3 py-3 hidden lg:table-cell">

                            Predio de origen

                        </th>

                        <th class="px-3 py-3 hidden lg:table-cell">

                            Título de propiedad

                        </th>

                        <th class="px-3 py-3 hidden lg:table-cell">

                            Valuador

                        </th>

                        <th class="px-3 py-3 hidden lg:table-cell">

                            Registro

                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-gray-200 flex-1 sm:flex-none">

                    @foreach($cuentasAsignadas as $cuenta)

                        <tr class="text-xs font-medium text-gray-500 bg-white flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0">

                            <td class="px-3 py-3 w-full lg:w-auto p-3 text-gray-800 text-center lg:text-left lg:border-0 border border-b block lg:table-cell relative lg:static">

                                <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Localidad</span>

                                {{ $cuenta->localidad }}

                            </td>

                            <td class="px-3 py-3 w-full lg:w-auto p-3 text-gray-800 text-center lg:text-left lg:border-0 border border-b block lg:table-cell relative lg:static">

                                <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Oficina</span>

                                {{ $cuenta->oficina }}

                            </td>

                            <td class="px-3 py-3 w-full lg:w-auto p-3 text-gray-800 text-center lg:text-left lg:border-0 border border-b block lg:table-cell relative lg:static">

                                <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Tipo de predio</span>

                                {{ $cuenta->tipo_predio }}

                            </td>

                            <td class="px-3 py-3 w-full lg:w-auto p-3 text-gray-800 text-center lg:text-left lg:border-0 border border-b block lg:table-cell relative lg:static">

                                <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Número de registro</span>

                                {{ $cuenta->numero_registro }}

                            </td>

                            <td class="px-3 py-3 w-full lg:w-auto p-3 text-gray-800 text-center lg:text-left lg:border-0 border border-b block lg:table-cell relative lg:static">

                                <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Observaciones</span>

                                {{ $cuenta->observaciones }}

                            </td>

                            <td class="px-3 py-3 w-full lg:w-auto p-3 text-gray-800 text-center lg:text-left lg:border-0 border border-b block lg:table-cell relative lg:static">

                                <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Predio origen</span>

                                {{ $cuenta->predio_origen  ?? 'N/A' }}

                            </td>

                            <td class="px-3 py-3 w-full lg:w-auto p-3 text-gray-800 text-center lg:text-left lg:border-0 border border-b block lg:table-cell relative lg:static">

                                <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Titulo de propiedad</span>

                                {{ $cuenta->titulo_propiedad ?? 'N/A' }}

                            </td>

                            <td class="px-3 py-3 w-full lg:w-auto p-3 text-gray-800 text-center lg:text-left lg:border-0 border border-b block lg:table-cell relative lg:static">

                                <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Valuador</span>

                                {{ $cuenta->valuadorAsignado->name }} {{ $cuenta->valuadorAsignado->ap_paterno }} {{ $cuenta->valuadorAsignado->ap_materno }}

                            </td>

                            <td class="px-3 py-3 w-full lg:w-auto p-3 text-gray-800 text-center lg:text-left lg:border-0 border border-b block lg:table-cell relative lg:static">

                                <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Registrado</span>

                                @if($cuenta->creadoPor != null)

                                    <span class="font-semibold">Registrado por: {{$cuenta->creadoPor->name}}</span> <br>

                                @endif

                                {{ $cuenta->created_at }}

                            </td>

                        </tr>

                    @endforeach

                </tbody>

                {{-- <tfoot class="border-gray-300 bg-gray-50">

                    <tr>

                        <td colspan="8" class="py-2 px-5">
                            {{ $cuentasAsignadas->links()}}
                        </td>

                    </tr>

                </tfoot> --}}

            </table>

            <div class="h-full w-full rounded-lg bg-gray-200 bg-opacity-75 absolute top-0 left-0" wire:loading.delay.longer>

                <img class="mx-auto h-16" src="{{ asset('storage/img/loading.svg') }}" alt="">

            </div>

        </div>

    @endif

</div>
