<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reporte de Venta</title>
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

        .rounded-table {
            width: 100%;
            margin-bottom: 30px;
            border-collapse: collapse; /* Asegura que no haya espacios entre las celdas */
            border-radius: 10px; /* Ajusta el radio según lo necesites */
            overflow: hidden; /* Asegura que el borde redondeado funcione correctamente */
        }

        .rounded-table th, .rounded-table td {
            border: 1px solid #ddd; /* Bordes de las celdas */
            padding: 8px; /* Espaciado interno */
        }

        .rounded-table th {
            background-color: #f2f2f2; /* Color de fondo de los encabezados */
            text-align: left; /* Alineación del texto */
        }
        .footer {
            position: fixed;
            bottom: -30px;
            left: 0px;
            right: 0px;
            height: 50px;
            text-align: center;
            line-height: 35px;
        }
        body {
            font-family: Arial, sans-serif;

            table {
                width: 100%;
                border-collapse: collapse;
                margin-bottom: 20px;
            }

            th, td {
                border: 1px solid #000;
                padding: 8px;
                text-align: center;
                font-family: Arial, sans-serif;
                font-size: 12px;
            }

            thead th {
                background-color: #f2f2f2;
                font-weight: bold;
            }

            tbody tr:nth-child(even) {
                background-color: #f9f9f9;
            }

            h6 {
                margin: 0;
                font-weight: normal;
                font-size: 12px;
            }

            .total {
                font-weight: bold;
                font-size: 14px;
            }

            tfoot {
                font-weight: bold;
            }

            .page-break {
                page-break-after: always;
            }

            .pagination {
                text-align: center;
                margin-top: 20px;
                font-size: 12px;
            }

            .table-items tfoot td {
                background-color: #f2f2f2;
                font-weight: bold;
            }
            .pagenum:before {
                content: counter(page);
            }

    </style>
</head>

<body>

<section class="header" style="top: -287px;">
    <table class="rounded-table" cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td colspan="2" align="center">
                <span style="font-size: 25px; font-weight: bold;"> Sistema {{ config('app.name') }}</span>
            </td>
        </tr>
        <tr>
            <!--td width="30%" style="vertical-align: top; padding-top: 10px; padding-left: 30px; position: relative">
                <img src="{{ public_path('img/ventasgr_logo.png') }}" alt="Logo VentasGR" class="invoice-logo"
                     style="max-width: 100px;">
            </td-->
            <td width="30%" style="vertical-align: top; padding-top: 10px; padding-left: 30px; position: relative">
                <img src="{{ asset('img/ventasgr_logo.png') }}" alt="VentasGR" class="invoice-logo"
                     style="max-width: 100px;">
            </td>
            <td width="70%" class="text-left text-company" style="vertical-align: top; padding-top: 30px">

                <span style="font-size: 16px"><strong>Venta # {{$getNextSaleNumber}}</strong></span>

                <br>

                <span style="font-size: 16px">Fecha de Consulta:<strong>
                {{\Carbon\Carbon::now()->format('H:i:s d-m-Y')}}</strong></span>

                <br>
                <span style="font-size: 14px">Cliente: {{$seller}}</span>
            </td>
        </tr>
    </table>
</section>


<section class="header" style="top: -287px;">

    <!--h3 aling="">Venta #</h3-->

    <table cellpadding="0" cellspacing="0" width="100%" class="table-items">
        <thead>
        <tr>
            <th align="center">No.</th>
            <th align="center">Cantidad</th>
            <th align="center">Nombre</th>
            <th align="center">Precio</th>
            <th align="center">Imagen</th>
        </tr>
        </thead>
        <tbody>
        @foreach($cart as $item)
            {{--dd($item)--}}
            <tr>
                <td align="center">{{ $loop->iteration }}</td>
                <td align="center">{{$item->qty}}</td>
                <td align="center">{{ $item->name }}</td>
                <td align="center">{{ $item->subtotal }}</td>
                <!--td align="center">{{ $item->attributes }}</td-->
                <!--td align="center"><img src="{{-- asset('storage/products/' . $item->attributes[0])--}}" alt="imagen de producto" height="50"
                                        width="50" class="rounded"></td-->
                <td align="center">
                    @php
                        $imagePath = 'storage/products/' . $item->options->image;
                        $defaultImagePath = 'img/noimg.jpg';
                    @endphp

                    @if (is_file(public_path($imagePath)))
                        <img src="{{ asset($imagePath) }}" alt="Imagen del producto" height="20" width="20" class="rounded">
                    @else
                        <img src="{{ asset($defaultImagePath) }}" alt="Imagen por defecto" height="20" width="20" class="rounded">
                    @endif
                </td>
            </tr>
        @endforeach
        </tbody>
        <tfoot>
        <tr>
            <td align="center"><span><b>TOTALES:</b></span></td>
            <td align="center" class="text-center" style=""><strong>{{ $cart->sum('qty')}}</strong></td>
            <!--td align="center"  colspan="1" class="text-center"><span><strong> Q. {{ number_format($cart->sum('price'),2)  }}</strong></span></td-->
            <td colspan="1"></td>
            <td align="center"><strong>Q. {{ number_format($cart->sum(function ($item) {
            return $item->price * $item->qty;
                    }), 2) }}</strong></td>
            <td colspan="1"></td>
        </tr>
        </tfoot>
    </table>

    <section class="footer">
        <table cellpadding="0" cellspacing="0" class="" width="100%">
            <tr>
                <td width="20%">
                    <span>Sistema {{ config('app.name') }}</span>
                </td>
                <td width="60%" class="text-center">
                    GR
                </td>
                <td class="text-center" width="20%">
                    página <span class="pagenum"></span>
                </td>
            </tr>
        </table>
    </section>
    <script type="text/php">
        if (isset($pdf)) {
                $pdf->page_script('
                    if ($PAGE_COUNT > 1) {
                        $font = $fontMetrics->get_font("Arial, Helvetica, sans-serif", "normal");
                        $size = 10;
                        $pageText = "Página: " . $PAGE_NUM . " de " . $PAGE_COUNT;
                        $y = 15;
                        $x = 520;
                        $pdf->text($x, $y, $pageText, $font, $size);
                    }
                ');
            }
    </script>

</body>

</html>

