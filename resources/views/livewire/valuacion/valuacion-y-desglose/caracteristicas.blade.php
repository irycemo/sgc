<div class="p-4 mb-1">

    @if(isset($predio->avaluo->folio))

        <div class="space-y-2 mb-5 bg-white rounded-lg p-2 text-right">

            <span class="bg-blue-400 text-white text-sm rounded-full px-2 py-1">Folio de avaluo: {{ $predio->avaluo->folio }}</span>

        </div>

    @endif

    <div class="space-y-2 mb-5 bg-white rounded-lg p-2">

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 items-end md:w-2/3 mx-auto mb-4">

            <div class="flex-auto">

                <div class="text-center">

                    <Label class="text-base tracking-widest rounded-xl border-gray-500">Clasificación de la zona</Label>

                </div>

                <div class="">

                    <select class="bg-white rounded text-xs w-full" wire:model.defer="avaluo.clasificacion_zona">

                        <option value="" selected>Seleccione una opción</option>

                        @foreach ($zonas as $item)

                            <option value="{{ $item }}">{{ $item }}</option>

                        @endforeach

                    </select>

                </div>

                <div>

                    @error('avaluo.clasificacion_zona') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                </div>

            </div>

            <div class="flex-auto">

                <div class="text-center">

                    <Label class="text-base tracking-widest rounded-xl border-gray-500">Tipo de construcción dominante</Label>

                </div>

                <div class="">

                    <select class="bg-white rounded text-xs w-full" wire:model.defer="avaluo.construccion_dominante">

                        <option value="" selected>Seleccione una opción</option>

                        @foreach ($construcciones as $item)

                            <option value="{{ $item }}">{{ $item }}</option>

                        @endforeach

                    </select>

                </div>

                <div>

                    @error('avaluo.construccion_dominante') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                </div>

            </div>

        </div>

        <div class="flex-row lg:flex lg:space-x-2 mb-2 space-y-2 lg:space-y-0 items-center justify-center" >

            <div class="text-left">

                <Label class="text-base tracking-widest rounded-xl border-gray-500">Servicios municipales</Label>

            </div>

            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-6 gap-3 items-end text-center">

                <div class="flex-auto">

                    <div>

                        <Label class="text-sm">Agua potable</Label>
                    </div>

                    <div>

                        <input type="checkbox" class="bg-white rounded text-xs" wire:model.defer="avaluo.agua" @if($predio && $predio->tipo_predio == 1) checked @endif>

                    </div>

                    <div>

                        @error('avaluo.agua') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                    </div>

                </div>

                <div class="flex-auto">

                    <div>

                        <Label class="text-sm">Drenaje</Label>
                    </div>

                    <div>

                        <input type="checkbox" class="bg-white rounded text-xs" wire:model.defer="avaluo.drenaje" @if($predio && $predio->tipo_predio == 1) checked @endif>

                    </div>

                    <div>

                        @error('avaluo.drenaje') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                    </div>

                </div>

                <div class="flex-auto">

                    <div>

                        <Label class="text-sm">Pavimento</Label>
                    </div>

                    <div>

                        <input type="checkbox" class="bg-white rounded text-xs" wire:model.defer="avaluo.pavimento" @if($predio && $predio->tipo_predio == 1) checked @endif>

                    </div>

                    <div>

                        @error('avaluo.pavimento') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                    </div>

                </div>

                <div class="flex-auto">

                    <div>

                        <Label class="text-sm">Energia eléctrica</Label>
                    </div>

                    <div>

                        <input type="checkbox" class="bg-white rounded text-xs" wire:model.defer="avaluo.energia_electrica" @if($predio && $predio->tipo_predio == 1) checked @endif>

                    </div>

                    <div>

                        @error('avaluo.energia_electrica') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                    </div>

                </div>

                <div class="flex-auto">

                    <div>

                        <Label class="text-sm">Alumbrado público</Label>
                    </div>

                    <div>

                        <input type="checkbox" class="bg-white rounded text-xs" wire:model.defer="avaluo.alumbrado_publico" @if($predio && $predio->tipo_predio == 1) checked @endif>

                    </div>

                    <div>

                        @error('avaluo.alumbrado_publico') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                    </div>

                </div>

                <div class="flex-auto">

                    <div>

                        <Label class="text-sm">Banqeta</Label>
                    </div>

                    <div>

                        <input type="checkbox" class="bg-white rounded text-xs" wire:model.defer="avaluo.banqueta" @if($predio && $predio->tipo_predio == 1) checked @endif>

                    </div>

                    <div>

                        @error('avaluo.banqueta') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

                    </div>

                </div>

            </div>

        </div>

    </div>

    <div class="space-y-2 mb-5 bg-white rounded-lg p-2">

        <h4 class="text-lg mb-5 text-center">Obra negra</h4>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-6 gap-3 items-end mx-auto">

            <div class="flex-auto ">

                <div>

                    <label class="text-sm" >Cimentación</label>

                </div>

                <div>

                    <select class="bg-white rounded text-xs w-full @error('avaluo.cimentacion') border-red-500 @enderror" wire:model.defer="avaluo.cimentacion">

                        @foreach ($cimentaciones as $item)

                            <option value="{{ $item }}">{{ $item }}</option>

                        @endforeach

                    </select>

                </div>

            </div>

            <div class="flex-auto ">

                <div>

                    <label class="text-sm" >Estructura</label>

                </div>

                <div>

                    <select class="bg-white rounded text-xs w-full @error('avaluo.estructura') border-red-500 @enderror" wire:model.defer="avaluo.estructura">

                        @foreach ($estructuras as $item)

                            <option value="{{ $item }}">{{ $item }}</option>

                        @endforeach

                    </select>

                </div>

            </div>

            <div class="flex-auto ">

                <div>

                    <label class="text-sm" >Muros</label>

                </div>

                <div>

                    <select class="bg-white rounded text-xs w-full @error('avaluo.muros') border-red-500 @enderror" wire:model.defer="avaluo.muros">

                        @foreach ($muros as $item)

                            <option value="{{ $item }}">{{ $item }}</option>

                        @endforeach

                    </select>

                </div>

            </div>

            <div class="flex-auto ">

                <div>

                    <label class="text-sm" >Entrepisos</label>

                </div>

                <div>

                    <select class="bg-white rounded text-xs w-full @error('avaluo.entrepiso') border-red-500 @enderror" wire:model.defer="avaluo.entrepiso">

                        @foreach ($entrepisos as $item)

                            <option value="{{ $item }}">{{ $item }}</option>

                        @endforeach

                    </select>

                </div>

            </div>

            <div class="flex-auto ">

                <div>

                    <label class="text-sm" >Techo</label>

                </div>

                <div>

                    <select class="bg-white rounded text-xs w-full @error('avaluo.techo') border-red-500 @enderror" wire:model.defer="avaluo.techo">

                        @foreach ($techos as $item)

                            <option value="{{ $item }}">{{ $item }}</option>

                        @endforeach

                    </select>

                </div>

            </div>

        </div>

    </div>

    <div class="space-y-2 mb-5 bg-white rounded-lg p-2">

        <h4 class="text-lg mb-5 text-center">Acabados</h4>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-9 gap-3 items-end mx-auto">

            <div class="flex-auto ">

                <div>

                    <label class="text-sm" >Plafones</label>

                </div>

                <div>

                    <select class="bg-white rounded text-xs w-full @error('avaluo.plafones') border-red-500 @enderror" wire:model.defer="avaluo.plafones">

                        @foreach ($plafones as $item)

                            <option value="{{ $item }}">{{ $item }}</option>

                        @endforeach

                    </select>

                </div>

            </div>

            <div class="flex-auto ">

                <div>

                    <label class="text-sm" >Vidriería</label>

                </div>

                <div>

                    <select class="bg-white rounded text-xs w-full @error('avaluo.vidrieria') border-red-500 @enderror" wire:model.defer="avaluo.vidrieria">

                        @foreach ($vidrieria as $item)

                            <option value="{{ $item }}">{{ $item }}</option>

                        @endforeach

                    </select>

                </div>

            </div>

            <div class="flex-auto ">

                <div>

                    <label class="text-sm" >Lambrines</label>

                </div>

                <div>

                    <select class="bg-white rounded text-xs w-full @error('avaluo.lambrines') border-red-500 @enderror" wire:model.defer="avaluo.lambrines">

                        @foreach ($lambrines as $item)

                            <option value="{{ $item }}">{{ $item }}</option>

                        @endforeach

                    </select>

                </div>

            </div>

            <div class="flex-auto ">

                <div>

                    <label class="text-sm" >Pisos</label>

                </div>

                <div>

                    <select class="bg-white rounded text-xs w-full @error('avaluo.pisos') border-red-500 @enderror" wire:model.defer="avaluo.pisos">

                        @foreach ($pisos as $item)

                            <option value="{{ $item }}">{{ $item }}</option>

                        @endforeach

                    </select>

                </div>

            </div>

            <div class="flex-auto ">

                <div>

                    <label class="text-sm" >Herrería</label>

                </div>

                <div>

                    <select class="bg-white rounded text-xs w-full @error('avaluo.herreria') border-red-500 @enderror" wire:model.defer="avaluo.herreria">

                        @foreach ($herreria as $item)

                            <option value="{{ $item }}">{{ $item }}</option>

                        @endforeach

                    </select>

                </div>

            </div>

            <div class="flex-auto ">

                <div>

                    <label class="text-sm" >Pintura</label>

                </div>

                <div>

                    <select class="bg-white rounded text-xs w-full @error('avaluo.pintura') border-red-500 @enderror" wire:model.defer="avaluo.pintura">

                        @foreach ($pintura as $item)

                            <option value="{{ $item }}">{{ $item }}</option>

                        @endforeach

                    </select>

                </div>

            </div>

            <div class="flex-auto ">

                <div>

                    <label class="text-sm" >Carpintería</label>

                </div>

                <div>

                    <select class="bg-white rounded text-xs w-full @error('avaluo.carpinteria') border-red-500 @enderror" wire:model.defer="avaluo.carpinteria">

                        @foreach ($carpinteria as $item)

                            <option value="{{ $item }}">{{ $item }}</option>

                        @endforeach

                    </select>

                </div>

            </div>

            <div class="flex-auto ">

                <div>

                    <label class="text-sm" >Aplanados</label>

                </div>

                <div>

                    <select class="bg-white rounded text-xs w-full @error('avaluo.aplanados') border-red-500 @enderror" wire:model.defer="avaluo.aplanados">

                        @foreach ($aplanados as $item)

                            <option value="{{ $item }}">{{ $item }}</option>

                        @endforeach

                    </select>

                </div>

            </div>

            <div class="flex-auto ">

                <div>

                    <label class="text-sm" >Recubrimiento especial</label>

                </div>

                <div>

                    <select class="bg-white rounded text-xs w-full @error('avaluo.recubrimiento_especial') border-red-500 @enderror" wire:model.defer="avaluo.recubrimiento_especial">

                        @foreach ($rec_especial as $item)

                            <option value="{{ $item }}">{{ $item }}</option>

                        @endforeach

                    </select>

                </div>

            </div>

        </div>

    </div>

    <div class="space-y-2 mb-5 bg-white rounded-lg p-2">

        <h4 class="text-lg mb-5 text-center">Instalaciones</h4>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 xl:grid-cols-5 gap-3 items-end mx-auto">

            <div class="flex-auto ">

                <div>

                    <label class="text-sm" >Hidáulica</label>

                </div>

                <div>

                    <select class="bg-white rounded text-xs w-full @error('avaluo.hidraulica') border-red-500 @enderror" wire:model.defer="avaluo.hidraulica">

                        @foreach ($hidraulica as $item)

                            <option value="{{ $item }}">{{ $item }}</option>

                        @endforeach

                    </select>

                </div>

            </div>

            <div class="flex-auto ">

                <div>

                    <label class="text-sm" >Sanitaria</label>

                </div>

                <div>

                    <select class="bg-white rounded text-xs w-full @error('avaluo.sanitaria') border-red-500 @enderror" wire:model.defer="avaluo.sanitaria">

                        @foreach ($sanitaria as $item)

                            <option value="{{ $item }}">{{ $item }}</option>

                        @endforeach

                    </select>

                </div>

            </div>

            <div class="flex-auto ">

                <div>

                    <label class="text-sm" >Eléctrica</label>

                </div>

                <div>

                    <select class="bg-white rounded text-xs w-full @error('avaluo.electrica') border-red-500 @enderror" wire:model.defer="avaluo.electrica">

                        @foreach ($electrica as $item)

                            <option value="{{ $item }}">{{ $item }}</option>

                        @endforeach

                    </select>

                </div>

            </div>

            <div class="flex-auto ">

                <div>

                    <label class="text-sm" >Gas</label>

                </div>

                <div>

                    <select class="bg-white rounded text-xs w-full @error('avaluo.gas') border-red-500 @enderror" wire:model.defer="avaluo.gas">

                        @foreach ($gas as $item)

                            <option value="{{ $item }}">{{ $item }}</option>

                        @endforeach

                    </select>

                </div>

            </div>

            <div class="flex-auto ">

                <div>

                    <label class="text-sm" >Especiales</label>

                </div>

                <div>

                    <select class="bg-white rounded text-xs w-full @error('avaluo.especiales') border-red-500 @enderror" wire:model.defer="avaluo.especiales">

                        @foreach ($especiales as $item)

                            <option value="{{ $item }}">{{ $item }}</option>

                        @endforeach

                    </select>

                </div>

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
