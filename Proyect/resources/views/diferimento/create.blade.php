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

            <div class="mb-3 border rounded p-3">
                <label class="form-label">Datos del Donante</label>
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">Nombre</label>
                        <input type="text" class="form-control" value="{{ $donante->nombre }} {{ $donante->apellido }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Cédula</label>
                        <input type="text" class="form-control" value="{{ $donante->cedula }}" readonly>
                    </div>
                </div>
            </div>

            <!-- Campo oculto para el ID del donante -->
            <input type="hidden" name="id_donante" value="{{ $donante->id }}">

            <div class="mb-3">
                <label for="motivo" class="form-label">Motivo</label>
                <input type="text" class="form-control" id="motivo" name="motivo" required>
            </div>

            <div class="mb-3">
                <label for="fechaDiferimiento" class="form-label">Fecha de Diferimiento</label>
                <input type="date" class="form-control" id="fechaDiferimiento" name="fecha_diferimiento" required>
            </div>

            <div class="mb-3">
                <label for="tipo_diferimiento" class="form-label">Seleccione el tipo de diferimiento:</label>
                <select id="tipo_diferimiento" name="tipo" class="form-control" required onchange="toggleTiempoEnMeses()">
                    <option value="Permanente">Permanente</option>
                    <option value="Temporal">Temporal</option>
                </select>
            </div>
            
            <div class="mb-3" id="tiempoEnMesesContainer">
                <label for="tiempoEnMeses" class="form-label">Tiempo en Meses</label>
                <input type="number" class="form-control" id="tiempoEnMeses" name="tiempo_en_meses">
            </div>
            
            <script>
                function toggleTiempoEnMeses() {
                    const tipoDiferimiento = document.getElementById('tipo_diferimiento').value;
                    const tiempoEnMesesContainer = document.getElementById('tiempoEnMesesContainer');
            
                    if (tipoDiferimiento === 'Permanente') {
                        tiempoEnMesesContainer.style.display = 'none';
                        document.getElementById('tiempoEnMeses').removeAttribute('required');
                    } else {
                        tiempoEnMesesContainer.style.display = 'block';
                        document.getElementById('tiempoEnMeses').setAttribute('required', 'required');
                    }
                }
            
                // Inicializar el estado al cargar la página
                document.addEventListener('DOMContentLoaded', toggleTiempoEnMeses);
            </script>

            <button type="submit" class="btn btn-primary">Guardar</button>
            <a class="btn btn-warning btn-rm" href="{{ route('gestionarDonante', ['id' => $donante->id]) }}">Cancelar</a>
        </form>
    </div>

    <!-- Bootstrap JS (Opcional) -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
