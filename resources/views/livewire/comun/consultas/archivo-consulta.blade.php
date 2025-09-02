<div>

    <h4 class="text-2xl tracking-widest py-1 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-thin mb-6  bg-white">Archivo</h4>

    @if(!$this->predio->archivos->where('descripcion', 'archivo')->first())

        <div class="bg-white p-4 rounded-lg w-full shadow-lg mb-5 text-sm text-gray-500" wire:loading.class.delaylongest="opacity-50">

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

        <div class="bg-white p-4 rounded-lg w-full shadow-lg mb-5 text-sm text-gray-500" wire:loading.class.delaylongest="opacity-50">

            <table class="w-full overflow-x-auto table-fixed">

                <thead class="border-b border-gray-300 ">

                    <tr class="text-sm text-gray-500 text-left traling-wider whitespace-nowrap">

                        <th class="px-2">Tipo</th>
                        <th class="px-2">Ver archivo</th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-gray-200">

                    <tr class="text-gray-500 text-sm leading-relaxed">
                        <td class=" px-2 w-full capitalize">Archivo</td>
                        <td class="px-2 w-full">

                            @if(app()->isProduction())

                                <a href="{{ Storage::disk('s3')->temporaryUrl(config('services.ses.ruta_predios') . $predio->archivos->where('descripcion', 'archivo')->first()->url, now()->addMinutes(10)) }}" class="text-blue-300 cursor-pointer" target="_blank">

                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>

                                </a>

                            @else

                                <a href="{{ Storage::disk('predios_archivo')->url($this->predio->archivos->where('descripcion', 'archivo')->first()->url) }}" class="text-blue-300 cursor-pointer" target="_blank">

                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                    </svg>

                                </a>

                            @endif

                        </td>
                    </tr>

                    @foreach ($this->predio->fotos() as $foto)

                        <tr class="text-gray-500 text-sm leading-relaxed">
                            <td class=" px-2 w-full capitalize">{{ $foto->descripcion }}</td>
                            <td class="px-2 w-full">
                                @if(app()->isProduction())

                                    <a href="{{ Storage::disk('s3')->temporaryUrl(config('services.ses.ruta_predios') . $foto->url, now()->addMinutes(10)) }}" class="text-blue-300 cursor-pointer" target="_blank">

                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>

                                    </a>

                                @else

                                    <a href="{{ Storage::disk('predios_fotos')->url($foto->url) }}" class="text-blue-300 cursor-pointer" target="_blank">

                                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-6">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                                        </svg>

                                    </a>

                                @endif
                            </td>
                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    @endif

</div>
