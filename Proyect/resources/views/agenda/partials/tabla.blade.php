@if ($agendas->count())
    @foreach ($agendas as $agenda)
        <tr>
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
                    <form action="{{ url('/agenda/' . $agenda->id) }}" method="post"
                        onsubmit="return confirm('¿Estás seguro de que deseas eliminar esta agenda?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm">
                            <img src="{{ asset('imgs/delete_icon.png') }}" alt="Editar"
                                style="width: 20px; height: 20px;">
                        </button>
                    </form>
                </div>
            </td>
        </tr>
    @endforeach
@else
    <tr>
        <td colspan="7" class="text-center">No se encontraron agendas en ese rango de fechas.</td>
    </tr>
@endif
