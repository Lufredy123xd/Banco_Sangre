@foreach ($usuarios as $usuario)
    <tr>
        <td>{{ $usuario->nombre }}</td>
        <td>{{ $usuario->apellido }}</td>
        <td>{{ $usuario->cedula }}</td>
        <td>{{ $usuario->tipo_usuario }}</td>
        <td>
            @php
                $cursoClass =
                    [
                        'Hemoterapia I' => 'bg-success',
                        'Hemoterapia II' => 'bg-warning',
                        'Hemoterapia III' => 'bg-secondary',
                        'Hemoterapia IV' => 'bg-danger',
                        'No Aplica' => 'bg-info',
                    ][$usuario->curso_hemoterapia] ?? 'bg-light text-dark';

            @endphp
            <span class="badge {{ $cursoClass }}">

                {{ $usuario->curso_hemoterapia ?: 'No especificado' }}
            </span>
        </td>
        <td>
            <div class="align-items-center gap-2">
                <a href="{{ url('/usuario/' . $usuario->id . '/edit') }}" class="btn btn-sm btn-primary" title="Editar">
                    <i class="fas fa-edit"></i>
                </a>
            </div>
        </td>
        <td>
            @php
                $estadoClass =
                    [
                        'Activo' => 'bg-success',
                        'Inactivo' => 'bg-secondary',
                        'Suspendido' => 'bg-warning',
                    ][$usuario->estado] ?? 'bg-light text-dark';
            @endphp
            <span class="badge {{ $estadoClass }}">{{ $usuario->estado }}</span>
        </td>
    </tr>
@endforeach