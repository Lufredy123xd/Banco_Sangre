<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Diferimentos</title>
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
    <h2>Lista de Diferimentos</h2>

    @if($rangoFechas)
        <p><strong>{{ $rangoFechas }}</strong></p>
    @endif
    <p style="text-align: center;">
        Total de Diferimentos: <strong>{{ $diferimentos->count() }}</strong>
    </p>
    <table>
        <thead>
            <tr>
                <th>Donante</th>
                <th>Motivo</th>
                <th>Fecha de Diferimiento</th>
                <th>Tipo</th>
                <th>Duración</th>
            </tr>
        </thead>
        <tbody>
            @foreach($diferimentos as $dif)
                <tr>
                    <td>{{ $dif->donante->nombre ?? '' }} {{ $dif->donante->apellido ?? '' }}</td>
                    <td>{{ $dif->motivo }}</td>
                    <td>{{ \Carbon\Carbon::parse($dif->fecha_diferimiento)->format('d/m/Y') }}</td>
                    <td>{{ $dif->tipo }}</td>
                    <td>
                        {{ $dif->tipo === 'Temporal' ? $dif->tiempo_en_meses . ' meses' : 'Indefinido' }}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
