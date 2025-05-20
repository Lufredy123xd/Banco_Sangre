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
                <th>Nombre</th>
                <th>Apellido</th>
                <th>CI</th>
                <th>ABO</th>
                <th>RH</th>
                <th>Última Fecha Donación</th>
                <th>Sexo</th>
                <th>Estado</th>
                <th>Donaciones</th> <!-- Columna de Donaciones -->
            </tr>
        </thead>
        <tbody>
            @foreach ($donantes as $donante)
                <tr>
                    <td>{{ $donante->nombre }}</td>
                    <td>{{ $donante->apellido }}</td>
                    <td>{{ $donante->cedula }}</td>
                    <td>{{ $donante->ABO }}</td>
                    <td>{{ $donante->RH }}</td>

                    <!-- Última Fecha Donación -->
                    <td>
                        @php
                            $ultimaDonacion = $donaciones
                                ->where('id_donante', $donante->id)
                                ->sortByDesc('fecha')
                                ->first();
                        @endphp
                        @if ($ultimaDonacion)
                            {{ $ultimaDonacion->fecha }}
                        @else
                            No disponible
                        @endif
                    </td>

                    <td>{{ $donante->sexo }}</td>
                    <td>{{ $donante->estado }}</td>

                    <!-- Mostrar las donaciones -->
                    <td>
                        @foreach ($donaciones->where('id_donante', $donante->id)->sortByDesc('fecha')->take(2) as $donacion)
                            <p>
                                Fecha: {{ $donacion->fecha }} |
                                Tipo: {{ $donacion->clase_donacion }} |
                                Reacciones adversas: {{ $donacion->reacciones_adversas ? 'Sí' : 'No' }}
                            </p>
                        @endforeach
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
