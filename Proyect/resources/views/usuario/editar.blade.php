@extends('layouts.admin')

@section('contentAdmin')
<section class="section__registrar">
    <h2 class="section__registrar-title">Editar Usuario</h2>
    <form action="{{ url('/usuario/' . $usuario->id) }}" method="post" class="registrar__formulario">
        {{ csrf_field() }}
        {{ method_field('PUT') }}

        <div class="contenedor__nombre__completo">
            <div>
                <label class="block" for="txt__nombre">Nombre</label>
                <input class="input__div" type="text" name="nombre" id="txt__nombre"
                    required placeholder="Nombre del usuario" maxlength="50"
                    pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+"
                    title="El nombre solo puede contener letras y espacios."
                    value="{{ $usuario->nombre }}">
            </div>
            <div>
                <label class="block" for="txt__apellido">Apellido</label>
                <input class="input__div" type="text" name="apellido" id="txt__apellido"
                    required placeholder="Apellido del usuario" maxlength="50"
                    pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+"
                    title="El apellido solo puede contener letras y espacios."
                    value="{{ $usuario->apellido }}">
            </div>
        </div>

        <label class="block" for="txt__cedula">Cédula</label>
        <input class="input__div" type="text" name="cedula" id="txt__cedula"
            required placeholder="Cédula del usuario" maxlength="20"
            pattern="\d+"
            title="La cédula solo puede contener números."
            value="{{ $usuario->cedula }}">

        <label class="block" for="txt__tipo_usuario">Tipo de usuario</label>
        <select class="input__div" name="tipo_usuario" id="txt__tipo_usuario" required>
            <option value="" disabled>Seleccione un tipo de usuario</option>
            @foreach (App\Enums\TipoUsuario::cases() as $tipo)
            <option value="{{ $tipo->value }}" {{ $usuario->tipo_usuario == $tipo->value ? 'selected' : '' }}>
                {{ $tipo->value }}
            </option>
            @endforeach
        </select>

        <label class="block" for="txt__curso">Curso (en caso de estudiante)</label>
        <select class="input__div" name="curso" id="txt__curso">
            <option value="" disabled>Seleccione un curso</option>
            @foreach (App\Enums\Curso::cases() as $curso)
            <option value="{{ $curso->value }}" {{ $usuario->curso == $curso->value ? 'selected' : '' }}>
                {{ $curso->value }}
            </option>
            @endforeach
        </select>


        <div class="contenedor__datos__sangineos">
            <div>
                <label class="block" for="txt__fecha_nacimiento">Fecha de nacimiento</label>
                <input class="input__div" type="date" name="fecha_nacimiento" id="txt__fecha_nacimiento"
                    required max="{{ date('Y-m-d') }}"
                    title="La fecha de nacimiento no puede ser posterior a hoy."
                    value="{{ $usuario->fecha_nacimiento }}">
            </div>
            <div>
                <label class="block" for="txt__nombre_usuario">Nombre de usuario</label>
                <input class="input__div" type="text" name="nombre_usuario" id="txt__nombre_usuario"
                    required placeholder="Nombre de usuario" maxlength="50"
                    pattern="[A-Za-z0-9_]+"
                    title="El nombre de usuario solo puede contener letras, números y guiones bajos."
                    value="{{ $usuario->user_name }}">
            </div>

            <div>
                <label class="block" for="txt__password">Contraseña</label>
                <input class="input__div" type="password" name="password" id="txt__password"
                    minlength="8" maxlength="20"
                    pattern="(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}"
                    title="La contraseña debe tener al menos 8 caracteres, incluyendo letras y números.">
                <small>Deja este campo vacío si no deseas cambiar la contraseña.</small>
            </div>

            <div>
                <label class="block" for="txt__estado">Estado</label>
                <select class="input__div" name="estado" id="txt__estado" required>
                @foreach (App\Enums\EstadoUsuario::cases() as $estado)
                    <option value="{{ $estado->value }}" {{ $usuario->estado == $estado->value ? 'selected' : '' }}>
                        {{ $estado->value }}</option>
                @endforeach
                </select>
            </div>
        </div>

        <div class="contenedor__bottom">
            <div class="contenedor__descripcion">
                <div>
                    <a href="{{ route('usuario.index') }}" class="contenedor__descripcion__porque">Volver</a>
                    <button type="submit" class="contenedor__descripcion__porque guardar">Editar</button>
                </div>
            </div>
        </div>
    </form>
</section>
@endsection