<div class="">

    <div class="mb-6">

        <h1 class="text-3xl tracking-widest py-3 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-thin mb-6  bg-white">Servicios</h1>

        <div class="flex justify-between">

            <div>

                <input type="text" wire:model.debounce.500ms="search" placeholder="Buscar" class="bg-white rounded-full text-sm">

                <select class="bg-white rounded-full text-sm" wire:model="pagination">

                    <option value="10">10</option>
                    <option value="25">25</option>
                    <option value="50">50</option>
                    <option value="100">100</option>

                </select>

            </div>

            @can('Crear servicio')

                <button wire:click="abrirModalCrear" class="bg-gray-500 hover:shadow-lg hover:bg-gray-700 float-right text-sm py-2 px-4 text-white rounded-full focus:outline-none hidden md:block">
                    <img wire:loading wire:target="abrirModalCrear" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">
                    Agregar nuevo servicio
                </button>

                <button wire:click="abrirModalCrear" class="bg-gray-500 hover:shadow-lg hover:bg-gray-700 float-right text-sm py-2 px-4 text-white rounded-full focus:outline-none md:hidden">+</button>

            @endcan

        </div>

    </div>

    @if($servicios->count())

        <div class="relative overflow-x-auto rounded-lg shadow-xl border-t-2 border-t-gray-500">

            <table class="rounded-lg w-full">

                <thead class="border-b border-gray-300 bg-gray-50">

                    <tr class="text-xs font-medium text-gray-500 uppercase text-left traling-wider">

                        <th wire:click="order('name')" class="cursor-pointer px-3 py-3 hidden lg:table-cell">

                            Nombre

                            @if($sort == 'name')

                                @if($direction == 'asc')

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 float-right" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4" />
                                    </svg>

                                @else

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 float-right" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12" />
                                    </svg>

                                @endif

                            @else

                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 float-right" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                </svg>

                            @endif

                        </th>

                        <th wire:click="order('estado')" class="cursor-pointer px-3 py-3 hidden lg:table-cell">

                            Estado

                            @if($sort == 'estado')

                                @if($direction == 'asc')

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 float-right" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4" />
                                    </svg>

                                @else

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 float-right" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12" />
                                    </svg>

                                @endif

                            @else

                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 float-right" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                </svg>

                            @endif

                        </th>

                        <th wire:click="order('tipo')" class="cursor-pointer px-3 py-3 hidden lg:table-cell">

                            Tipo

                            @if($sort == 'tipo')

                                @if($direction == 'asc')

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 float-right" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4" />
                                    </svg>

                                @else

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 float-right" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12" />
                                    </svg>

                                @endif

                            @else

                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 float-right" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                </svg>

                            @endif

                        </th>

                        <th wire:click="order('umas')" class="cursor-pointer px-3 py-3 hidden lg:table-cell">

                            UMAS

                            @if($sort == 'umas')

                                @if($direction == 'asc')

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 float-right" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4" />
                                    </svg>

                                @else

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 float-right" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12" />
                                    </svg>

                                @endif

                            @else

                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 float-right" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                </svg>

                            @endif

                        </th>

                        {{-- <th wire:click="order('operacion_principal')" class="cursor-pointer px-3 py-3 hidden lg:table-cell">

                            Opreación Principal

                            @if($sort == 'operacion_principal')

                                @if($direction == 'asc')

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 float-right" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4" />
                                    </svg>

                                @else

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 float-right" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12" />
                                    </svg>

                                @endif

                            @else

                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 float-right" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                </svg>

                            @endif

                        </th> --}}

                        <th wire:click="order('operacion_parcial')" class="cursor-pointer px-3 py-3 hidden lg:table-cell">

                            Opreación Parcial

                            @if($sort == 'operacion_parcial')

                                @if($direction == 'asc')

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 float-right" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4" />
                                    </svg>

                                @else

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 float-right" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12" />
                                    </svg>

                                @endif

                            @else

                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 float-right" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                </svg>

                            @endif

                        </th>

                        <th wire:click="order('ordinario')" class="cursor-pointer px-3 py-3 hidden lg:table-cell">

                            Ordinario

                            @if($sort == 'ordinario')

                                @if($direction == 'asc')

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 float-right" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4" />
                                    </svg>

                                @else

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 float-right" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12" />
                                    </svg>

                                @endif

                            @else

                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 float-right" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                </svg>

                            @endif

                        </th>

                        <th wire:click="order('urgente')" class="cursor-pointer px-3 py-3 hidden lg:table-cell">

                            Urgente

                            @if($sort == 'urgente')

                                @if($direction == 'asc')

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 float-right" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4" />
                                    </svg>

                                @else

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 float-right" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12" />
                                    </svg>

                                @endif

                            @else

                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 float-right" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                </svg>

                            @endif

                        </th>

                        <th wire:click="order('extra_urgente')" class="cursor-pointer px-3 py-3 hidden lg:table-cell">

                            Extra Urgente

                            @if($sort == 'extra_urgente')

                                @if($direction == 'asc')

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 float-right" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4" />
                                    </svg>

                                @else

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 float-right" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12" />
                                    </svg>

                                @endif

                            @else

                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 float-right" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                </svg>

                            @endif

                        </th>

                        <th wire:click="order('categoria_servicio_id')" class="cursor-pointer px-3 py-3 hidden lg:table-cell">

                            Categoría

                            @if($sort == 'categoria_servicio_id')

                                @if($direction == 'asc')

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 float-right" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4" />
                                    </svg>

                                @else

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 float-right" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12" />
                                    </svg>

                                @endif

                            @else

                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 float-right" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                </svg>

                            @endif

                        </th>

                        <th wire:click="order('created_at')" class="cursor-pointer px-3 py-3 hidden lg:table-cell">

                            Registro

                            @if($sort == 'created_at')

                                @if($direction == 'asc')

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 float-right" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4" />
                                    </svg>

                                @else

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 float-right" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12" />
                                    </svg>

                                @endif

                            @else

                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 float-right" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                </svg>

                            @endif

                        </th>

                        <th wire:click="order('updated_at')" class="cursor-pointer px-3 py-3 hidden lg:table-cell">

                            Actualizado

                            @if($sort == 'updated_at')

                                @if($direction == 'asc')

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 float-right" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h9m5-4v12m0 0l-4-4m4 4l4-4" />
                                    </svg>

                                @else

                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 float-right" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4h13M3 8h9m-9 4h6m4 0l4-4m0 0l4 4m-4-4v12" />
                                    </svg>

                                @endif

                            @else

                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 float-right" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4" />
                                </svg>

                            @endif

                        </th>

                        <th class="px-3 py-3 hidden lg:table-cell">Acciones</th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-gray-200 flex-1 sm:flex-none ">

                    @foreach($servicios as $servicio)

                        <tr class="text-sm font-medium text-gray-500 bg-white flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0">

                            <td class="px-3 py-3 w-full lg:w-auto p-3 text-gray-800 text-center lg:text-left lg:border-0 border border-b block lg:table-cell relative lg:static">

                                <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Nombre</span>

                                {{ $servicio->nombre }}

                            </td>

                            <td class="px-3 py-3 w-full lg:w-auto p-3 text-gray-800 text-center lg:text-left lg:border-0 border border-b block lg:table-cell relative lg:static">

                                <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Estado</span>

                                @if($servicio->estado == 'activo')

                                    <span class="bg-green-400 py-1 px-2 rounded-full text-white text-xs">{{ ucfirst($servicio->estado) }}</span>

                                @else

                                    <span class="bg-red-400 py-1 px-2 rounded-full text-white text-xs">{{ ucfirst($servicio->estado) }}</span>

                                @endif

                            </td>

                            <td class="px-3 py-3 w-full capitalize lg:w-auto p-3 text-gray-800 text-center lg:text-left lg:border-0 border border-b block lg:table-cell relative lg:static">

                                <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Tipo</span>

                                {{ $servicio->tipo }}

                            </td>

                            <td class="px-3 py-3 w-full lg:w-auto p-3 text-gray-800 text-center lg:text-left lg:border-0 border border-b block lg:table-cell relative lg:static">

                                <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Umas</span>

                                {{ $servicio->umas > 0 ?  $servicio->umas : 'N/A'}}

                            </td>

                            {{-- <td class="px-3 py-3 w-full lg:w-auto p-3 text-gray-800 text-center lg:text-left lg:border-0 border border-b block lg:table-cell relative lg:static">

                                <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Operación Principal</span>

                                {{ $servicio->operacion_principal }}

                            </td> --}}

                            <td class="px-3 py-3 w-full lg:w-auto p-3 text-gray-800 text-center lg:text-left lg:border-0 border border-b block lg:table-cell relative lg:static">

                                <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Operación Parcial</span>

                                {{ $servicio->operacion_parcial }}

                            </td>

                            <td class="px-3 py-3 w-full lg:w-auto capitalize p-3 text-gray-800 text-center lg:text-left lg:border-0 border border-b block lg:table-cell relative lg:static">

                                <span class="lg:hidden  absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Ordinario</span>

                                ${{ $servicio->ordinario }}

                            </td>

                            <td class="px-3 py-3 w-full lg:w-auto capitalize p-3 text-gray-800 text-center lg:text-left lg:border-0 border border-b block lg:table-cell relative lg:static">

                                <span class="lg:hidden  absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Urgente</span>

                                {{ $servicio->urgente > 0 ? '$' . $servicio->urgente : 'N/A'}}

                            </td>

                            <td class="px-3 py-3 w-full lg:w-auto p-3 text-gray-800 text-center lg:text-left lg:border-0 border border-b block lg:table-cell relative lg:static">

                                <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Extra Urgente</span>

                                {{ $servicio->extra_urgente > 0 ? '$' . $servicio->extra_urgente : 'N/A'}}

                            </td>

                            <td class="px-3 py-3 w-full lg:w-auto p-3 text-gray-800 text-center lg:text-left lg:border-0 border border-b block lg:table-cell relative lg:static">

                                <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Categoría</span>

                                {{ $servicio->categoria->nombre  }}

                            </td>

                            <td class="px-3 py-3 w-full lg:w-auto p-3 text-gray-800 text-center lg:text-left lg:border-0 border border-b block lg:table-cell relative lg:static">

                                <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Registrado</span>

                                @if($servicio->creadoPor != null)

                                    <span class="font-semibold">Registrado por: {{$servicio->creadoPor->name}}</span> <br>

                                @else

                                    <span class="font-semibold">Registrado:</span> <br>

                                @endif

                                {{ $servicio->created_at }}

                            </td>

                            <td class="px-3 py-3 w-full lg:w-auto p-3 text-gray-800 text-center lg:text-left lg:border-0 border border-b block lg:table-cell relative lg:static">

                                <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Actualizado</span>

                                @if($servicio->actualizadoPor != null)

                                    <span class="font-semibold">Actualizado por: {{$servicio->actualizadoPor->name}}</span> <br>

                                @else

                                    <span class="font-semibold">Actualizado:</span> <br>

                                @endif

                                {{ $servicio->updated_at }}

                            </td>

                            <td class="px-3 py-3 w-full lg:w-auto p-3 text-gray-800 text-center lg:text-left lg:border-0 border border-b lg:table-cell relative lg:static">

                                <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Acciones</span>

                                <div class="flex md:flex-col justify-center lg:justify-start md:space-y-1">

                                    @can('Editar servicio')

                                        <button
                                            wire:click="abrirModalEditar({{$servicio->id}})"
                                            wire:loading.attr="disabled"
                                            wire:target="abiriModalEditar({{$servicio->id}})"
                                            class="md:w-full bg-blue-400 hover:shadow-lg text-white text-xs md:text-sm px-3 py-1 rounded-full mr-2 hover:bg-blue-700 flex items-center justify-center focus:outline-none"
                                        >

                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4 mr-2">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                            </svg>

                                            Editar

                                        </button>

                                    @endcan

                                    @can('Borrar servicio')

                                        <button
                                            wire:click="abrirModalBorrar({{$servicio->id}})"
                                            wire:loading.attr="disabled"
                                            wire:target="abrirModalBorrar({{$servicio->id}})"
                                            class="md:w-full bg-red-400 hover:shadow-lg text-white text-xs md:text-sm px-3 py-1 items-center rounded-full hover:bg-red-700 flex justify-center focus:outline-none"
                                        >

                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4 mr-2">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>

                                            Eliminar

                                        </button>

                                    @endcan

                                </div>

                            </td>
                        </tr>

                    @endforeach

                </tbody>

                <tfoot class="border-gray-300 bg-gray-50">

                    <tr>

                        <td colspan="15" class="py-2 px-5">
                            {{ $servicios->links()}}
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

    <x-dialog-modal wire:model="modal">

        <x-slot name="title">

            @if($crear)
                Nuevo Servicio
            @elseif($editar)
                Editar Servicio
            @endif

        </x-slot>

        <x-slot name="content">

            <div class="relative p-1">

                <div class="flex flex-col md:flex-row justify-between md:space-x-3 mb-5">

                    <div class="flex-auto ">

                        <div>

                            <Label>Nombre</Label>
                        </div>

                        <div>

                            <input type="text" class="bg-white rounded text-sm w-full" wire:model.defer="modelo_editar.nombre">

                        </div>

                        <div>

                            @error('modelo_editar.nombre') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                        </div>

                    </div>

                </div>

                <div class="flex flex-col md:flex-row justify-between md:space-x-3 mb-5">

                    {{-- <div class="flex-auto ">

                        <div>

                            <Label>Operación principal</Label>
                        </div>

                        <div>

                            <input type="number" class="bg-white rounded text-sm w-full" wire:model.defer="modelo_editar.operacion_principal">

                        </div>

                        <div>

                            @error('modelo_editar.operacion_principal') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                        </div>

                    </div> --}}

                    <div class="flex-auto ">

                        <div>

                            <Label>Operación parcial</Label>
                        </div>

                        <div>

                            <input type="number" class="bg-white rounded text-sm w-full" wire:model.defer="modelo_editar.operacion_parcial">

                        </div>

                        <div>

                            @error('modelo_editar.operacion_parcial') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                        </div>

                    </div>

                    <div class="flex-auto ">

                        <div>

                            <Label>Estado</Label>

                        </div>

                        <div>

                            <select class="bg-white rounded text-sm w-full" wire:model.defer="modelo_editar.estado">

                                <option value="" selected>Seleccione una opción</option>
                                <option value="activo" selected>Activo</option>
                                <option value="inactivo" selected>Inactivo</option>

                            </select>

                        </div>

                        <div>

                            @error('modelo_editar.estado') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                        </div>

                    </div>

                </div>

                <div class="flex flex-col md:flex-row justify-between md:space-x-3 mb-5">

                    <div class="flex-auto mr-1 ">

                        <div>

                            <Label>Categoría</Label>

                        </div>

                        <div>

                            <select class="bg-white rounded text-sm w-full" wire:model.defer="modelo_editar.categoria_servicio_id">

                                <option value="">Seleccione una opción</option>

                                @foreach ($categorias as $categoria)


                                    <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>

                                @endforeach

                            </select>

                        </div>

                        <div>

                            @error('modelo_editar.categoria_servicio_id') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                        </div>

                    </div>

                    <div class="flex-auto ">

                        <div>

                            <Label>Tipo</Label>

                        </div>

                        <div>

                            <select class="bg-white rounded text-sm w-full" wire:model="modelo_editar.tipo">

                                <option value="" selected>Seleccione una opción</option>
                                <option value="fija" selected>Fija</option>
                                <option value="uma" selected>UMA</option>

                            </select>

                        </div>

                        <div>

                            @error('modelo_editar.tipo') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                        </div>

                    </div>

                    @if($this->modelo_editar->tipo == 'uma')

                        <div class="flex-auto">

                            <div>

                                <Label>UMAS</Label>

                            </div>

                            <div>

                                <input type="number" class="bg-white rounded text-sm w-full" wire:model.lazy="modelo_editar.umas">

                            </div>

                            <div>

                                @error('modelo_editar.umas') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                            </div>

                        </div>

                    @endif

                </div>

                <div class="flex flex-col md:flex-row justify-between md:space-x-3 mb-5">

                    <div class="flex-auto mb-5">

                        <div>

                            <Label>Ordinario</Label>
                        </div>

                        <div>

                            <input type="number" class="bg-white rounded text-sm w-full" wire:model.lazy="modelo_editar.ordinario">

                        </div>

                        <div>

                            @error('modelo_editar.ordinario') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                        </div>

                    </div>

                    <div class="flex-auto mb-5">

                        <div>

                            <Label>Urgente</Label>
                        </div>

                        <div>

                            <input type="number" class="bg-white rounded text-sm w-full" wire:model.defer="modelo_editar.urgente">

                        </div>

                        <div>

                            @error('modelo_editar.urgente') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                        </div>

                    </div>

                    <div class="flex-auto mb-5">

                        <div>

                            <Label>Extra Ordinario</Label>
                        </div>

                        <div>

                            <input type="number" class="bg-white rounded text-sm w-full" wire:model.defer="modelo_editar.extra_urgente">

                        </div>

                        <div>

                            @error('modelo_editar.extra_urgente') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                        </div>

                    </div>

                </div>

                <div class="h-full w-full rounded-lg bg-gray-200 bg-opacity-75 absolute top-1/2 left-1/2 transform -translate-x-1/2 -translate-y-1/2" wire:loading.delay.longer>

                    <img class="mx-auto h-16" src="{{ asset('storage/img/loading.svg') }}" alt="">

                </div>

            </div>

        </x-slot>

        <x-slot name="footer">

            <div class="float-righ">

                @if($crear)

                    <button
                        wire:click="crear"
                        wire:loading.attr="disabled"
                        wire:target="crear"
                        class="bg-blue-400 text-white hover:shadow-lg font-bold px-4 py-2 rounded-full text-sm mb-2 hover:bg-blue-700 flaot-left mr-1 focus:outline-none">

                        <img wire:loading wire:target="crear" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                        Guardar
                    </button>

                @elseif($editar)

                    <button
                        wire:click="actualizar"
                        wire:loading.attr="disabled"
                        wire:target="actualizar"
                        class="bg-blue-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded-full text-sm mb-2 hover:bg-blue-700 flaot-left mr-1 focus:outline-none">

                        <img wire:loading wire:target="actualizar" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                        Actualizar
                    </button>

                @endif

                <button
                    wire:click="resetearTodo"
                    wire:loading.attr="disabled"
                    wire:target="resetearTodo"
                    type="button"
                    class="bg-red-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded-full text-sm mb-2 hover:bg-red-700 flaot-left focus:outline-none">
                    Cerrar
                </button>

            </div>

        </x-slot>

    </x-dialog-modal>

    <x-confirmation-modal wire:model="modalBorrar">

        <x-slot name="title">
            Eliminar Servicio
        </x-slot>

        <x-slot name="content">
            ¿Esta seguro que desea eliminar al servicio? No sera posible recuperar la información.
        </x-slot>

        <x-slot name="footer">

            <x-secondary-button
                wire:click="$toggle('modalBorrar')"
                wire:loading.attr="disabled"
            >
                No
            </x-secondary-button>

            <x-danger-button
                class="ml-2"
                wire:click="borrar()"
                wire:loading.attr="disabled"
                wire:target="borrar"
            >
                Borrar
            </x-danger-button>

        </x-slot>

    </x-confirmation-modal>

</div>
