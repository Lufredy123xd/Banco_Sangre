{{-- filepath: resources/views/usuario/modificarUsuario.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container bg-danger mt-5 p-5 rounded">
        <h1 class="mb-4 text-light text-center">Modificar Usuario</h1>
        <form action="{{ url('/usuario/' . $usuario->id) }}" method="POST" class="p-4 bg-light border rounded shadow">
            {{ csrf_field() }}
            {{ method_field('PUT') }}

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" id="nombre" name="nombre" class="form-control" value="{{ $usuario->nombre }}" required>
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" id="email" name="email" class="form-control" value="{{ $usuario->email }}" required>
            </div>

            <div class="mb-3">
                <label for="rol" class="form-label">Rol:</label>
                <select id="rol" name="rol" class="form-control" required>
                    <option value="Administrador" {{ $usuario->rol == 'Admin' ? 'selected' : '' }}>Administrador</option>
                    <option value="Estudiante" {{ $usuario->rol == 'Estudiante' ? 'selected' : '' }}>Estudiante</option>
                    <option value="Docente" {{ $usuario->rol == 'Docente' ? 'selected' : '' }}>Docente</option>
                    <option value="Funcionario" {{ $usuario->rol == 'Funcionario' ? 'selected' : '' }}>Funcionario</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Contraseña (Opcional):</label>
                <input type="password" id="password" name="password" class="form-control">
                <small class="text-muted">Deja este campo vacío si no deseas cambiar la contraseña.</small>
            </div>

            <a href="{{ route('usuario.index') }}" class="btn btn-secondary">Volver</a>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </form>

        @if (session('mensaje'))
            <div class="alert alert-success mt-3">
                {{ session('mensaje') }}
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>