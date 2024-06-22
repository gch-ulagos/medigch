@extends('dashboard.userdash')

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

@endsection