@extends('layouts.dashboard')

@section('content')
  <h2>Órdenes</h2>
  <p>Revisa las últimas órdenes creadas</p>
  <div class="flex-container">
    <div id="crearOrdenes" class="frame btn btn-primary">
      <a href="{{ route('medic/panel/crear_orden') }}" class="button big">Crear orden</a>
    </div>

    <div id="adjuntarDocumento" class="frame btn btn-primary">
      <a href="{{ route('medic/panel/adjuntar_doc') }}" class="button big">Adjuntar documentos</a>
    </div>

    <div id="verHistorial" class="frame btn btn-primary">
      <a href="{{ route('medic/modificar_ordenes') }}" class="button big">Modificar órdenes</a>
    </div>
   </div>
@endsection

