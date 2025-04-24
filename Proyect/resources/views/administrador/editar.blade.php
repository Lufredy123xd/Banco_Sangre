@extends('layouts.admin')


@section('contentAdmin')
<section class="section__registrar">
    <h2 class="section__registrar-title">Editar Usuario</h2>
    <form action="{{ route('administrador.registrar') }}" method="post" class="registrar__formulario">
    @csrf
    <div class="contenedor__nombre__completo">
        <div>
            <label class="block" for="txt__nombre">Nombre</label>
            <input class="input__div" type="text" name="nombre" id="txt__nombre">
        </div>
        <div>
            <label class="block" for="txt__apellido">Apellido</label>
            <input class="input__div" type="text" name="apellido" id="txt__apellido">
        </div>
    </div>

    <label class="block" for="txt__cedula">Cedula</label>
    <input class="input__div" type="text" name="cedula" id="txt__cedula">

    <label class="block" for="txt__telefono">Teléfono</label>
    <input class="input__div" type="text" name="telefono" id="txt__telefono">

    <label class="block" for="txt__fecha">Tipo de usuario</label>
    <input class="input__div" type="text" name="fecha" id="txt__fecha">

    <label class="block" for="txt__ultima__don">Curso(en caso de estudiante)</label>
    <input class="input__div" type="text" name="ultima_don" id="txt__ultima__don">

    <div class="contenedor__datos__sangineos">
        <div>
            <label class="block" for="txt__abo">fecha Nacimiento</label>
            <input class="input__div" type="text" name="ABO" id="txt__abo">
        </div>
        <div>
            <label class="block" for="txt__rh">Nombre Usuario</label>
            <input class="input__div" type="text" name="RH" id="txt__rh">
        </div>

        <div>
            <label class="block" for="txt__rh">Contraseña</label>
            <input class="input__div" type="text" name="RH" id="txt__rh">
        </div>
    </div>

    <div class="contenedor__bottom">
       

        <div class="contenedor__descripcion">
            <div>
                <button type="button" class="contenedor__descripcion__porque">Cancelar</button>
                <button type="submit" class="contenedor__descripcion__porque guardar">Editar</button>
            </div>
        </div>
    </div>
</form>
</section>
@endsection