@extends('layouts.admin')

@section('contentAdmin')
<section class="section__registrar">
    <h2 class="section__registrar-title">Registrar Usuario</h2>
    <form action="{{ url('/usuario')}}" method="post" class="registrar__formulario">
        {{ csrf_field() }}
        <div class="contenedor__nombre__completo">
            <div>
                <label class="block" for="txt__nombre">Nombre</label>
                <input class="input__div" type="text" name="nombre" id="txt__nombre"
                    required placeholder="Nombre del usuario" maxlength="50"
                    pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+"
                    title="El nombre solo puede contener letras y espacios.">
            </div>
            <div>
                <label class="block" for="txt__apellido">Apellido</label>
                <input class="input__div" type="text" name="apellido" id="txt__apellido"
                    required placeholder="Apellido del usuario" maxlength="50"
                    pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+"
                    title="El apellido solo puede contener letras y espacios.">
            </div>
        </div>

        <label class="block" for="txt__cedula">Cédula</label>
        <input class="input__div" type="text" name="cedula" id="txt__cedula"
            required placeholder="Cédula del usuario" maxlength="20"
            pattern="\d+"
            title="La cédula solo puede contener números.">

        <label class="block" for="txt__tipo_usuario">Tipo de usuario</label>
        <select class="input__div" name="tipo_usuario" id="txt__tipo_usuario" required>
            @foreach (App\Enums\TipoUsuario::cases() as $tipo)
            <option value="{{ $tipo->value }}">{{ $tipo->value }}</option>
            @endforeach
        </select>

        <label class="block" for="txt__curso">Curso (en caso de estudiante)</label>
        <select class="input__div" name="curso" id="txt__curso">
            @foreach (App\Enums\Curso::cases() as $curso)
            <option value="{{ $curso->value }}">{{ $curso->value }}</option>
            @endforeach
        </select>
        

        <div class="contenedor__datos__sangineos">
            <div>
                <label class="block" for="txt__fecha_nacimiento">Fecha de nacimiento</label>
                <input class="input__div" type="date" name="fecha_nacimiento" id="txt__fecha_nacimiento"
                    required max="{{ date('Y-m-d') }}"
                    title="La fecha de nacimiento no puede ser posterior a hoy.">
            </div>
            <div>
                <label class="block" for="txt__nombre_usuario">Nombre de usuario</label>
                <input class="input__div" type="text" name="user_name" id="txt__nombre_usuario"
                    required placeholder="Nombre de usuario" maxlength="50"
                    pattern="[A-Za-z0-9_]+"
                    title="El nombre de usuario solo puede contener letras, números y guiones bajos.">
            </div>

            <div>
                <label class="block" for="txt__password">Contraseña</label>
                <input class="input__div" type="password" name="password" id="txt__password"
                    required minlength="8" maxlength="20"
                    pattern="(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}"
                    title="La contraseña debe tener al menos 8 caracteres, incluyendo letras y números.">
            </div>

            <div>
                <label class="block" for="txt__estado">Estado</label>
                <select class="input__div" name="estado" id="txt__estado" required>
                @foreach (App\Enums\EstadoUsuario::cases() as $estado)
                    <option value="{{ $estado->value }}">{{ $estado->value }}</option>
                @endforeach
                </select>
            </div>
        </div>

        <div class="contenedor__bottom">
                <a href="{{ route('donante.index') }}" type="button"
                    class="contenedor__descripcion__porque cancelar">Volver</a>
                <button type="submit" class="contenedor__descripcion__porque guardar">Registrar</button>
            </div>
    </form>
</section>
@endsection