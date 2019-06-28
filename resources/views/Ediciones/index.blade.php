@extends('layouts.app')


@section('contenido')
    @include('plantillas.edicion')
@endsection

@section('Table')
    <script>
        $(document).ready(function(){
            addGeneral('#vue-vaciado','addPlantillas','#vue-table-productos',false);
            // GetTablaSub('#tCategoria',"{{ url('TablaCategoria') }}");  
            producto2 = '@foreach ($producto as $item) <option  value="{{ $item->id }}">{{ $item->Pnombre }}</option> @endforeach';
            medida2 = '@foreach ($medida as $medidas) <option  value="{{ $medidas->id }}">{{ $medidas->nombre }}</option> @endforeach ';
            TablaVacia('#vue-table-productos');
            $('#addLinea').on('click',function () {
                AddColumnaGeneral(producto2,medida2,'#vue-table-productos'); 
            });
        })
    </script>
@endsection

@section('Ruta')
    <li class="breadcrumb-item">
        Edición de Plantillas
    </li>
@endsection
@section('diaco_title')
    DIACO
@endsection