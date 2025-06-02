<div class="">

    <x-header>Ficha Técnica</x-header>

    <div class="space-y-2 mb-5 bg-white rounded-lg p-2 shadow-xl">

        <div class="md:w-1/2 lg:w-1/4 mx-auto items-center text-center">

            <div class="mb-5">

                <x-filepond wire:model.live="documento"  accept="['application/vnd.ms-excel', 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet', '.xlsx']"/>

            </div>

            <div>

                @error('documento') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

            </div>

            @if($documento)

                <button
                    class="bg-blue-400 hover:shadow-lg w-full justify-center text-white text-xs md:text-sm px-3 py-1 items-center rounded-full mr-2 hover:bg-blue-700 flex focus:outline-none"
                    wire:click="procesar"
                    wire:loading.attr="disabled"
                    wire:target="procesar">

                    <img wire:loading wire:target="procesar" class="h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                    Procesar
                </button>

            @else

                <button
                    class="bg-green-400 hover:shadow-lg w-full justify-center text-white text-xs md:text-sm px-3 py-1 items-center rounded-full mr-2 hover:bg-green-700 flex focus:outline-none"
                    wire:click="descargarFicha"
                    wire:loading.attr="disabled"
                    wire:target="descargarFicha">

                    <div wire:loading.flex wire:target="descargarFicha" class="flex absolute top-1 right-1 items-center">
                        <svg class="animate-spin h-5 w-5 text-blue-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                        </svg>
                    </div>

                    Descargar ficha técnica
                </button>

            @endif

        </div>

    </div>

    @if ($data != null)

        <div class="mb-6 shadow-xl">

            <h1 class="text-3xl tracking-widest py-3 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-thin mb-6  bg-white">Avaluos creados</h1>

        </div>

        <div class="relative overflow-x-auto rounded-lg border-t-2 border-t-gray-500 shadow-xl">

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

                    </tr>

                </thead>

                <tbody class="divide-y divide-gray-200 flex-1 sm:flex-none ">

                    @forelse($data as $avaluo)

                        <tr class="text-sm font-medium text-gray-500 bg-white flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0">

                            <td class="px-3 py-3 w-full lg:w-auto p-3 text-gray-800 text-center lg:text-left lg:border-0 border border-b block lg:table-cell relative lg:static">

                                <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Folio</span>

                                {{ $avaluo->año }}-{{ $avaluo->folio }}

                            </td>

                            <td class="px-3 py-3 w-full lg:w-auto p-3 text-gray-800 text-center lg:text-left lg:border-0 border border-b block lg:table-cell relative lg:static">

                                <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Cuenta predial</span>

                                {{ $avaluo->predioAvaluo->cuentaPredial() }}

                            </td>

                            <td class="px-3 py-3 w-full lg:w-auto p-3 text-gray-800 text-center lg:text-left lg:border-0 border border-b block lg:table-cell relative lg:static">

                                <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Clave catastral</span>

                                {{ $avaluo->predioAvaluo->claveCatastral() }}

                            </td>

                        </tr>

                    @empty

                    <div>NO</div>

                    @endforelse

                </tbody>

            </table>

            <div class="h-full w-full rounded-lg bg-gray-200 bg-opacity-75 absolute top-0 left-0" wire:loading.delay.longer>

                <img class="mx-auto h-16" src="{{ asset('storage/img/loading.svg') }}" alt="">

            </div>

        </div>

    @else

        <div class="space-y-2 mb-5 bg-white rounded-lg p-4 shadow-xl">

            <div class="space-y-2">

                <h4 class="text-xl font-semibold">Colindancias</h4>

                <p class="">Las colindancias deben tener la siguiente estrctura: <strong>VIENTO:LONGITUD:DESCRIPCION</strong>. Cada elemento separado por el carácter '<strong>:</strong>'. Debe usar el carácter '<strong>|</strong>' para separar colindancias.</p>

                <p class="">Valores permitidos para VIENTO:</p>

                <ul class="ml-10 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6">

                    @foreach ($vientos as $viento)

                        <li class="list-disc">{{ $viento }}</li>

                    @endforeach

                </ul>

                <p class="">Ejemplo para una colindancia: <strong>NORTE:100:Colinda 100 metros al norte</strong></p>

                <p class="">Ejemplo para más de una colindancia: <strong>NORTE:100:Colinda 100 metros al norte|SUR:50:Colinda 50 metros al sur|ESTE:10:colinda 10 metros al este</strong></p>

            </div>

        </div>

        <div class="space-y-2 mb-5 bg-white rounded-lg p-4 shadow-xl">

            <div class="space-y-2">

                <h4 class="text-xl font-semibold">Terrenos</h4>

                <p class="">Los terrenos deben tener la siguiente estrctura: <strong>SUPERFICIE:VALOR UNITARIO:VALOR DEMERITADO</strong>. Cada elemento separado por el carácter '<strong>:</strong>'. Debe usar el carácter '<strong>|</strong>' para separar terrenos.</p>

                <p class="">Si el predio es urbano ingresa el valor numérico del valor unitario, si es un predio rústico debe usar uno de los siguientes valores:</p>

                <ul class="ml-10 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6">

                    @foreach ($valoresRusticos as $valor)

                        <li class="list-disc">{{ $valor->concepto }}</li>

                    @endforeach

                </ul>

                <p class="">Ejemplo para un terreno urbano: <strong>100:250:30</strong></p>

                <p class="">Ejemplo para un terreno rústico: <strong>100:RIEGO POR GRAVEDAD:30</strong></p>

                <p class="">Ejemplo para más de un terreno urbano: <strong>100:250:30|200:50:10|50:30:10</strong></p>

                <p class="">Ejemplo para más de un terreno rústico: <strong>100:TEMPORAL DE SEGUNDA:30|200:ERIAZO:10|50:TEMPORAL DE PRIMERA:10</strong></p>

            </div>

        </div>

        <div class="space-y-2 mb-5 bg-white rounded-lg p-4 shadow-xl">

            <div class="space-y-2">

                <h4 class="text-xl font-semibold">Construcciones</h4>

                <p class="">Los construcciones deben tener la siguiente estrctura: <strong>REFERENCIA:TIPO:USO:CALIDAD:ESTADO:NIVELES:SUPERFICIE</strong>. Cada elemento separado por el carácter '<strong>:</strong>'. Debe usar el carácter '<strong>|</strong>' para separar construcciones.</p>

                <p class="">Valores permitidos para la clasificación de construcción <strong>(TIPO:USO:CALIDAD:ESTADO)</strong>:</p>

                <ul class="ml-10 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6">

                    @foreach ($valoresConstruccion as $valor)

                        <li class="list-disc">{{ $valor->tipo }}:{{ $valor->uso }}:{{ $valor->calidad }}:{{ $valor->estado }}</li>

                    @endforeach

                </ul>

                <p class="">Ejemplo para una construcción: <strong>A:1:1:1:1:2:50</strong></p>

                <p class="">Ejemplo para más de una construcción: <strong>A:1:1:1:1:2:50|B:1:1:1:2:3:20|B:1:1:1:3:2:30</strong></p>

            </div>

        </div>

        <div class="space-y-2 mb-5 bg-white rounded-lg p-4 shadow-xl">

            <div class="space-y-2">

                <h4 class="text-xl font-semibold">Terrenos de área común</h4>

                <p class="">Los terrenos de área común deben tener la siguiente estrctura: <strong>ÁREA COMÚN DE TERRENO:INDIVISO DE TERRENO:VALOR UNITARIO</strong>. Cada elemento separado por el carácter '<strong>:</strong>'. Debe usar el carácter '<strong>|</strong>' para separar terrenos de área común.</p>

                <p class="">Ejemplo para un terreno de área común: <strong>100:50:30</strong></p>

                <p class="">Ejemplo para más de un terreno de área común: <strong>100:60:30|200:20:10|50:20:10</strong></p>

            </div>

        </div>

        <div class="space-y-2 mb-5 bg-white rounded-lg p-4 shadow-xl">

            <div class="space-y-2">

                <h4 class="text-xl font-semibold">Construcciones de área común</h4>

                <p class="">Los construcciones de área común deben tener la siguiente estrctura: <strong>ÁREA COMÚN DE CONSTRUCCION:INDIVISO DE CONSTRUCCIÓN:TIPO:USO:CALIDAD:ESTADO:NIVELES</strong>. Cada elemento separado por el carácter '<strong>:</strong>'. Debe usar el carácter '<strong>|</strong>' para separar construcciones de área común.</p>

                <p class="">Valores permitidos para la clasificación de construcción <strong>(TIPO:USO:CALIDAD:ESTADO)</strong>:</p>

                <ul class="ml-10 grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6">

                    @foreach ($valoresConstruccion as $valor)

                        <li class="list-disc">{{ $valor->tipo }}:{{ $valor->uso }}:{{ $valor->calidad }}:{{ $valor->estado }}</li>

                    @endforeach

                </ul>

                <p class="">Ejemplo para una construcción de área común: <strong>50:10:1:1:1:1:3</strong></p>

                <p class="">Ejemplo para más de una construcción de área común: <strong>50:10:1:1:1:1:3|20:8:2:3:3:3:1|10:15:2:1:3:2:1</strong></p>

            </div>

        </div>

    </div>

    @endif

</div>
