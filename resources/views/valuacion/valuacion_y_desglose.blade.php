@extends('layouts.admin')

@section('content')

    <x-header>Valuación y Desglose</x-header>

    <div class="tab-wrapper max-h-full" x-data="{ activeTab: 0 }">

        <div class="flex py-4 space-x-4 items-center border-b-2 border-gray-500 mb-6 flex-wrap">

            <label
                @click="activeTab = 0"
                class="px-6 py-1 text-gray-600 rounded-xl border-b-2 border-gray-500 font-semibold mb-3 cursor-pointer bg-white"
                :class="{'active  bg-gray-200 rounded-full px-3 py-1 text-gray-500 no-underline': activeTab === 0 }"
            >Datos de identificación del inmueble
            </label>

            <label
                @click="activeTab = 1"
                class="px-6 py-1 text-gray-600 rounded-xl border-b-2 border-gray-500 font-semibold mb-3 cursor-pointer bg-white"
                :class="{'active  bg-gray-200 rounded-full px-3 py-1 text-gray-500 no-underline': activeTab === 1 }"
            >Colindancias
            </label>

            <label
                @click="activeTab = 2"
                class="px-6 py-1 text-gray-600 rounded-xl border-b-2 border-gray-500 font-semibold mb-3 cursor-pointer bg-white"
                :class="{'active  bg-gray-200 rounded-full px-3 py-1 text-gray-500 no-underline': activeTab === 2 }"
            >Características
            </label>

            <label
                @click="activeTab = 3"
                class="px-6 py-1 text-gray-600 rounded-xl border-b-2 border-gray-500 font-semibold mb-3 cursor-pointer bg-white"
                :class="{'active  bg-gray-200 rounded-full px-3 py-1 text-gray-500 no-underline': activeTab === 3 }"
            >Determinación de valor catastral
            </label>

            <label
                @click="activeTab = 4"
                class="px-6 py-1 text-gray-600 rounded-xl border-b-2 border-gray-500 font-semibold mb-3 cursor-pointer bg-white"
                :class="{'active  bg-gray-200 rounded-full px-3 py-1 text-gray-500 no-underline': activeTab === 4 }"
            >Imágenes y observaciones
            </label>

        </div>

        <div x-cloak class="tab-panel" :class="{ 'active': activeTab === 4 }" x-show.transition.in.opacity.duration.800="activeTab === 4"  wire:key="tab-4">

            @livewire('valuacion.valuacion-y-desglose.imagenes-observaciones', ['avaluo_id' => $id])

        </div>

        <div x-cloak class="tab-panel" :class="{ 'active': activeTab === 3 }" x-show.transition.in.opacity.duration.800="activeTab === 3"  wire:key="tab-3">

            @livewire('valuacion.valuacion-y-desglose.valor', ['avaluo_id' => $id])

        </div>

        <div class="tab-panel" :class="{ 'active': activeTab === 0 }" x-show.transition.in.opacity.duration.800="activeTab === 0"  wire:key="tab-0">

            @livewire('valuacion.valuacion-y-desglose.inmueble', ['avaluo_id' => $id])

        </div>

        <div x-cloak class="tab-panel" :class="{ 'active': activeTab === 1 }" x-show.transition.in.opacity.duration.800="activeTab === 1"  wire:key="tab-1">

            @livewire('valuacion.valuacion-y-desglose.colindancias', ['avaluo_id' => $id])

        </div>

        <div x-cloak class="tab-panel" :class="{ 'active': activeTab === 2 }" x-show.transition.in.opacity.duration.800="activeTab === 2"  wire:key="tab-2">

            @livewire('valuacion.valuacion-y-desglose.caracteristicas', ['avaluo_id' => $id])

        </div>

    </div>

@endsection
