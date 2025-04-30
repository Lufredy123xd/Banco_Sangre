<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulario Agenda</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Formulario Agenda</h1>
        <form action="{{ url('/agenda') }}" method="POST" class="p-4 border rounded shadow">
            {{ csrf_field() }}

            <p>Donante seleccionado: {{ $donante->nombre }}</p>

            <!-- Campo oculto para el ID del donante -->
            <input type="hidden" name="id_donante" value="{{ $donante->id }}">

            <!-- Campo para la fecha -->
            <div class="mb-3">
                <label for="fecha_agenda" class="form-label">Fecha de la Agenda:</label>
                <input type="date" id="fecha_agenda" name="fecha_agenda" class="form-control" required>
            </div>

            <!-- Campo para el horario -->
            <div class="mb-3">
                <label for="horario" class="form-label">Horario:</label>
                <input type="time" id="horario" name="horario" class="form-control" required>
            </div>

            <input type="hidden" id="asistio" name="asistio" value="">
            <!-- Campo para asistencia 
            <div class="mb-3">
                <label for="asistio" class="form-label">¿Asistió?</label>
                <select id="asistio" name="asistio" class="form-select" required>
                    <option value="1">Sí</option>
                    <option value="0">No</option>
                </select>
            </div>-->

            <button type="submit" class="btn btn-primary">Guardar</button>
            <a class="btn btn-warning btn-rm" href="{{ route('gestionarDonante', ['id' => $donante->id]) }}">Cancelar</a>
            
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
