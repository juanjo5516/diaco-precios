@extends('layouts.app')


@section('contenido')
    @include('plantillas.DSmercado')
@endsection

@section('Table')
    <script>
        $(document).ready(function(){
            addGeneral('#addMercados','DetalleMercados','#tMercados',true);
            GetTabla('#tMercados',"{{ url('TablaMercados') }}");  
        })
    </script>
@endsection

@section('Ruta')
    <li class="breadcrumb-item">
        Super Mercado
    </li>
@endsection
@section('diaco_title')
    DIACO
@endsection