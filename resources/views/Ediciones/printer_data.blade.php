<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    
    <link rel="stylesheet" href="{{public_path('css/css/bootstrap.min.css')}}">
    <style>
        /* @page { margin: 4em 1em 4em 1em; } */
        
        
        .table {
            font-family: verdana !important;
            font-size: 11px;
            width: 100%;
            border-spacing: 0;
            border-collapse: collapse;
            border: none;
            border-top: none !important;
            margin-bottom: none !important;
        }
        .card {
            position: relative;
            display: -webkit-box;
            display: -ms-flexbox;
            display: flex;
            -webkit-box-orient: vertical;
            -webkit-box-direction: normal;
            -ms-flex-direction: column;
            flex-direction: column;
            min-width: 0;
            word-wrap: break-word;
            background-color: #fff;
            background-clip: border-box;
            border: 1px solid rgba(0, 0, 0, 0.125);
            border-radius: 0.25rem;
            }
    
        .card-body {
            -webkit-box-flex: 1;
            -ms-flex: 1 1 auto;
            flex: 1 1 auto;
            }
        .border  tr, .border th, .border td{
                border: 1px solid #000 !important;
            }
            
        /* .tableData{
                padding-bottom: 10px;
                width:100% !important;
            } */

        /* .table img{
                width: 80%;
                
            } */
        .tableData td p{
                width: 300;
                font-size: 14px;
                text-align: center;
            }

        .categoria{
                text-align: center;
            }

        hr{
                color:#000 !important;
                margin-top:25px;
                background-color: #000 !important;
            }
        .text_center{
            text-align:center !important;
            width:5% !important;
        }

        .handler_data_header{
            text-align:center !important;
            width:35% !important;
        }
        .handler_data_prices{
            text-align:center !important;
            
        }

        .handler_data_table{
            padding-top: -20px;
        }

        .handle_title_document{
            text-align: center !important;
            font-size:2em;
            vertical-align: middle;
            margin-top:2em !important;
        }

        .table-borderless td,
            .table-borderless th {
                border: 0;
            }
        

    </style>
</head>
<body>
    <div>
        @foreach ($categoria as $dataCategoria)
            <table class="table" >
                <tr>
                    <td style="text-align:center"><img width="250px" height="80px" src="{{public_path('img/Ndiaco.jpg')}}" alt="diaco"  ></td>
                    <td style="text-align:center" class="handle_title_document">
                        <span ><br> Boleta de {{ $dataCategoria->type_verify}}</span>    
                    </td>
                    <td style="text-align:center"><img width="250px" height="80px" src="{{public_path('img/Ndiaco.jpg')}}" alt="diaco" ></td>
                </tr>
            </table>
        @endforeach
        <table class="table border" >
            <tr >
                <td colspan="7">
                    Fecha: <span>{{ $fecha }}</span>
                    <input type="hidden" name="fechaVaciado" value="12-25-25">
                </td>
                <td colspan="5">
                    Boleta No.: <span style="color:red;font-size:1.2em;"> {{ $correlativo }}</span>
                    
                </td>
            </tr>
            @foreach ($usuario as $item)
            <tr>
                <td>
                    Sede:
                </td>
                <td colspan="5"  >
                    {{ $item->sede }}
                </td>
                <td >
                    Verificador:
                </td>
                <td colspan="5"  >
                    {{ $item->nombre }} 
                    
                </td>
            </tr>
            @endforeach
        </table>   
        @foreach ($categoria as $dataCategoria)
                    @if ($dataCategoria->paso == '0' && $dataCategoria->type_verify == 'Mercado')
                        @foreach($category_mer as $rows)
                            <table class="table table-sm table-bordered border">
                                <thead>
                                    <tr>
                                        <th colspan="3" class="categoria"><h5 >{{ $rows->nombre }}</h5></th>
                                    </tr>
                                    <tr>
                                        <th class="text_center">No.</th>
                                        <th>Establecimiento</th>
                                        <th class="text_center">No. local</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($i = 1; $i <= $Ncolumna; $i++)
                                        <tr > 
                                            <td class="text_center">{{ $i }}</td>
                                            <td ></td>
                                            <td ></td>
                                        </tr>
                                    @endfor
                                    <tr>
                                        <td colspan="8">
                                            <table class="table table-sm">
                                                <thead>
                                                    <tr>
                                                        <th>Producto</th>
                                                        <th>Medida</th>
                                                        @for ($i = 1; $i <= $Ncolumna; $i++)
                                                            <th > Visita {{ $i }} </th>
                                                        @endfor
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($coleccion as $row)
                                                        @if($row->categoria == $rows->nombre)
                                                            <tr>
                                                                <td>{{ $row->produto }}</td>
                                                                <td>{{ $row->medida }}</td>
                                                                @for ($i = 1; $i <= $Ncolumna; $i++)    
                                                                    <td >
                                                                        &nbsp;
                                                                    </td>
                                                                @endfor
                                                            </tr>
                                                        @endif
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        @endforeach
                    @elseif($dataCategoria->type_verify == 'Gas Propano' && $dataCategoria->paso == '1')
                        <table class="table    table-bordered descripcion border" >
                            <thead>
                                <tr>
                                    <th colspan="3"></th>
                                    @for ($e = 0; $e < count($cat_pro_gas) ; $e++)
                                        <th colspan="{{ $cat_pro_gas[$e]->coulspan}}" class="categoria">{{ $cat_pro_gas[$e]->producto }}</th>
                                    @endfor
                                </tr>
                                <tr >
                                    <th style="width:2%">No.</th>
                                    <th style="width:20%">Nombre</th>
                                    <th style="width:20%">Dirección</th>
                                    @for ($e = 0; $e < count($cat_pro_gas) ; $e++)
                                        @for ($i = 0; $i < count($coleccion) ; $i++)
                                            @if($coleccion[$i]->produto == $cat_pro_gas[$e]->producto)
                                                <th style="font-size:10px;text-align: center;">{{$coleccion[$i]->medida}}</th>
                                            @endif
                                        @endfor
                                    @endfor
                                    
                                </tr>
                            </thead>
                            <tbody>
                                    
                                    @for ($i = 1; $i <= $Ncolumna; $i++)
                                            <tr > 
                                                <td >{{ $i}}</td>
                                                <td ></td>
                                                <td ></td>
                                                @for($fila = 0; $fila < count($coleccion) ; $fila++)
                                                    <td></td>
                                                @endfor
                                            </tr>
                                    @endfor
                            </tbody>
                        </table> 
                        <table class="table" >
                            <tr>
                                <td>
                                    Observaciones:  
                                </td>
                            </tr>
                            <tr>
                                <span>
                                    @for($linea = 1; $linea < 4; $linea++)
                                        <hr>
                                    @endfor
                                </span>
                            </tr>
                            
                        </table>
                    @elseif($dataCategoria->type_verify == 'Combustibles' && $dataCategoria->paso == '11')
                        <table class="table    table-bordered descripcion border" >
                            <thead>
                                <tr >
                                    <th style="width:2%">No.</th>
                                    <th style="width:20%">Nombre</th>
                                    <th style="width:20%">Dirección</th>
                                </tr>
                            </thead>
                            <tbody>
                                    
                                    @for ($i = 1; $i <= $Ncolumna; $i++)
                                            <tr > 
                                                <td >{{ $i}}</td>
                                                <td ></td>
                                                <td ></td>
                                            </tr>
                                    @endfor
                            </tbody>
                        </table> 
                        <table class="table    table-bordered descripcion border">
                            <thead>
                                <tr>
                                    <th ></th>
                                    @for ($e = 0; $e < count($type_category) ; $e++)
                                        <th colspan="{{ $type_category[$e]->coulspan}}" class="categoria">{{ $type_category[$e]->categoria }}</th>
                                    @endfor
                                </tr>
                                <tr>
                                    <th ></th>
                                    @for ($e = 0; $e < count($type_category) ; $e++)
                                        @for($con = 0; $con < count($data_pro_category); $con++)
                                            @if($type_category[$e]->categoria == $data_pro_category[$con]->category)
                                                <th colspan="{{ $data_pro_category[$con]->coulspan}}" class="categoria">{{ $data_pro_category[$con]->producto }}</th>
                                            @endif
                                        @endfor
                                    @endfor
                                </tr>
                            </thead>
                            <tbody>
                                    @for ($i = 1; $i <= $Ncolumna; $i++)
                                            <tr > 
                                                <td >{{ $i}}</td>
                                                
                                                @for($fila = 0; $fila < count($coleccion) ; $fila++)
                                                    <td></td>
                                                @endfor
                                            </tr>
                                    @endfor
                            </tbody>
                        </table>
                        
                    @elseif($dataCategoria->type_verify == 'Tienda de Barrio' && $dataCategoria->paso == '0')
                            <table class="table table-sm table-bordered border">
                                <thead>
                                    <tr>
                                        <th class="text_center">No.</th>
                                        <th>Establecimiento</th>
                                        <th>Dirección</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($i = 1; $i <= $Ncolumna; $i++)
                                        <tr > 
                                            <td class="text_center">{{ $i }}</td>
                                            <td ></td>
                                            <td ></td>
                                        </tr>
                                    @endfor
                                </tbody>
                            </table>
                            @foreach($category_mer as $rows)
                                <table class="table table-sm table-bordered border handler_data_table">
                                    <thead>
                                        <tr>
                                            <th class="handler_data_header">Producto - {{ $rows->nombre }}</th>
                                            <th class="handler_data_header">Medida</th>
                                            @for ($i = 1; $i <= $Ncolumna; $i++)
                                                <th class="handler_data_prices"> Visita {{ $i }} </th>
                                            @endfor
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($coleccion as $row)
                                            @if($row->categoria == $rows->nombre)
                                                <tr>
                                                    <td>{{ $row->produto }}</td>
                                                    <td>{{ $row->medida }}</td>
                                                    @for ($i = 1; $i <= $Ncolumna; $i++)    
                                                        <td >
                                                            &nbsp;
                                                        </td>
                                                    @endfor
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            @endforeach
                    @elseif($dataCategoria->type_verify == 'Super Mercado' && $dataCategoria->paso == '0')
                            <table class="table table-sm table-bordered border">
                                <thead>
                                    <tr>
                                        <th class="text_center">No.</th>
                                        <th>Establecimiento</th>
                                        <th>Dirección</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($i = 1; $i <= $Ncolumna; $i++)
                                        <tr > 
                                            <td class="text_center">{{ $i }}</td>
                                            <td ></td>
                                            <td ></td>
                                        </tr>
                                    @endfor
                                </tbody>
                            </table>
                            @foreach($category_mer as $rows)
                                <table class="table table-sm table-bordered border handler_data_table">
                                    <thead>
                                        <tr>
                                            <th class="handler_data_header">Producto - {{ $rows->nombre }}</th>
                                            <th class="handler_data_header">Medida</th>
                                            @for ($i = 1; $i <= $Ncolumna; $i++)
                                                <th class="handler_data_prices"> Visita {{ $i }} </th>
                                            @endfor
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($coleccion as $row)
                                            @if($row->categoria == $rows->nombre)
                                                <tr>
                                                    <td>{{ $row->produto }}</td>
                                                    <td>{{ $row->medida }}</td>
                                                    @for ($i = 1; $i <= $Ncolumna; $i++)    
                                                        <td >
                                                            &nbsp;
                                                        </td>
                                                    @endfor
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                            @endforeach
                    @elseif($dataCategoria->type_verify == 'Tortillería' && $dataCategoria->paso == '0')
                            <table class="table table-sm table-bordered border">
                                <thead>
                                    <tr>
                                        <th class="text_center">No.</th>
                                        <th>Nombre de la Tortillería</th>
                                        <th>Dirección</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @for ($i = 1; $i <= $Ncolumna; $i++)
                                        <tr > 
                                            <td class="text_center">{{ $i }}</td>
                                            <td ></td>
                                            <td ></td>
                                        </tr>
                                    @endfor
                                </tbody>
                            </table>
                            @foreach($category_mer as $rows)
                                <table class="table table-sm table-bordered border handler_data_table">
                                    <thead>
                                        <tr>
                                            <th class="handler_data_header">Producto - {{ $rows->nombre }}</th>
                                            <th class="handler_data_header">Medida</th>
                                            @for ($i = 1; $i <= $Ncolumna; $i++)
                                                <th class="handler_data_prices"> Visita {{ $i }} </th>
                                            @endfor
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($coleccion as $row)
                                            @if($row->categoria == $rows->nombre)
                                                <tr>
                                                    <td>{{ $row->produto }}</td>
                                                    <td>{{ $row->medida }}</td>
                                                    @for ($i = 1; $i <= $Ncolumna; $i++)    
                                                        <td >
                                                            &nbsp;
                                                        </td>
                                                    @endfor
                                                </tr>
                                            @endif
                                        @endforeach
                                    </tbody>
                                </table>
                                @endforeach
                                    <table class="table" >
                                        <thead>
                                            <tr>
                                                <th>
                                                    Observaciones:  
                                                </th>
                                            </tr>

                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td>
                                                <span>
                                                    @for($linea = 1; $linea < 4; $linea++)
                                                        <hr>
                                                    @endfor
                                                </span>
                                                </td>
                                            </tr>
                                        </tbody>
                                        
                                    </table>
                    @endif
        @endforeach
    </div>
</body>
</html>

