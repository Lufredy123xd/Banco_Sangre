<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Usuario</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container bg-danger mt-5 p-5 rounded">
        <h1 class="mb-4 text-light text-center">Registrar Usuario</h1>
        <form action="{{ url('/usuario') }}" method="POST" class="p-4 bg-light border rounded shadow" >
            {{ csrf_field() }}

            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" id="nombre" name="nombre" class="form-control" 
                    required placeholder="Nombre del usuario" maxlength="50" 
                    pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+" 
                    title="El nombre solo puede contener letras y espacios.">
            </div>

            <div class="mb-3">
                <label for="email" class="form-label">Email:</label>
                <input type="email" id="email" name="email" class="form-control" 
                    required placeholder="Email del usuario" maxlength="250"
                    title="Por favor, introduce un correo electrónico válido.">
            </div>

            <div class="mb-3">
                <label for="rol" class="form-label">Rol:</label>
                <select id="rol" name="rol" class="form-control" required>
                    <option value="" disabled selected>Selecciona un rol</option>
                    <option value="Administrador">Administrador</option>
                    <option value="Estudiante">Estudiante</option>
                    <option value="Docente">Docente</option>
                    <option value="Funcionario">Funcionario</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Contraseña:</label>
                <input type="password" id="password" name="password" class="form-control" 
                    required minlength="8" maxlength="20" 
                    pattern="(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}" 
                    title="La contraseña debe tener al menos 8 caracteres, incluyendo letras y números.">
            </div>

            <a href="{{ route('usuario.index') }}" class="btn btn-secondary">Volver</a>
            <button type="submit" class="btn btn-primary">Guardar</button>
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