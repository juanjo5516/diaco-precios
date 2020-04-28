@extends('layouts.app')
@section('contenido')
    @include('plantillas.Detalle_categoria')
@endsection

@section('Table')
    {{-- <script>
        $(document).ready(function(){
            addGeneral('#addCategorias','categorias','#tCategoria',true);
            GetTablaSub('#tCategoria',"{{ url('TablaCategoria') }}");  
        })
    </script> --}}
@endsection

@section('Ruta')
    <li class="breadcrumb-item">
        Categoria
    </li>
@endsection
@section('diaco_title')
    DIACO
@endsection