@extends('layouts.app')

@section('content')
<div class="container-fluid py-4">

    <h1 class="mb-4">Lista de Agendas</h1>

    <!-- Tabla -->
    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <table class="table table-striped" id="tablaAgendas">
                    <thead class="table-dark">
                        <tr>
                            <th>#</th>
                            <th>Donante</th> <!-- Nueva columna -->
                            <th>Apellido</th> <!-- Nueva columna -->
                            <th>Fecha de la Agenda</th>
                            <th>Horario</th>
                            <th>Asistió</th>
                            <th>Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($agendas as $agenda)
                        <tr>
                            <td>{{ $agenda->id }}</td>
                            <td>{{ $agenda->donante->nombre ?? 'Sin donante' }}</td>
                            <td>{{ $agenda->donante->apellido ?? 'Sin apellido' }}</td>
                            <td>{{ \Carbon\Carbon::parse($agenda->fecha_agenda)->format('d/m/Y') }}</td>
                            <td>{{ $agenda->horario }}</td>
                            <td>{{ $agenda->asistio ? 'Sí' : 'No' }}</td>
                            <td>
                                <div class="d-flex gap-2 justify-content-center">
                                    <a href="{{ url('/agenda/' . $agenda->id . '/edit') }}" class="btn btn-sm btn-primary">
                                        <img src="{{ asset('imgs/edit_icon.png') }}" alt="Editar" style="width: 20px; height: 20px;">
                                    </a>
                                    <form action="{{ url('/agenda/' . $agenda->id) }}" method="post" onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta agenda?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">
                                           <img src="{{ asset('imgs/delete_icon.png') }}" alt="Editar" style="width: 20px; height: 20px;">
                                        </button>
                                    </form>
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
@endsection