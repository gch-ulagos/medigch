@extends('dashboard.medicdash')

@section('display')

<div class="container mt-3">
  <h2>Órdenes Médicas Recientes</h2>
  @foreach ($ordenes as $orden)
  <div class="orden">
      <p>Orden ID: {{ $orden->id }}</p>
      <p>Rut del Paciente: {{ $orden->patient_id }}</p>
      <button class="btn btn-primary" onclick="mostrarDetalles({{ $orden->id }})">Mostrar Detalles</button>
      <div id="detalles-{{ $orden->id }}" style="display: none;">
          {{-- Aquí se mostrarán los detalles del paciente --}}
      </div>
  </div>
  @endforeach
</div>

<script>
  function mostrarDetalles(ordenId) {
      var detalles = document.getElementById('detalles-' + ordenId);
      detalles.style.display = detalles.style.display === 'none' ? 'block' : 'none';
  }
</script>

@endsection