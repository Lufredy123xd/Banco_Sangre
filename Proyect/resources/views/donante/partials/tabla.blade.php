@foreach ($donantes as $donante)
    <tr class="fila-usuario">
        <td class="nombre">{{ $donante->nombre }}</td>
        <td class="apellido">{{ $donante->apellido }}</td>
        <td class="cedula">{{ $donante->cedula }}</td>
        <td class="abo">{{ $donante->ABO }}</td>
        <td class="rh">{{ $donante->RH }}</td>
        @php
            $ultimaDonacion = $donante->donaciones->filter(fn($d) => $d->fecha)->sortByDesc('fecha')->first();
        @endphp
        <td class="fecha">
            {{ $ultimaDonacion ? \Carbon\Carbon::parse($ultimaDonacion->fecha)->format('d/m/Y') : 'Sin donaciones' }}
        </td>

        <td class="sexo">{{ $donante->sexo }}</td>
        <td>
            <a href="{{ url('/donante/' . $donante->id . '/edit') }}" class="btn btn-sm btn-primary">
                <img src="{{ asset('imgs/edit_icon.png') }}" alt="Editar" style="width: 20px; height: 20px;">
            </a>
        </td>
        <td>
            <button class="btn btn-sm btn-info" onclick="verMas({{ $donante->id }})" data-bs-toggle="modal"
                data-bs-target="#verMasModal">
                <img src="{{ asset('imgs/ver_mas_icon.png') }}" alt="Ver más" style="width: 20px; height: 20px;">
            </button>
        </td>
        <td>
            <a href="{{ route('gestionarDonante', ['id' => $donante->id]) }}" class="btn btn-sm btn-warning">
                <img src="{{ asset('imgs/gestionar_icon.png') }}" alt="Gestionar" style="width: 20px; height: 20px;">
            </a>
        </td>
        <td class="estado {{ strtolower(str_replace(' ', '-', $donante->estado)) }}">
            {{ $donante->estado }}
        </td>
    </tr>
@endforeach
