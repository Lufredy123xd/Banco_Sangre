{{-- filepath: resources/views/donante/index.blade.php --}}
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Donantes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">Lista de Donantes</h1>
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Nombre</th>
                    <th>Apellido</th>
                    <th>Cédula</th>
                    <th>Teléfono</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($donantes as $donante)

                    <tr>
                        <td>{{ $donante->id }}</td>
                        <td>{{ $donante->nombre }}</td>
                        <td>{{ $donante->apellido }}</td>
                        <td>{{ $donante->cedula }}</td>
                        <td>{{ $donante->telefono }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ url('/donante/' . $donante->id . '/edit') }}"
                                    class="btn btn-warning btn-sm">Editar</a>
                                <form action="{{ url('/donante/' . $donante->id) }}" method="post">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('¿Estás seguro de que deseas eliminar este donante?');">Eliminar</button>
                                </form>


                                <a class="btn btn-warning btn-sm"
                                    href="{{ route('gestionarDonante', ['id' => $donante->id]) }}">Gestionar
                                    Donante</a>


                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        @if (session('mensaje'))
            <div class="alert alert-success">
                {{ session('mensaje') }}
            </div>
        @endif

        <div class="d-flex justify-content-end">
            <a href="{{ route('donante.create') }}" class="btn btn-primary">Registrar Donante</a>
        </div>
    </div>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
