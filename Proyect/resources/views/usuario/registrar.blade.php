@extends('layouts.app')

@section('content')
<div class="container py-4">
    <!-- Encabezado -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="mb-0"><i class="fas fa-user-plus me-2"></i>Registrar Nuevo Usuario</h1>
    </div>

    <!-- Mensajes -->
    @if (session('mensaje'))
        <div class="alert alert-success alert-dismissible fade show">
            <i class="fas fa-check-circle me-2"></i> {{ session('mensaje') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show">
            <i class="fas fa-exclamation-triangle me-2"></i> {{ session('error') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <!-- Formulario -->
    <div class="card shadow-lg">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0"><i class="fas fa-user-circle me-2"></i>Datos del Usuario</h5>
        </div>
        <div class="card-body">
            <form action="{{ url('/usuario') }}" method="POST">
                @csrf

                <!-- Sección 1: Información Básica -->
                <div class="mb-4">
                    <h5 class="text-primary mb-3"><i class="fas fa-id-card me-2"></i>Información Personal</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="nombre" id="txt__nombre" required
                                    placeholder="Nombre" maxlength="50" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+"
                                    title="Solo letras y espacios">
                                <label for="txt__nombre">Nombre</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="apellido" id="txt__apellido" required
                                    placeholder="Apellido" maxlength="50" pattern="[A-Za-zÁÉÍÓÚáéíóúÑñ\s]+"
                                    title="Solo letras y espacios">
                                <label for="txt__apellido">Apellido</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="cedula" id="txt__cedula" required
                                    placeholder="Cédula" maxlength="8" pattern="\d+"
                                    title="Solo números">
                                <label for="txt__cedula">Cédula</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="date" class="form-control" name="fecha_nacimiento" id="txt__fecha_nacimiento" required
                                    max="{{ date('Y-m-d') }}" title="Fecha no puede ser posterior a hoy">
                                <label for="txt__fecha_nacimiento">Fecha de Nacimiento</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sección 2: Datos de Cuenta -->
                <div class="mb-4">
                    <h5 class="text-primary mb-3"><i class="fas fa-user-shield me-2"></i>Datos de Cuenta</h5>
                    <div class="row g-3">
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select" name="tipo_usuario" id="txt__tipo_usuario" required>
                                    @foreach (App\Enums\TipoUsuario::cases() as $tipo)
                                        <option value="{{ $tipo->value }}">{{ $tipo->value }}</option>
                                    @endforeach
                                </select>
                                <label for="txt__tipo_usuario">Tipo de Usuario</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select" name="curso_hemoterapia" id="txt__curso">
                                    <option value="">Seleccione un curso</option>
                                    @foreach (App\Enums\Curso::cases() as $curso)
                                        <option value="{{ $curso->value }}">{{ $curso->value }}</option>
                                    @endforeach
                                </select>
                                <label for="txt__curso">Curso (para estudiantes)</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="text" class="form-control" name="nombre_usuario" id="txt__nombre_usuario" required
                                    placeholder="Nombre de usuario" maxlength="50" pattern="[A-Za-z0-9_]+"
                                    title="Letras, números y guiones bajos">
                                <label for="txt__nombre_usuario">Nombre de Usuario</label>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <input type="password" class="form-control" name="password" id="txt__password" required
                                    minlength="8" maxlength="20" pattern="(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}"
                                    title="Mínimo 8 caracteres con letras y números">
                                <label for="txt__password">Contraseña</label>
                                <small class="text-muted">Mínimo 8 caracteres con letras y números</small>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-floating">
                                <select class="form-select" name="estado" id="txt__estado" required>
                                    @foreach (App\Enums\EstadoUsuario::cases() as $estado)
                                        <option value="{{ $estado->value }}">{{ $estado->value }}</option>
                                    @endforeach
                                </select>
                                <label for="txt__estado">Estado</label>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones -->
                <div class="d-flex justify-content-end gap-3 mt-4">
                    <a href="{{ route('usuario.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-arrow-left me-2"></i> Cancelar
                    </a>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save me-2"></i> Registrar Usuario
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection