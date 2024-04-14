<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>crear personal</title>
</head>
<body>
    <div class="container">
        <h1>Crear Personal</h1>
        <a href="#" class="btn">Registro de Órdenes</a>
        <a href="/admin/crear_personal" class="btn">Crear Personal</a>
        <a href="#" class="btn">Editar Usuarios</a>

        <form method="POST" >
        @csrf

        <!-- Name -->
        <div>
            <x-input-label for="name" :value="__('Name')" />
            <x-text-input id="name" class="block mt-1 w-full" type="text" name="name" :value="old('name')" required autofocus autocomplete="name" />
            <x-input-error :messages="$errors->get('name')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input id="email" class="block mt-1 w-full" type="email" name="email" :value="old('email')" required autocomplete="username" />
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="password" :value="__('Password')" />

            <x-text-input id="password" class="block mt-1 w-full"
                            type="password"
                            name="password"
                            required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <!-- Confirm Password -->
        <div class="mt-4">
            <x-input-label for="password_confirmation" :value="__('Confirm Password')" />

            <x-text-input id="password_confirmation" class="block mt-1 w-full"
                            type="password"
                            name="password_confirmation" required autocomplete="new-password" />

            <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
        </div>
        <div class="mt-4">
            <label for="Roles" class="block mt-1 w-full">Rol del usuario</label>
                <select name="Roles" id="Roles">
                    <option value="admin">Admin</option>
                    <option value="medic">Médico</option>
                    <option value="user">Usuario</option>
                </select>
        </div>



        
        <div class="flex items-center justify-end mt-4">

            <x-primary-button class="ms-4">
                {{ __('Registrar') }}
            </x-primary-button>
        </div>
    </form>







        <form method="POST" action="{{ route('logout') }}" id="logoutButton">
            @csrf
              <a class="nav-link active"><input type="submit" class="btn btn-danger btn-sm" id="logoutButton" value="Desconectarse"></a>
        </form>
    </div>
</body>
</html>
