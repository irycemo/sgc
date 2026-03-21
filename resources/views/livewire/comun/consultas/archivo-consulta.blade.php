<div>

    <x-h4>Archivo</x-h4>

    @if(!$archivos_anteriores && $this->predio->files->count() == 0)

        <div class="bg-white p-4 rounded-lg w-full shadow-lg mb-5 text-sm text-gray-500 overflow-auto" wire:loading.class.delaylongest="opacity-50">

            <table class="w-full overflow-x-auto table-fixed">

                <thead class="border-b border-gray-300 ">

                    <tr class="text-sm text-gray-500 text-left traling-wider whitespace-nowrap">

                        <th class="px-2">Tipo</th>
                        <th class="px-2">Ver archivo</th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-gray-200">

                    @foreach ($archivos as $key => $item)

                        @foreach ($item as $link)

                            <tr class="text-gray-500 text-sm leading-relaxed">
                                <td class=" px-2 w-full capitalize">{{ $key }}</td>
                                <td class="px-2 w-full">
                                    <a href="{{ $link['url'] }}" class="text-blue-300 cursor-pointer" target="_blank">

                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>

                                    </a>
                                </td>
                            </tr>

                        @endforeach

                    @endforeach

                </tbody>

            </table>

        </div>

    @else

        <div class="bg-white p-4 rounded-lg w-full shadow-lg mb-5 text-sm text-gray-500 overflow-auto" wire:loading.class.delaylongest="opacity-50">

            <table class="w-full table table-auto">

                <thead class="border-b border-gray-300 ">

                    <tr class="text-sm text-gray-500 text-left traling-wider whitespace-nowrap">

                        <th class="px-2">Descripción</th>
                        <th class="px-2">Registro</th>
                        <th class="px-2">Link</th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-gray-200">

                    @foreach ($this->predio->archivos() as $archivo)

                        <tr class="text-gray-500 text-sm leading-relaxed">
                            <td class=" px-2  capitalize">{{ Str::ucfirst($archivo->descripcion) }}</td>
                            <td class=" px-2  capitalize">{{ $archivo->created_at }}</td>
                            <td class="px-2 flex gap-4">

                                <a href="{{ $archivo->getLinkArchivo() }}" class="text-blue-300 cursor-pointer" target="_blank">

                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>

                                </a>

                                @if($flag_borrar)

                                    <x-button-red
                                    wire:confirm="¿Esta seguro que quiere borrar el archivo?"
                                    wire:click="borrarArchivo({{ $archivo->id }})"
                                    wire:loading.attr="disabled"
                                    wire:target="borrarArchivo({{ $archivo->id }})">

                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 0 1-2.244 2.077H8.084a2.25 2.25 0 0 1-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 0 1 3.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 0 0-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 0 0-7.5 0" />
                                        </svg>

                                    </x-button-red>

                                @endif

                            </td>
                        </tr>

                    @endforeach


                    @foreach ($this->predio->fotos() as $foto)

                        <tr class="text-gray-500 text-sm leading-relaxed">
                            <td class=" px-2  capitalize">{{ $foto->descripcion }}</td>
                            <td class=" px-2  capitalize">{{ $foto->created_at }}</td>
                            <td class="px-2">
                                <a href="{{ $foto->getLinkFoto() }}" class="text-blue-300 cursor-pointer" target="_blank">

                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>

                                </a>
                            </td>
                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    @endif

</div>
