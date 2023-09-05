<div class="p-4 mb-1">

    @if(isset($predio->avaluo->folio))

        <div class="space-y-2 mb-5 bg-white rounded-lg p-2 text-right">

            <span class="bg-blue-400 text-white text-sm rounded-full px-2 py-1">Folio de avaluo: {{ $predio->avaluo->folio }}</span>

        </div>

    @endif

    <div class="space-y-2 mb-5 bg-white rounded-lg p-2">

        <h4 class="text-lg mb-5 text-center">Colindancias</h4>

        <div class="mb-5  divide-y">

            @foreach ($medidas as $index => $medida)

                <div class="grid grid-cols-1 md:grid-cols-12 gap-3 items-start mb-2">

                    <div class="flex-auto lg:col-span-2">

                        <div>

                            <label class="text-sm" >Viento</label>

                        </div>

                        <div>

                            <select class="bg-white rounded text-xs w-full" wire:model.defer="medidas.{{ $index }}.viento">

                                <option value="" selected>Seleccione una opción</option>

                                @foreach ($vientos as $viento)

                                    <option value="{{ $viento }}" selected>{{ $viento }}</option>

                                @endforeach

                            </select>

                        </div>

                        <div>

                            @error('medidas.' . $index . '.viento') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                        </div>

                    </div>

                    <div class="flex-auto lg:col-span-2">

                        <div>

                            <label class="text-sm" >Longitud</label>

                        </div>

                        <div>

                            <input type="number" min="0" class="bg-white rounded text-xs w-full" wire:model.defer="medidas.{{ $index }}.longitud">

                        </div>

                        <div>

                            @error('medidas.' . $index . '.longitud') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                        </div>

                    </div>

                    <div class="flex-auto lg:col-span-7">

                        <div>

                            <label class="text-sm" >Descripción</label>

                        </div>

                        <div>

                            <textarea rows="1" class="bg-white rounded text-xs w-full" wire:model.defer="medidas.{{ $index }}.descripcion"></textarea>

                        </div>

                        <div>

                            @error('medidas.' . $index . '.descripcion') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                        </div>

                    </div>

                    <div class="flex-auto lg:col-span-1 my-auto">

                        <button
                            wire:click="borrarMedida({{ $index }})"
                            wire:loading.attr="disabled"
                            wire:target="borrarMedida({{ $index }})"
                            class="  bg-red-400 hover:shadow-lg text-white text-xs md:text-sm  px-3 py-1 w-full lg:w-auto lg:ml-auto rounded-full  hover:bg-red-700 flex justify-center items-center focus:outline-none "
                        >

                            <img wire:loading wire:target="borrarMedida({{ $index }})" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                            Borrar

                        </button>

                    </div>

                </div>

            @endforeach

        </div>

        <button
            wire:click="agregarMedida"
            wire:loading.attr="disabled"
            wire:target="agregarMedida"
            class=" bg-blue-400 hover:shadow-lg text-white text-xs md:text-sm px-3 py-1 mr-auto rounded-full  hover:bg-blue-700 flex items-center justify-center focus:outline-none "
        >

            <img wire:loading wire:target="agregarMedida" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

            Agregar nuevo

        </button>

    </div>

    <div class="bg-white rounded-lg p-3 flex justify-end">

        @if(count($errors) > 0)

            <span class="bg-red-400 hover:shadow-lg text-white text-xs md:text-sm px-3 py-1 ml-auto rounded-full  hover:bg-red-700 flex items-center justify-center focus:outline-none ">
                Campos incorrectos
                @error('predio') <span class="error text-sm text-white">{{ $message }}</span> @enderror
            </span>

        @endif

        @if($predio)

            <button
                wire:click="guardar"
                wire:loading.attr="disabled"
                wire:target="guardar"
                class=" bg-green-400 hover:shadow-lg text-white text-xs md:text-sm px-3 py-1 ml-auto rounded-full  hover:bg-green-700 flex items-center justify-center focus:outline-none "
            >

                <img wire:loading wire:target="guardar" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                Guardar

            </button>

        @endif

    </div>

</div>
