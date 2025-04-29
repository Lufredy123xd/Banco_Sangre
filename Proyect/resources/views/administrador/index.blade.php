<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Usuarios</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container bg-danger mt-5 p-5 rounded">
        <h1 class="text-light mb-4">Lista de Usuarios</h1>
        <table class="table table-striped table-bordered">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Cédula</th>
                    <th>Tipo de Usuario</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($usuarios as $usuario)
                    <tr>
                        <td>{{ $usuario->id }}</td>
                        <td>{{ $usuario->nombre }}</td>
                        <td>{{ $usuario->apellido }}</td>
                        <td>{{ $usuario->cedula }}</td>
                        <td>{{ $usuario->tipo_usuario }}</td>
                        <td>{{ $usuario->estado }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ url('/administrador/' . $usuario->id . '/edit') }}"
                                    class="btn btn-warning btn-sm">Editar</a>
                                <form action="{{ url('/administrador/' . $usuario->id) }}" method="post">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('¿Estás seguro de que deseas eliminar este usuario?');">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-between">
            <a href="{{ route('administrador.home') }}" class="btn btn-secondary">Volver al Inicio</a>
            <a href="{{ route('administrador.create') }}" class="btn btn-primary">Registrar Usuario</a>
        </div>
    </div>

    @if (session('mensaje'))
        <div class="alert alert-success">
            {{ session('mensaje') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>