<header class="header">
    <div class="header__dropdown">
        <button class="header__dropdown-button">
            <img src="{{ asset ('imgs/dropdown.png')}}" alt="" class="header__dropdown-icon">
        </button>
        <nav class="header__nav">
            <a href="{{ route('home') }}" class="header__nav-link">Inicio</a>
            <a href="{{ route('registrar') }}" class="header__nav-link">Registrar</a>
            <a href="{{ route('modificar') }}"class="header__nav-link">Modificar</a>
            <a href="{{ route('detalle') }}"class="header__nav-link">Detalle</a>
            <a href="{{ route('gestionarDonante') }}"class="header__nav-link">Gestionar Donante</a>
            <a href="" class="header__nav-link">Cerrar sesion</a>
        </nav>
    </div>
    <div class="header__left">
        <img src="{{ asset ('imgs/vaccine_icon.png')}}" alt="vaccine" class="header__left-icon">
        <h1 class="header__left-title">BloodBank</h1>
    </div>

    <div class="header__right">
        <h2 class="header__right-title">Usuario</h2>
      <a href="#"><img src="{{ asset ('imgs/user_icon.png')}}" alt=""></a>
    </div>
</header>