@extends('layouts.app')

@section('contenido')
    @include('dashboard.chart')
@endsection 

@section('Table')
<script>
        $(document).ready(function(){
                var datos = {!! $chart !!} 
                
                google.charts.load("current", {'packages':["corechart"]});
                google.charts.setOnLoadCallback(drawChart);
                function drawChart() {
                    var data = google.visualization.arrayToDataTable(datos);
                    console.log(datos);
                    var options = {
                        title: "Movimiento de los Precios en Verduras",
                        pieHole: 0.4,

                };
                var chart = new google.visualization.PieChart(document.getElementById("barchart_values"));
                chart.draw(data, options);
                };
        })

       
    </script>  
@endsection


@section('Ruta')
    <li class="breadcrumb-item">
        Categoria
    </li>
@endsection
@section('diaco_title')
    DIACO
@endsection