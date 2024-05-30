@extends('dashboard.admindash')
@section('display')

<div class="container mt-3">
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
                    <button class="btn btn-primary" onclick="mostrarDocumentos({{ $orden->id }})">Mostrar Documentos</button>
                    <button class="btn btn-secondary" onclick="editarOrden({{ $orden->id }})" data-bs-toggle="modal" data-bs-target="#MyModal">Editar Orden</button>
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
                            <a href="{{ route('file/download', ['documento' => $documento->archivo]) }}" class="btn btn-primary">Descargar Archivo</a>
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

<!-- Modal -->
<div class="modal fade" id="editOrderModal" tabindex="-1" aria-labelledby="editOrderModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="editOrderModalLabel">Editar Orden Médica</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="editOrderForm" method="POST" action="{{ route('admin.modificar_ordenes.update', ['id' => $orden->id]) }}">
          @csrf
          @method('PATCH')
          <input type="hidden" id="editOrderId" name="order_id">
          <!-- rut del paciente-->
          <div class="mb-3 mt-3">
            <x-input-label for="editRut" :value="__('RUT')" class="form-label" />
            <x-text-input id="editRut" class="form-control" type="text" name="Rut" :value="old('Rut')" />
            <x-input-error :messages="$errors->get('Rut')" class="mt-2" />
          </div>
          <button type="button" class="add-btn btn btn-primary">Agregar detalle</button>
          <!-- detalles de la orden-->
          <div id="editDetallesContainer">
            <div class="detalle">
                <label for="detail" class="form-label">Detalle de la orden</label>
                <input type="text" name="detalle[]" class="form-control" placeholder="Detalle de la orden">
                <button type="button" class="remove-btn btn btn-danger" style="display: none;">Eliminar detalle</button>
                <br>
            </div>
          </div>
          <br>
          <div class="mb-3 mt-3">
            <button type="button" onclick="validateForm()" class="btn btn-success">
              {{ __('Actualizar') }}
            </button>
          </div>
          <br>
        </form>
      </div>
    </div>
  </div>
</div>


<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js"></script>

<script>
function mostrarDetalles(ordenId) {
    var detalles = document.getElementById('detalles-' + ordenId);
    detalles.style.display = detalles.style.display === 'none' ? 'block' : 'none';
}

function mostrarDocumentos(ordenId) {
    var documentos = document.getElementById('examens-' + ordenId);
    documentos.style.display = documentos.style.display === 'none' ? 'block' : 'none';
}

function editarOrden(ordenId) {
    // Obtener los datos de la orden usando AJAX
    fetch('/api/ordenes/' + ordenId)
        .then(response => response.json())
        .then(data => {
            // Llenar el formulario del modal con los datos de la orden
            document.getElementById('editOrderId').value = ordenId;
            document.getElementById('editRut').value = data.patient_id;

            var detallesContainer = document.getElementById('editDetallesContainer');
            detallesContainer.innerHTML = '';
            data.detalles.forEach(detalle => {
                var detalleDiv = document.createElement('div');
                detalleDiv.classList.add('detalle');
                detalleDiv.innerHTML = `
                    <br>
                    <div class="container-fluid remove-btn">
                        <div class="row">
                            <div class="col-sm-9">
                                <input type="text" name="detalle[]" class="form-control extra-detail" value="${detalle.detalle}" placeholder="Detalle de la orden">
                            </div>
                            <div class="col-sm-3">
                                <button type="button" class="remove-btn btn btn-danger btn-sm"> [ X ] </button>
                            </div>
                        </div>
                    </div>
                `;
                detallesContainer.appendChild(detalleDiv);
            });

            // Mostrar el modal
            var editOrderModal = new bootstrap.Modal(document.getElementById('editOrderModal'));
            editOrderModal.show();
        });
}

function validateForm() {
    const rutInput = document.getElementById('editRut');
    const rutValue = rutInput.value;

    if (rutValue.length < 8 || rutValue.length > 9 || !rutValue.match(/^\d+$/)) {
        alert("El Rut debe tener entre 8 y 9 caracteres y contener solo números");
        return false;
    }

    // Verifica que al menos haya un detalle ingresado
    const detalles = document.querySelectorAll('input[name="detalle[]"]');
    let hasDetalle = false;
    detalles.forEach(detalle => {
        if (detalle.value.trim() !== '') {
            hasDetalle = true;
        }
    });

    if (!hasDetalle) {
        alert("Debe ingresar al menos un detalle para la orden.");
        return false;
    }

    alert("Orden actualizada! Volviendo al dashboard.");
    document.getElementById('editOrderForm').submit();
}

document.addEventListener('DOMContentLoaded', function () {
    const detallesContainer = document.getElementById('editDetallesContainer');

    detallesContainer.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-btn')) {
            e.target.closest('.detalle').remove();
            checkButtons(e.target.closest('.detalle'));
        }
    });

    function checkButtons(detalle) {
        const removeButton = detalle.querySelector('.remove-btn');
        const removeButtons = detalle.parentNode.querySelectorAll('.remove-btn');

        removeButtons.forEach((button, index) => {
            if (button === removeButton) {
                button.style.display = 'none';
            } else {
                button.style.display = 'inline-block';
            }
        });
    }

    document.querySelector('.add-btn').addEventListener('click', function () {
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
        checkButtons(newDetalle);
    });
});
</script>
@endsection