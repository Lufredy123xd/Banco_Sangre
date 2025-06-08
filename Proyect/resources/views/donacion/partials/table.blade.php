{{-- resources/views/donacion/partials/tabla.blade.php --}}
@foreach ($donaciones as $donacion)
    <tr class="fila-donacion">
        <td>{{ $donacion->donante->nombre }} {{ $donacion->donante->apellido }}</td>
        <td class="fecha-donacion">
            {{ \Carbon\Carbon::parse($donacion->fecha)->format('d/m/Y') }}</td>
        <td>{{ $donacion->clase_donacion }}</td>
        <td>
            <div class="d-flex gap-2 justify-content-center">
                <a href="{{ url('/donacion/' . $donacion->id . '/edit') }}"
                    class="btn btn-primary btn-sm"><img src="{{ asset('imgs/edit_icon.png') }}"
                        alt="Editar" style="width: 20px; height: 20px;"></a>
            </div>
        </td>
    </tr>
@endforeach