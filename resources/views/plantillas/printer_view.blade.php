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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/element-ui/2.8.2/theme-chalk/index.css">
    

</head>

<body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show">
    
    <div class="app-body">
        <main  class="main">
            <div  class="container-fluid">
                <div id="main">
                    
                        <div class="main" class="content-wrapper container-fluid ">
                                <div class="col-md-12 col-lg-12 col-12 col-sm-12">
                                    
                                    <printer-component 
                                        :fecha="{{ json_encode($fecha) }}" 
                                        :usuario = "{{ json_encode($usuario)}}" 
                                        :coleccion = "{{ json_encode($coleccion) }}"
                                        :categoria = "{{ json_encode($categoria) }}"
                                        ></printer-component>
                                </div>
                            </div>
                </div>
            </div>
        </main>

    </div>

    <!-- Scripts -->
    
    <script src="{{ asset('js/custom.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.18/b-1.5.6/b-colvis-1.5.6/b-flash-1.5.6/b-html5-1.5.6/fc-3.2.5/fh-3.1.4/r-2.2.2/datatables.min.js"></script>
    <script src="{{ asset('js/Datatables/TableProducto.js') }}"></script>
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    


</body>

</html>

