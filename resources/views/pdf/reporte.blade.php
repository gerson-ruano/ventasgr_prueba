<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes</title>
    <link rel="stylesheet" href="{{ asset('css/custom_pdf.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom_page.css') }}">
    <style>
        .table-items {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .table-items th,
        .table-items td {
            border: 1px solid #ddd;
            text-align: center;
            padding: 8px;
        }

        .table-items th {
            background-color: #f2f2f2;
        }

        .table-items tbody tr:last-child td {
            border-bottom: 1px solid #ddd;
        }

        .footer {
            position: fixed;
            bottom: -20px; /* Espacio adicional para evitar montado */
            left: 0px;
            right: 0px;
            height: 50px;
            text-align: center;
            line-height: 35px;
            font-size: 10px;
        }

        .page-break {
            page-break-after: always;
        }

        .pagenum:before {
            content: counter(page);
        }

        body {
            counter-reset: page;
        }
    </style>
</head>
@php
    $statusTranslations = [
        'PAID' => 'Pagado',
        'CANCELLED' => 'Cancelado',
        'PENDING' => 'Pendiente'
    ];
@endphp

<body>
<section class="header" style="top: -287px;">
    <table cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td colspan="2" align="center">
                <span style="font-size: 25px; font-weight: bold;">Sistema {{ config('app.name') }}</span>
            </td>
        </tr>
        <tr>
            <td width="30%" style="padding-top: 10px; padding-left: 30px;">
                <img src="{{ public_path('img/ventasgr_logo.png') }}" alt="Logo VentasGR" class="invoice-logo" style="max-width: 100px;">
            </td>
            <td width="70%" style="padding-top: 30px;">
                @if($reportType == 0)
                    <strong>Reporte de Ventas del Dia</strong>
                @else
                    <strong>Reporte de Ventas por Fechas</strong>
                @endif
                <br>
                @if($reportType != 0)
                    Fecha de consulta: <strong>{{ $dateFrom }} al {{ $dateTo }}</strong>
                @else
                    Fecha de consulta: <strong>{{ \Carbon\Carbon::now()->format('d-m-Y') }}</strong>
                @endif
                <br>
                Usuario: {{ $user }}
            </td>
        </tr>
    </table>
</section>

<section style="margin-top: 10px">
    <table cellpadding="0" cellspacing="0" class="table-items" width="100%">
        <thead>
        <tr>
            <th width="5%">No.</th>
            <th width="6%">VENTA</th>
            <th width="10%">IMPORTE</th>
            <th width="8%">CANT.</th>
            <th width="8%">ESTADO</th>
            <th width="4%">CLIENTE</th>
            <th width="14%">USUARIO</th>
            <th width="34%">FECHA/HORA</th>
        </tr>
        </thead>
        <tbody>
        @php
            $firstPageCount = 22;  // Número de registros en la primera página
            $otherPagesCount = 26; // Número de registros en las páginas siguientes
        @endphp

        @foreach ($data as $index => $item)
            <tr>
                <td>{{ $index + 1 }}</td>
                <td>{{ $item->id }}</td>
                <td style="text-align: right;">{{ number_format($item->total, 2) }}</td>
                <td>{{ $item->items }}</td>
                <td>{{ $statusTranslations[$item->status] ?? $item->status }}</td>
                <td>{{ $item->seller_name }}</td>
                <td>{{ $item->user }}</td>
                <td>{{ $item->created_at->format('d-m-Y H:i') }}</td>
            </tr>
            @if (($index + 1) == $firstPageCount && !$loop->last)
                <tr>
                    <td colspan="8" style="border: none; height: 1px;"></td>
                </tr>
                <section class="footer table-items">
                    <table cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td width="20%">Sistema {{ config('app.name') }}</td>
                            <td width="60%" class="text-center">GR</td>
                            <td width="20%" class="text-center">Pág. <span class="pagenum"></span></td>
                        </tr>
                    </table>
                </section>
                <tr class="page-break"></tr>
            @elseif ($index + 1 > $firstPageCount && ($index + 1 - $firstPageCount) % $otherPagesCount == 0 && !$loop->last)
                <tr>
                    <td colspan="8" style="border: none; height: 1px;"></td>
                </tr>
                <section class="footer table-items">
                    <table cellpadding="0" cellspacing="0" width="100%">
                        <tr>
                            <td width="20%">Sistema {{ config('app.name') }}</td>
                            <td width="60%" class="text-center">GR</td>
                            <td width="20%" class="text-center">Pág. <span class="pagenum"></span></td>
                        </tr>
                    </table>
                </section>
            <tr class="page-break"></tr>
            @endif
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td colspan="2"><b>TOTALES:</b></td>
            <td style="text-align: right;"><b>Q.{{ number_format($data->sum('total'), 2) }}</b></td>
            <td><b>{{ $data->sum('items') }}</b></td>
            <td colspan="4"></td>
        </tr>
        </tfoot>
    </table>
</section>
<section class="footer table-items">
    <table cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td width="20%">Sistema {{ config('app.name') }}</td>
            <td width="60%" class="text-center">GR</td>
            <td width="20%" class="text-center">Pág. <span class="pagenum"></span></td>
        </tr>
    </table>
</section>
</body>
</html>



