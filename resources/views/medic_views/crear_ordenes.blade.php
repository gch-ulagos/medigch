@extends('dashboard.medicdash')

@section('display')

        <div class="container mt-3">
            <h1>Ingresar Orden Medica</h1>
            <form method="POST" action="{{ route('medic/panel/crear_orden/store') }}">
            @csrf
            <!-- Nombre Paciente -->
            <div class="mb-3 mt-3">
                <x-input-label for="Nombre" :value="__('Nombre')" />
                <x-text-input id="Nombre" class="form-control" type="text" name="Nombre" :value="old('Nombre')"  />
                <x-input-error :messages="$errors->get('Nombre')" class="mt-2" />
            </div>

            <!-- Rut del paciente-->
            <div class="mb-3 mt-3">
                <x-input-label for="Rut" :value="__('Rut')" />
                <x-text-input id="Rut" class="form-control" type="Rut" name="Rut" :value="old('Rut')"  />
                <x-input-error :messages="$errors->get('Rut')" class="mt-2" />
            </div>


             <!-- Genero -->
             <div class="mb-3 mt-3">
                <x-input-label for="Genero" :value="__('Genero')" />
                <select id="Genero" class="form-control" name="Genero" required >
                <option value="masculino">Masculino</option>
                <option value="femenino">Femenino</option>

                </select>
                <x-input-error :messages="$errors->get('fecha_emision')" class="mt-2" />
            </div>

            <!-- Indicaciones Medicas -->
            <div class="mb-3 mt-3">
                <x-input-label for="Indicaciones" :value="__('Indicaciones')" />
                <x-text-input id="Indicaciones" class="form-control" type="text" name="Indicaciones" :value="old('Indicaciones')"  />
                <x-input-error :messages="$errors->get('Indicaciones')" class="mt-2" />
            </div>



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
    function alertaUsuario(){
        alert("Orden! Volviendo al dashboard.");
    }

</script>
@endsection
