@foreach ($usuarios as $usuario)
    <tr class="fila-usuario">
        <td class="nombre">{{ $usuario->nombre }}</td>
        <td class="apellido">{{ $usuario->apellido }}</td>
        <td class="cedula">{{ $usuario->cedula }}</td>
        <td class="tipo_usuario">{{ $usuario->tipo_usuario }}</td>
        <td class="curso_hemoterapia">{{ $usuario->curso_hemoterapia }}</td>
        <td>
            <a href="{{ url('/usuario/' . $usuario->id . '/edit') }}" class="btn btn-sm btn-primary">
                <img src="{{ asset('imgs/edit_icon.png') }}" alt="Editar" style="width: 20px; height: 20px;">
            </a>
        </td>
        <td>
            <button class="btn btn-sm btn-info" data-bs-toggle="modal" data-bs-target="#modalUsuario"
                data-nombre="{{ $usuario->nombre }}" data-apellido="{{ $usuario->apellido }}"
                data-cedula="{{ $usuario->cedula }}" data-tipo_usuario="{{ $usuario->tipo_usuario }}"
                data-curso_hemoterapia="{{ $usuario->curso_hemoterapia }}" data-estado="{{ $usuario->estado }}">
                <img src="{{ asset('imgs/ver_mas_icon.png') }}" alt="Ver más" style="width: 20px; height: 20px;">
            </button>
        </td>
        <td class="estado {{ strtolower(str_replace(' ', '-', $usuario->estado)) }}">
            {{ $usuario->estado }}
        </td>
    </tr>
@endforeach
