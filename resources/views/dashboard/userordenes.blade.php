@extends('layouts.dashboard')

@section('content')
  <h2>Mis órdenes</h2>
  <p>Revisa tus órdenes y tus documentos</p>
  <div class="flex-container">
    <div id="ordenesPaciente" class="frame btn btn-primary">
      <a href="{{ route('dashboard') }}" class="button big">Órdenes</a>
    </div>
    <div id="verDocumentos" class="frame btn btn-primary">
      <a href="{{ route('user/documentos') }}" class="button big">Documentos</a>
    </div>
   </div>
@endsection

@section('display')
@include('layouts.ordenes_dash')
@endsection