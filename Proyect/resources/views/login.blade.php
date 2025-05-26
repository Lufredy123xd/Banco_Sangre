@extends('layouts.auth')

@section('auth')
<header class="header">
    <img src="{{ asset('imgs/bloodbank-icon.svg') }}" alt="Ícono de vacuna">

    <form action="{{ route('login.authenticate') }}" method="post" class="form">
        @csrf
        <div>
            <label for="user_name">Usuario</label>
            <input 
                type="text" 
                name="user_name" 
                id="user_name" 
                required 
                minlength="3" 
                maxlength="20" 
                pattern="[A-Za-z0-9_]+" 
                title="El usuario debe tener entre 3 y 20 caracteres y solo puede contener letras, números y guiones bajos.">

            <label for="password">Contraseña</label>
            <input 
                type="password" 
                name="password" 
                id="password" 
                required 
                minlength="6" 
                maxlength="50" 
                title="La contraseña debe tener al menos 6 caracteres y un máximo de 50.">
        </div>

        <button type="submit" id="btn__ingresar">Ingresar</button>

        {{-- <a href="{{ route('password.form') }}">¿Has olvidado la contraseña?</a> --}}
    </form>

    @if ($errors->any())
        <div class="error-messages">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif
</header>
@endsection
