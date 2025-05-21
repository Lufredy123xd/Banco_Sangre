<!DOCTYPE html>
<html>

<head>
    <title>Lista de Donantes</title>
    <style>
        @page {
            margin: 20mm;
        }

        body {
            font-family: DejaVu Sans, sans-serif;
            /* fuente compatible con DomPDF */
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            page-break-inside: auto;
        }

        tr {
            page-break-inside: avoid;
            page-break-after: auto;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
            vertical-align: top;
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
    <h2>Lista de Donaciones</h2>
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
                    @foreach ($donacionesDonante as $donacion)
                        <tr>
                            <td>{{ $donante->nombre }} {{ $donante->apellido }}</td>
                            <td>{{ $donacion->fecha }}</td>
                            <td>{{ $donacion->clase_donacion }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td>{{ $donante->nombre }} {{ $donante->apellido }}</td>
                        <td>Sin fecha</td>
                        <td>Sin donaciones</td>
                    </tr>
                @endif
            @endforeach

        </tbody>
    </table>
</body>

</html>
