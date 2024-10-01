<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reportes</title>
    <link rel="stylesheet" href="{{ asset('css/custom_pdf.css') }}">
    <link rel="stylesheet" href="{{ asset('css/custom_page.css') }}">
    <style>
        /* Estilo para el footer */
        .footer {
            text-align: center;
            background-color: #f0f0f0;
            padding: 10px;
            margin-top: 30px; /* Espacio entre el contenido y el footer */
            position: fixed;
            bottom: 0;
            left: 0;
            right: 0;
        }


        .footer-table {
            width: 100%;
            border-collapse: collapse;
        }

        .footer-table td {
            border: 1px solid #ddd;
            padding: 5px;
            text-align: center;
        }

        .footer-table .text-right {
            text-align: right;
        }

        .pagenum:before {
            content: counter(page);
        }

        .table-items {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        .table-items th,
        .table-items td {
            border: 1px solid #ddd;
            text-align: center;
        }

        .table-items th {
            background-color: #f2f2f2;
        }
    </style>
</head>

<body>
<section class="header" style="top: -287px;">
    <table cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td colspan="2" align="center">
                <span style="font-size: 25px; font-weight: bold;"> Sistema {{ config('app.name') }}</span>
            </td>
        </tr>
        <tr>
            <td width="30%" style="vertical-align: top; padding-top: 10px; padding-left: 30px; position: relative">
                <img src="{{ public_path('img/ventasgr_logo.png') }}" alt="Logo VentasGR" class="invoice-logo" style="max-width: 100px;">
            </td>
            <td width="70%" class="text-left text-company" style="vertical-align: top; padding-top: 30px">
                @if($reportType == 0)
                    <span style="font-size: 16px"><strong>Reporte de Ventas del Dia</strong></span>
                @else
                    <span style="font-size: 16px"><strong>Reporte de Ventas por Fechas</strong></span>
                @endif
                <br>
                @if($reportType != 0)
                    <span style="font-size: 16px">Fecha de consulta:<strong> {{$dateFrom}} al
                            {{($dateTo)}}</strong></span>
                @else
                    <span style="font-size: 16px"><strong>Fecha de consulta:
                            {{\Carbon\Carbon::now()->format('d-m-Y')}}</strong></span>
                @endif
                <br>
                <span style="font-size: 14px">{{__('Usuario')}}: {{$user}}</span>
            </td>
        </tr>
    </table>
</section>

<section style="margin-top: 10px">
    <table cellpadding="0" cellspacing="0" class="table-items" width="100%">
        <thead>
        <tr>
            <th width="5%">No.</th>
            <th width="10%">#VENTA</th>
            <th width="14%">IMPORTE</th>
            <th width="10%">CANT.</th>
            <th width="12%">ESTADO</th>
            <th width="12%">CLIENTE</th>
            <th>USUARIO</th>
            <th width="22%">FECHA/HORA</th>
        </tr>
        </thead>
        <tbody>
        {{--dd($data)--}}
        @foreach($data as $item)
            <tr>
                <td align="center">{{ $loop->iteration }}</td>
                <td align="center">{{($item->id)}}</td>
                <td style="text-align: right;">{{ number_format($item->total, 2) }}</td>
                <td align="center">{{($item->items)}}</td>
                <td align="center">{{($item->status)}}</td>
                <td align="center">{{($item->seller)}}</td>
                <td align="center">{{($item->user)}}</td>
                <td align="center">{{($item->created_at)->format('d-m-Y H:i')}}</td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td align="center" colspan="2"><span><b>TOTALES:</b></span></td>
            <td style="text-align: right;" colspan="1" class="text-center"><span><strong> Q.
                                {{ number_format($data->sum('total'),2) }}</strong></span></td>
            <td align="center" class="text-center" style=""><b> {{ $data->sum('items')}}</b></td>
            <td colspan="4"></td>
        </tr>
        </tfoot>
    </table>
</section>

<section class="footer">
    <table cellpadding="0" cellspacing="0" class="footer-table" width="100%">
        <tr>
            <td width="20%">
                <span>Sistema {{ config('app.name') }}</span>
            </td>
            <td class="text-right" width="80%">
                Página <span class="pagenum"></span> <span class="pagecount"></span>
            </td>
        </tr>
    </table>
</section>

<script type="text/php">
    if (isset($pdf)) {
        $text = "Página {PAGE_NUM} de {PAGE_COUNT}";
        $size = 14;
        $color = array(0, 0, 0); // Color en RGB
        $x = 250; // Ajusta la posición X
        $y = 780; // Ajusta la posición Y

        // Establecer el estilo de paginado para todas las páginas
        for ($i = 1; $i <= $pdf->get_page_count(); $i++) {
            $pdf->page_script('
                $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                $pdf->text(' . $x . ', ' . $y . ', "' . $text . '", $font, ' . $size . ', ' . var_export($color, true) . ');
            ');
        }
    }
</script>



</body>


</html>
