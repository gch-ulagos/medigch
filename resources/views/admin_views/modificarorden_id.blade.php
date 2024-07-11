@extends('dashboard.admindash')

@section('display')

<div class="container mt-3">
    <h1>Editar orden médica</h1>
    <form method="POST" action="{{ route('admin.modificar_ordenes.updateOrden') }}" enctype="multipart/form-data">
        @csrf
        @method('PATCH')

        <input type="hidden" name="order_id" value="{{ $orden->id }}">

        <!-- rut del paciente-->
        <div class="mb-3 mt-3">
            <x-input-label for="Rut" :value="__('RUT')" class="form-label" />
            <x-text-input id="Rut" class="form-control" type="text" name="Rut" value="{{ $orden->patient_id }}" readonly/>
            <x-input-error :messages="$errors->get('Rut')" class="mt-2" />
        </div>
        
        <!-- detalles de la orden-->
        <div id="detalles-container">
            @foreach($detalles as $detalle)
                <div class="detalle">
                    <label for="detail" class="form-label">Detalle de la orden</label>
                    <input type="text" name="detalle[]" class="form-control" value="{{ $detalle->detalle }}">
                    <button type="button" class="remove-btn btn btn-danger btn-sm"> [ X ] </button>
                    <br>
                </div>
            @endforeach
            <button type="button" class="add-btn btn btn-primary">Agregar detalle</button>
        </div>
        <br>

        <!-- archivos-->
        <div class="mb-3 mt-3">
            <label class="block mb-2 text-sm font-medium text-gray-900 dark:text-white" for="archivo">Archivos</label>
            <input class="block w-full text-sm text-gray-900 border border-gray-300 rounded-lg cursor-pointer bg-gray-50 dark:text-gray-400 focus:outline-none dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400"
            id="archivo" name="archivo[]" type="file" multiple>
        </div> 
        <br>

        <div id="documentos-container">
            @foreach($documentos as $documento)
                <div class="documento">
                    <br>
                    <p>{{ $documento->archivo }}</p>
                    <button type="button" class="remove-document-btn btn btn-danger btn-sm" data-document-id="{{ $documento->id }}"> [ X ] </button>
                </div>
            @endforeach
        </div>   
        
        <div class="mb-3 mt-3">
            <button type="submit" class="btn btn-success">
                {{ __('Actualizar') }}
            </button>
        </div>
        <br>
    </form>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const detallesContainer = document.getElementById('detalles-container');
        const documentosContainer = document.getElementById('documentos-container');
        const addBtn = document.querySelector('.add-btn');
        const form = document.querySelector('form');

        addBtn.addEventListener('click', function () {
            const newDetalle = document.createElement('div');
            newDetalle.classList.add('detalle');
            newDetalle.innerHTML = `
                <br>
                <div class="container-fluid remove-btn">
                    <div class="row">
                        <div class="col-sm-9">
                            <input type="text" name="detalle[]" class="form-control extra-detail" placeholder="Detalle de la orden">
                        </div>
                        <div class="col-sm-3">
                            <button type="button" class="remove-btn btn btn-danger btn-sm"> [ X ] </button>
                        </div>
                    </div>
                </div>
            `;
            detallesContainer.appendChild(newDetalle);
            checkButtons();
        });

        detallesContainer.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-btn')) {
                e.target.closest('.detalle').remove();
                checkButtons();
            }
        });

        documentosContainer.addEventListener('click', function (e) {
            if (e.target.classList.contains('remove-document-btn')) {
                const documentId = e.target.getAttribute('data-document-id');
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'remove_document_ids[]';
                input.value = documentId;
                e.target.closest('form').appendChild(input);
                e.target.closest('.documento').remove();
            }
        });

        form.addEventListener('submit', function (e) {
            e.preventDefault();
            validateForm();
        });

        function checkButtons() {
            const removeButtons = document.querySelectorAll('.remove-btn');
            removeButtons.forEach((button, index) => {
                if (index === 0) {
                    button.style.display = 'none';
                } else {
                    button.style.display = 'inline-block';
                }
            });
        }

        function validateForm() {
            const rutInput = document.getElementById('Rut');
            const rutValue = rutInput.value;

            if (rutValue.length < 8 || rutValue.length > 9 || !rutValue.match(/^\d+$/)) {
                alert("El Rut debe tener entre 8 y 9 caracteres y contener solo números");
                return false;
            }

            alert("Orden actualizada, volviendo al dashboard.");
            form.submit();
        }
    });
</script>

@endsection
