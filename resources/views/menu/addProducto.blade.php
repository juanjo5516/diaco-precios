@extends('layouts.app')


@section('contenido')
    @include('plantillas.containerCProducto')
@endsection

@section('Table')
    <script>
        $(document).ready(function(){
            addGeneral('#addProductos','addProducto','#tDatos',true);
            GetTablaSub('#tDatos',"{{ url('Productos') }}");
            
        })
    </script>
@endsection

@section('Ruta')
    <li class="breadcrumb-item">
        Productos
    </li>
@endsection
@section('diaco_title')
    DIACO
@endsection