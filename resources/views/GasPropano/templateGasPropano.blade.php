@extends('layouts.app')


@section('contenido')
    @include('plantillasGasPropano.detallePropano')
@endsection

@section('Table')
    {{-- <script>
        $(document).ready(function(){
            addGeneral('#addMercados','DetalleMercados','#tMercados',true);
            GetTabla('#tMercados',"{{ url('TablaMercados') }}");  
        })
    </script> --}}
@endsection

@section('Ruta')
    <li class="breadcrumb-item">
        Gas Propano
    </li>
@endsection
@section('diaco_title')
    DIACO
@endsection