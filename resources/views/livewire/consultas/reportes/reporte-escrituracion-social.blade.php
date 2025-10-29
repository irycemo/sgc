<div>

    <div class="md:flex md:flex-row flex-col justify-center md:space-x-4 items-end bg-white rounded-xl mb-5 p-4 shadow-xl">

        <x-input-group for="fecha1" label="Fecha inicial" :error="$errors->first('fecha1')">

            <x-input-text type="date" id="fecha1" wire:model.live="fecha1" />

        </x-input-group>

        <x-input-group for="fecha2" label="Fecha final" :error="$errors->first('fecha2')">

            <x-input-text type="date" id="fecha2" wire:model.live="fecha2" />

        </x-input-group>

    </div>

    <div class="md:flex flex-col md:flex-row justify-between md:space-x-3 items-center bg-white rounded-xl mb-5 p-4 shadow-xl">

        <x-input-group for="estado" label="Estado" :error="$errors->first('estado')" class="w-full">

            <x-input-select id="estado" wire:model.live="estado">

                <option value="">Seleccione una opción</option>
                <option value="nuevo">Nuevo</option>
                <option value="autorizado">Autorizado</option>
                <option value="pagado">Pagado</option>
                <option value="concluido">Concluido</option>
                <option value="expirado">Expirado</option>

            </x-input-select>

        </x-input-group>

        <x-input-group for="servicio" label="Servicio" :error="$errors->first('servicio')" class="w-full">

            <x-input-select id="servicio" wire:model.live="servicio">

                <option value="">Seleccione una opción</option>

                @foreach ($servicios as $servicio)

                    <option value="{{ $servicio->id }}">{{ $servicio->nombre }}</option>

                @endforeach

            </x-input-select>

        </x-input-group>

        <x-input-group for="dependencia" label="Dependencia" :error="$errors->first('dependencia')" class="w-full">

            <x-input-select id="dependencia" wire:model.live="dependencia">

                <option value="">Seleccione una opción</option>

                @foreach ($dependencias as $dependencia)

                    <option value="{{ $dependencia->nombre }}">{{ $dependencia->nombre }}</option>

                @endforeach

            </x-input-select>

        </x-input-group>

        <x-input-group for="usuario" label="Usuario" :error="$errors->first('usuario')" class="w-full">

            <x-input-select id="usuario" wire:model.live="usuario">

                <option value="">Seleccione una opción</option>

                @foreach ($usuarios as $item)

                    <option value="{{ $item->id }}">{{ $item->name }}</option>

                @endforeach

            </x-input-select>

        </x-input-group>

        <x-input-group for="oficina" label="Oficina" :error="$errors->first('oficina')" class="w-full">

            <x-input-select id="oficina" wire:model.live="oficina">

                <option value="">Seleccione una opción</option>

                @foreach ($oficinas as $item)

                    <option value="{{ $item->id }}">{{ $item->nombre }}</option>

                @endforeach

            </x-input-select>

        </x-input-group>

    </div>

    <div>

        @if(count($this->tramites))

            <div class="rounded-lg shadow-xl mb-5 p-4 font-thin md:flex items-center justify-between bg-white">

                <p class="text-xl font-extralight">Se encontraron: {{ number_format($this->tramites->total()) }} registros con los filtros seleccionados.</p>

                <x-button-green wire:click="descargarExcel()">

                    <img wire:loading wire:target="descargarExcel" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3M3 17V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z" />
                    </svg>

                    Exportar a Excel

                </x-button-green>

            </div>

            <div class="overflow-x-auto rounded-lg shadow-xl border-t-2 border-t-gray-500">

                <x-table>

                    <x-slot name="head">

                        <x-table.heading>Folio</x-table.heading>
                        <x-table.heading>Estado</x-table.heading>
                        <x-table.heading>Servicio</x-table.heading>
                        <x-table.heading>Solicitante</x-table.heading>
                        <x-table.heading>Número de oficio</x-table.heading>
                        <x-table.heading>Cantidad</x-table.heading>
                        <x-table.heading>Registro</x-table.heading>
                        <x-table.heading>Observaciones</x-table.heading>

                    </x-slot>

                    <x-slot name="body">

                        @forelse ($this->tramites as $tramite)

                            <x-table.row wire:loading.class.delaylongest="opacity-50" wire:key="row-{{ $tramite->id }}">

                                <x-table.cell>

                                    <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Año</span>

                                    {{ $tramite->año }}-{{ $tramite->folio }}-{{ $tramite->usuario }}

                                </x-table.cell>

                                <x-table.cell>

                                    <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Estado</span>

                                    <span class="bg-{{ $tramite->estado_color }} py-1 px-2 rounded-full text-white text-xs">{{ ucfirst($tramite->estado) }}</span>

                                </x-table.cell>

                                <x-table.cell>

                                    <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Servicio</span>

                                    <p class="mt-2">{{ $tramite->servicio->nombre }}</p>

                                </x-table.cell>

                                <x-table.cell>

                                    <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Nombre del solicitante</span>

                                    <p class="mt-2">{{ $tramite->nombre_solicitante }}</p>

                                </x-table.cell>

                                <x-table.cell>

                                    <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Número de oficio</span>

                                    {{ $tramite->numero_oficio ?? 'N/A' }}

                                </x-table.cell>

                                <x-table.cell>

                                    <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Cantidad</span>

                                    {{ $tramite->cantidad }}

                                </x-table.cell>

                                <x-table.cell>

                                    <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Registrado</span>

                                    {{ $tramite->created_at }}

                                </x-table.cell>

                                <x-table.cell>

                                    <span class="lg:hidden absolute top-0 left-0 bg-blue-300 px-2 text-[10px] text-white font-bold uppercase rounded-br-xl">Observaciones</span>

                                    <p class="mt-2">{{ $tramite->observaciones ?? 'N/A' }}</p>

                                </x-table.cell>

                            </x-table.row>

                        @empty

                            <x-table.row>

                                <x-table.cell colspan="15">

                                    <div class="bg-white text-gray-500 text-center p-5 rounded-full text-lg">

                                        No hay resultados.

                                    </div>

                                </x-table.cell>

                            </x-table.row>

                        @endforelse

                    </x-slot>

                    <x-slot name="tfoot">

                        <x-table.row>

                            <x-table.cell colspan="15" class="bg-gray-50">

                                {{ $this->tramites->links()}}

                            </x-table.cell>

                        </x-table.row>

                    </x-slot>

                </x-table>

            </div>

        @else

            <div class="border-b border-gray-300 bg-white text-gray-500 text-center p-5 rounded-full text-lg">

                No hay resultados.

            </div>

        @endif

    </div>

</div>
