@extends('layouts.app')

@section('contenido')
    @include('dashboard.chart')
@endsection 

@section('Table')
<script>
        $(document).ready(function(){
            var analytics = {!! $chart !!}
            
            google.charts.load('current', {'packages':['corechart']});

            google.charts.setOnLoadCallback(drawChart);

            function drawChart()
            {
                var data = google.visualization.arrayToDataTable(analytics);
                console.log(data);
                
                var options = {
                title : 'data'
                };
                var chart = new google.visualization.PieChart(document.getElementById('pie_chart'));
                chart.draw(data, options);
            }
            
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