@if ($agendas->count())
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
@else
    <tr>
        <td colspan="6" class="text-center py-4">
            <i class="fas fa-calendar-times fa-2x text-muted mb-2"></i>
            <p class="mb-0">No se encontraron agendas programadas</p>
        </td>
    </tr>
@endif