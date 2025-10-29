@push('styles')

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" integrity="sha512-ZKX+BvQihRJPA8CROKBhDNvoc2aDMOdAlcm7TUQY+35XYtrd3yh95QOOhsPDQY9QnKE0Wqag9y38OIgEvb88cA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

@endpush

@extends('layouts.admin')

@section('content')

    <x-header>Avaluo</x-header>

    <x-h4>Datos generales</x-h4>

    <div class="bg-white p-4 rounded-lg w-full shadow-lg mb-5 text-sm text-gray-600">

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Folio</strong>

                <p>{{ $avaluo->año }}-{{ $avaluo->folio }}-{{ $avaluo->usuario }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Estado</strong>

                <p class="capitalize">{{ $avaluo->estado }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Asignado a</strong>

                <p>{{ $avaluo->asignadoA->name }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Trámtie de inspección ocular</strong>

                <p>{{ $avaluo->tramiteInspeccion?->año }}-{{ $avaluo->tramiteInspeccion?->folio }}-{{ $avaluo->tramiteInspeccion?->usuario }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Trámtie de desglose</strong>

                <p>{{ $avaluo->tramiteDesglose?->año }}-{{ $avaluo->tramiteDesglose?->folio }}-{{ $avaluo->tramiteDesglose?->usuario }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Registro</strong>

                <p>Registrado por: {{ $avaluo->creadoPor->name }}</p>
                <p>Registrado en: {{ $avaluo->created_at }}</p>

            </div><div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Notificación</strong>

                <p>Notificado por:{{ $avaluo->notificador?->name }}</p>
                <p>Notificado en: {{ $avaluo->notificado_en?->format('d-m-Y') }}</p>

            </div>

        </div>

    </div>

    <x-h4>Datos generales del predio</x-h4>

    <div class="bg-white p-4 rounded-lg w-full shadow-lg mb-5 text-sm text-gray-600">

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Cuenta predial</strong>

                <p>{{ $predio->localidad }}-{{ $predio->oficina }}-{{ $predio->tipo_predio }}-{{ $predio->numero_registro }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Clave catastral</strong>

                <p>{{ $predio->estado }}-{{ $predio->region_catastral }}-{{ $predio->municipio }}-{{ $predio->zona_catastral }}-{{ $predio->localidad }}-{{ $predio->sector }}-{{ $predio->manzana }}-{{ $predio->predio }}-{{ $predio->edificio }}-{{ $predio->departamento }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Fecha de notificación</strong>

                <p>{{ $predio->fecha_notificacion ?? 'N/A' }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Fecha de efectos</strong>

                <p>{{ $predio->fecha_efectos ?? 'N/A' }}</p>

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

                <strong>Valor total de terreno</strong>

                <p>{{ number_format($predio->valor_total_terreno, 2) }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Superficie total de construcción</strong>

                <p>{{ number_format($predio->superficie_total_construccion, 2) }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Valor total de construcción</strong>

                <p>{{ number_format($predio->valor_total_construccion, 2) }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Valor catastral</strong>

                <p>${{ number_format($predio->valor_catastral, 2) }}</p>

            </div>

        </div>

    </div>

    @include('admin.comun.ubicacion')

    <x-h4>Caracteristicas</x-h4>

    <div class="bg-white p-4 rounded-lg w-full shadow-lg mb-5 text-gray-600">

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4 text-sm">

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Clasificación de la zona</strong>

                <p>{{ $avaluo->clasificacion_zona }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Tipo de construcción dominante</strong>

                <p>{{ $avaluo->construccion_dominante }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Cimentación</strong>

                <p>{{ $avaluo->cimentacion }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Estructura</strong>

                <p>{{ $avaluo->estructura }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Muros</strong>

                <p>{{ $avaluo->muros }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Entrepisos</strong>

                <p>{{ $avaluo->entrepiso }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Techo</strong>

                <p>{{ $avaluo->techo }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Plafones</strong>

                <p>{{ $avaluo->plafones }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Vidriería</strong>

                <p>{{ $avaluo->vidrieria }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Lambrines</strong>

                <p>{{ $avaluo->lambrines }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Pisos</strong>

                <p>{{ $avaluo->pisos }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Herreria</strong>

                <p>{{ $avaluo->herreria }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Pintura</strong>

                <p>{{ $avaluo->pintura }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Carpinteria</strong>

                <p>{{ $avaluo->carpinteria }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Recubrimiento especial</strong>

                <p>{{ $avaluo->recubrimiento_especial }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Aplanados</strong>

                <p>{{ $avaluo->aplanados }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Hidraulica</strong>

                <p>{{ $avaluo->hidraulica }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Sanitaria</strong>

                <p>{{ $avaluo->sanitaria }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Eléctrica</strong>

                <p>{{ $avaluo->electrica }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Gas</strong>

                <p>{{ $avaluo->gas }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Especiales</strong>

                <p>{{ $avaluo->especiales }}</p>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2 col-span-1 sm:col-span-2 lg:col-span-5">

                <strong>Observaciones</strong>

                <p>{{ $avaluo->observaciones }}</p>

            </div>

        </div>

    </div>

    @include('admin.comun.colindancias')

    @include('admin.comun.terrenos')

    @include('admin.comun.construcciones')

    @include('admin.comun.terrenos_comun')

    @include('admin.comun.construcciones_comun')

    @include('admin.comun.propietarios')

    <x-h4>Imágenes</x-h4>

    <div class="bg-white p-4 rounded-lg w-full shadow-lg mb-5 text-sm">

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Fachada</strong>

                <a href="{{ $avaluo->fachada() }}" data-lightbox="imagen" data-title="Fachada">
                    <img class="h-20 w-20 mx-auto my-3" src="{{ $avaluo->fachada() }}" alt="Fachada">
                </a>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Foto</strong>

                <a href="{{ $avaluo->foto2() }}" data-lightbox="imagen" data-title="Foto 2">
                    <img class="h-20 w-20 mx-auto my-3" src="{{ $avaluo->foto2() }}" alt="Foto 2">
                </a>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Foto</strong>

                <a href="{{ $avaluo->foto3() }}" data-lightbox="imagen" data-title="Foto 3">
                    <img class="h-20 w-20 mx-auto my-3" src="{{ $avaluo->foto3() }}" alt="Foto 3">
                </a>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Foto</strong>

                <a href="{{ $avaluo->foto4() }}" data-lightbox="imagen" data-title="Foto 4">
                    <img class="h-20 w-20 mx-auto my-3" src="{{ $avaluo->foto4() }}" alt="Foto 4">
                </a>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Macrolocalización</strong>

                <a href="{{ $avaluo->macrolocalizacion() }}" data-lightbox="imagen" data-title="Macrolocalización">
                    <img class="h-20 w-20 mx-auto my-3" src="{{ $avaluo->macrolocalizacion() }}" alt="Macrolocalización">
                </a>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Microlocalización</strong>

                <a href="{{ $avaluo->microlocalizacion() }}" data-lightbox="imagen" data-title="Microlocalización">
                    <img class="h-20 w-20 mx-auto my-3" src="{{ $avaluo->microlocalizacion() }}" alt="Microlocalización">
                </a>

            </div>

            <div class="rounded-lg bg-gray-100 py-1 px-2">

                <strong>Imágen del poligono</strong>

                <a href="{{ $avaluo->poligonoImagen() }}" data-lightbox="imagen" data-title="Imágen del poligono">
                    <img class="h-20 w-20 mx-auto my-3" src="{{ $avaluo->poligonoImagen() }}" alt="Imágen del poligono">
                </a>

            </div>


        </div>

    </div>

    @include('admin.comun.auditoria')

@endsection

@push('scripts')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js" integrity="sha512-894YE6QWD5I59HgZOGReFYm4dnWc1Qt5NtvYSaNcOP+u1T9qYdvdihz0PPSiiqn/+/3e7Jo4EaG7TubfWGUrMQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js" integrity="sha512-k2GFCTbp9rQU412BStrcD/rlwv1PYec9SNrkbQlo6RZCf75l6KcC3UwDY8H5n5hl4v77IDtIPwOk9Dqjs/mMBQ==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

@endpush
