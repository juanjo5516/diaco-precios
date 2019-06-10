@extends('layouts.app')


@section('contenido')
    @include('plantillas.Dmercados')
@endsection

@section('Table')
    <script>
        $(document).ready(function(){
            addGeneral('#addMercados','DetalleMercados','#tMercados');
            GetTabla('#tMercados',"{{ url('TablaMercados') }}");  
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