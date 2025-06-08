@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">

        <h1 class="mb-4">Lista de Agendas</h1>

        <!-- Filtros de búsqueda -->
        <div class="card mb-4">
            <div class="card-body">
                <div class="row g-3 align-items-end">
                    <div class="col-md-3">
                        <label for="fecha_inicio">Fecha inicio</label>
                        <input type="date" id="fecha_inicio" class="form-control" placeholder="Fecha inicio">
                    </div>
                    <div class="col-md-3">
                        <label for="fecha_fin">Fecha fin</label>
                        <input type="date" id="fecha_fin" class="form-control" placeholder="Fecha fin">
                    </div>

                    <div class="col-md-6 text-md-end">
                        <a href="#" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalCrearAgenda">
                            <i class="bi bi-plus-circle"></i> Agregar Agenda
                        </a>
                    </div>

                </div>
            </div>
        </div>

        <!-- Tabla -->
        <div class="row">
            <div class="col-12">
                <div class="table-responsive">
                    <table class="table table-striped" id="tablaAgendas">
                        <thead class="table-dark">
                            <tr>
                                <th>Donante</th> <!-- Nueva columna -->
                                <th>Apellido</th> <!-- Nueva columna -->
                                <th>Fecha de la Agenda</th>
                                <th>Horario</th>
                                <th>Asistió</th>
                                <th>Editar</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($agendas as $agenda)
                                <tr>
                                    <td>{{ $agenda->donante->nombre ?? 'Sin donante' }}</td>
                                    <td>{{ $agenda->donante->apellido ?? 'Sin apellido' }}</td>
                                    <td>{{ \Carbon\Carbon::parse($agenda->fecha_agenda)->format('d/m/Y') }}</td>
                                    <td>{{ $agenda->horario }}</td>
                                    <td>
                                        {{ $agenda->asistio ? 'Sí' : 'No' }}</td>
                                    <td>
                                        <div class="d-flex gap-2 justify-content-center">
                                            <a href="{{ url('/agenda/' . $agenda->id . '/edit') }}"
                                                class="btn btn-sm btn-primary">
                                                <img src="{{ asset('imgs/edit_icon.png') }}" alt="Editar"
                                                    style="width: 20px; height: 20px;">
                                            </a>
                                            @if (!$agenda->asistio)
                                                <form action="{{ url('/agenda/' . $agenda->id) }}" method="post"
                                                    onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta agenda?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-danger btn-sm">
                                                        <img src="{{ asset('imgs/delete_icon.png') }}" alt="Editar"
                                                            style="width: 20px; height: 20px;">
                                                    </button>
                                                </form>
                                            @endif
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <div>
                        {{ $agendas->links('pagination::bootstrap-5') }}
                    </div>
                </div>
            </div>
        </div>



        <!-- Mensaje -->
        @if (session('mensaje'))
            <div class="alert alert-success mt-3">
                {{ session('mensaje') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-warning mt-3">
                {{ session('error') }}
            </div>
        @endif

    </div>



    <!-- Modal Crear Agenda -->
    <div class="modal fade" id="modalCrearAgenda" tabindex="-1" aria-labelledby="modalCrearAgendaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="formCrearAgenda" action="{{ url('/agenda') }}" method="POST" class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title" id="modalCrearAgendaLabel">Crear Nueva Agenda</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="donante_id" class="form-label">Donante</label>
                        <select class="form-select" id="donante_id" name="id_donante" required>
                            <option value="">Seleccione un donante</option>
                            @foreach (\App\Models\Donante::orderBy('nombre')->get() as $donante)
                                <option value="{{ $donante->id }}">{{ $donante->nombre }} {{ $donante->apellido }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="fecha_agenda" class="form-label">Fecha de la Agenda</label>
                        <input type="date" class="form-control" id="fecha_agenda" name="fecha_agenda" required>
                    </div>
                    <div class="mb-3">
                        <label for="horario" class="form-label">Horario</label>
                        <input type="time" class="form-control" id="horario" name="horario" required>
                    </div>
                    <input type="hidden" id="asistio" name="asistio" value="">
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <button type="button" id="btnGuardarAgenda" class="btn btn-primary">Guardar Agenda</button>
                </div>
            </form>
        </div>
    </div>


    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fechaInicio = document.getElementById('fecha_inicio');
            const fechaFin = document.getElementById('fecha_fin');
            const tablaBody = document.querySelector('#tablaAgendas tbody');

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
                        // Selecciona el div de paginación después de actualizar el DOM
                        const paginacionDiv = document.querySelector('.table-responsive > div');
                        if (paginacionDiv) {
                            paginacionDiv.innerHTML = data.paginacion;
                            attachPaginationEvents();
                        }
                    })
                    .catch(err => console.error('Error en la búsqueda:', err));
            }

            function attachPaginationEvents() {
                const paginacionDiv = document.querySelector('.table-responsive > div');
                if (!paginacionDiv) return;
                paginacionDiv.querySelectorAll('.pagination a').forEach(link => {
                    link.addEventListener('click', function(e) {
                        e.preventDefault();
                        const url = new URL(link.href);
                        const page = url.searchParams.get('page') || 1;
                        fetchAgendas(page);
                    });
                });
            }

            fechaInicio.addEventListener('input', () => fetchAgendas());
            fechaFin.addEventListener('input', () => fetchAgendas());

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
                        // Cierra el modal
                        const modal = bootstrap.Modal.getOrCreateInstance(document.getElementById('modalCrearAgenda'));
                        modal.hide();

                        // Limpia el formulario
                        form.reset();

                        // Recarga la tabla de agendas
                        fetchAgendas();

                        // Opcional: muestra mensaje de éxito
                        alert(data.mensaje);
                    }
                })
                .catch(err => {
                    alert('Error al guardar la agenda');
                    console.error(err);
                });
            });

            attachPaginationEvents();
        });
    </script>
@endsection
