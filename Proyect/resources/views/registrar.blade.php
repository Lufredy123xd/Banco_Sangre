@extends('layouts.app')

@section('content')
<section class="section__registrar">
    <h2 class="section__registrar-title">Registrar donante</h2>
    <form action="{{ url('/usuario') }}" method="post" class="registrar__formulario">
    {{ csrf_field() }}
        <div class="contenedor__nombre__completo">
            <div>
                <label class="block" for="txt__nombre">Nombre</label>
                <input class="input__div" type="text" name="nombre" id="txt__nombre" 
                    required placeholder="Nombre del donante" maxlength="50" 
                    pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+" 
                    title="El nombre solo puede contener letras y espacios.">
            </div>
            <div>
                <label class="block" for="txt__apellido">Apellido</label>
                <input class="input__div" type="text" name="apellido" id="txt__apellido" 
                    required placeholder="Apellido del donante" maxlength="50" 
                    pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+" 
                    title="El apellido solo puede contener letras y espacios.">
            </div>
        </div>

        <label class="block" for="txt__cedula">Cédula</label>
        <input class="input__div" type="text" name="cedula" id="txt__cedula" 
            required placeholder="Cédula del donante" maxlength="20" 
            pattern="\d+" 
            title="La cédula solo puede contener números.">

        <label class="block" for="txt__telefono">Teléfono</label>
        <input class="input__div" type="text" name="telefono" id="txt__telefono" 
            required placeholder="Teléfono del donante" maxlength="15" 
            pattern="\d{7,15}" 
            title="El teléfono debe contener entre 7 y 15 dígitos.">

        <label class="block" for="txt__fecha">Fecha de nacimiento</label>
        <input class="input__div" type="date" name="fecha" id="txt__fecha" 
            required max="{{ date('Y-m-d') }}" 
            title="La fecha de nacimiento no puede ser posterior a hoy.">

        <label class="block" for="txt__ultima__don">Última donación</label>
        <input class="input__div" type="date" name="ultima_don" id="txt__ultima__don" 
            max="{{ date('Y-m-d') }}" 
            title="La fecha de la última donación no puede ser posterior a hoy.">

        <div class="contenedor__datos__sangineos">
            <div>
                <label class="block" for="txt__abo">ABO</label>
                <input class="input__div" type="text" name="ABO" id="txt__abo" 
                    required placeholder="Grupo sanguíneo ABO" maxlength="3" 
                    pattern="^(A|B|AB|O)$" 
                    title="El grupo sanguíneo debe ser A, B, AB o O.">
            </div>
            <div>
                <label class="block" for="txt__rh">RH</label>
                <input class="input__div" type="text" name="RH" id="txt__rh" 
                    required placeholder="Factor RH" maxlength="1" 
                    pattern="^[+-]$" 
                    title="El factor RH debe ser '+' o '-'.">
            </div>
        </div>

        <div class="contenedor__bottom">
            <div class="contenedor__checkbox">
                <h3>¿Quiere y/o puede donar?</h3>
                <div>
                    <label for="ckb__si__donar">SI</label>
                    <input class="contenedor__bottom__input" type="radio" name="puede_donar" id="ckb__si__donar" value="1" required>
                    <label for="ckb__no__donar">NO</label>
                    <input class="contenedor__bottom__input" type="radio" name="puede_donar" id="ckb__no__donar" value="0" required>
                </div>
                <h3>¿Pendiente?</h3>
                <div>
                    <label for="ckb__si__pendiente">SI</label>
                    <input class="contenedor__bottom__input" type="radio" name="pendiente" id="ckb__si__pendiente" value="1" required>
                    <label for="ckb__no__pendiente">NO</label>
                    <input class="contenedor__bottom__input" type="radio" name="pendiente" id="ckb__no__pendiente" value="0" required>
                </div>
            </div>

            <div class="contenedor__descripcion">
                <label class="block" for="txt__porque">¿Por qué?</label>
                <input type="text" name="porque" id="txt__porque" 
                    placeholder="Motivo" maxlength="255" 
                    title="El motivo no puede exceder los 255 caracteres.">
                <div>
                    <a href="{{ route('usuario.index') }}" type="button" class="contenedor__descripcion__porque">Volver</a>
                    <button type="submit" class="contenedor__descripcion__porque guardar">Registrar</button>
                </div>
            </div>
        </div>
    </form>
</section>
@endsection