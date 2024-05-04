@extends('dashboard.medicdash')

@section('display')

        <div class="container mt-3">
            <h1>Ingresar Orden Medica</h1>
            <form method="POST" action="{{ route('medic/panel/crear_orden/store') }}">
            @csrf
            <!-- Rut del paciente-->
            <div class="mb-3 mt-3">
                <x-input-label for="Rut" :value="__('Rut')" />
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
                    <input type="text" name="detalle[]" placeholder="Detalle de la orden">
                    <button type="button" class="remove-btn" style="display: none;">Eliminar detalle</button>
                </div>
            </div>
            <button type="button" class="add-btn">Agregar más detalles</button>
            <button type="submit">Guardar Orden</button>


            <div class="flex items-center justify-end mt-3 mb-3">

                <x-primary-button onclick="alertaUsuario()" class="btn btn-primary">
                    {{ __('Registrar') }}
                </x-primary-button>
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
          <input type="text" name="detalle[]" placeholder="Detalle de la orden">
          <button type="button" class="remove-btn">Eliminar detalle</button>
        `;
        detallesContainer.appendChild(newDetalle);
        checkButtons();
      });
    
      detallesContainer.addEventListener('click', function (e) {
        if (e.target.classList.contains('remove-btn')) {
          e.target.parentElement.remove();
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
