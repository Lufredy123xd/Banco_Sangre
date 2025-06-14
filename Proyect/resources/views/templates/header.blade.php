<header class="header">
    <div class="header__dropdown">
        <button class="header__dropdown-button" id="menu-toggle">
            <i class="fas fa-bars header__dropdown-icon"></i>
        </button>
        <nav class="header__nav" id="menu">
            @if (session('tipo_usuario') === 'Administrador')
                <a href="{{ route('usuario.index') }}" class="header__nav-link">Gestionar Usuarios</a>
                <a href="{{ route('donante.index') }}" class="header__nav-link">Gestionar Donantes</a>
            @else
                <a href="{{ route('donante.index') }}" class="header__nav-link">Gestionar Donantes</a>
            @endif
            <a href="{{ route('agenda.index') }}" class="header__nav-link">Listar Agendas</a>
            <a href="{{ route('donacion.index') }}" class="header__nav-link">Listar Donaciones</a>
            <a href="{{ route('diferimento.index') }}" class="header__nav-link">Listar Diferimientos</a>
            <a href="{{ route('password.form') }}" class="header__nav-link">Cambiar contraseña</a>
            <a href="{{ route('logout') }}" class="header__nav-link">Cerrar sesión</a>
        </nav>
    </div>

    <div class="header__left">
        <img src="{{ asset('imgs/vaccine_icon.png') }}" alt="vaccine" class="header__left-icon">
        <h1 class="header__left-title">BloodBank</h1>
    </div>

    <div class="header__right">
        <a href="{{ route('notificacion.index') }}" class="header__notification-button" title="Notificaciones">
            <svg class="header__notification-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                stroke="white">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V4a2 2 0 10-4 0v1.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
            </svg>
            @if ($notificacionesPendientes > 0)
                <span class="notification-count">{{ $notificacionesPendientes }}</span>
            @endif
        </a>
        <div class="header__user-info">
            <span class="header__right-title">{{ session('user_name', 'Usuario') }}</span>
            <a href="#" class="header__user-avatar-link">
                <img src="{{ asset('imgs/user_icon.png') }}" alt="Usuario" class="header__user-icon">
            </a>
        </div>
    </div>
</header>


<script>
    document.addEventListener('DOMContentLoaded', function() {
        const toggleButton = document.getElementById('menu-toggle');
        const menu = document.getElementById('menu');

        toggleButton.addEventListener('click', function(e) {
            e.stopPropagation();
            menu.classList.toggle('visible');
        });

        // Cerrar el menú al tocar fuera de él
        document.addEventListener('click', function(e) {
            if (!menu.contains(e.target) && !toggleButton.contains(e.target)) {
                menu.classList.remove('visible');
            }
        });
    });
</script>





<!-- Estilo menu desplegable -->
<style>
    .header__dropdown-icon {
        color: white;
        /* Cambiar el color a blanco */
        font-size: 2rem;
        /* Aumentar el tamaño del icono */
    }

    .header__dropdown-button {
        border: none;
        transition: background 0.2s;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .header__nav {
        position: absolute;
        top: 50%;
        left: 10%;
        min-width: 210px;
        background: #fff;
        border-radius: 16px;
        box-shadow: 0 8px 32px rgba(0, 0, 0, 0.18);
        padding: 10px 0;
        display: none;
        flex-direction: column;
        animation: fadeInMenu 0.25s;
        border: 1px solidrgb(153, 147, 147);
    }


    .header__nav-link {
        color: rgb(0, 0, 0);
        text-decoration: none;
        padding: 12px 24px;
        font-size: 1rem;
        border: none;
        background: none;
        transition: background 0.18s, color 0.18s;
        border-radius: 8px;
        margin: 0 8px;
        display: block;
    }

    .header__nav-link:hover {
        background: #d72d57;
        color: #fff;
    }

    @keyframes fadeInMenu {
        from {
            opacity: 0;
            transform: translateY(-10px);
        }

        to {
            opacity: 1;
            transform: translateY(0);
        }
    }

    .header__nav {
        display: none;
        /* ... ya existente ... */
    }

    .header__nav.visible {
        display: flex;
    }


    /* Responsive */
    @media (max-width: 700px) {
        .header__nav {
            position: absolute;
            top: 100%;
            left: 10%;
            min-width: 210px;
            background: #fff;
            border-radius: 16px;
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.18);
            padding: 10px 0;
            display: none;
            flex-direction: column;
            animation: fadeInMenu 0.25s;
            border: 1px solidrgb(153, 147, 147);
        }

        .header__nav {
            left: 0;
            right: 0;
            width: 95vw;
            min-width: 180px;
            max-width: 320px;
            margin: 0 auto;
            border-radius: 12px;
        }

        .header__nav-link {
            padding: 14px 18px;
            font-size: 1rem;
        }
    }
</style>

<!-- Estilo parte derecha del menu -->
<style>
    .header__right {
        display: flex;
        align-items: center;
        gap: 18px;
        flex-grow: 0.01;
    }

    .header__notification-button {
        position: relative;
        display: inline-block;
        background: none;
        border: none;
        cursor: pointer;
        outline: none;
        margin-right: 0;
    }

    .header__notification-icon {
        width: 28px;
        height: 28px;
    }

    .notification-count {
        position: absolute;
        top: -6px;
        right: -6px;
        background: #e53935;
        color: white;
        border-radius: 50%;
        padding: 2px 7px;
        font-size: 13px;
        font-weight: bold;
        box-shadow: 0 2px 6px rgba(0, 0, 0, 0.15);
    }

    .header__user-info {
        display: flex;
        align-items: center;
        gap: 12px;
        background: rgba(255, 255, 255, 0.18);
        border-radius: 24px;
        padding: 6px 18px 6px 14px;
        transition: background 0.18s, box-shadow 0.18s;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.04);
    }

    .header__user-info:hover {
        background: rgba(255, 255, 255, 0.32);
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.10);
    }

    .header__right-title {
        color: var(--primary);
        font-size: 1.15rem;
        font-weight: 600;
        margin: 0 6px 0 0;
        white-space: nowrap;
        letter-spacing: 0.5px;
    }

    .header__user-avatar-link {
        display: flex;
        align-items: center;
    }

    .header__user-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        background: #fff;
        padding: 4px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.10);
        transition: box-shadow 0.2s;
    }

    .header__user-avatar-link:hover .header__user-icon {
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.18);
    }

    @media (max-width: 700px) {
        .header__nav {
            left: 0;
            right: 0;
            width: 95vw;
            min-width: 180px;
            max-width: 320px;
            margin: 0 auto;
        }

        .header__user-info {
            padding: 4px 8px;
        }

        .header__right-title {
            font-size: 1rem;
        }

        .header__user-icon {
            width: 32px;
            height: 32px;
            padding: 2px;
        }
    }
</style>
