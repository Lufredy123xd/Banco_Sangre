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
        <td class="sexo">{{ $donante->sexo === 'M' ? 'Masculino' : 'Femenino' }}</td>
        <td>
            <div class="d-flex justify-content-center gap-2">
                <a href="{{ route('gestionarDonante', ['id' => $donante->id]) }}" class="btn btn-sm btn-danger"
                    title="Gestionar">
                    <i class="fas fa-droplet"></i>
                </a>
                <button class="btn btn-sm btn-info" onclick="verMas({{ $donante->id }})" data-bs-toggle="modal"
                    data-bs-target="#verMasModal" title="Ver más">
                    <i class="fas fa-eye"></i>
                </button>
                <a href="{{ url('/donante/' . $donante->id . '/edit') }}" class="btn btn-sm btn-primary" title="Editar">
                    <i class="fas fa-user-pen"></i>
                </a>
            </div>
        </td>
        <td class="estado {{ strtolower(str_replace(' ', '-', $donante->estado)) }}">
            {{ $donante->estado }}
        </td>

    </tr>
@endforeach
