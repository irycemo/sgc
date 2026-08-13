<div>

    <div>

        @if($exportacion)

            <div
                wire:poll.2s="consultarExportacion"
                class="p-4 mb-5 bg-white shadow-lg rounded-lg text-gray-700 flex justify-center">

                @if($exportacion['status'] === 'procesando')

                    <div class="space-y-4 w-full lg:w-1/3">

                        <div class="flex justify-between items-center">

                            <div>

                                <div class="font-semibold">

                                    Generando reporte

                                </div>

                                <div class="text-sm text-gray-500">

                                    {{ number_format($exportacion['procesados']) }} predios procesados de {{ number_format($exportacion['total']) }}

                                </div>

                            </div>

                        </div>

                        <div class="w-full bg-gray-200 rounded-full h-4 overflow-hidden">

                            <div
                                class="bg-blue-600 h-4 rounded-full transition-all duration-500"
                                style="width: {{ round(($exportacion['procesados'] / $exportacion['total']) * 100, 2)  }}%">
                            </div>

                        </div>

                    </div>

                @endif

                @if($exportacion['status'] === 'completado')

                    <div>

                        <a
                            href="{{ $this->descargar() }}"
                            target="_blank"
                            class="bg-green-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded text-xs hover:bg-green-700 focus:outline-none flex items-center justify-center focus:outline-blue-400 focus:outline-offset-2">

                            Descargar reporte

                        </a>

                    </div>

                @endif

            </div>

        @else

            @if(
                !$exportacion ||
                $this->exportacion['status'] === 'completado' ||
                $this->exportacion['status'] === 'fallido'
            )

                <div class="p-4 mb-5 bg-white shadow-lg rounded-lg text-gray-700 flex justify-center">

                    <button
                        wire:click="comenzarImportacion"
                        wire:loading.attr="disabled"
                        class="bg-blue-400 hover:shadow-lg text-white font-bold px-4 py-2 rounded text-xs hover:bg-blue-700 focus:outline-none flex items-center justify-center focus:outline-blue-400 focus:outline-offset-2">

                        <span wire:loading.remove> Generar reporte</span>

                        <span wire:loading> Iniciando... </span>

                    </button>

                </div>

            @endif

        @endif

    </div>

    <div class="p-4 mb-5 bg-white shadow-lg rounded-lg text-gray-700">

        <span class="text-gray-800 font-semibold">Reportes generados anteriormente</span>

        <ul class="list-disc p-4 text-sm">

            @foreach ($reportes as $reporte)

                <li>
                    <a href="{{ $reporte['link'] }}">{{ Str::replace('sgc/reportes/sat/', '', $reporte['file']) }}</a>
                </li>

            @endforeach

        </ul>

    </div>

</div>
