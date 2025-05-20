<!DOCTYPE html>
<html>

<head>
    <title>Lista de Donantes</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 12px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        h2 {
            text-align: center;
        }
    </style>
</head>

<body>
    <h2>Lista de Donantes</h2>
    <table>
        <thead>
            <tr>
                <th>Donante</th>
                <th>Fecha</th>
                <th>Clase de Donación</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($donantes as $donante)
                @php
                    $donacionesDonante = $donaciones->where('id_donante', $donante->id);
                @endphp
                @if ($donacionesDonante->count())
                    @foreach ($donacionesDonante as $i => $donacion)
                        <tr>
                            @if ($i === 0)
                                <td rowspan="{{ $donacionesDonante->count() }}">{{ $donante->nombre }}
                                    {{ $donante->apellido }}</td>
                            @endif
                            <td>{{ $donacion->fecha }}</td>
                            <td>{{ $donacion->clase_donacion }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td>{{ $donante->nombre }} {{ $donante->apellido }}</td>
                        <td colspan="2" style="text-align:center;">Sin donaciones</td>
                    </tr>
                @endif
            @endforeach
        </tbody>
    </table>
</body>

</html>
