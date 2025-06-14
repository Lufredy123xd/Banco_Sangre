@if ($diferimentos->isEmpty())
    <tr>
        <td colspan="6" class="text-center text-muted">No se encontraron diferimientos en el rango de fechas.</td>
    </tr>
@else
    @foreach ($diferimentos as $diferimento)
        @php
            $donante = $diferimento->donante;
            $nombreDonante = $donante ? $donante->nombre . ' ' . $donante->apellido : 'Donante no encontrado';

        @endphp
        <tr>
            <td>{{ $nombreDonante ? $nombreDonante : 'Donante no encontrado' }}</td>
            <td>{{ Str::limit($diferimento->motivo, 30) }}</td>
            <td>{{ date('d/m/Y', strtotime($diferimento->fecha_diferimiento)) }}</td>
            <td>
                <span class="badge {{ $diferimento->tipo == 'Permanente' ? 'bg-danger' : 'bg-warning text-dark' }}">
                    {{ $diferimento->tipo }}
                </span>
            </td>
            <td>
                {{ $diferimento->tipo == 'Temporal' ? $diferimento->tiempo_en_meses . ' meses' : 'Indefinido' }}
            </td>
            <td>
                <div class="d-flex justify-content-center gap-2">
                    <a href="{{ url('/diferimento/' . $diferimento->id . '/edit') }}" class="btn btn-sm btn-outline-primary"
                        title="Editar">
                        <i class="fas fa-edit"></i>
                    </a>
                    <form action="{{ url('/diferimento/' . $diferimento->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-outline-danger" title="Eliminar"
                            onclick="return confirm('¿Estás seguro de eliminar este diferimieinto?')">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                </div>
            </td>
        </tr>
    @endforeach
@endif
