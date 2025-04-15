@extends('layouts.app')

@section('content')
<div class="content__main">
    <div class="content__main__top">
        <form action="" method="post">
            <input type="text" name="txt_buscar" id="txt_buscar" class="content__main__top-text" placeholder="Ingrese dato a buscar">
            <button class="content__main__top-button">Buscar</button>
        </form>
        <div class="main__select">
            <select name="cmb__ordenado_por" id="cmb__ordenado__por" class="select">
                <option value="1" disabled selected>Ordenado por</option>
                <option value="2">Mes</option>
                <option value="2">Año</option>
                <option value="2">Edad</option>
            </select>

            <select name="cmb__sexo" id="cmb__sexo" class="select">
                <option value="1" disabled selected>Sexo</option>
                <option value="2">Mes</option>
                <option value="2">Año</option>
                <option value="2">Edad</option>
            </select>

            <select name="cmb__estado" id="cmb__estado" class="select">
                <option value="1" disabled selected>Estado</option>
                <option value="2">Mes</option>
                <option value="2">Año</option>
                <option value="2">Edad</option>
            </select>
        </div>
    </div>

    <div class="content__main__center">
        <div class="fila">
            <h3 class="file__h3">Nombre</h3>
            <h3 class="file__h3">Apellido</h3>
            <h3 class="file__h3">CI</h3>
            <h3 class="file__h3">Telefono</h3>
            <h3 class="file__h3">Fecha Nacimiento</h3>
            <h3 class="file__h3">ABO</h3>
            <h3 class="file__h3">RH</h3>
            <h3 class="file__h3">Ultima Fecha Donación</h3>
            <h3 class="file__h3">Sexo</h3>
            <h3 class="file__h3">Estado</h3>
        </div>

        <div class="fila">
            <img src="imgs/user_icon.png" alt="">
            <h5 class="file__h3">Nombre</h5>
            <h5 class="file__h3">Apellido</h5>
            <h5 class="file__h3">CI</h5>
            <h5 class="file__h3">Telefono</h5>
            <h5 class="file__h3">Fecha Nacimiento</h5>
            <h5 class="file__h3">ABO</h5>
            <h5 class="file__h3">RH</h5>
            <h5 class="file__h3">Ultima Fecha Donación</h5>
            <h5 class="file__h3">Sexo</h5>
            <h5 class="file__h3"><span>Estado</span></h5>
        </div>
    </div>

    <div class="content__main__bottom">
        <div class="btns">
        <button id="btn__Eliminar" class="btn__bottom eliminar">Eliminar</button>
        <button id="btn__Modificar" class="btn__bottom">Modificar</button>
        <button id="btn__Registrar" class="btn__bottom">Registrar</button>
        </div>
    </div>
</div>
@endsection