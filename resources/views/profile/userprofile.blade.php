@extends("layouts.dashboard")

@section("content")

    <h2>Mi perfil</h2>
    <P>Modifica tu correo o contraseña</P>
    <div class="flex-container">
        <form method="POST" action="{{ route('profile.update') }}">
            @csrf
            @method('PUT')

            <!-- Correo -->    
            <div class="form-group">
                <label for="email">Correo electrónico</label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" class="form-control">
                @error('email')
                 <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>

            <!-- Contraseña -->
            <div class="form-group">
                <x-input-label for="password" :value="__('Contraseña')" />

                <x-text-input id="password" class="form-control"
                                type="password"
                                name="password"
                                required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password')" class="mt-2" />
            </div>

            <!-- Confirmar contraseña -->
            <div class="form-group">
                <x-input-label for="password_confirmation" :value="__('Confirmar contraseña')" />

                <x-text-input id="password_confirmation" class="form-control"
                                type="password"
                                name="password_confirmation" required autocomplete="new-password" />

                <x-input-error :messages="$errors->get('password_confirmation')" class="mt-2" />
            </div>
    
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </form>
    </div>
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

@endsection