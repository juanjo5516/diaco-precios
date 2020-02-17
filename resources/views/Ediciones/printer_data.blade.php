<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>pdf</title>
    <link rel="stylesheet" href="{{public_path('css/css/bootstrap.min.css')}}">
    <style>
        /* @page { margin: 4em 1em 4em 1em; } */
        
        
        .table {
            font-family: verdana !important;
            font-size: 12px;
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
            
        .tableData{
                padding-bottom: 10px;
                width:100% !important;
            }


        .tableData img{
                padding: 0 auto;
                margin:0 auto;
                width:200px;
                
            }
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

    </style>
</head>
<body>
    <div >
                <table class="tableData" >
                    <tr>
                        <td style="width:30%;"><img src="{{public_path('img/Ndiaco.jpg')}}" alt="diaco"></td>
                        <td style="width:40%;">
                            <p>
                                Dirección de Atención y Asistencia al Consumidor -DIACO-
                            </p> 
                            <br>
                            <p>Ministerio de Economia</p>
                        </td>
                        <td style="width:30%;"><img src="{{public_path('img/Ndiaco.jpg')}}" alt="diaco" ></td>
                    </tr>
                </table>

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
            <!-- @foreach ($categoria as $dataCategoria)
                               
                @if ($dataCategoria->type_verify == 'Gas propano')
                    <table class="table   table-bordered descripcion border" >
                        <thead>
                            
                            <tr >
                                <th style="width:2%">No.</th>
                                <th >Nombre</th>
                                <th >Dirección</th>
                                <th >Departamento</th>
                            </tr>
                        </thead>
                        <tbody>
                                @for ($i = 1; $i <= $Ncolumna; $i++)
                                        <tr > 
                                            <td >{{ $i}}</td>
                                            <td ></td>
                                            <td ></td>
                                            <td ></td>
                                        </tr>
                                @endfor
                        </tbody>
                    </table> 
                @endif
            @endforeach            -->
                <div class="card">
                    <div class="card-body">
                        @foreach ($categoria as $dataCategoria)
                                    @if ($dataCategoria->paso == '0' && $dataCategoria->type_verify == 'Mercado')
                                        <table class="table table-sm  table-bordered descripcion border" >
                                            @for($index=0; $index < count($category_mer); $index++)
                                                <thead>
                                                    <tr>
                                                        <th colspan="3" class="categoria">{{ $category_mer[$index]->nombre }} </th>
                                                    </tr> 
                                                    <tr >
                                                        <th style="width:8%;text-align: center;">No.</th>
                                                        <th >Establecimiento</th>
                                                        <th style="width:10%">No. Local</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @for ($i = 1; $i <= $Ncolumna; $i++)
                                                    <tr > 
                                                        <td >{{ $i }}</td>
                                                        <td ></td>
                                                        <td ></td>
                                                    </tr>
                                                    @endfor 
                                                    <tr style="border:none !important;">
                                                        <td colspan="3" style="border:none !important;">
                                                            <table class="table table-bordered descripcion border table-sm" >
                                                                <thead>
                                                                    <tr>
                                                                        <th>
                                                                            Producto
                                                                        </th>
                                                                        <th>
                                                                            Medida
                                                                        </th>
                                                                            @for ($i = 1; $i <= $Ncolumna; $i++)
                                                                                    <th > Visita {{ $i }} </th>
                                                                            @endfor
                                                                    </tr>
                                                                </thead>
                                                                <tbody>
                                                                    @foreach ($coleccion as $item)
                                                                        @if ($item->categoria == $category_mer[$index]->nombre)
                                                                                <tr class="my-1">
                                                                                    <td >
                                                                                        {{ $item->produto }}
                                                                                    </td>
                                                                                    <td >
                                                                                        {{ $item->medida }}
                                                                                    </td>
                                                                                    @for ($i = 1; $i <= $Ncolumna; $i++)    
                                                                                        <td >
                                                                                            &nbsp;
                                                                                        </td>
                                                                                    @endfor
                                                                                </tr> 
                                                                        @endif
                                                                    @endforeach
                                                                    <div style="page-break-after:always;"></div>
                                                                    <!-- <tr>
                                                                        <td colspan="7"></td>
                                                                    </tr> -->
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            @endfor
                                        </table>
                                        
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
                                        
                                    @endif
                        @endforeach
                    </div>
                </div>
        </div>
    </body>
</html>

