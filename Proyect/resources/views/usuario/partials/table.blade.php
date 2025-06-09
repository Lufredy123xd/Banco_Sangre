@foreach ($usuarios as $usuario)
    <tr>
        <td>{{ $usuario->nombre }}</td>
        <td>{{ $usuario->apellido }}</td>
        <td>{{ $usuario->cedula }}</td>
        <td>{{ $usuario->tipo_usuario }}</td>
        <td>
            @php
                $cursoClass = [
                    'Completado' => 'bg-success',
                    'En Progreso' => 'bg-warning',
                    'Pendiente' => 'bg-secondary',
                    'No Aplica' => 'bg-info'
                ][$usuario->curso_hemoterapia] ?? 'bg-light text-dark';
                
                $cursoIcon = [
                    'Completado' => 'fa-check-circle',
                    'En Progreso' => 'fa-spinner',
                    'Pendiente' => 'fa-clock',
                    'No Aplica' => 'fa-minus-circle'
                ][$usuario->curso_hemoterapia] ?? 'fa-question-circle';
            @endphp
            <span class="badge {{ $cursoClass }}">
                <i class="fas {{ $cursoIcon }} me-1"></i> {{ $usuario->curso_hemoterapia ?: 'No especificado' }}
            </span>
        </td>
        <td>
            <div class="d-flex gap-2">
                <a href="{{ url('/usuario/' . $usuario->id . '/edit') }}" 
                   class="btn btn-sm btn-primary" title="Editar">
                   <i class="fas fa-edit"></i>
                </a>
                
            </div>
        </td>
        <td>
            @php
                $estadoClass = [
                    'Activo' => 'bg-success',
                    'Inactivo' => 'bg-secondary',
                    'Suspendido' => 'bg-warning',
                    'Pendiente' => 'bg-info'
                ][$usuario->estado] ?? 'bg-light text-dark';
                
                $estadoIcon = [
                    'Activo' => 'fa-check-circle',
                    'Inactivo' => 'fa-times-circle',
                    'Suspendido' => 'fa-exclamation-circle',
                    'Pendiente' => 'fa-clock'
                ][$usuario->estado] ?? 'fa-question-circle';
            @endphp
            <span class="badge {{ $estadoClass }}">
                <i class="fas {{ $estadoIcon }} me-1"></i> {{ $usuario->estado }}
            </span>
        </td>
    </tr>
@endforeach