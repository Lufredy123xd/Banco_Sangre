<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Agendas</title>
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
    <h2>Lista de Agendas</h2>

    @if ($rangoFechas)
        <p><strong>{{ $rangoFechas }}</strong></p>
    @endif
    <p style="text-align: center;">
        Total de Agendas: <strong>{{ $agendas->count() }}</strong>
    </p>
    <table>
        <thead>
            <tr>
                <th><i class="fas fa-user me-1"></i> Nombre</th>
                <th><i class="fas fa-user me-1"></i> Apellido</th>
                <th><i class="fas fa-id-card me-1"></i> Cédula</th>
                <th><i class="fas fa-phone me-1"></i> Teléfono</th>
                <th><i class="fas fa-calendar-day me-1"></i> Fecha</th>
                <th><i class="fas fa-clock me-1"></i> Horario</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($agendas as $agenda)
                <tr>
                    <td>{{ $agenda->donante->nombre ?? 'N/A' }}</td>
                    <td>{{ $agenda->donante->apellido ?? 'N/A' }}</td>
                    <td>{{ $agenda->donante->cedula ?? 'N/A' }}</td>
                    <td>{{ $agenda->donante->telefono ?? 'N/A' }}</td>
                    <td>{{ \Carbon\Carbon::parse($agenda->fecha_agenda)->format('d/m/Y') }}</td>
                    <td>{{ $agenda->horario }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>

</html>
