<header class="header">
    <div class="header__dropdown">
        <button class="header__dropdown-button">
            <img src="{{ asset('imgs/dropdown.png')}}" alt="" class="header__dropdown-icon">
        </button>
        <nav class="header__nav">
            @if (session('tipo_usuario') === 'Administrador')
                <a href="{{ route('usuario.index') }}" class="header__nav-link">Gestionar Usuarios</a>
                <a href="{{ route('donante.index') }}" class="header__nav-link">Gestionar Donantes</a>
            @else
                <a href="{{ route('donante.index') }}" class="header__nav-link">Gestionar Donantes</a>
            @endif
            <a href="{{ route('donacion.index') }}" class="header__nav-link">Listar Donaciones</a>
            <a href="{{ route('password.form') }}" class="header__nav-link">Cambiar contraseña</a>
            <a href="{{ route('logout') }}" class="header__nav-link">Cerrar sesión</a>
        </nav>
    </div>

    <div class="header__left">
        <img src="{{ asset('imgs/vaccine_icon.png')}}" alt="vaccine" class="header__left-icon">
        <h1 class="header__left-title">BloodBank</h1>
    </div>

    <div class="header__right">
        <a href="{{ route('notificacion.index') }}" class="header__notification-button" title="Notificaciones">
            <svg class="header__notification-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke="white">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V4a2 2 0 10-4 0v1.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
            @if($notificacionesPendientes > 0)
                <span class="notification-count">{{ $notificacionesPendientes }}</span>
            @endif
        </a>

        <h2 class="header__right-title">{{ session('user_name', 'Usuario') }}</h2>

        <a href="#"><img src="{{ asset('imgs/user_icon.png')}}" alt=""></a>
    </div>
</header>

<style>
    .header__notification-button {
        position: relative;
        display: inline-block;
        margin-right: 15px;
    }

    .header__notification-icon {
        width: 24px;
        height: 24px;
    }

    .notification-count {
        position: absolute;
        top: -5px;
        right: -5px;
        background: red;
        color: white;
        border-radius: 50%;
        padding: 2px 6px;
        font-size: 12px;
    }
</style>