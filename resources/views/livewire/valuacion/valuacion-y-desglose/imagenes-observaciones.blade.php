<div class="p-4 mb-1 overflow-y-auto">

    @if(isset($predio->avaluo->folio))

        <div class="space-y-2 mb-5 bg-white rounded-lg p-2 text-right">

            <span class="bg-blue-400 text-white text-sm rounded-full px-2 py-1">Folio de avaluo: {{ $predio->avaluo->folio }}</span>

        </div>

    @endif

    @if($predio)

        <div class="space-y-2 mb-5  rounded-lg p-2">

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-3 items-start  mx-auto">

                <div class="bg-white rounded-lg p-4 flex flex-col">

                    <p>Encabezado</p>

                    @if($encabezado)

                        <img class="h-32 w-32 mx-auto my-3" src="{{ $encabezado->temporaryUrl() }}" alt="">

                    @else

                        <img class="h-32 w-32 mx-auto my-3" src="{{ $predio->avaluo->encabezado() }}" alt="">

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

                <div class="bg-white rounded-lg p-4 flex flex-col">

                    <p>Fachada</p>

                    @if($fachada)

                        <img class="h-32 w-32 mx-auto my-3" src="{{ $fachada->temporaryUrl() }}" alt="">

                    @else

                        <img class="h-32 w-32 mx-auto my-3" src="{{ $predio->avaluo->fachada() }}" alt="">

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

                <div class="bg-white rounded-lg p-4 flex flex-col">

                    <p>Fotografía 2</p>

                    @if($foto2)

                        <img class="h-32 w-32 mx-auto my-3" src="{{ $foto2->temporaryUrl() }}" alt="">

                    @else

                        <img class="h-32 w-32 mx-auto my-3" src="{{ $predio->avaluo->foto2() }}" alt="">

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

                <div class="bg-white rounded-lg p-4 flex flex-col">

                    <p>Fotografía 3</p>

                    @if($foto3)

                        <img class="h-32 w-32 mx-auto my-3" src="{{ $foto3->temporaryUrl() }}" alt="">

                    @else

                        <img class="h-32 w-32 mx-auto my-3" src="{{ $predio->avaluo->foto3() }}" alt="">

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

                <div class="bg-white rounded-lg p-4 flex flex-col">

                    <p>Fotografía 4</p>

                    @if($foto4)

                        <img class="h-32 w-32 mx-auto my-3" src="{{ $foto4->temporaryUrl() }}" alt="">

                    @else

                        <img class="h-32 w-32 mx-auto my-3" src="{{ $predio->avaluo->foto4() }}" alt="">

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

                <div class="bg-white rounded-lg p-4 flex flex-col">

                    <p>Macrolocalización</p>

                    @if($macrolocalizacion)

                        <img class="h-32 w-32 mx-auto my-3" src="{{ $macrolocalizacion->temporaryUrl() }}" alt="">

                    @else

                        <img class="h-32 w-32 mx-auto my-3" src="{{ $predio->avaluo->macrolocalizacion() }}" alt="">

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

                <div class="bg-white rounded-lg p-4 flex flex-col">

                    <p>Microlocalización</p>

                    @if($microlocalizacion)

                        <img class="h-32 w-32 mx-auto my-3" src="{{ $microlocalizacion->temporaryUrl() }}" alt="">

                    @else

                        <img class="h-32 w-32 mx-auto my-3" src="{{ $predio->avaluo->microlocalizacion() }}" alt="">

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

                <div class="bg-white rounded-lg p-4 flex flex-col">

                    <p>Representación del poligono (Imagen)</p>

                    @if($poligonoImagen)

                        <img class="h-32 w-32 mx-auto my-3" src="{{ $poligonoImagen->temporaryUrl() }}" alt="">

                    @else

                        <img class="h-32 w-32 mx-auto my-3" src="{{ $predio->avaluo->poligonoImagen() }}" alt="">

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

                <div class="bg-white rounded-lg p-4 flex flex-col">

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

    @endif

    <div class="bg-white rounded-lg p-3 flex justify-end mb-5">

        <div class="  mx-auto lg:w-1/2">

            <div>

                <h4 class="text-lg mb-5 text-center">Observaciones</h4>

            </div>

            <textarea class="bg-white rounded text-xs w-full" rows="4" wire:model.defer="predio.avaluo.observaciones"></textarea>

            <div>

                @error('observaciones') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

            </div>

        </div>

    </div>

    <div class="bg-white rounded-lg p-3 flex justify-end">

        @if(count($errors) > 0)

            <span class="bg-red-400 hover:shadow-lg text-white text-xs md:text-sm px-3 py-1 ml-auto rounded-full  hover:bg-red-700 flex items-center justify-center focus:outline-none ">
                Campos incorrectos
                @error('predio') <span class="error text-sm text-white">{{ $message }}</span> @enderror
            </span>

        @endif

        <button
            wire:click="guardar"
            wire:loading.attr="disabled"
            wire:target="guardar"
            class=" bg-green-400 hover:shadow-lg text-white text-xs md:text-sm px-3 py-1 ml-auto rounded-full  hover:bg-green-700 flex items-center justify-center focus:outline-none "
        >

            <img wire:loading wire:target="guardar" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

            Guardar

        </button>

    </div>

</div>
