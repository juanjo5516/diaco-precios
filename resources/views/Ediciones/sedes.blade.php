@extends('layouts.app')


@section('contenido')
    @include('plantillas.AsignacionesSede') 
@endsection

@section('Table')
    <script>
            addvue('#vue-Asignacion');
    </script>
@endsection

@section('Ruta')
    <li class="breadcrumb-item">
        Asignación de Plantillas
    </li>
@endsection
@section('diaco_title')
    DIACO
@endsection