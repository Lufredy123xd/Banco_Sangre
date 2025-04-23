@extends('layouts.auth')

@section('auth')
<header class="header">
    <img src="imgs/vaccine_icon.png" alt="">
    <form action="" method="post" class="form">
        <div>
        <label for="user">Usuario</label>
        <input type="text" name="user" id="txt_usuario">
        <label for="password">Contraseña</label>
        <input type="text" name="password" id="txt_usuario">
        </div>
        <a href="">¿Has olvidado la contraseña?</a>
        <button id="btn__ingresar" class="btn">Ingresar</button>
    </form>


</header>
@endsection