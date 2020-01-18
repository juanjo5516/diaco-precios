@extends('layouts.app')
@section('contenido')
    <div class="row wow fadeIn">
        <div class="col-md-12 mb-12">
            <div class="card mb-12 border-shadow">
                <div class="card-header text-left">
                    Datos enviados por Sede
                </div>
                <div class="card-body">
                    <div class="container">
                        <submitdata-component></submitdata-component>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('diaco_title')
    DIACO
@endsection