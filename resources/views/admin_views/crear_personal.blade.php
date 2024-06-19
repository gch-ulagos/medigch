@extends('dashboard.admindash')

@section('display')
        
        <div class="container mt-3">
            <h1>Crear Personal</h1>
            <form method="POST" action="/admin/crear_personal">
            @csrf

            <!-- Rut -->
            <div>
                <x-input-label for="Rut" :value="__('Rut')" />
                <x-text-input id="Rut" class="block mt-1 w-full" type="text" name="Rut" :value="old('Rut')" required autofocus autocomplete="Rut" />
                <x-input-error :messages="$errors->get('Rut')" class="mt-2" />
                <p class="text-sm text-gray-500">Sin puntos y sin guión, si su Rut termina en K, reemplácelo por un 0</p> <!-- Texto adicional -->
            </div>

            <!-- Nombre -->
            <div class="mb-3 mt-3">
                <x-input-label for="name" :value="__('Nombre')" />
                <x-text-input id="name" class="form-control" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
                <x-input-error :messages="$errors->get('name')" class="mt-2" />
            </div>

            <!-- Email -->
            <div class="mb-3 mt-3">
                <x-input-label for="email" :value="__('Email')" />
                <x-text-input id="email" class="form-control" type="email" name="email" :value="old('email')" required autocomplete="username" />
                <x-input-error :messages="$errors->get('email')" class="mt-2" />
            </div>

            <!-- Contraseña -->
            <div class="mb-3 mt-3">
                <x-input-label for="password" :value="__('Contraseña')" />

                <x-text-input id="password" class="form-control"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirmar contraseña -->
            <div class="mb-3 mt-3">
                <x-input-label for="password_confirmation" :value="__('Confirmar contraseña')" />

                <x-text-input id="password_confirmation" class="form-control"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
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
        alert("Usuario creado! Volviendo al dashboard.");
    }
    
</script>
@endsection