@extends('dashboard.medicdash')

@section('display')
<div class="ordenes">
  <h2>Órdenes Médicas Recientes</h2>
<div class="d-flex flex-column mt-3 mb-3 align-items-center">
  @foreach ($ordenes as $orden)
  <div class="card" style="width:400px">
    <div class="orden">
      <div class="card-header">
        <p><b>Orden Nº</b> {{ $orden->id }}</p>
        <p><b>RUT del Paciente:</b> {{ $orden->patient_id }}</p>
      </div>
      <div class="card-body">
      <button class="btn btn-primary" onclick="mostrarDetalles({{ $orden->id }})">Mostrar Detalles</button>
      <div id="detalles-{{ $orden->id }}" class="card-footer mb-3 mt-3" style="display: none;">
          {{-- Aquí se mostrarán los detalles del paciente --}}
          @php
              $detalles = DB::table('detalles')->where('order_id', $orden->id)->get();
          @endphp
          @foreach ($detalles as $detalle)
              <p>- {{ $detalle->detalle }}</p>
          @endforeach
      </div> 
    </div>
    </div>
  </div>
  <br>
  @endforeach
  </div>
</div>

<script>
  function mostrarDetalles(ordenId) {
      var detalles = document.getElementById('detalles-' + ordenId);
      detalles.style.display = detalles.style.display === 'none' ? 'block' : 'none';
  }
</script>

@endsection