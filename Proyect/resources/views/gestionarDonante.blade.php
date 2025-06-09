@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <div class="card shadow-lg mb-4">
            <div class="card-header bg-primary text-white">
                <h4 class="mb-0">
                    <i class="fas fa-user-circle me-2"></i>Información del Donante
                </h4>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover table-bordered">
                        <thead class="table-light">
                            <tr>
                                <th><i class="fas fa-user me-1"></i> Nombre</th>
                                <th><i class="fas fa-user me-1"></i> Apellido</th>
                                <th><i class="fas fa-id-card me-1"></i> CI</th>
                                <th><i class="fas fa-tint me-1"></i> ABO</th>
                                <th><i class="fas fa-tint me-1"></i> RH</th>
                                <th><i class="fas fa-calendar-alt me-1"></i> Última Donación</th>
                                <th><i class="fas fa-clock me-1"></i> Agenda</th>
                                <th><i class="fas fa-venus-mars me-1"></i> Sexo</th>
                                <th><i class="fas fa-info-circle me-1"></i> Estado</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="align-middle">
                                <td>{{ $donante->nombre }}</td>
                                <td>{{ $donante->apellido }}</td>
                                <td>{{ $donante->cedula }}</td>
                                <td><span class="badge bg-danger">{{ $donante->ABO }}</span></td>
                                <td><span class="badge bg-danger">{{ $donante->RH }}</span></td>
                                <td>{{ $donante->donaciones->sortByDesc('fecha')->first() ? \Carbon\Carbon::parse($donante->donaciones->sortByDesc('fecha')->first()->fecha)->format('d/m/Y') : 'Sin donaciones' }}</td>
                                <td>
                                    @if (is_null($agenda))
                                        <span class="text-muted">N/D</span>
                                    @else
                                        <span class="fw-bold">{{ $agenda->fecha_agenda }}</span>
                                        <span class="text-muted">|</span>
                                        <span class="fw-bold">{{ $agenda->horario }}</span>
                                    @endif
                                </td>
                                <td>{{ $donante->sexo }}</td>
                                <td>
                                    @php
                                        $estadoClass = [
                                            'Para Actualizar' => 'bg-warning',
                                            'Notificado' => 'bg-info',
                                            'Disponible' => 'bg-success',
                                            'Diferido' => 'bg-secondary'
                                        ][$donante->estado] ?? 'bg-light text-dark';
                                    @endphp
                                    <span class="badge {{ $estadoClass }}">{{ $donante->estado }}</span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

                @if (session('mensaje'))
                    <div class="alert alert-success alert-dismissible fade show mt-3">
                        <i class="fas fa-check-circle me-2"></i> {{ session('mensaje') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                <div class="d-flex justify-content-center flex-wrap gap-3 mt-4">
                    @if ($agenda && $agenda->asistio == null)
                        @php
                            $fechaAgenda = \Carbon\Carbon::parse($agenda->fecha_agenda)->toDateString();
                            $hoy = \Carbon\Carbon::now()->toDateString();
                        @endphp

                        @if ($hoy >= $fechaAgenda && strtolower($donante->estado) === strtolower('Para Actualizar'))
                            <div class="d-flex gap-3">
                                <a href="{{ route('diferimento.create', ['donante_id' => $donante->id]) }}" 
                                   class="btn btn-danger d-inline-block">
                                   <i class="fas fa-clock me-1"></i> Diferir Donante
                                </a>
                                <a href="{{ route('donacion.create', ['donante_id' => $donante->id]) }}" 
                                   class="btn btn-primary d-inline-block">
                                   <i class="fas fa-plus me-1"></i> Agregar Donación
                                </a>
                            </div>

                            <form action="{{ route('donante.no_asistio', ['id' => $donante->id]) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-outline-danger">
                                    <i class="fas fa-times-circle me-1"></i> No asistió
                                </button>
                            </form>
                        @endif
                    @endif

                    @if (strtolower($donante->estado) === strtolower('Notificado') || strtolower($donante->estado) === strtolower('Disponible'))
                        <a href="{{ route('agenda.create', ['donante_id' => $donante->id]) }}" 
                           class="btn btn-primary">
                           <i class="fas fa-calendar-plus me-1"></i> Agendar Donante
                        </a>
                    @endif
                    
                    @if (strtolower($donante->estado) === strtolower('Disponible'))
                        <form action="{{ route('donante.notificar', ['id' => $donante->id]) }}" method="POST">
                            @csrf
                            <button type="submit"
                                onclick="window.open('https://wa.me/598{{ $donante->telefono }}?text=Hola%20{{ urlencode($donante->nombre) }}%20{{ urlencode($donante->apellido) }}%2C%20te%20informamos%20que%20ya%20estás%20apto%20para%20donar%20sangre.%20¡Esperamos%20tu%20contribución%21', '_blank')"
                                class="btn btn-success">
                                <i class="fab fa-whatsapp me-1"></i> Enviar Recordatorio
                            </button>
                        </form>
                    @endif
                </div>
            </div>
        </div>

        <div class="row">
            <!-- Historial de donaciones -->
            <div class="col-md-6 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-history me-2"></i>Historial de Donaciones
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th><i class="fas fa-calendar-day me-1"></i> Fecha</th>
                                        <th><i class="fas fa-ellipsis-h me-1"></i> Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($donaciones->isEmpty())
                                        <tr>
                                            <td colspan="2" class="text-center text-muted py-3">
                                                <i class="fas fa-info-circle me-2"></i>No hay donaciones registradas
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($donaciones as $donacion)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($donacion->fecha)->format('d/m/Y') }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal"
                                                        data-bs-target="#modalDonacion"
                                                        data-fecha="{{ \Carbon\Carbon::parse($donacion->fecha)->format('d/m/Y') }}"
                                                        data-serologia="{{ $donacion->serologia }}"
                                                        data-anticuerpos_irregulares="{{ $donacion->anticuerpos_irregulares }}"
                                                        data-clase_donacion="{{ $donacion->clase_donacion }}">
                                                        <i class="fas fa-search me-1"></i> Detalles
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Historial de diferimientos -->
            <div class="col-md-6 mb-4">
                <div class="card h-100 shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0">
                            <i class="fas fa-clock me-2"></i>Historial de Diferimientos
                        </h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead class="table-light">
                                    <tr>
                                        <th><i class="fas fa-calendar-day me-1"></i> Fecha</th>
                                        <th><i class="fas fa-ellipsis-h me-1"></i> Opciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if ($diferimientos->isEmpty())
                                        <tr>
                                            <td colspan="2" class="text-center text-muted py-3">
                                                <i class="fas fa-info-circle me-2"></i>No hay diferimientos registrados
                                            </td>
                                        </tr>
                                    @else
                                        @foreach ($diferimientos as $diferimiento)
                                            <tr>
                                                <td>{{ \Carbon\Carbon::parse($diferimiento->fecha_diferimiento)->format('d/m/Y') }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-sm btn-outline-info" data-bs-toggle="modal"
                                                        data-bs-target="#modalDiferimiento"
                                                        data-fecha="{{ \Carbon\Carbon::parse($diferimiento->fecha_diferimiento)->format('d/m/Y') }}"
                                                        data-tipo="{{ $diferimiento->tipo }}"
                                                        data-tiempo_en_meses="{{ $diferimiento->tiempo_en_meses }}"
                                                        data-motivo="{{ $diferimiento->motivo }}">
                                                        <i class="fas fa-search me-1"></i> Detalles
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="text-center mt-3">
            <a href="{{ route(name: 'donante.index') }}" class="btn btn-outline-primary">
                <i class="fas fa-arrow-left me-1"></i> Volver al Listado
            </a>
        </div>
    </div>

    <!-- Modal de Diferimiento -->
    <div class="modal fade" id="modalDiferimiento" tabindex="-1" aria-labelledby="modalDiferimientoLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalDiferimientoLabel">
                        <i class="fas fa-clock me-2"></i>Detalle del Diferimiento
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <strong><i class="fas fa-calendar-day me-2"></i>Fecha:</strong>
                            <span id="modalFecha" class="float-end"></span>
                        </li>
                        <li class="list-group-item">
                            <strong><i class="fas fa-comment me-2"></i>Motivo:</strong>
                            <span id="modalMotivo" class="float-end"></span>
                        </li>
                        <li class="list-group-item">
                            <strong><i class="fas fa-tag me-2"></i>Tipo:</strong>
                            <span id="modalTipo" class="float-end"></span>
                        </li>
                        <li class="list-group-item">
                            <strong><i class="fas fa-hourglass-half me-2"></i>Tiempo en meses:</strong>
                            <span id="modalTiempo" class="float-end"></span>
                        </li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal de Donación -->
    <div class="modal fade" id="modalDonacion" tabindex="-1" aria-labelledby="modalDonacionLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalDonacionLabel">
                        <i class="fas fa-tint me-2"></i>Detalle de la Donación
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item">
                            <strong><i class="fas fa-calendar-day me-2"></i>Fecha:</strong>
                            <span id="donacionFecha" class="float-end"></span>
                        </li>
                        <li class="list-group-item">
                            <strong><i class="fas fa-flask me-2"></i>Serología:</strong>
                            <span id="donacionSerologia" class="float-end"></span>
                        </li>
                        <li class="list-group-item">
                            <strong><i class="fas fa-microscope me-2"></i>Anticuerpos irregulares:</strong>
                            <span id="donacionAnticuerpos" class="float-end"></span>
                        </li>
                        <li class="list-group-item">
                            <strong><i class="fas fa-tag me-2"></i>Clase de donación:</strong>
                            <span id="donacionClase" class="float-end"></span>
                        </li>
                    </ul>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                        <i class="fas fa-times me-1"></i> Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        const modal = document.getElementById('modalDiferimiento');
        modal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const fecha = button.getAttribute('data-fecha');
            const motivo = button.getAttribute('data-motivo');
            const tipo = button.getAttribute('data-tipo');
            const tiempo_en_meses = button.getAttribute('data-tiempo_en_meses');

            modal.querySelector('#modalFecha').textContent = fecha;
            modal.querySelector('#modalMotivo').textContent = motivo;
            modal.querySelector('#modalTipo').textContent = tipo;
            modal.querySelector('#modalTiempo').textContent = tiempo_en_meses;
        });

        const modalDonacion = document.getElementById('modalDonacion');
        modalDonacion.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const fecha = button.getAttribute('data-fecha');
            const serologia = button.getAttribute('data-serologia');
            const anticuerpos = button.getAttribute('data-anticuerpos_irregulares');
            const clase = button.getAttribute('data-clase_donacion');

            modalDonacion.querySelector('#donacionFecha').textContent = fecha;
            modalDonacion.querySelector('#donacionSerologia').textContent = serologia;
            modalDonacion.querySelector('#donacionAnticuerpos').textContent = anticuerpos;
            modalDonacion.querySelector('#donacionClase').textContent = clase;
        });
    </script>
@endsection