{{-- filepath: resources/views/donacion/index.blade.php --}}
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Donaciones</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">Lista de Donaciones</h1>
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Donante</th>
                    <th>Fecha</th>
                    <th>Clase de Donación</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($donaciones as $donacion)
                    <tr>
                        <td>{{ $donacion->id }}</td>
                        <td>{{ $donacion->donante->nombre }} {{ $donacion->donante->apellido }}</td>
                        <td>{{ $donacion->fecha }}</td>
                        <td>{{ $donacion->clase_donacion }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ url('/donacion/' . $donacion->id . '/edit') }}" class="btn btn-warning btn-sm">Editar</a>
                                <form action="{{ url('/donacion/' . $donacion->id) }}" method="post">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('¿Estás seguro de que deseas eliminar esta donación?');">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-end">
            <a href="{{ route('donacion.create') }}" class="btn btn-primary">Registrar Donación</a>
        </div>
    </div>

    @if (session('mensaje'))
        <div class="alert alert-success">
            {{ session('mensaje') }}
        </div>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>