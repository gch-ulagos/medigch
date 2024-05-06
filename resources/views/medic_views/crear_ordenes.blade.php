@extends('dashboard.medicdash')

@section('display')

        <div class="container mt-3">
            <h1>Ingresar Orden Medica</h1>
            <form method="POST" action="{{ route('medic/panel/crear_orden/store') }}">
            @csrf
            <!-- Rut del paciente-->
            <div class="mb-3 mt-3">
                <x-input-label for="Rut" :value="__('RUT')" class="form-label" />
                <x-text-input id="Rut" class="form-control" type="Rut" name="Rut" :value="old('Rut')"  />
                <x-input-error :messages="$errors->get('Rut')" class="mt-2" />
            </div>

            <!-- Indicaciones Medicas 
            <div class="mb-3 mt-3">
                <x-input-label for="Indicaciones" :value="__('Indicaciones')" />
                <x-text-input id="Indicaciones" class="form-control" type="text" name="Indicaciones" :value="old('Indicaciones')"  />
                <x-input-error :messages="$errors->get('Indicaciones')" class="mt-2" />
            </div>-->

            <div id="detalles-container">
                <div class="detalle">
                    <label for="detail" class="form-label">Detalle de la orden</label>
                    <input type="text" name="detalle[]" class="form-control">
                    <button type="button" class="remove-btn btn btn-danger" style="display: none;">Eliminar detalle</button>
                    <br>
                    <button type="button" class="add-btn btn btn-primary">Agregar detalle</button>
                </div>
            </div>
            <br>
            <div class="mb-3 mt-3">
                <button onclick="alertaUsuario()" class="btn btn-success">
                    {{ __('Registrar') }}
                </button>
            </div>
            <br>
        </form>
    </div>

    @method('PUT')

<script>
    document.addEventListener('DOMContentLoaded', function () {
      const detallesContainer = document.getElementById('detalles-container');
      const addBtn = document.querySelector('.add-btn');
    
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

      function alertaUsuario(){
        alert("Orden! Volviendo al dashboard.");
    }
    });
</script>
    
@endsection
