<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">
<style>
    @page { margin: 70px 20px; }
        
        html{
           font-family: verdana !important;
            font-size: 12px;
        }
        .font-lg {
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
        }
        table {
            font-family: verdana !important;
            font-size: 12px;
            width: 100%;
            border-spacing: 0;
            border-collapse: collapse;
            border: 1px solid #ccc;
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
            .card-header {
            padding: 0.75rem 1.25rem;
            margin-bottom: 0;
            background-color: rgba(0, 0, 0, 0.03);
            border-bottom: 1px solid rgba(0, 0, 0, 0.125);
            }

            .card-header:first-child {
            border-radius: calc(0.25rem - 1px) calc(0.25rem - 1px) 0 0;
            }

            .card-header + .list-group .list-group-item:first-child {
            border-top: 0;
            }
            
            .table {
                margin-bottom: 0 !important;
            }
            
            .tableData{
                padding-bottom: 25px;
                /* border:1px solid $000; */
            }
    
            .tableData td{
                border:1px solid #000;
            }
        /* .border th {
            border: 1px solid #ccc;
    
        }
       .header{
            background-color: #dddddd !important;
           height:25px ;
        }  */
    </style>


   
   
    {{-- <div > --}}
            {{-- <div class="card">
                <div class="card-body"> --}}
    <table class="tableData">
        <tr>
            <td style="">
            {{-- <img src="{{ asset('img/Ndiaco.jpg') }}" alt="diaco"  style="width: 30rem;"> --}}
            {{-- <img src="" alt="diaco" > --}}
           <img src="https://www.diaco.gob.gt/site/images/2018/LOGO/2018/Ndiaco.jpg" width="200" height="200">
            </td>
            <td>b</td>
            <td>c</td>
        </tr>
    </table>
                        <table class="table" >
                                <tr >
                                    <td colspan="12">
                                        Fecha: <span>{{ $fecha }}</span>
                                            <input type="hidden" name="fechaVaciado" value="12-25-25">
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
                {{-- </div>
            </div> --}}

            @foreach ($categoria as $dataCategoria)
                
            
            <div class="card">
                    
                    <div class="card-body">
                        <table class="table">
                            <tr>
                                <td>
                                        {{ $dataCategoria->categoria }}
                                </td>
                            </tr>
                        </table>
                            <table class="table table-bordered descripcion" >
                                    <thead>
                                            <tr>
                                                <th>
                                                    Producto
                                                </th>
                                                <th>
                                                    Medida
                                                </th>
                                                <th>
                                                    1
                                                </th>
                                                <th>
                                                    2
                                                </th>
                                                <th>
                                                    3
                                                </th>
                                                <th>
                                                    4
                                                </th>
                                                <th>
                                                    5
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($coleccion as $item)
                                            @if ($item->categoria == $dataCategoria->categoria)
                                            <tr >
                                                    <td >
                                                        {{ $item->produto }}
                                                    </td>
                                                    <td >
                                                        {{ $item->medida }}
                                                    </td>
                                                    <td >
                                                        &nbsp;
                                                    </td>
                                                    <td >
                                                        &nbsp;
                                                    </td>
                                                    <td >
                                                        &nbsp;
                                                    </td>
                                                    <td >
                                                        &nbsp;
                                                    </td>
                                                    <td >
                                                        &nbsp;
                                                    </td>
                                            </tr> 
                                            @endif
                                            @endforeach
                                            
                                        </tbody>
                            </table>
                    </div>
            </div>

            @endforeach
    {{-- </div> --}}

    {{-- <table>
            @if(!isset($header))
            <tr>
                <th colspan="7" class="text-center font-lg">RELACION DE CLIENTES</th>
            </tr>
            @endif
            <tr class="border">
                <th class="w-number header">N°</th>
                <th class="text-left header">Nombre</th>
                <th class="text-left header">Apellidos</th>
                <th class="w-60 header">N° DNI</th>
                <th class="w-60 header">Email</th>
                <th class="text-left header">Dirección</th>
                <th class="text-left header">Telefonos</th>
            </tr>
            @php
                $i =0;
            @endphp
            @foreach ($rows as $clients)

                <tr>
                    <td class="text-left">{{$i}}</td>
                    <td class="text-left">{{ $clients['name']}}</td>
                    <td class="text-left">{{ $clients['surnames']}}</td>
                    <td class="text-left">{{ $clients['number']}}</td>
                    <td class="text-left">{{ $clients['email']}}</td>
                    <td class="text-left">{{ $clients['address']}}</td>
                    <td class="text-left">{{ $clients['telephone']}}</td>
                </tr>
            @endforeach
    </table> --}}