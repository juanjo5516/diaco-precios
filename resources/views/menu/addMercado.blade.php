@extends('layouts.app')


@section('contenido')
    @include('plantillas.Mercado')
@endsection

@section('Table')
    <script>
        $(document).ready(function(){
            TablaVacia('#TDProductos');
            producto = '<select name="Dproducto" id="Dproducto" class="form-control"> @foreach ($producto as $item) <option  value="{{ $item->id }}">{{ $item->Pnombre }}</option> @endforeach </select>';
            producto2 = '@foreach ($producto as $item) <option  value="{{ $item->id }}">{{ $item->Pnombre }}</option> @endforeach';
            medida = '<select name="Dmedida" id="Dmedida" class="form-control"> @foreach ($medida as $medidas) <option  value="{{ $medidas->id }}">{{ $medidas->nombre }}</option> @endforeach </select>';
            medida2 = '@foreach ($medida as $medidas) <option  value="{{ $medidas->id }}">{{ $medidas->nombre }}</option> @endforeach ';
            $('#addLinea').on('click',function () {
                AddColumna(producto2,medida2);
            });
            $('#almacenar').on('click',function(){               
                t = $('#TDProductos').DataTable().data();
                ar = $()
                var list = {
                'datos' :[]
                };
                for (var i = 0; i < t.rows()[0].length; i++) { 
                    ar = ar.add(t.row(i).node())
                }
                json_obj = {}
                ar.find('select,input,textarea').each(function(i, el) {
                    json_obj[$(el).attr('name')] = $(el).val();
                });
                paso = JSON.stringify(json_obj);
                /*LLenado a controler*/
                //addGeneral('#addVaciados','addProducto','#TDProductos')
                
                /*$('#Djson').text(ar.find('select,input,textarea').serialize());*/
                //$('#Djson').text(paso);
            })
            $('#mercadoVaciado').change(function(e){
                e.preventDefault();
                let parametros = $(this).serialize();
                ChangeAddress(parametros,'GetAddress','#direccionMercadoVaciado');
            });
            
            $('#establecimientoVaciado').change(function(e){
                e.preventDefault();
                let parametros = $(this).serialize();
                ChangeAddress(parametros,'GetAddressEstablecimiento','#direccionEstablecimientoVaciado')
            })
            addGeneral('#addVaciados','AddVaciadoMercado','#TDProductos',false)
            /*AddVaciadoMercado*/
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