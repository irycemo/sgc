<div>

    <div class="">

        <div class="mb-6">

            <h1 class="text-3xl tracking-widest py-3 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-thin mb-6  bg-white">Trámites</h1>

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

            </div>

        </div>

        @if($tramites->count())

            <div class="relative overflow-x-auto rounded-lg shadow-xl border-t-2 border-t-gray-500">

                <table class="rounded-lg w-full">

                    <thead class="border-b border-gray-300 bg-gray-50">

                        <tr class="text-xs font-medium text-gray-500 uppercase text-left traling-wider">

                            <th wire:click="order('folio')" class="cursor-pointer px-3 py-3 hidden lg:table-cell">

                                Folio

                                @if($sort == 'folio')

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

                            <th wire:click="order('tipo_tramite')" class="cursor-pointer px-3 py-3 hidden lg:table-cell">

                                Tipo de trámite

                                @if($sort == 'tipo_tramite')

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

                            <th wire:click="order('servicio_id')" class="cursor-pointer px-3 py-3 hidden lg:table-cell">

                                Servicio

                                @if($sort == 'servicio_id')

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

                            <th wire:click="order('solicitante')" class="cursor-pointer px-3 py-3 hidden lg:table-cell">

                                Solicitante

                                @if($sort == 'solicitante')

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

                            <th wire:click="order('cantidad')" class="cursor-pointer px-3 py-3 hidden lg:table-cell">

                                Cantidad

                                @if($sort == 'cantidad')

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

                            <th wire:click="order('monto')" class="cursor-pointer px-3 py-3 hidden lg:table-cell">

                                Monto

                                @if($sort == 'monto')

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

                            <th wire:click="order('fecha_entrega')" class="cursor-pointer px-3 py-3 hidden lg:table-cell">

                                Fecha de entrega

                                @if($sort == 'fecha_entrega')

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

                            <th wire:click="order('fecha_pago')" class="cursor-pointer px-3 py-3 hidden lg:table-cell">

                                Fecha de pago

                                @if($sort == 'fecha_pago')

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

                            <th wire:click="order('fecha_vencimiento')" class="cursor-pointer px-3 py-3 hidden lg:table-cell">

                                Fecha de vencimiento

                                @if($sort == 'fecha_vencimiento')

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

                            <th wire:click="order('tipo_servicio')" class="cursor-pointer px-3 py-3 hidden lg:table-cell">

                                Tipo de servicio

                                @if($sort == 'tipo_servicio')

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

                        @foreach($tramites as $tramite)

                            <tr class="text-sm font-medium text-gray-500 bg-white flex lg:table-row flex-row lg:flex-row flex-wrap lg:flex-no-wrap mb-10 lg:mb-0">

                                <td class="px-3 py-3 w-full lg:w-auto p-3 text-gray-800 text-center lg:text-left lg:border-0 border border-b block lg:table-cell relative lg:static">

                                    <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Folio</span>

                                    {{ $tramite->folio }}

                                </td>

                                <td class="px-3 py-3 w-full lg:w-auto p-3 text-gray-800 text-center lg:border-0 border border-b block lg:table-cell relative lg:static">

                                    <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Estado</span>

                                    <span class="bg-{{ $tramite->estado_color }} py-1 px-2 rounded-full text-white text-xs">{{ ucfirst($tramite->estado) }}</span>

                                </td>

                                <td class="px-3 py-3 w-full capitalize lg:w-auto p-3 text-gray-800 text-center lg:text-left lg:border-0 border border-b block lg:table-cell relative lg:static">

                                    <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Tipo de trámite</span>

                                    {{ $tramite->tipo_tramite }}

                                </td>

                                <td class="px-3 py-3 w-full lg:w-auto p-3 text-gray-800 text-center lg:text-left lg:border-0 border border-b block lg:table-cell relative lg:static">

                                    <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Servicio</span>

                                    {{ $tramite->servicio->categoria->nombre }}

                                </td>

                                <td class="px-3 py-3 w-full lg:w-auto p-3 text-gray-800 text-center lg:text-left lg:border-0 border border-b block lg:table-cell relative lg:static">

                                    <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Solicitante</span>

                                    {{ $tramite->solicitante }}

                                </td>

                                <td class="px-3 py-3 w-full lg:w-auto p-3 text-gray-800 text-center lg:text-left lg:border-0 border border-b block lg:table-cell relative lg:static">

                                    <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Cantidad</span>

                                    {{ $tramite->cantidad }}

                                </td>

                                <td class="px-3 py-3 w-full lg:w-auto capitalize p-3 text-gray-800 text-center lg:text-left lg:border-0 border border-b block lg:table-cell relative lg:static">

                                    <span class="lg:hidden  absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Monto</span>

                                    ${{ number_format($tramite->monto, 2) }}

                                </td>

                                <td class="px-3 py-3 w-full lg:w-auto capitalize p-3 text-gray-800 text-center lg:text-left lg:border-0 border border-b block lg:table-cell relative lg:static">

                                    <span class="lg:hidden  absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Fecha de entrega</span>

                                    {{ $tramite->fecha_entrega?->format('d-m-Y') ?? 'N/A'}}

                                </td>

                                <td class="px-3 py-3 w-full lg:w-auto p-3 text-gray-800 text-center lg:text-left lg:border-0 border border-b block lg:table-cell relative lg:static">

                                    <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Fecha de pago</span>

                                    {{ $tramite->fecha_pago?->format('d-m-Y') ?? 'N/A'}}

                                </td>

                                <td class="px-3 py-3 w-full lg:w-auto p-3 text-gray-800 text-center lg:text-left lg:border-0 border border-b block lg:table-cell relative lg:static">

                                    <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Fecha de vencimiento</span>

                                    {{ $tramite->fecha_vencimiento?->format('d-m-Y') ?? 'N/A' }}

                                </td>

                                <td class="px-3 py-3 w-full lg:w-auto p-3 text-gray-800 text-center lg:text-left lg:border-0 border border-b block lg:table-cell relative lg:static">

                                    <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Tipo de servicio</span>

                                    {{ $tramite->tipo_servicio }}

                                </td>

                                <td class="px-3 py-3 w-full lg:w-auto p-3 text-gray-800 text-center lg:text-left lg:border-0 border border-b block lg:table-cell relative lg:static">

                                    <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Registrado</span>

                                    @if($tramite->creadoPor != null)

                                        <span class="font-semibold">Registrado por: {{$tramite->creadoPor->name}}</span> <br>

                                    @else

                                        <span class="font-semibold">Registrado:</span> <br>

                                    @endif

                                    {{ $tramite->created_at }}

                                </td>

                                <td class="px-3 py-3 w-full lg:w-auto p-3 text-gray-800 text-center lg:text-left lg:border-0 border border-b block lg:table-cell relative lg:static">

                                    <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Actualizado</span>

                                    @if($tramite->actualizadoPor != null)

                                        <span class="font-semibold">Actualizado por: {{$tramite->actualizadoPor->name}}</span> <br>

                                    @else

                                        <span class="font-semibold">Actualizado:</span> <br>

                                    @endif

                                    {{ $tramite->updated_at }}

                                </td>

                                <td class="px-3 py-3 w-full lg:w-auto p-3 text-gray-800 text-center lg:text-left lg:border-0 border border-b lg:table-cell relative lg:static">

                                    <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 py-1 text-xs text-white font-bold uppercase rounded-br-xl">Acciones</span>

                                    <div class="flex md:flex-col justify-center lg:justify-start md:space-y-1">

                                        @can('Editar servicio')

                                            <button
                                                wire:click="abrirModalEditar({{$tramite->id}})"
                                                wire:loading.attr="disabled"
                                                wire:target="abiriModalEditar({{$tramite->id}})"
                                                class="md:w-full bg-blue-400 hover:shadow-lg text-white text-xs md:text-sm px-3 py-1 rounded-full mr-2 hover:bg-blue-700 flex items-center justify-center focus:outline-none"
                                            >

                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4 mr-2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                                </svg>

                                                Editar

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
                                {{ $tramites->links()}}
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
                    Editar Trámite
            </x-slot>

            <x-slot name="content">

                <div class="relative p-1">

                    <div class="flex flex-col md:flex-row justify-between md:space-x-3 mb-5">

                        <div class="flex-auto ">

                            <div>

                                <Label class="text-base">Solicitante</Label>
                            </div>

                            <div>

                                <input type="text" class="bg-white rounded text-sm w-full" wire:model.defer="modelo_editar.solicitante">

                            </div>

                            <div>

                                @error('modelo_editar.solicitante') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                            </div>

                        </div>

                        <div class="flex-auto ">

                            <div>

                                <Label class="text-base">Estado</Label>
                            </div>

                            <div>

                                <select class="bg-white rounded text-sm w-full" wire:model.defer="modelo_editar.estado">

                                    <option value="" selected>Seleccione una opción</option>
                                    <option value="activo" selected>Activo</option>
                                    <option value="concluido" selected>Concluido</option>

                                </select>

                            </div>

                            <div>

                                @error('modelo_editar.estado') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                            </div>

                        </div>


                    </div>

                    @if($modelo_editar->predios->count())

                        <div class="flex flex-col md:flex-row justify-between md:space-x-3 mb-5">

                            <div class="flex-auto ">

                                <div>

                                    <Label class="text-base">Cuentas prediales involucradas</Label>

                                    <div class="flex-row lg:flex lg:space-x-2 items-start justify-between ">

                                        <div>

                                            <input placeholder="Localidad" type="number" class="bg-white rounded text-sm w-full" wire:model.defer="localidad">

                                            <div>

                                                @error('localidad') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                                            </div>


                                        </div>

                                        <div>

                                            <input placeholder="Oficina rentistica" type="number" class="bg-white rounded text-sm w-full" wire:model.defer="oficina" @if(auth()->user()->oficina != 101) readonly @endif>

                                            <div>

                                                @error('oficina') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                                            </div>

                                        </div>

                                        <div>

                                            <input placeholder="Tipo de predio" type="number" class="bg-white rounded text-sm w-full" wire:model.defer="tipo">

                                            <div>

                                                @error('tipo') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                                            </div>

                                        </div>

                                        <div>

                                            <input placeholder="Número de registro" type="number" class="bg-white rounded text-sm w-full" wire:model.defer="registro">

                                            <div>

                                                @error('registro') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                                            </div>

                                        </div>

                                        <button
                                            wire:click="buscarPredio"
                                            wire:loading.attr="disabled"
                                            wire:target="buscarPredio"
                                            type="button"
                                            class="bg-blue-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded text-sm hover:bg-blue-700 focus:outline-none flex items-center w-fit">
                                            <img wire:loading wire:target="buscarPredio" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">
                                            <p class="mr-1"> Buscar</p>
                                        </button>

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
                                                class="bg-green-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded text-sm hover:bg-green-700 focus:outline-none flex items-center w-fit">
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
                                                                <button
                                                                    wire:click="quitarPredio({{ $item['id'] }})"
                                                                    wire:loading.attr="disabled"
                                                                    wire:target="quitarPredio({{ $item['id'] }})"
                                                                    class="md:w-full bg-red-400 hover:shadow-lg text-white text-xs md:text-sm px-1 py-1 items-center rounded-full hover:bg-red-700 flex justify-center focus:outline-none"
                                                                >

                                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="w-4 h-4">
                                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                                    </svg>

                                                                </button>
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

                                <div>

                                    @error('predios') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                                </div>

                            </div>

                        </div>

                    @endif

                    <div class="flex flex-col md:flex-row justify-between md:space-x-3 mb-5">

                        <div class="flex-auto mr-1 ">

                            <div>

                                <Label class="text-base">Observaciones</Label>

                            </div>

                            <div>

                                <textarea rows="5" wire:model.lazy="modelo_editar.observaciones" class="bg-white rounded text-sm w-full" placeholder="Se lo mas especifico posible acerca de porque se genera el trámite."></textarea>

                            </div>

                            <div>

                                @error('modelo_editar.observaciones') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

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

                    <button
                        wire:click="actualizar"
                        wire:loading.attr="disabled"
                        wire:target="actualizar"
                        class="bg-blue-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded-full text-sm mb-2 hover:bg-blue-700 flaot-left mr-1 focus:outline-none">

                        <img wire:loading wire:target="actualizar" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                        Actualizar
                    </button>

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
