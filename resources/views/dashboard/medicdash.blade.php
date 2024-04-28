@extends('layouts.dashboard')

@section('content')
  <h2>Órdenes</h2>
  <p>Revisa las últimas órdenes creadas</p>
  <div class="flex-container">
    <div id="crearOrdenes" class="frame btn btn-primary">
      <a href=# class="button big">Crear orden</a>
    </div>
    <div id="adjuntarDocumento" class="frame btn btn-primary">
      <a href="/admin/crear_personal" class="button big">Manejar personal</a>
    </div>
    <div id="verHistorial" class="frame btn btn-primary">
      <a href=# class="button big">Ver historial de órdenes</a>
    </div>
   </div>
@endsection