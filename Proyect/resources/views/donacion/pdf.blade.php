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
    @if ($fechaInicio || $fechaFin)
        <p style="text-align: center;">
            @if ($fechaInicio && $fechaFin)
                Donaciones entre el {{ \Carbon\Carbon::parse($fechaInicio)->format('d/m/Y') }}
                y el {{ \Carbon\Carbon::parse($fechaFin)->format('d/m/Y') }}
            @elseif ($fechaInicio)
                Donaciones desde el {{ \Carbon\Carbon::parse($fechaInicio)->format('d/m/Y') }}
            @elseif ($fechaFin)
                Donaciones hasta el {{ \Carbon\Carbon::parse($fechaFin)->format('d/m/Y') }}
            @endif
        </p>
    @endif
    <p style="text-align: center;">Total de Donaciones: {{ $donaciones->count() }}</p>
    <table>
        <thead>
            <tr>
                <th>Donante</th>
                <th>Fecha Donación</th>
                <th>Clase Donación</th>
                <th>Serología</th>
                <th>Anticuerpos Irregulares</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($donaciones as $donacion)
                <tr>
                    <td>{{ $donacion->donante->nombre ?? 'N/A' }} {{ $donacion->donante->apellido ?? '' }}<br>Cédula:
                        {{ $donacion->donante->cedula ?? '' }}</td>
                    <td>{{ \Carbon\Carbon::parse($donacion->fecha)->format('d/m/Y') }}</td>
                    <td>{{ $donacion->clase_donacion }}</td>
                    <td>{{ $donacion->serologia }}</td>
                    <td>{{ $donacion->anticuerpos_irregulares }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
