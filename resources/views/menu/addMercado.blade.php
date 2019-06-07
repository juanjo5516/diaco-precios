@extends('layouts.app')


@section('contenido')
    @include('plantillas.Mercado')
@endsection

@section('Table')
    <script>
        $(document).ready(function(){
            
            
            TablaVacia('#TDProductos');
            //addGeneral('#addProductos','addProducto','#TDProductos');
            //GetTablaSub('#TDProductos',"{{ url('Productos') }}");

            // $('#DproductoT').on( 'submit', function (e) {
            //     e.preventDefault();
            //     var jsonData=$(this).serializeArray()
            //         .reduce(function(a, z) { a[z.name] = z.value; return a; }, {});
            //         producto = $("#Dproducto option:selected").text();
            //         medida = $("#Dmedida option:selected").text();
            //         precio = $("#Dprecio").val();
            //     AddColumna(jsonData,producto,medida,precio);
            // });
            producto = '<select name="Dproducto" id="Dproducto" class="form-control"> @foreach ($producto as $item) <option  value="{{ $item->id }}">{{ $item->Pnombre }}</option> @endforeach </select>';
            producto2 = '@foreach ($producto as $item) <option  value="{{ $item->id }}">{{ $item->Pnombre }}</option> @endforeach';
            medida = '<select name="Dmedida" id="Dmedida" class="form-control"> @foreach ($medida as $medidas) <option  value="{{ $medidas->id }}">{{ $medidas->nombre }}</option> @endforeach </select>';
            $('#addLinea').on('click',function () {
                AddColumna(producto2,medida);
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
                
                
                
                
                
                
                /*$('#Djson').text(ar.find('select,input,textarea').serialize());*/
                $('#Djson').text(JSON.stringify(json_obj));
            })
            
            
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