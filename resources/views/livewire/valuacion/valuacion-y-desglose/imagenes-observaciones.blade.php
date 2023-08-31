<div class="p-4 max-h-full overflow-y-auto">

    @if(isset($predio->avaluo->folio))

        <div class=" mb-1 bg-white rounded-lg p-2 text-right">

            <span class="bg-blue-400 text-white text-sm rounded-full px-2 py-1">Folio de avaluo: {{ $predio->avaluo->folio }}</span>

        </div>

    @endif

    <div class="rounded-lg mb-1">

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-1 items-start  mx-auto">

            <div class="bg-white rounded-lg p-1 px-4 flex flex-col text-center">

                <p>Encabezado</p>

                @if($encabezado)

                    <img class="h-20 w-20 mx-auto my-3" src="{{ $encabezado->temporaryUrl() }}" alt="">

                @else

                    @if($predio)

                        <img class="h-20 w-20 mx-auto my-3" src="{{ $predio->avaluo->encabezado() }}" alt="">

                    @else

                        <img class="h-20 w-20 mx-auto my-3" src="{{ asset('storage/img/escudo_guinda.png') }}" alt="">

                    @endif

                @endif

                <label for="encabezado" class="bg-gray-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded-full text-sm mb-2 hover:bg-gray-700 cursor-pointer focus:outline-none">
                    <img wire:loading wire:target="encabezado" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">
                    Subir archivo
                </label>

                <input type="file" class="sr-only" id="encabezado" wire:model="encabezado">

                <div>

                    @error('encabezado') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                </div>

            </div>

            <div class="bg-white rounded-lg p-1 px-4 flex flex-col text-center">

                <p>Fachada</p>

                @if($fachada)

                    <img class="h-20 w-20 mx-auto my-3" src="{{ $fachada->temporaryUrl() }}" alt="">

                @else

                    @if($predio)

                        <img class="h-20 w-20 mx-auto my-3" src="{{ $predio->avaluo->fachada() }}" alt="">

                    @else

                        <img class="h-20 w-20 mx-auto my-3" src="{{ asset('storage/img/escudo_guinda.png') }}" alt="">

                    @endif

                @endif

                <label for="fachada" class="bg-gray-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded-full text-sm mb-2 hover:bg-gray-700 cursor-pointer focus:outline-none">
                    <img wire:loading wire:target="fachada" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">
                    Subir archivo
                </label>

                <input type="file" class="sr-only" id="fachada" wire:model="fachada">

                <div>

                    @error('fachada') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                </div>

            </div>

            <div class="bg-white rounded-lg p-1 px-4 flex flex-col text-center">

                <p>Fotografía 2</p>

                @if($foto2)

                    <img class="h-20 w-20 mx-auto my-3" src="{{ $foto2->temporaryUrl() }}" alt="">

                @else

                    @if($predio)

                        <img class="h-20 w-20 mx-auto my-3" src="{{ $predio->avaluo->foto2() }}" alt="">

                    @else

                        <img class="h-20 w-20 mx-auto my-3" src="{{ asset('storage/img/escudo_guinda.png') }}" alt="">

                    @endif

                @endif

                <label for="foto2" class="bg-gray-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded-full text-sm mb-2 hover:bg-gray-700 cursor-pointer focus:outline-none">
                    <img wire:loading wire:target="foto2" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">
                    Subir archivo
                </label>

                <input type="file" class="sr-only" id="foto2" wire:model="foto2">

                <div>

                    @error('foto2') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                </div>

            </div>

            <div class="bg-white rounded-lg p-1 px-4 flex flex-col text-center">

                <p>Fotografía 3</p>

                @if($foto3)

                    <img class="h-20 w-20 mx-auto my-3" src="{{ $foto3->temporaryUrl() }}" alt="">

                    @else

                @if($predio)

                        <img class="h-20 w-20 mx-auto my-3" src="{{ $predio->avaluo->foto3() }}" alt="">

                    @else

                        <img class="h-20 w-20 mx-auto my-3" src="{{ asset('storage/img/escudo_guinda.png') }}" alt="">

                    @endif

                @endif

                <label for="foto3" class="bg-gray-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded-full text-sm mb-2 hover:bg-gray-700 cursor-pointer focus:outline-none">
                    <img wire:loading wire:target="foto3" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">
                    Subir archivo
                </label>

                <input type="file" class="sr-only" id="foto3" wire:model="foto3">

                <div>

                    @error('foto3') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                </div>

            </div>

            <div class="bg-white rounded-lg p-1 px-4 flex flex-col text-center">

                <p>Fotografía 4</p>

                @if($foto4)

                    <img class="h-20 w-20 mx-auto my-3" src="{{ $foto4->temporaryUrl() }}" alt="">

                @else

                    @if($predio)

                        <img class="h-20 w-20 mx-auto my-3" src="{{ $predio->avaluo->foto4() }}" alt="">

                    @else

                        <img class="h-20 w-20 mx-auto my-3" src="{{ asset('storage/img/escudo_guinda.png') }}" alt="">

                    @endif

                @endif

                <label for="foto4" class="bg-gray-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded-full text-sm mb-2 hover:bg-gray-700 cursor-pointer focus:outline-none">
                    <img wire:loading wire:target="foto4" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">
                    Subir archivo
                </label>

                <input type="file" class="sr-only" id="foto4" wire:model="foto4">

                <div>

                    @error('foto4') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                </div>

            </div>

            <div class="bg-white rounded-lg p-1 px-4 flex flex-col text-center">

                <p>Macrolocalización</p>

                @if($macrolocalizacion)

                    <img class="h-20 w-20 mx-auto my-3" src="{{ $macrolocalizacion->temporaryUrl() }}" alt="">

                @else

                      @if($predio)

                        <img class="h-20 w-20 mx-auto my-3" src="{{ $predio->avaluo->macrolocalizacion() }}" alt="">

                    @else

                        <img class="h-20 w-20 mx-auto my-3" src="{{ asset('storage/img/escudo_guinda.png') }}" alt="">

                    @endif

                @endif

                <label for="macrolocalizacion" class="bg-gray-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded-full text-sm mb-2 hover:bg-gray-700 cursor-pointer focus:outline-none">
                    <img wire:loading wire:target="macrolocalizacion" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">
                    Subir archivo
                </label>

                <input type="file" class="sr-only" id="macrolocalizacion" wire:model="macrolocalizacion">

                <div>

                    @error('macrolocalizacion') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                </div>

            </div>

            <div class="bg-white rounded-lg p-1 px-4 flex flex-col text-center">

                <p>Microlocalización</p>

                @if($microlocalizacion)

                    <img class="h-20 w-20 mx-auto my-3" src="{{ $microlocalizacion->temporaryUrl() }}" alt="">

                @else

                    @if($predio)

                        <img class="h-20 w-20 mx-auto my-3" src="{{ $predio->avaluo->microlocalizacion() }}" alt="">

                    @else

                        <img class="h-20 w-20 mx-auto my-3" src="{{ asset('storage/img/escudo_guinda.png') }}" alt="">

                    @endif

                @endif

                <label for="microlocalizacion" class="bg-gray-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded-full text-sm mb-2 hover:bg-gray-700 cursor-pointer focus:outline-none">
                    <img wire:loading wire:target="microlocalizacion" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">
                    Subir archivo
                </label>

                <input type="file" class="sr-only" id="microlocalizacion" wire:model="microlocalizacion">

                <div>

                    @error('microlocalizacion') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                </div>

            </div>

            <div class="bg-white rounded-lg p-1 px-4 flex flex-col text-center">

                <p>Representación del poligono (Imagen)</p>

                @if($poligonoImagen)

                    <img class="h-20 w-20 mx-auto my-3" src="{{ $poligonoImagen->temporaryUrl() }}" alt="">

                @else

                    @if($predio)

                        <img class="h-20 w-20 mx-auto my-3" src="{{ $predio->avaluo->poligonoImagen() }}" alt="">

                    @else

                        <img class="h-20 w-20 mx-auto my-3" src="{{ asset('storage/img/escudo_guinda.png') }}" alt="">

                    @endif

                @endif

                <label for="poligonoImagen" class="bg-gray-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded-full text-sm mb-2 hover:bg-gray-700 cursor-pointer focus:outline-none">
                    <img wire:loading wire:target="poligonoImagen" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">
                    Subir archivo
                </label>

                <input type="file" class="sr-only" id="poligonoImagen" wire:model="poligonoImagen">

                <div>

                    @error('poligonoImagen') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                </div>

            </div>

            <div class="bg-white rounded-lg p-1 px-4 flex flex-col text-center">

                <p>Representación del poligono (DWG)</p>

                <label for="poligonoDwg" class="bg-gray-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded-full text-sm mb-2 hover:bg-gray-700 cursor-pointer focus:outline-none">
                    <img wire:loading wire:target="poligonoDwg" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">
                    Subir archivo
                </label>

                <input type="file" class="sr-only" id="poligonoDwg" wire:model="poligonoDwg">

                <div>

                    @error('poligonoDwg') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                </div>

            </div>

        </div>

    </div>

    <div class="bg-white rounded-lg p-1 flex justify-end mb-2">

        <div class="  mx-auto lg:w-1/2">

            <div>

                <h4 class="text-lg mb-1 text-center">Observaciones</h4>

            </div>

            <textarea class="bg-white rounded text-xs w-full @error('predio.avaluo.observaciones') border-1 border-red-500 @enderror" rows="4" wire:model.defer="predio.avaluo.observaciones"></textarea>

            <div>

                @error('predio.avaluo.observaciones') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

            </div>

        </div>

    </div>

    <div class="bg-white rounded-lg p-1 flex justify-end">

        @if(count($errors) > 0)

            <span class="bg-red-400 hover:shadow-lg text-white text-xs md:text-sm px-3 py-1 ml-auto rounded-full  hover:bg-red-700 flex items-center justify-center focus:outline-none ">
                Campos incorrectos
                @error('predio') <span class="error text-sm text-white">{{ $message }}</span> @enderror
            </span>

        @endif

        @if($predio)

            <button
                wire:click="actualizar"
                wire:loading.attr="disabled"
                wire:target="actualizar"
                class=" bg-green-400 hover:shadow-lg text-white text-xs md:text-sm px-3 py-1 ml-auto rounded-full  hover:bg-green-700 flex items-center justify-center focus:outline-none "
            >

                <img wire:loading wire:target="actualizar" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                Guardar

            </button>

        @endif

    </div>

</div>
