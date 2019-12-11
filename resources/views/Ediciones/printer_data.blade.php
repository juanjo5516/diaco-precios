<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>pdf</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
    <style>
        /* @page { margin: 50px 6px 200px 5px; } */
        
        /* html{
           font-family: verdana !important;
            font-size: 12px;
        } */
        /* .font-lg {
            font-size: 13px;
            font-weight:bold;
            text-align: center;
        }
        .text-center  {
            text-align: center;
        }
        .text-left  {
            text-align:left;
            border: 1px solid #ccc;
        }
        .w-number {
            width: 20px;
            text-align: center !important;
        } */
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
            padding: 1.25rem;
            }
            .border  tr, .border th, .border td{
                border: 1px solid #000 !important;
            }
        
        /*    .card-header {
            padding: 0.75rem 1.25rem;
            margin-bottom: 0;
            background-color: rgba(0, 0, 0, 0.03);
            border-bottom: 1px solid rgba(0, 0, 0, 0.125);
            } */

            /* .card-header:first-child {
            border-radius: calc(0.25rem - 1px) calc(0.25rem - 1px) 0 0;
            }

            .card-header + .list-group .list-group-item:first-child {
            border-top: 0;
            }
             */
            
            
            .tableData{
                padding-bottom: 10px;
                /* border:1px solid $000; */
            }
    
            /* .tableData td{
                border:1px solid #000;
            } */

            .tableData img{
                padding: 0 auto;
                margin:0 auto;
                width:200px;
                
            }
            .tableData td p{
                width: 200;
                font-size: 14px;
                text-align: center;
            }
        /* .border th {
            border: 1px solid #ccc;
    
        } */
       
       /* .header{
            background-color: #dddddd !important;
           height:25px ;
        }   */
    </style>
</head>
<body>
    <div >
    <table class=" tableData">
        <tr>
            <td><img src="img/Ndiaco.jpg" alt="diaco"  ></td>
            {{-- <td><img src="{{ asset('img/Ndiaco.jpg') }}" alt="diaco"  ></td> --}}
            <td>
                <p>
                    Dirección de Atención y Asistencia al Consumidor -DIACO-
                </p> <br>
                <p>Ministerio de Economia</p>
            </td>
            <td><img src="img/Ndiaco.jpg" alt="diaco" ></td>
            {{-- <td><img src="{{ asset('img/Ndiaco.jpg') }}" alt="diaco" ></td> --}}
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
            @foreach ($categoria as $dataCategoria)
            <table class="table my-3  table-bordered descripcion border" >
                <thead>
                    <tr >
                        <th >No.</th>
                        <th >Establecimiento</th>
                        <th >No. Local</th>
                    </tr>
                </thead>
                <tbody>
                        @for ($i = 1; $i <= $Ncolumna; $i++)
                                <tr > 
                                    <td ></td>
                                    <td ></td>
                                    <td ></td>
                                </tr>
                        @endfor
                </tbody>
            </table>
            <div class="card">
                <div class="card-body">
                    <table class="table border table-sm">
                        <tr>
                                <td>
                                    {{ $dataCategoria->categoria }} 
                                </td>
                            </tr>
                        </table>
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
                                    @if ($item->categoria == $dataCategoria->categoria)
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
                            </tbody>
                        </table>
                    </div>
                </div>
            @endforeach
        </div>
        </body>
        </html>