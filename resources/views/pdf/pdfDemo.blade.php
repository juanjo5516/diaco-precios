@extends('layouts.app')

@section('contenido')
    {{-- @include('pdf.index')  --}}
    @include('Ediciones.printer_data') 
@endsection

@section('Ruta')
    <li class="breadcrumb-item">
        Información de Visita
    </li>
@endsection 
@section('diaco_title')
    DIACO
@endsection 