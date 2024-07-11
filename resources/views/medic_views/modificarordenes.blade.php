@extends('dashboard.medicdash')

@section('display')

<div class="container mt-3">
    <h1>Buscar orden directamente</h1>
    <form id="search-form" action="{{ route('medic.modificar_ordenes.search') }}" method="GET">
        <input type="text" id="order-id-input" name="search" placeholder="Introduzca el id">
        <button type="submit">Buscar</button>
    </form>
</div>

<div class="container mt-3">
    <h2>Órdenes médicas recientes</h2>
    <div class="d-flex flex-column mt-3 mb-3 align-items-center">
        @foreach ($ordenes as $orden)
        <div class="card" style="width:400px">
            <div class="orden">
                <div class="card-header">
                    <p><b>Orden Nº</b> {{ $orden->id }}</p>
                    <p><b>RUT del paciente:</b> {{ $orden->patient_id }}</p>
                </div>
                <div class="card-body">
                    <button class="btn btn-primary" onclick="mostrarDetalles({{ $orden->id }})">Mostrar detalles</button>
                    <button class="btn btn-primary" onclick="mostrarDocumentos({{ $orden->id }})">Mostrar documentos</button>
                    <a class="btn btn-secondary" href="{{ route('admin.modificar_ordenes.ordenInfo', ['id' => $orden->id]) }}">Editar orden</a>
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
                        @endforeach
                    @else
                        <p>No hay documentos asociados a esta orden.</p>
                    @endif
                </div>
            </div>
        </div>
        <br>
        @endforeach
    </div>
</div>

@endsection

<script>
    function mostrarDetalles(ordenId) {
        var detalles = document.getElementById('detalles-' + ordenId);
        detalles.style.display = detalles.style.display === 'none' ? 'block' : 'none';
    }
  
    function mostrarDocumentos(ordenId) {
        var documentos = document.getElementById('examens-' + ordenId);
        documentos.style.display = documentos.style.display === 'none' ? 'block' : 'none';
    }

    document.addEventListener('DOMContentLoaded', function () {
        const searchForm = document.getElementById('search-form');
        const orderIdInput = document.getElementById('order-id-input');

        searchForm.addEventListener('submit', function (event) {
            event.preventDefault(); // Prevenir el envío del formulario

            const orderId = orderIdInput.value.trim();

            fetch(`{{ route('medic.modificar_ordenes.check', '') }}/${orderId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.found) {
                        searchForm.submit(); // Enviar el formulario después de confirmar que la orden existe
                    } else {
                        alert("Orden no encontrada, introduzca una orden válida");
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert("Ocurrió un error al buscar la orden. Por favor, inténtelo de nuevo.");
                });
        });
    });
  </script>