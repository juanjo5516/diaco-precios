@extends('layouts.app')


@section('contenido')
    @include('plantillas.DetalleSubCategoria')
@endsection

@section('Table')
    <script>
        $(document).ready(function(){
            addGeneral('#addSubCategorias','AddSubCategoria','#tSCategoria',true);
            GetTablaSub('#tSCategoria',"{{ url('TablaSubCategoria') }}");
            
        })
    </script>
@endsection

@section('Ruta')
    <li class="breadcrumb-item">
        Sub-Categoria
    </li>
@endsection
@section('diaco_title')
    DIACO
@endsection