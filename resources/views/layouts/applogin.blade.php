<!DOCTYPE html>
<html lang="en">
<head>
    <base href="./admin">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="description" content="CoreUI - Laravel">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('diaco_title')</title>
    <link href="{{ asset('css/app.css') }}" rel="stylesheet"> 
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom_login.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/element-ui/2.8.2/theme-chalk/index.css">
    
    
</head>
<!-- <body class="app header-fixed sidebar-fixed aside-menu-fixed sidebar-lg-show"> -->
<body >
    {{-- @include('common.header')    --}}
    <div class="container container_login">
        <!-- <main class="main" id="main"> -->
        <main id="main">
            <!-- {{-- <div  class="container"> --}} -->
               
                    @yield('content')
                
            <!-- {{-- </div>  --}} -->
        </main>
    </div>
</body>
</html>