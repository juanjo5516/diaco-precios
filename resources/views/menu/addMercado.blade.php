@extends('layouts.app')


@section('contenido')
    @include('plantillas.mercados')
@endsection

@section('Table')
    <script>
        $(document).ready(function(){
            
            
            TablaVacia('#TDProductos');
            //addGeneral('#addProductos','addProducto','#TDProductos');
            //GetTablaSub('#TDProductos',"{{ url('Productos') }}");

            $('#DproductoT').on( 'submit', function (e) {
                
                e.preventDefault();
                var jsonData=$(this).serializeArray()
                    .reduce(function(a, z) { a[z.name] = z.value; return a; }, {});
                    producto = $("#Dproducto option:selected").text();
                    medida = $("#Dmedida option:selected").text();
                    precio = $("#Dprecio").val();
                    //alert($('select[name=Dproducto]').text());
                    //console.log($('select[name="DproductoT"] option:selected').text());
                    //console.log($(this));
                    //console.log(jsonData);
                AddColumna(jsonData,producto,medida,precio);
            });

            
            
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