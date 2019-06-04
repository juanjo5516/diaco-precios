<!DOCTYPE html>
<html lang="en">

<head>
    <base href="./admin">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, shrink-to-fit=no">
    <meta name="description" content="CoreUI - Laravel">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('diaco_title')</title>

    <!-- Styles --> 
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.18/b-1.5.6/b-colvis-1.5.6/b-flash-1.5.6/b-html5-1.5.6/fc-3.2.5/fh-3.1.4/r-2.2.2/datatables.min.css"/>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet"> 
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
        integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
    

</head>

<body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
    @include('common.header')
    <div class="app-body">
        <div class="sidebar">

            @include('common.sidebar')

            <button class="sidebar-minimizer brand-minimizer" type="button"></button>
        </div>
        <main class="main">

            <ol class="breadcrumb">
                <li class="breadcrumb-item">Home</li>
                <li class="breadcrumb-item">
                    <a href="#">Admin</a>
                </li>
                <li class="breadcrumb-item active">Dashboard</li>

                <li class="breadcrumb-menu d-md-down-none">
                    <div class="btn-group" role="group" aria-label="Button group">
                        <a class="btn" href="#">
                            <i class="icon-speech"></i>
                        </a>
                        <a class="btn" href="./">
                            <i class="icon-graph"></i> &nbsp;Dashboard</a>
                        <a class="btn" href="#">
                            <i class="icon-settings"></i> &nbsp;Settings</a>
                    </div>
                </li>
            </ol>
            <div class="container-fluid">
                <div id="ui-view">
                @include('common.containerCProducto')
                </div>
            </div>
        </main>

    </div>
    @include('common.footer')
    <!-- Scripts -->

    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('js/custom.js') }}"></script>

    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.18/b-1.5.6/b-colvis-1.5.6/b-flash-1.5.6/b-html5-1.5.6/fc-3.2.5/fh-3.1.4/r-2.2.2/datatables.min.js"></script>
    
<script>
    $(document).ready(function(){
        addProducto('#addProductos');
        GetTabla('#tDatos');
        
    })

   

            function GetTabla(tabla){
                
                var table =  $(tabla).DataTable( {
        
                    "searching": true,
                    "destroy": true,
                    responsive: true,
                    "serverSide": true,
                    "ajax": "{{ url('Producto') }}",
                    "type" : "GET",
                    'dataType': 'json',
                    "columns": [
                        { data: 'ID' , width: 100},
                        { data: 'Pnombre' ,width: 100},
                    ],
                    dom: 'Bfrtip',
                    lengthMenu: [
                        [ 5,10, 25, 50, -1 ],
                        [ '5 Filas','10 Filas', '25 Filas', '50 Filas', 'Todo' ]
                    ],
                    buttons: [
                        
                        
                        {
                            extend:'excel',
                            className: 'btn-success',
                            init: function(api, node, config) {
                            $(node).removeClass('btn-secondary')
                            }
                        },
                        {
                            extend:'pageLength',
                            className: 'btn-primary',
                            init: function(api, node, config) {
                            $(node).removeClass('btn-secondary')
                            }
                        }
                    ],
                    "language": {
                        buttons: {
                        pageLength: {
                            _: "Mostrar %d Registros",
                            '-1': "Todos"
                            }
                        },
                        "lengthMenu": "Display _MENU_ records",
                        "info": "_TOTAL_ registros",
                        "search": "Buscar",
                        "paginate": {
                            "next": ">>",
                            "previous": "<<",
                        },
                        "loadingRecords": "Cargando...",
                        "processing": "Procesando...",
                        "emptyTable": "No hay datos",
                        "zeroRecords": "No hay coincidencias",
                        "infoEmpty": "Mostrando registros del …un total de 0 registros",
                        "infoFiltered": "(filtrado de un total de _MAX_ registros)"
                    
                    }       
                });

                

                // table.columns().every( function () {
                //     var that = this;

                //         $( 'input', this.footer() ).on( 'keyup change', function () {
                //             if ( that.search() !== this.value ) {
                                
                //                 that
                                    
                //                     .search( this.value )
                //                     .draw();
                //             }
                //         });
                //     } );
            }


</script>

</body>

</html>
