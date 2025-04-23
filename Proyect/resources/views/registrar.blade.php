@extends('layouts.app')


@section('content')
<section class="section__registrar">
    <h2 class="section__registrar-title">Registrar donante</h2>
    <form class="registrar__formulario">
        <div class="fila">
            <div class="input__div">
                <label>Nombre</label>
                <input type="text" />
            </div>
            <div class="input__div">
                <label>Apellido</label>
                <input type="text" />
            </div>
        </div>

        <div class="fila">
            <div class="input__div">
                <label>CI</label>
                <input type="text" />
            </div>
            <div class="input__div">
                <label>Teléfono</label>
                <input type="text" />
            </div>
        </div>

        <div class="fila">
            <div class="input__div">
                <label>Fecha nacimiento</label>
                <input type="date" />
            </div>
            <div class="input__div">
                <label>Última fecha donación</label>
                <input type="date" />
            </div>
        </div>

        <div class="fila">
            <div class="input__div">
                <label>ABO</label>
                <input type="text" />
            </div>
            <div class="input__div">
                <label>RH</label>
                <input type="text" />
            </div>
        </div>

        <div class="contenedor__checkbox">
            <div class="contenedor__checkbox__fila">
                <div class="radio-group">
                    <label>¿Quiere y/o puede donar?</label>
                    <div class="group__div">
                    <input type="radio" name="puede_donar" /> Sí
                    <input type="radio" name="puede_donar" /> No
                    </div>
                </div>

                <div class="contenedor__descripcion">
                    <label>¿Por qué?</label>
                    <input type="text" class="contenedor__descripcion__porque" />
                </div>
            </div>

            <div class="contenedor__checkbox__fila ultimo">
                <div class="radio-group">
                    <label>¿Pendiente?</label>
                    <div class="group__div">
                    <input type="radio" name="pendiente" /> Sí
                    <input type="radio" name="pendiente" /> No
                    </div>
                </div>

                <div class="radio-group">
                    <label>Sexo</label>
                    <div class="group__div">
                    <input type="radio" name="sexo" /> M
                    <input type="radio" name="sexo" /> F
                    </div>
                </div>
            </div>
        </div>
        <div class="contenedor__bottom">
            <button class="cancelar">Cancelar</button>
            <button class="guardar">Guardar</button>
        </div>
    </form>
</section>
@endsection