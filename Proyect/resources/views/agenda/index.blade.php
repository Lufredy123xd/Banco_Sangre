@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">
        <!-- Encabezado -->
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="mb-0"><i class="fas fa-calendar-alt me-2"></i>Lista de Agendas</h1>
            <div class="btn-group">
                <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearAgenda">
                    <i class="fas fa-plus-circle me-2"></i> Nueva Agenda
                </a>
                <a id="btnExportarPDF" class="btn btn-danger">
                    <i class="fas fa-file-pdf me-2"></i> Exportar PDF
                </a>
            </div>
        </div>

        <!-- Filtros de búsqueda -->
        <div class="card shadow-sm mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fas fa-filter me-2"></i>Filtros</h5>
            </div>
            <div class="card-body">
                <div class="row g-3 align-items-center">
                    <div class="col-md-4">
                        <label for="fecha_inicio" class="form-label">Fecha inicio</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                            <input type="date" id="fecha_inicio" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="fecha_fin" class="form-label">Fecha fin</label>
                        <div class="input-group">
                            <span class="input-group-text"><i class="fas fa-calendar"></i></span>
                            <input type="date" id="fecha_fin" class="form-control">
                        </div>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button id="btnLimpiarFiltros" class="btn btn-outline-secondary">
                            <i class="fas fa-broom me-2"></i>Limpiar
                        </button>
                    </div>
                </div>
            </div>
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
                <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Tabla de agendas -->
        <div class="card shadow-sm">
            <div class="card-header bg-light d-flex justify-content-between align-items-center">
                <h5 class="mb-0"><i class="fas fa-list me-2"></i>Agendas Programadas</h5>
                <span class="badge bg-primary">{{ $agendas->total() }} registros</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0" id="tablaAgendas">
                        <thead class="table-light">
                            <tr>
                                <th><i class="fas fa-user me-1"></i> Nombre</th>
                                <th><i class="fas fa-user me-1"></i> Apellido</th>
                                <th><i class="fas fa-id-card me-1"></i> Cédula</th>
                                <th><i class="fas fa-calendar-day me-1"></i> Fecha</th>
                                <th><i class="fas fa-clock me-1"></i> Horario</th>
                                <th><i class="fas fa-check-circle me-1"></i> Asistencia</th>
                                <th><i class="fas fa-cog me-1"></i> Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($agendas as $agenda)
                                <tr>
                                    <td>{{ $agenda->donante->nombre ?? 'N/A' }}</td>
                                    <td>{{ $agenda->donante->apellido ?? 'N/A' }}</td>
                                    <td>{{ $agenda->donante->cedula ?? 'N/A' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($agenda->fecha_agenda)->format('d/m/Y') }}</td>
                                    <td>{{ $agenda->horario }}</td>
                                    <td>
                                        @if($agenda->asistio)
                                            <span class="badge bg-success"><i class="fas fa-check me-1"></i>Sí</span>
                                        @else
                                            <span class="badge bg-danger"><i class="fas fa-times me-1"></i>No</span>
                                        @endif
                                    </td>
                                    <td>
                                        <div class="d-flex gap-2">
                                            <a href="{{ url('/agenda/' . $agenda->id . '/edit') }}" 
                                               class="btn btn-sm btn-primary" title="Editar">
                                               <i class="fas fa-edit"></i>
                                            </a>
                                            @if (!$agenda->asistio)
                                                <form action="{{ url('/agenda/' . $agenda->id) }}" method="post"
                                                    onsubmit="return confirm('¿Estás seguro de eliminar esta agenda?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" title="Eliminar">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer bg-light">
                    {{ $agendas->links('pagination::bootstrap-5') }}
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Crear Agenda -->
    <div class="modal fade" id="modalCrearAgenda" tabindex="-1" aria-labelledby="modalCrearAgendaLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalCrearAgendaLabel">
                        <i class="fas fa-calendar-plus me-2"></i>Nueva Agenda
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <form id="formCrearAgenda" action="{{ url('/agenda') }}" method="POST">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="donante_id" class="form-label">
                                <i class="fas fa-user me-1"></i>Donante
                            </label>
                            @php
                                use App\Enums\EstadoDonante;
                            @endphp
                            <select class="form-select" id="donante_id" name="id_donante" required>
                                <option value="">Seleccione un donante</option>
                                @foreach (\App\Models\Donante::where('estado', EstadoDonante::Disponible->value)->orderBy('nombre')->get() as $donante)
                                    <option value="{{ $donante->id }}">{{ $donante->nombre }} {{ $donante->apellido }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="fecha_agenda" class="form-label">
                                <i class="fas fa-calendar-day me-1"></i>Fecha
                            </label>
                            <input type="date" class="form-control" id="fecha_agenda" name="fecha_agenda" required>
                        </div>
                        <div class="mb-3">
                            <label for="horario" class="form-label">
                                <i class="fas fa-clock me-1"></i>Horario
                            </label>
                            <input type="time" class="form-control" id="horario" name="horario" required>
                        </div>
                        <input type="hidden" id="asistio" name="asistio" value="">
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                            <i class="fas fa-times me-2"></i>Cancelar
                        </button>
                        <button type="button" id="btnGuardarAgenda" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Guardar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fechaInicio = document.getElementById('fecha_inicio');
            const fechaFin = document.getElementById('fecha_fin');
            const btnLimpiar = document.getElementById('btnLimpiarFiltros');
            const tablaBody = document.querySelector('#tablaAgendas tbody');

            // Función para cargar agendas con AJAX
            function fetchAgendas(page = 1) {
                const params = new URLSearchParams({
                    fecha_inicio: fechaInicio.value,
                    fecha_fin: fechaFin.value,
                    page: page
                });

                fetch(`/agenda/buscar?${params}`)
                    .then(response => response.json())
                    .then(data => {
                        tablaBody.innerHTML = data.tabla;
                        const paginacionDiv = document.querySelector('.card-footer');
                        if (paginacionDiv) {
                            paginacionDiv.innerHTML = data.paginacion;
                            attachPaginationEvents();
                        }
                    })
                    .catch(err => console.error('Error en la búsqueda:', err));
            }

            // Limpiar filtros
            btnLimpiar.addEventListener('click', function() {
                fechaInicio.value = '';
                fechaFin.value = '';
                fetchAgendas();
            });

            // Eventos para los filtros
            fechaInicio.addEventListener('change', () => fetchAgendas());
            fechaFin.addEventListener('change', () => fetchAgendas());

            // AJAX para crear agenda
            document.getElementById('btnGuardarAgenda').addEventListener('click', function() {
                const form = document.getElementById('formCrearAgenda');
                const formData = new FormData(form);

                fetch(form.action, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': form.querySelector('input[name="_token"]').value
                    },
                    body: formData
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalCrearAgenda'));
                        modal.hide();
                        form.reset();
                        fetchAgendas();
                        
                        // Mostrar notificación de éxito
                        const alertDiv = document.createElement('div');
                        alertDiv.className = 'alert alert-success alert-dismissible fade show';
                        alertDiv.innerHTML = `
                            <i class="fas fa-check-circle me-2"></i>${data.mensaje}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        `;
                        document.querySelector('.container-fluid').prepend(alertDiv);
                        
                        // Eliminar la alerta después de 5 segundos
                        setTimeout(() => alertDiv.remove(), 5000);
                    }
                })
                .catch(err => {
                    console.error(err);
                    alert('Error al guardar la agenda');
                });
            });

            // Manejar eventos de paginación
            function attachPaginationEvents() {
                document.querySelectorAll('.pagination a').forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        const url = new URL(link.href);
                        const page = url.searchParams.get('page') || 1;
                        fetchAgendas(page);
                    });
                });
            }

            // Inicializar eventos de paginación
            attachPaginationEvents();
        });

        // Exportar a PDF
        document.getElementById('btnExportarPDF').addEventListener('click', function() {
                const fechaInicio = document.getElementById('fecha_inicio').value;
                const fechaFin = document.getElementById('fecha_fin').value;

                let url = new URL("{{ route('agenda.exportar.pdf') }}", window.location.origin);
                if (fechaInicio) url.searchParams.append('fecha_inicio', fechaInicio);
                if (fechaFin) url.searchParams.append('fecha_fin', fechaFin);

                window.location.href = url;
            });
    </script>
@endsection