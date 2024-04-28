@extends('dashboard.medicdash')

@section('display')
        
        <div class="container mt-3">
            <h1>Ingresar Orden Medica</h1>
            <form method="POST" action="/medic/crearOrdenes">
            @csrf
            <!-- Nombre Paciente -->
            <div class="mb-3 mt-3">
                <x-input-label for="name" :value="__('Nombre')" />
                <x-text-input id="name" class="form-control" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Rut del paciente-->
            <div class="mb-3 mt-3">
                <x-input-label for="rut" :value="__('Rut')" />
                <x-text-input id="rut" class="form-control" type="rut" name="rut" :value="old('rut')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('rut')" class="mt-2" />
            </div>

            <!-- Fecha de Emision -->
            <div class="mb-3 mt-3">
                <x-input-label for="fecha_emision" :value="__('Fecha de Emision')" />
                <x-text-input id="fecha_emision" class="form-control"
                                type="date"
                                name="fecha_emision"
                                required />

                <x-input-error :messages="$errors->get('fecha_emision')" class="mt-2" />
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
                <x-input-label for="indicaciones" :value="__('Indicaciones Medicas')" />

                <x-text-input id="indicaciones" class="form-control"
                                type="password"
                                name="indicaciones" required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('indicaciones')" class="mt-2" />
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