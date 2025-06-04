@extends('layouts.app')

@section('content')
    <div class="container-fluid py-4">

        <h1 class="mb-4">Lista de Agendas</h1>

        <!-- Filtros de búsqueda -->
        <div class="row mb-3">
            <div class="col-md-3">
                <label for="">Fecha inicio</label>
                <input type="date" id="fecha_inicio" class="form-control" placeholder="Fecha inicio">
            </div>
            <div class="col-md-3">
                <label for="">Fecha fin</label>
                <input type="date" id="fecha_fin" class="form-control" placeholder="Fecha fin">
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

            attachPaginationEvents();
        });
    </script>
@endsection
