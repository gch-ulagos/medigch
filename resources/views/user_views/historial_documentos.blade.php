@extends('dashboard.userdash')

@section('display')

<div class="container mt-3">
    <h1>Buscar orden médica</h1>
    <input type="text" id="search" class="form-control" placeholder="Buscar por RUT o detalle...">
    <div id="results" class="mt-3"></div>
</div>

<div class="container mt-3">
    <h2>Órdenes médicas recientes</h2>
    <div class="d-flex flex-column mt-3 mb-3 align-items-center" id="ordenes-container">
        @foreach ($ordenes as $orden)
        <div class="card order-card" style="width:400px">
            <div class="orden">
                <div class="card-header">
                    <p><b>Orden Nº</b> {{ $orden->id }}</p>
                    <p><b>RUT del Paciente:</b> {{ $orden->patient_id }}</p>
                </div>
                <div id="examens-{{ $orden->id }}" class="card-body">
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

<script>
document.addEventListener('DOMContentLoaded', function() {
    const searchInput = document.getElementById('search');
    const ordenesContainer = document.getElementById('ordenes-container');

    searchInput.addEventListener('input', function() {
        const query = searchInput.value;

        if (query.length > 0) {
            fetch(`/user/documentos/search?q=${query}`)
                .then(response => response.json())
                .then(data => {
                    ordenesContainer.innerHTML = '';
                    if (data.length > 0) {
                        data.forEach(orden => {
                            const orderElement = document.createElement('div');
                            orderElement.classList.add('card', 'order-card');
                            orderElement.style.width = '400px';
                            orderElement.innerHTML = `
                                <div class="orden">
                                    <div class="card-header">
                                        <p><b>Orden Nº</b> ${orden.id}</p>
                                        <p><b>RUT del Paciente:</b> ${orden.patient_id}</p>
                                    </div>
                                    <div id="examens-${orden.id}" class="card-body">
                                        ${orden.examens.length > 0 ? '<h3>Documentos</h3>' + orden.examens.map(documento => `
                                            <br>
                                            <p>${documento.archivo}</p>
                                            <p>Fecha y hora de subida: ${documento.created_at}</p>
                                            <a href="/file/download?documento=${documento.archivo}" class="btn btn-primary">Descargar archivo</a>
                                            <br>
                                        `).join('') : '<p>No hay documentos asociados a esta orden.</p>'}
                                    </div>
                                </div>`;
                            ordenesContainer.appendChild(orderElement);});
                    } else {
                        ordenesContainer.innerHTML = '<p>No se encontraron órdenes.</p>';
                    }});
        } else {
            location.reload();
        }});
});
</script>

@endsection

