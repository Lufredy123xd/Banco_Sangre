{{-- filepath: c:\xampp\htdocs\_PHP\Banco_Sangre\Proyect\resources\views\Diferimento\index.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Diferimientos</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">Lista de Diferimientos</h1>
        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>#</th>
                    <th>Motivo</th>
                    <th>Fecha de Diferimiento</th>
                    <th>Tipo</th>
                    <th>Tiempo en Meses</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($diferimentos as $diferimento)
                    <tr>
                        <td>{{ $diferimento->id }}</td>
                        <td>{{ $diferimento->motivo }}</td>
                        <td>{{ $diferimento->fecha_diferimiento }}</td>
                        <td>{{ $diferimento->tipo }}</td>
                        <td>{{ $diferimento->tiempo_en_meses }}</td>
                        <td>
                            <div class="d-flex gap-2">
                                <a href="{{ url('/diferimento/' . $diferimento->id . '/edit') }}" class="btn btn-warning btn-sm">
                                    <i class="fas fa-edit"></i> <!-- Icono de editar (opcional) -->
                                    Editar
                                </a>
                                <form action="{{ url('/diferimento/' . $diferimento->id) }}" method="post">
                                    {{ csrf_field() }}
                                    {{ method_field('DELETE') }}
                                    <button type="submit" class="btn btn-danger btn-sm"
                                        onclick="return confirm('¿Estás seguro de que deseas eliminar este diferimiento?');">Eliminar</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="d-flex justify-content-end">
            <a href="{{ route('diferimento.create') }}" class="btn btn-primary">Crear Diferimiento</a>
        </div>
    </div>

    @if (session('mensaje'))
        <div class="alert alert-success">
            {{ session('mensaje') }}
        </div>
    @endif

    <!-- Bootstrap JS (Opcional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>