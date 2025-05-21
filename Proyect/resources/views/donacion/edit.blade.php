{{-- filepath: resources/views/donacion/edit.blade.php --}}
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Donación</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <h1 class="mb-4 text-center">Editar Donación</h1>
        <form action="{{ url('/donacion/' . $donacion->id) }}" method="POST" class="p-4 border rounded shadow">
            {{ csrf_field() }}
            {{ method_field('PATCH') }}

            <div class="mb-3">
                <label for="id_donante" class="form-label">Donante:</label>

                @php
                    $donante = App\Models\Donante::find($donacion->id_donante);
                    $nombreCompleto = $donante->nombre . ' ' . $donante->apellido;
                @endphp

                <input type="hidden" id="id_donante" name="id_donante" value="{{ $donacion->id_donante }}">
                <input value="{{ $nombreCompleto }}" class="form-control" required>
                    
            </div>

            <div class="mb-3">
                <label for="fecha" class="form-label">Fecha:</label>
                <input type="date" id="fecha" name="fecha" class="form-control" value="{{ $donacion->fecha }}" required>
            </div>

            <div class="mb-3">
                <label for="serologia" class="form-label">Serología:</label>
                <select id="serologia" name="serologia" class="form-control" required>
                    @foreach (App\Enums\TipoSerologia::cases() as $tipo)
                        <option value="{{ $tipo->value }}" {{ $donacion->serologia === $tipo->value ? 'selected' : '' }}>
                            {{ $tipo->value }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="anticuerpos_irregulares" class="form-label">Anticuerpos Irregulares:</label>
                <select id="anticuerpos_irregulares" name="anticuerpos_irregulares" class="form-control" required>
                    @foreach (App\Enums\TipoAnticuerposIrregulares::cases() as $tipo)
                        <option value="{{ $tipo->value }}" {{ $donacion->anticuerpos_irregulares === $tipo->value ? 'selected' : '' }}>
                            {{ $tipo->value }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="clase_donacion" class="form-label">Clase de Donación:</label>
                <select id="clase_donacion" name="clase_donacion" class="form-control" required>
                    @foreach (App\Enums\TipoDonacion::cases() as $tipo)
                        <option value="{{ $tipo->value }}" {{ $donacion->clase_donacion === $tipo->value ? 'selected' : '' }}>
                            {{ $tipo->value }}
                        </option>
                    @endforeach
                </select>
            </div>

            <a href="{{ route('donacion.index') }}" class="btn btn-secondary">Cancelar</a>
            <button type="submit" class="btn btn-primary">Guardar Cambios</button>
        </form>
    </div>
</body>

</html>