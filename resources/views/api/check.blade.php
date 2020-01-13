@extends('layouts.app')
@section('contenido')
    @include('api.detalle')
@endsection

@section('Ruta')
    <li class="breadcrumb-item">
        Api
    </li>
@endsection
@section('diaco_title')
    DIACO
@endsection