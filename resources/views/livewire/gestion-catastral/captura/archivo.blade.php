<div>

    <div class="space-y-2 mb-5 bg-white rounded-lg p-2 shadow-xl">

        @if($predio?->archivos()->where('descripcion', 'archivo')->first())

            <div class="flex justify-center">

                @if(app()->isProduction())

                    <x-link-blue
                        href="{{ Storage::disk('s3')->temporaryUrl(config('services.ses.ruta_predios') . $predio->archivos()->where('descripcion', 'archivo')->first()->url, now()->addMinutes(10)) }}"
                        target="_blank"
                        >
                        Descargar archivo actual
                    </x-link-blue>


                @else

                    <x-link-blue
                        href="{{ Storage::disk('predios_archivo')->url($predio->archivos()->where('descripcion', 'archivo')->first()->url) }}"
                        target="_blank"
                        >
                        Descargar archivo actual
                    </x-link-blue>

                @endif

            </div>

        @else

            <div class="w-full lg:w-1/2 mx-auto">

                @if($predio)

                    <livewire:comun.consultas.archivo-consulta lazy :predio_id="$predio->id" />

                @endif

            </div>

        @endif

        <div class="w-full md:w-1/2 lg:w-1/4 mx-auto items-center text-center">

            <div class="mb-5">

                <x-filepond wire:model.live="documento" accept="['application/pdf']"/>

            </div>

            <div>

                @error('documento') <span class="error text-sm text-red-500">{{ $message }}</span> @enderror

            </div>

        </div>

    </div>

    @if($predio)

        <div class="mb-5 bg-white rounded-lg p-2 shadow-lg flex justify-end gap-4">

            <x-button-green
                wire:click="guardar"
                wire:loading.attr="disabled"
                wire:target="guardar">

                <img wire:loading wire:target="guardar" class="mx-auto h-4 mr-1" src="{{ asset('storage/img/loading3.svg') }}" alt="Loading">

                Guardar

            </x-button-green>

        </div>

    @endif

</div>
