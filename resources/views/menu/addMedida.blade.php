@extends('layouts.app')


@section('contenido')
    @include('plantillas.medida')
@endsection

@section('Table')
    <script>
        $(document).ready(function(){
            addGeneral('#addMedida','Medidas','#tMedida');
            GetTablaSub('#tMedida',"{{ url('TablaMedida') }}");  
        })
    </script>
@endsection

@section('Ruta')
    <li class="breadcrumb-item">
        Medida
    </li>
@endsection
@section('diaco_title')
    DIACO
@endsection