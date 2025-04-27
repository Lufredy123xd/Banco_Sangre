{{-- filepath: resources/views/donante/create.blade.php --}}
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Donante</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Registrar Donante</h1>
        <form action="{{ url('/donante') }}" method="POST" class="p-4 border rounded shadow">
            {{ csrf_field() }}

            <!-- Campo oculto para el ID -->
            <input type="hidden" id="id" name="id" value="{{ old('id') }}">


            <div class="mb-3">
                <label for="nombre" class="form-label">Nombre:</label>
                <input type="text" id="nombre" name="nombre" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="apellido" class="form-label">Apellido:</label>
                <input type="text" id="apellido" name="apellido" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="cedula" class="form-label">Cédula:</label>
                <input type="number" id="cedula" name="cedula" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="sexo" class="form-label">Sexo:</label>
                <select id="sexo" name="sexo" class="form-control" required>
                    <option value="M">Masculino</option>
                    <option value="F">Femenino</option>
                </select>
            </div>

            <div class="mb-3">
                <label for="telefono" class="form-label">Teléfono:</label>
                <input type="text" id="telefono" name="telefono" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="fecha_nacimiento" class="form-label">Fecha de Nacimiento:</label>
                <input type="date" id="fecha_nacimiento" name="fecha_nacimiento" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="ABO" class="form-label">Grupo Sanguíneo (ABO):</label>
                <select id="ABO" name="ABO" class="form-control" required>
                    @foreach (App\Enums\TipoABO::cases() as $tipo)
                        <option value="{{ $tipo->value }}">{{ $tipo->value }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="RH" class="form-label">Factor RH:</label>
                <select id="RH" name="RH" class="form-control" required>
                    @foreach (App\Enums\TipoRH::cases() as $tipo)
                        <option value="{{ $tipo->value }}">{{ $tipo->value }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="estado" class="form-label">Estado:</label>
                <select id="estado" name="estado" class="form-control" required>
                    @foreach (App\Enums\EstadoDonante::cases() as $tipo)
                        <option value="{{ $tipo->value }}">{{ $tipo->value }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="observaciones" class="form-label">Observaciones:</label>
                <textarea id="observaciones" name="observaciones" class="form-control" rows="3"></textarea>
            </div>

            <a href="{{ route('donante.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary">Guardar</button>
        </form>

        @if (session('mensaje'))
            <div class="alert alert-success">
                {{ session('mensaje') }}
            </div>
        @endif
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>