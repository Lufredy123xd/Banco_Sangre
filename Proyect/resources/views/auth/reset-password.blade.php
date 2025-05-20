@extends('layouts.auth')

@section('auth')
<header class="header">
    <img src="{{ asset('imgs/vaccine_icon.png') }}" alt="">

    <form action="{{ route('password.reset') }}" method="POST" class="form">
        @csrf
        
        <div>
            <label for="user_name">Usuario</label>
            <input type="text" name="user_name" value="{{ $UserName }}" readonly>

            <label for="new_password">Nueva Contraseña</label>
            <input type="password" name="new_password" required>

            <label for="new_password_confirmation">Confirmar Contraseña</label>
            <input type="password" name="new_password_confirmation" required>
        </div>
        <button class="btn">Restablecer contraseña</button>
        <a href="{{ route('donante.index') }}" class="reset-btn">Cancelar</a>
    </form>

    @if ($errors->any())
        <div class="error-messages">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    @if (session('mensaje'))
        <p class="success-message">{{ session('mensaje') }}</p>
    @endif
</header>
@endsection
