@extends('layouts.dashboard')

@section('content')
  <h2>Gestión de Plataforma</h2>
  <p>Gestionar órdenes médicas</p>
  <div class="frame-container">
    <div id="manejarOrdenes" class="frame">
      <a href=# class="button big">Manejar ordenes</a>
    </div>
    <div id="manejarPersonal" class="frame">
      <a href="/admin/crear_personal" class="button big">Manejar personal</a>
    </div>
    <div id="manejaPaciente" class="frame">
      <a href=# class="button big">Manejar pacientes</a>
    </div>
   </div>

@endsection