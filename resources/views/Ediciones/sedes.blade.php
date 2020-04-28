@extends('layouts.app')


@section('contenido')
    @include('plantillas.AsignacionesSede') 
@endsection

@section('Table')
    <script>
        $(document).ready(function(){
            addvue('#vue-Asignacion');
            TablaVacia('#table-vue-asede');
            GetTablaAsede("#table-vue-asede","{{ url('GetListaAsede') }}");
        });
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