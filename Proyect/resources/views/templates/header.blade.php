<header class="header">
    <div class="header__dropdown">
        <button class="header__dropdown-button">
            <img src="{{ asset ('imgs/dropdown.png')}}" alt="" class="header__dropdown-icon">
        </button>
        <nav class="header__nav">

        <a href="{{ route('password.form') }}" class="header__nav-link">Olvide mi contraseña</a>
            @if (session('tipo_usuario') === 'Administrador')
                <a href="{{ route('usuario.index') }}" class="header__nav-link">Gestionar Usuarios</a>
                <a href="{{ route('donante.index') }}" class="header__nav-link">Gestionar Donantes</a>

            @else
                <a href="{{ route('donante.index') }}" class="header__nav-link">Gestionar Donantes</a>
            @endif
            <a href="{{ route('logout') }}" class="header__nav-link">Cerrar sesión</a>
        </nav>
    </div>
    <div class="header__left">
        <img src="{{ asset ('imgs/vaccine_icon.png')}}" alt="vaccine" class="header__left-icon">
        <h1 class="header__left-title">BloodBank</h1>
    </div>

    <div class="header__right">
        <h2 class="header__right-title">{{ session('user_name', 'Usuario') }}</h2>
        <a href="#"><img src="{{ asset ('imgs/user_icon.png')}}" alt=""></a>
    </div>
</header>