<div>

    <x-header>Crear o editar pregunta</x-header>

    <div class="bg-white rounded-lg shadow-xl p-4">

        <div class="w-full lg:w-1/2 mx-auto mb-5">

            <x-input-group for="titulo" label="Título" :error="$errors->first('titulo')" class="w-full mb-5">

                <x-input-text id="titulo" wire:model="titulo" />

            </x-input-group>

            <x-input-group for="categoria" label="Categoría" :error="$errors->first('categoria')" class="w-full mb-5">

                        <x-input-select id="categoria" wire:model="categoria" class="w-full">

                            <option value="">Seleccione una opción</option>

                            @foreach ($categorias as $categoria)

                                    <option value="{{ $categoria }}">{{ $categoria }}</option>

                            @endforeach

                        </x-input-select>

                    </x-input-group>

            <x-ck-editor property="contenido" id="content" class="w-full"></x-ck-editor>

            <div class="my-5">

                <x-filepond wire:model.live="video" accept="['video/*']"/>

            </div>

            <div>

                @error('video') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

            </div>

            @if($errors->first('contenido'))

                <div class="text-red-500 text-sm mt-1"> {{ $errors->first('contenido') }} </div>

            @endif

        </div>

        <div class="w-full lg:w-1/2 mx-auto flex justify-end">

            @if ($pregunta)

                <x-button-blue
                    wire:click="actualizar"
                    wire:loading.attr="disabled">

                    <img wire:loading wire:target="asignar" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                    Actualizar
                </x-button-blue>

            @else

                <x-button-blue
                    wire:click="guardar"
                    wire:loading.attr="disabled">

                    <img wire:loading wire:target="asignar" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                    Guardar
                </x-button-blue>

            @endif

        </div>

    </div>

</div>
