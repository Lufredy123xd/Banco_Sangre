<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Agenda | Sistema de Donaciones</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .card-header {
            background-color: #0d6efd;
            color: white;
        }
        .form-container {
            max-width: 600px;
            margin: 0 auto;
        }
        .btn-primary {
            background-color: #0d6efd;
            border-color: #0d6efd;
        }
    </style>
</head>

<body class="bg-light">
    <div class="container py-5">
        <div class="form-container">
            <!-- Encabezado -->
            <div class="card shadow mb-4">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h2 class="mb-0">
                        <i class="fas fa-calendar-edit me-2"></i>Editar Agenda
                    </h2>
                    <a href="{{ route('agenda.index') }}" class="btn btn-outline-light btn-sm">
                        <i class="fas fa-arrow-left me-1"></i> Volver
                    </a>
                </div>
                
                <!-- Formulario -->
                <div class="card-body">
                    <form action="{{ url('/agenda/' . $agenda->id) }}" method="POST">
                        @csrf
                        @method('PATCH')

                        <!-- Información del Donante -->
                        <div class="mb-4 p-3 bg-light rounded">
                            <h5 class="mb-3 text-primary">
                                <i class="fas fa-user-circle me-2"></i>Información del Donante
                            </h5>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        <i class="fas fa-user me-1"></i>Nombre
                                    </label>
                                    <input type="text" class="form-control bg-white" 
                                           value="{{ $agenda->donante->nombre ?? 'N/A' }}" readonly>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        <i class="fas fa-user me-1"></i>Apellido
                                    </label>
                                    <input type="text" class="form-control bg-white" 
                                           value="{{ $agenda->donante->apellido ?? 'N/A' }}" readonly>
                                </div>
                            </div>
                        </div>

                        <!-- Detalles de la Agenda -->
                        <div class="mb-4">
                            <h5 class="mb-3 text-primary">
                                <i class="fas fa-calendar-alt me-2"></i>Detalles de la Agenda
                            </h5>
                            
                            <!-- Fecha -->
                            <div class="mb-3">
                                <label for="fecha_agenda" class="form-label">
                                    <i class="fas fa-calendar-day me-1"></i>Fecha
                                </label>
                                <input type="date" id="fecha_agenda" name="fecha_agenda" 
                                       class="form-control" value="{{ $agenda->fecha_agenda }}" required>
                            </div>

                            <!-- Horario -->
                            <div class="mb-3">
                                <label for="horario" class="form-label">
                                    <i class="fas fa-clock me-1"></i>Horario
                                </label>
                                <input type="time" id="horario" name="horario" 
                                       class="form-control" value="{{ $agenda->horario }}" required>
                            </div>

                            <!-- Asistencia -->
                            <div class="mb-3">
                                <label for="asistio" class="form-label">
                                    <i class="fas fa-check-circle me-1"></i>Asistencia
                                </label>
                                <select id="asistio" name="asistio" class="form-select" required>
                                    <option value="1" {{ $agenda->asistio == 1 ? 'selected' : '' }}>
                                        <i class="fas fa-check text-success me-1"></i> Sí asistió
                                    </option>
                                    <option value="0" {{ $agenda->asistio == 0 ? 'selected' : '' }}>
                                        <i class="fas fa-times text-danger me-1"></i> No asistió
                                    </option>
                                </select>
                            </div>
                        </div>

                        <!-- Botones -->
                        <div class="d-flex justify-content-between mt-4">
                            <a href="{{ route('agenda.index') }}" class="btn btn-outline-secondary">
                                <i class="fas fa-times me-1"></i> Cancelar
                            </a>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-1"></i> Guardar Cambios
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Mensajes -->
            @if (session('mensaje'))
                <div class="alert alert-success alert-dismissible fade show mt-3">
                    <i class="fas fa-check-circle me-2"></i> {{ session('mensaje') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show mt-3">
                    <i class="fas fa-exclamation-triangle me-2"></i> Por favor corrige los siguientes errores:
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>