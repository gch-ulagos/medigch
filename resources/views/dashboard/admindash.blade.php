@extends('layouts.dashboard')

@section('content')
  <h2>Gestión de plataforma</h2>
  <p>Gestionar órdenes médicas</p>
  <div class="flex-container">
    <div id="manejarÓrdenes" class="frame btn btn-primary">
      <a href="/admin/modificar_orden" class="button big">Modificar órdenes</a>
    </div>
    <div id="manejarPersonal" class="frame btn btn-primary">
      <a href="/admin/crear_personal" class="button big">Crear personal</a>
    </div>
   </div>

@endsection
