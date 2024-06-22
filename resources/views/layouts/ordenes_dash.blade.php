<div class="ordenes">
  <h2>Órdenes médicas recientes</h2>
 @foreach ($ordenes as $orden) 
  <div class="d-flex flex-column mt-3 mb-3 align-items-center">
    <div class="card" style="width:400px">
      <div class="orden">
        <div class="card-header">
          <p><b>Orden Nº</b> {{ $orden->id }}</p>
          <p><b>RUT del paciente:</b> {{ $orden->patient_id }}</p>
        </div>
        <div class="card-body">
          <button class="btn btn-primary" onclick="mostrarDetalles({{ $orden->id }})">Mostrar detalles</button>
          <button class="btn btn-primary" onclick="mostrarDocumentos({{ $orden->id }})">Mostrar documentos</button>
          <div id="detalles-{{ $orden->id }}" class="card-footer mb-3 mt-3" style="display: none;">
            @php
            $detalles = DB::table('detalles')->where('order_id', $orden->id)->get();
            @endphp
            @if ($detalles->isNotEmpty())
              @foreach ($detalles as $detalle)
                <p>- {{ $detalle->detalle }}</p>
              @endforeach
            @else
              <p>No hay detalles asociados a esta orden.</p>
            @endif
          </div>
        </div>
      <div id="examens-{{ $orden->id }}" class="card-footer mb-3 mt-3" style="display: none;">
          {{-- Aquí se mostrarán los documentos de la orden --}}
          @php
              $documentos = DB::table('examens')->where('order_id', $orden->id)->get();
          @endphp
          @if ($documentos->isNotEmpty())
              <h3>Documentos</h3>
              @foreach ($documentos as $documento)
                <br>
                  <p>{{ $documento->archivo }}</p>
                  <p>Fecha y hora de subida: {{ $documento->created_at }}</p>
                  <a href="{{ route('file/download', ['documento' => $documento->archivo]) }}" class="btn btn-primary">Descargar archivo</a>
                  <br>
                  {{-- Agrega aquí el código necesario para mostrar el documento o un enlace para descargarlo --}}
              @endforeach
          @else
              <p>No hay documentos asociados a esta orden.</p>
          @endif
      </div>
      </div>
      </div>
    </div>
    <br>
    </div>
  </div>
  @endforeach

<script>
  function mostrarDetalles(ordenId) {
      var detalles = document.getElementById('detalles-' + ordenId);
      detalles.style.display = detalles.style.display === 'none' ? 'block' : 'none';
  }

  function mostrarDocumentos(ordenId) {
      var documentos = document.getElementById('examens-' + ordenId);
      documentos.style.display = documentos.style.display === 'none' ? 'block' : 'none';
  }
</script>
