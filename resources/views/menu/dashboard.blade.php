@extends('layouts.app')

@section('contenido')
    @include('dashboard.chart')
@endsection 

@section('Table')
<script>
        $(document).ready(function(){
                var datos = {!! $chart !!} 
                console.log(datos);
                google.charts.load("current", {packages:["corechart"]});
                google.charts.setOnLoadCallback(drawChart);
                function drawChart() {
                var data = google.visualization.arrayToDataTable([
                    datos
                ]);

                var view = new google.visualization.DataView(data);
                view.setColumns([0, 1,
                                { calc: "stringify",
                                    sourceColumn: 1,
                                    type: "string",
                                    role: "annotation" },
                                2]);

                var options = {
                    title: "Density of Precious Metals, in g/cm^3",
                    width: 600,
                    height: 400,
                    bar: {groupWidth: "95%"},
                    legend: { position: "none" },
                };
                var chart = new google.visualization.BarChart(document.getElementById("barchart_values"));
                chart.draw(view, options);
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