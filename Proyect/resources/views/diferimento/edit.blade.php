{{-- filepath: c:\xampp\htdocs\_PHP\Banco_Sangre\Proyect\resources\views\diferimento\edit.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Diferimiento</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Editar Diferimiento</h1>
        <form action="{{ url('/diferimento/' . $diferimento->id) }}" method="POST" enctype="multipart/form-data"
            class="p-4 border rounded shadow">
            {{ csrf_field() }}
            {{ method_field('PATCH') }}

            <!-- Campo para el motivo -->
            <div class="mb-3">
                <label for="motivo" class="form-label">Motivo:</label>
                <input type="text" id="motivo" name="motivo" class="form-control"
                    value="{{ $diferimento->motivo }}" required>
            </div>

            <!-- Campo para la fecha de diferimiento -->
            <div class="mb-3">
                <label for="fecha_diferimiento" class="form-label">Fecha de Diferimiento:</label>
                <input type="date" id="fecha_diferimiento" name="fecha_diferimiento" class="form-control"
                    value="{{ $diferimento->fecha_diferimiento }}" required>
            </div>

            <!-- Campo para el tipo -->
            <div class="mb-3">
                <label for="tipo" class="form-label">Tipo:</label>
                <input type="text" id="tipo" name="tipo" class="form-control" value="{{ $diferimento->tipo }}"
                    required>
            </div>

            <!-- Campo para el tiempo en meses -->
            <div class="mb-3">
                <label for="tiempo_en_meses" class="form-label">Tiempo en Meses:</label>
                <input type="number" id="tiempo_en_meses" name="tiempo_en_meses" class="form-control"
                    value="{{ $diferimento->tiempo_en_meses }}" required>
            </div>

            <a href="{{ route('diferimento.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>

        @if (session('mensaje'))
            <div class="alert alert-success">
                {{ session('mensaje') }}
            </div>
        @endif
    </div>

    <!-- Bootstrap JS (Opcional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>