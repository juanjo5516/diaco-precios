@extends('layouts.app')

@section('contenido')
    @include('plantillas.inbox') 
@endsection

@section('Table')
    {{-- <script>
        $(document).ready(function(){
            addvue('#vue-Asignacion');
            TablaVacia('#table-vue-asede');
            GetTablaAsede("#table-vue-asede","{{ url('GetListaAsede') }}");
        });
    </script> --}}
@endsection

@section('Ruta')
    <li class="breadcrumb-item">
        Bandeja de Contenidos
    </li>
@endsection
@section('diaco_title')
    DIACO
@endsection