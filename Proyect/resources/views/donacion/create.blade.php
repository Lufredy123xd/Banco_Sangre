{{-- filepath: resources/views/donacion/create.blade.php --}}
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Donación</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Registrar Donación</h1>
        <form action="{{ url('/donacion') }}" method="POST" class="p-4 border rounded shadow">
            {{ csrf_field() }}

            <div class="mb-3 border rounded p-3">
                <label class="form-label">Datos del Donante:</label>
                <div class="row">
                    <div class="col-md-6">
                        <label class="form-label">Nombre</label>
                        <input type="text" class="form-control"
                            value="{{ $donante->nombre }} {{ $donante->apellido }}" readonly>
                    </div>
                    <div class="col-md-6">
                        <label class="form-label">Cédula</label>
                        <input type="text" class="form-control" value="{{ $donante->cedula }}" readonly>
                    </div>
                </div>
            </div>

            <input type="hidden" name="id_donante" value="{{ $donante->id }}">

            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha:</label>
                <input type="date" id="fecha" name="fecha" class="form-control" required>
            </div>

            <div class="mb-3">
                <label for="serologia" class="form-label">Serología:</label>
                <select id="serologia" name="serologia" class="form-control" required>
                    @foreach (App\Enums\TipoSerologia::cases() as $tipo)
                        <option value="{{ $tipo->value }}">{{ $tipo->value }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="anticuerpos_irregulares" class="form-label">Anticuerpos Irregulares:</label>
                <select id="anticuerpos_irregulares" name="anticuerpos_irregulares" class="form-control" required>
                    @foreach (App\Enums\TipoAnticuerposIrregulares::cases() as $tipo)
                        <option value="{{ $tipo->value }}">{{ $tipo->value }}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="clase_donacion" class="form-label">Clase de Donación:</label>
                <select id="clase_donacion" name="clase_donacion" class="form-control" required>
                    @foreach (App\Enums\TipoDonacion::cases() as $tipo)
                        <option value="{{ $tipo->value }}">{{ $tipo->value }}</option>
                    @endforeach
                </select>
            </div>

            <div class="d-flex justify-content-between">
                <a class="btn btn-warning btn-rm"
                    href="{{ route('gestionarDonante', ['id' => $donante->id]) }}">Cancelar</a>
                <button type="submit" class="btn btn-primary">Guardar</button>
            </div>

        </form>
    </div>
</body>

</html>
