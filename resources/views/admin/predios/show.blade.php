@extends('layouts.admin')

@section('content')

    <h1 class="text-3xl tracking-widest py-3 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-thin mb-6  bg-white">Predio</h1>

    <h4 class="text-2xl tracking-widest py-1 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-thin mb-6  bg-white">Datos generales</h4>

    <div class="bg-white p-4 rounded-lg w-full shadow-lg mb-5 text-gray-600">

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 text-sm">

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Cuenta predial</strong>

                <p>{{ $predio->localidad }}-{{ $predio->oficina }}-{{ $predio->tipo_predio }}-{{ $predio->numero_registro }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Clave catastral</strong>

                <p>{{ $predio->estado }}-{{ $predio->region_catastral }}-{{ $predio->municipio }}-{{ $predio->zona_catastral }}-{{ $predio->localidad }}-{{ $predio->sector }}-{{ $predio->manzana }}-{{ $predio->predio }}-{{ $predio->edificio }}-{{ $predio->departamento }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Estado</strong>

                <p>{{ $predio->status }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Folio real</strong>

                <p>{{ $predio->folio_real }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Documento de entrada - Número de documento</strong>

                <p>{{ $predio->documento_entrada }} - {{ $predio->documento_numero }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Declarante</strong>

                <p>{{ $predio->declarante }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>CURT</strong>

                <p>{{ $predio->curt }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Fecha de efectos</strong>

                <p>{{ $predio->fecha_efectos }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Superficie notarial</strong>

                <p>{{ number_format($predio->superficie_notarial, 2) }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Superficie judicial</strong>

                <p>{{ number_format($predio->superficie_judicial, 2) }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Superficie de terreno</strong>

                <p>{{ number_format($predio->superficie_terreno, 2) }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Valor de terreno</strong>

                <p>{{ number_format($predio->valor_total_terreno, 2) }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Superficie de construcción</strong>

                <p>{{ number_format($predio->superficie_construccion, 2) }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Valor de construcción</strong>

                <p>{{ number_format($predio->valor_total_construccion, 2) }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Área común de terreno</strong>

                <p>{{ number_format($predio->area_comun_terreno, 2) }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Valor de terreno común</strong>

                <p>{{ number_format($predio->valor_terreno_comun, 2) }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Área común de construcción</strong>

                <p>{{ number_format($predio->area_comun_construccion, 2) }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Valor de construcción común</strong>

                <p>{{ number_format($predio->valor_construccion_comun, 2) }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Valor catastral</strong>

                <p>${{ number_format($predio->valor_catastral, 2) }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Uso del predio</strong>

                <p>Uso 1: {{ $predio->uso_1 }}</p>
                <p>Uso 2: {{ $predio->uso_2 }}</p>
                <p>Uso 3: {{ $predio->uso_3 }}</p>

            </div>

            <div class="col-span-1 sm:col-span-2 lg:col-span-5 rounded-lg bg-gray-100 py-1 px-2">

                <strong>Observaciones</strong>

                <p>{{ $predio->observaciones }}</p>

            </div>

        </div>

    </div>

    @include('admin.comun.ubicacion')

    @include('admin.comun.colindancias')

    @include('admin.comun.terrenos')

    @include('admin.comun.construcciones')

    @include('admin.comun.terrenos_comun')

    @include('admin.comun.construcciones_comun')

    @include('admin.comun.propietarios')

    @include('admin.comun.movimientos')

    <h4 class="text-2xl tracking-widest py-1 px-6 text-gray-600 rounded-xl border-b-2 border-gray-500 font-thin mb-6  bg-white">Bloqueos ({{ $predio->bloqueos->count() }})</h4>

    <div class="bg-white p-4 rounded-lg w-full shadow-lg mb-5">

        <table class="w-full overflow-x-auto table-fixed">

            <thead class="border-b border-gray-300 ">

                <tr class="text-sm text-gray-500 text-left traling-wider whitespace-nowrap">

                    <th class="px-2">Estado</th>
                    <th class="px-2">Motivo de bloqueo</th>
                    <th class="px-2">Motivo de desbloqueo</th>
                    <th class="px-2">Bloqueado por</th>
                    <th class="px-2">Desbloqueado por</th>

                </tr>

            </thead>

            <tbody class="divide-y divide-gray-200">

                @foreach ($predio->bloqueos as $bloqueo)

                    <tr class="text-gray-500 text-sm leading-relaxed">
                        <td class=" px-2 w-full capitalize">{{ $bloqueo->estado }}</td>
                        <td class=" px-2 w-full ">{{ $bloqueo->observaciones_bloqueo }}</td>
                        <td class=" px-2 w-full ">{{ $bloqueo->observaciones_desbloqueo }}</td>
                        <td class=" px-2 w-full ">
                            <div>{{ $bloqueo->creadoPor?->name }}</div>
                            <div>{{ $bloqueo->created_at }}</div>
                        </td>
                        <td class="px-2 w-full">
                            <div>{{ $bloqueo->actualizadoPor?->name }}</div>
                            <div>{{ $bloqueo->updated_at }}</div>
                        </td>
                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

    @include('admin.comun.auditoria')

    <div class="grid grid-cols-3 gap-4">

        <div>

            @livewire('comun.consultas.certificaciones-consulta', ['predio_id' => $predio->id])

        </div>

        <div>

            @livewire('comun.consultas.traslados-consulta', ['predio_id' => $predio->id])

        </div>

        <div>

            @livewire('comun.consultas.archivo-consulta', ['predio_id' => $predio->id])

        </div>


    </div>

@endsection
