@extends('layouts.app')


@section('contenido')
    @include('plantillas.Establecimiento')
@endsection

@section('Table')
    <script>
        $(document).ready(function(){
            addGeneral('#addEstablecimiento','addDestablecimiento','#tEstablecimiento',true);
            GetTabla('#tEstablecimiento',"{{ url('GetTablaEstablecimiento') }}");  
        })
    </script>
@endsection

@section('Ruta')
    <li class="breadcrumb-item">
        Establecimiento
    </li>
@endsection
@section('diaco_title')
    DIACO
@endsection