<x-app-layout>

    <div class="max-w-7xl mx-auto p-6 lg:p-8">
        <div class="flex justify-center">
            <a href="/">
                <img src="{{ asset('storage/img/logo2.png') }}" alt="Logo" class="w-96">
            </a>

        </div>

        <div class="mt-16">

            <div class="space-y-4">

                <div class="scale-100 p-6 bg-white from-gray-700/50 via-transparent rounded-lg shadow-2xl shadow-gray-500/20 flex  transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">

                    <div class="flex flex-col lg:flex-row gap-3 lg:gap-8 items-center">

                        <div class="h-16 w-16 bg-red-50 flex items-center justify-center rounded-full">

                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-7 h-7 stroke-red-500">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75m-3-7.036A11.959 11.959 0 0 1 3.598 6 11.99 11.99 0 0 0 3 9.749c0 5.592 3.824 10.29 9 11.623 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.248-8.25-3.285Z" />
                            </svg>

                        </div>

                        <div>

                            <h2 class="mt-6 text-xl font-semibold text-gray-900">Verificación de documento</h2>

                            <p class="mt-4 text-gray-500 text-sm leading-relaxed">
                                El Instituto Registral y Catastral verifica la siguiente información contenida el el documento: <strong>{{ $certificacion->documento }}, FOLIO: {{ $certificacion->año }}-{{ $certificacion->folio }}</strong>.
                            </p>

                        </div>

                    </div>

                </div>

                <div class="scale-100 p-6 bg-white from-gray-700/50 via-transparent rounded-lg shadow-2xl shadow-gray-500/20 ">

                    <h2 class=" text-xl font-semibold text-gray-900 mb-4">Información contenida en el documento</h2>

                    @if($certificacion->documento === 'CERTIFICADO DE HISTORIA CATASTRAL')

                        @include('verificacion.historia-catastral')

                    @elseif($certificacion->documento === 'NOTIFICACIÓN DE VALOR CATASTRAL')

                        @include('verificacion.notificacion-valor-catastral')

                    @elseif(in_array($certificacion->documento, ['CERTIFICADO DE REGISTRO CON COLINDANCIAS', 'CERTIFICADO DE REGISTRO ELECTRÓNICO', 'CERTIFICADO DE REGISTRO']))

                        @include('verificacion.certificado-registro')

                    @elseif($certificacion->documento === 'CEDULA DE ACTUALIZACIÓN CATASTRAL')

                        @include('verificacion.cedula-actualizacion')

                    @elseif($certificacion->documento === 'CERTIFICADO NEGATIVO DE REGISTRO')

                        @include('verificacion.certificado-negativo')

                    @endif

                </div>

            </div>

        </div>

    </div>

</x-app-layout>
