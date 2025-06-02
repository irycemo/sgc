@push('styles')

    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

@endpush

<div>

    <h1 class="text-3xl tracking-widest py-3 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-thin mb-6  bg-white">Ventanilla</h1>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-3">

        <div>

            <div class="flex-row lg:flex lg:space-x-3">

                <div class="flex-auto bg-white p-3 rounded-lg mb-3 shadow-md">

                    <div class="mb-2">

                        <Label class="text-lg tracking-widest rounded-xl border-gray-500">Categoría</Label>

                    </div>

                    <div>

                        <select class="bg-white rounded text-sm w-full" wire:model.live="categoria_seleccionada">

                            <option selected value="">Selecciona una opción</option>

                            @foreach ($categorias as $item)

                                <option value="{{ $item }}">{{ $item->nombre }}</option>

                            @endforeach

                        </select>

                    </div>

                </div>

                @if($this->categoria != "")

                    <div class="bg-white p-3 rounded-lg space-y-2 mb-3 shadow-md">

                        <div class="">

                            <div class="mb-2">

                            <Label class="text-lg tracking-widest rounded-xl border-gray-500">Servicio</Label>

                            </div>

                            <div>

                                <select class="bg-white rounded text-sm w-full" wire:model.live="servicio_seleccionado">

                                    <option selected value="">Selecciona una opción</option>

                                    @foreach ($servicios as $item)

                                        <option value="{{ $item }}">{{ $item->nombre }}</option>

                                    @endforeach

                                </select>

                            </div>

                        </div>

                    </div>

                @endif

            </div>

        </div>

        <div class="">

            <div class="bg-white p-3 rounded-lg text-center shadow-md mb-3">

                <div class="mb-2">

                    <Label class="text-lg tracking-widest rounded-xl border-gray-500">Buscar trámite</Label>

                </div>

                <div class="flex justify-center lg:w-1/2 mx-auto">

                    <select class="bg-white rounded-l text-sm border border-r-transparent  focus:ring-0" wire:model="tramite_año">
                        @foreach ($años as $año)

                            <option value="{{ $año }}">{{ $año }}</option>

                        @endforeach
                    </select>

                    <input type="number" placeholder="Folio" min="1" class="bg-white text-sm w-20 focus:ring-0 @error('tramite_folio') border-red-500 @enderror" wire:model="tramite_folio">

                    <input type="number" placeholder="Usuario" min="1" class="bg-white text-sm w-20 focus:ring-0 border-l-0 @error('tramite_usuario') border-red-500 @enderror" wire:model="tramite_usuario">

                    <button
                        wire:click="buscarTramite"
                        wire:loading.attr="disabled"
                        wire:target="buscarTramite"
                        type="button"
                        class="bg-blue-400 hover:shadow-lg text-white font-bold px-4 rounded-r text-sm hover:bg-blue-700 focus:outline-blue-400 focus:outline-offset-2">

                        <img wire:loading wire:target="buscarTramite" class="mx-auto h-5 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                        <svg wire:loading.remove wire:target="buscarTramite" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 105.196 5.196a7.5 7.5 0 0010.607 10.607z" />
                        </svg>

                    </button>

                </div>

            </div>

        </div>

    </div>

    <div>

        @if($flags['Simple'])

            @livewire('tramites.ventanilla.simple', ['servicio' => $servicio, 'tramite' => $tramite, 'años' => $años, 'solicitantes' => $solicitantes, 'dependencias' => $dependencias, 'notarias' => $notarias])

        @endif

        @if($flags['Completo'])

            @livewire('tramites.ventanilla.completo', ['servicio' => $servicio, 'tramite' => $tramite, 'años' => $años, 'solicitantes' => $solicitantes, 'dependencias' => $dependencias, 'notarias' => $notarias])

        @endif

        @if($flags['Certificaciones catastrales'])

            @livewire('tramites.ventanilla.certificaciones', ['servicio' => $servicio, 'tramite' => $tramite, 'años' => $años, 'solicitantes' => $solicitantes, 'dependencias' => $dependencias, 'notarias' => $notarias])

        @endif

        @if($flags['Predio Ignorado'])

            @livewire('tramites.ventanilla.predio-ignorado', ['servicio' => $servicio, 'tramite' => $tramite, 'años' => $años, 'solicitantes' => $solicitantes, 'dependencias' => $dependencias, 'notarias' => $notarias])

        @endif

        @if($flags['Inspecciones Oculares'])

            @livewire('tramites.ventanilla.inspeccion-ocular', ['servicio' => $servicio, 'tramite' => $tramite, 'años' => $años, 'solicitantes' => $solicitantes, 'dependencias' => $dependencias, 'notarias' => $notarias])

        @endif

        @if($flags['Expedición de duplicados de documentos catastrales'])

            @livewire('tramites.ventanilla.copias', ['servicio' => $servicio, 'tramite' => $tramite, 'años' => $años, 'solicitantes' => $solicitantes, 'dependencias' => $dependencias, 'notarias' => $notarias])

        @endif

        @if($flags['Levantamientos topográficos'])

            @livewire('tramites.ventanilla.levantamientos-topograficos', ['servicio' => $servicio, 'tramite' => $tramite, 'años' => $años, 'solicitantes' => $solicitantes, 'dependencias' => $dependencias, 'notarias' => $notarias])

        @endif

    </div>

</div>

@push('scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

@endpush
