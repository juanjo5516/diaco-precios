@extends('layouts.app')

@section('contenido')
    @include('plantillas.historico') 
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
        Historicos de Enviados
    </li>
@endsection
@section('diaco_title')
    DIACO
@endsection