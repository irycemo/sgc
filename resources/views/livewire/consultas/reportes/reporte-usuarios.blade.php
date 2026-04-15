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

        <x-input-group for="rol" label="Rol" :error="$errors->first('rol')" class="w-full">

            <x-input-select id="rol" wire:model.live="rol">

                <option value="">Seleccione una opción</option>

                @foreach ($roles as $role)

                    <option value="{{ $role->name }}">{{ $role->name }}</option>

                @endforeach

            </x-input-select>

        </x-input-group>

        <x-input-group for="permiso" label="Permiso" :error="$errors->first('permiso')" class="w-full">

            <x-input-select id="permiso" wire:model.live="permiso">

                <option value="">Seleccione una opción</option>

                @foreach ($permisos as $permiso)

                    <option value="{{ $permiso->name }}">{{ $permiso->name }}</option>

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

        @if(count($this->usuarios))

            <div class="rounded-lg shadow-xl mb-5 p-4 font-thin md:flex items-center justify-between bg-white">

                <p class="text-xl font-extralight">Se encontraron: {{ number_format($this->usuarios->total()) }} registros con los filtros seleccionados.</p>

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

                        <x-table.heading>Clave</x-table.heading>
                        <x-table.heading>Nombre</x-table.heading>
                        <x-table.heading>Correo</x-table.heading>
                        <x-table.heading>Estado</x-table.heading>
                        <x-table.heading>Rol</x-table.heading>
                        <x-table.heading>Área</x-table.heading>
                        <x-table.heading>Oficina</x-table.heading>
                        <x-table.heading>Valuador</x-table.heading>
                        <x-table.heading>Registro</x-table.heading>

                    </x-slot>

                    <x-slot name="body">

                        @forelse ($this->usuarios as $usuario)

                            <x-table.row wire:loading.class.delaylongest="opacity-50" wire:key="row-{{ $usuario->id }}">

                                <x-table.cell title="Clave">

                                    {{ $usuario->clave }}

                                </x-table.cell>

                                <x-table.cell title="Nombre">

                                    {{ $usuario->name }}

                                </x-table.cell>

                                <x-table.cell title="Correo">

                                    {{ $usuario->email }}

                                </x-table.cell>

                                <x-table.cell title="Estado">

                                    @if($usuario->estado == 'activo')

                                        <span class="bg-green-400 py-1 px-2 rounded-full text-white text-xs">{{ ucfirst($usuario->estado) }}</span>

                                    @else

                                        <span class="bg-red-400 py-1 px-2 rounded-full text-white text-xs">{{ ucfirst($usuario->estado) }}</span>

                                    @endif

                                </x-table.cell>

                                <x-table.cell title="Rol">

                                    {{ $usuario->getRoleNames()->first() }}

                                </x-table.cell>

                                <x-table.cell title="Área">

                                    {{ $usuario->area }}

                                </x-table.cell>

                                <x-table.cell title="Oficina">

                                    {{ $usuario->oficina->nombre }}

                                </x-table.cell>

                                <x-table.cell title="Valuador">

                                    {{ $usuario->valuador ? 'Si' : ' No' }}

                                </x-table.cell>

                                <x-table.cell title="Registrado">

                                    {{ $usuario->created_at }}

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

                                {{ $this->usuarios->links()}}

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
