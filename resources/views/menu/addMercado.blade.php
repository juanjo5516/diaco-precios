@extends('layouts.app')


@section('contenido')
    @include('plantillas.mercados')
@endsection

@section('Table')
    <script>
        $(document).ready(function(){
            addGeneral('#addProductos','addProducto','#tDatos');
            GetTablaSub('#tDatos',"{{ url('Productos') }}");
            
        })
    </script>
@endsection

@section('Ruta')
    <li class="breadcrumb-item">
        Mercado
    </li>
@endsection
@section('diaco_title')
    DIACO
@endsection