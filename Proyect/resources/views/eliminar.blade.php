@extends('layouts.app')


@section('content')
<section class="section__registrar">
    <h2 class="section__registrar-title">Eliminar donante</h2>
    <form action="" method="post" class="registrar__formulario">
        <div class="contenedor__nombre__completo">
            <div>
                <label class="block" for="nombre">Nombre</label>
                <input class="input__div" type="text" name="nombre" id="txt__nombre">
            </div>
            <div>
                <label class="block" for="apellido">Apellido</label>
                <input class="input__div" type="text" name="apellido" id="txt__apellido">
            </div>
        </div>

        <label class="block" for="cedula">Cedula</label>
        <input type="text" name="cedula" id="txt__cedula">

        <label class="block" for="telefono">telefono</label>
        <input type="text" name="telefono" id="txt__telefono">

        <label class="block" for="fecha">Fecha de nacimiento</label>
        <input type="text" name="fecha" id="txt__fecha">

        <label class="block" for="ultima__don">Ultimo donante</label>
        <input type="text" name="ultima__don" id="txt__ultima__don">

        <div class="contenedor__datos__sangineos">
            <div>
                <label class="block" for="ABO">ABO</label>
                <input class="input__div" type="text" name="ABO" id="txt__abo">
            </div>
            <div>
                <label class="block" for="RH">RH</label>
                <input class="input__div" type="text" name="RH" id="txt__rh">
            </div>
        </div>

        <div class="contenedor__bottom">
            <div class="contenedor__checkbox">
                <h3>¿Quiere y/o puede donar?</h3>
                <div>
                    <label for="si">SI</label>
                    <input class="contenedor__bottom__input" type="checkbox" name="si" id="ckb__si__donar">
                    <label for="no">NO</label>
                    <input class="contenedor__bottom__input" type="checkbox" name="no" id="ckb__no__donar">
                </div>
                <h3>¿Pendiente?</h3>
                <div>
                    <label for="si">SI</label>
                    <input class="contenedor__bottom__input" type="checkbox" name="si" id="ckb__si__pendiente">
                    <label for="no">NO</label>
                    <input class="contenedor__bottom__input" type="checkbox" name="no" id="ckb__no__pendiente">
                </div>
            </div>

            <div class="contenedor__descripcion">
                <label class="block" for="porque">¿Porque?</label>
                <input type="text" name="porque" id="txt__porque">
                <div>
                    <button class="contenedor__descripcion__porque">Cancelar</button>
                    <button class="contenedor__descripcion__porque guardar">Eliminar</button>
                </div>
            </div>
        </div>
    </form>
</section>
@endsection