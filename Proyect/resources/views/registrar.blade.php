@extends('layouts.app')


@section('content')
<section class="section__registrar">
    <h2 class="section__registrar-title">Registrar donante</h2>
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

    <label class="block" for="txt__fecha">Fecha de nacimiento</label>
    <input class="input__div" type="date" name="fecha" id="txt__fecha">

    <label class="block" for="txt__ultima__don">Última donación</label>
    <input class="input__div" type="date" name="ultima_don" id="txt__ultima__don">

    <div class="contenedor__datos__sangineos">
        <div>
            <label class="block" for="txt__abo">ABO</label>
            <input class="input__div" type="text" name="ABO" id="txt__abo">
        </div>
        <div>
            <label class="block" for="txt__rh">RH</label>
            <input class="input__div" type="text" name="RH" id="txt__rh">
        </div>
    </div>

    <div class="contenedor__bottom">
        <div class="contenedor__checkbox">
            <h3>¿Quiere y/o puede donar?</h3>
            <div>
                <label for="ckb__si__donar">SI</label>
                <input class="contenedor__bottom__input" type="checkbox" name="puede_donar" id="ckb__si__donar">
                <label for="ckb__no__donar">NO</label>
                <input class="contenedor__bottom__input" type="checkbox" name="puede_donar" id="ckb__no__donar">
            </div>
            <h3>¿Pendiente?</h3>
            <div>
                <label for="ckb__si__pendiente">SI</label>
                <input class="contenedor__bottom__input" type="checkbox" name="pendiente" id="ckb__si__pendiente">
                <label for="ckb__no__pendiente">NO</label>
                <input class="contenedor__bottom__input" type="checkbox" name="pendiente" id="ckb__no__pendiente">
            </div>
        </div>

        <div class="contenedor__descripcion">
            <label class="block" for="txt__porque">¿Por qué?</label>
            <input type="text" name="porque" id="txt__porque">
            <div>
                <button type="button" class="contenedor__descripcion__porque">Cancelar</button>
                <button type="submit" class="contenedor__descripcion__porque guardar">Modificar</button>
            </div>
        </div>
    </div>
</form>
</section>
@endsection