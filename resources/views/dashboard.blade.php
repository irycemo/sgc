@extends('layouts.admin')

@section('content')

    @if(auth()->user()->hasRole(['Administrador', 'Oficina rentistica']))

        @livewire('dashboard.administrador-dashboard', ['lazy' => true])

    @elseif(auth()->user()->hasRole(['Jefe de departamento']))

    @elseif(auth()->user()->hasRole(['Valuador predio ignorado', 'Valuador variación catastral', 'Valuador subdivisiones', 'Valuación']))

    @elseif(auth()->user()->hasRole(['Fiscal']))

    @elseif(auth()->user()->hasRole(['Gestion catastral']))

    @elseif(auth()->user()->hasRole(['Cartografía']))

    @elseif(auth()->user()->hasRole(['A y T Administrativos']))

    @endif

@endsection
