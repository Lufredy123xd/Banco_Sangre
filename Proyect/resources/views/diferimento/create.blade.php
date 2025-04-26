{{-- filepath: c:\xampp\htdocs\_PHP\Banco_Sangre\Proyect\resources\views\diferimento\create.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Diferimiento</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4">Crear Diferimiento</h1>

        @if (session('mensaje'))
            <div class="alert alert-success">
                {{ session('mensaje') }}
            </div>
        @endif

        <form action="{{ url('/diferimento') }}" method="post">
            {{ csrf_field() }}

            <div class="mb-3">
                <label for="motivo" class="form-label">Motivo</label>
                <input type="text" class="form-control" id="motivo" name="motivo" required>
            </div>

            <div class="mb-3">
                <label for="fechaDiferimiento" class="form-label">Fecha de Diferimiento</label>
                <input type="date" class="form-control" id="fechaDiferimiento" name="fecha_diferimiento" required>
            </div>

            <div class="mb-3">
                <label for="tipo" class="form-label">Tipo</label>
                <input type="text" class="form-control" id="tipo" name="tipo" required>
            </div>

            <div class="mb-3">
                <label for="tiempoEnMeses" class="form-label">Tiempo en Meses</label>
                <input type="number" class="form-control" id="tiempoEnMeses" name="tiempo_en_meses" required>
            </div>

            <button type="submit" class="btn btn-primary">Guardar</button>
            <a href="{{ url('/diferimento') }}" class="btn btn-secondary">Cancelar</a>
        </form>
    </div>

    <!-- Bootstrap JS (Opcional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>