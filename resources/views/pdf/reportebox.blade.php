<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cierre de Caja</title>
    <link rel="stylesheet" href="{{ asset('css/custom_pdf.css') }}">
    <link rel="stylesheet" href="{{ asset('css/pdf.css') }}">
</head>
@php
    $statusTranslations = [
        'PAID' => 'PAGADO',
        'CANCELLED' => 'ANULADO',
        'PENDING' => 'PENDIENTE'
    ];
@endphp
<body>
<section class="header" style="top: -287px;">
    <table class="rounded-table" cellpadding="0" cellspacing="0" width="100%" style="margin-bottom: 30px;">
        <tr>
            <td colspan="2" align="center">
                <!--span style="font-size: 25px; font-weight: bold;">Sistema {{-- config('app.name') --}}</span-->
                @include('livewire.components.empresa_header', ['empresa' => $empresa])
            </td>
        </tr>
        <tr>

            <td colspan="2" style="padding: 10px; text-align: center;">
                <!--span style="font-size: 16px"><strong>VENTA</strong></span><br-->
                <span style="font-size: 16px"><strong>VENTA #{{$getNextSaleNumber}}</strong></span><br>
                <!--span style="font-size: 16px">Fecha de Consulta: <strong>{{ \Carbon\Carbon::now()->format('H:i:s d-m-Y') }}</strong></span-->
                <span style="font-size: 14px">Cliente: <strong>{{$seller_name}}</strong></span>
            </td>
        </tr>
    </table>
</section>

<table class="table-items">
    <thead>
    <tr>
        <th>#</th>
        <th>Producto</th>
        <th>Precio Unitario</th>
        <th>Cantidad</th>
        <th>Total</th>
    </tr>
    </thead>
    <tbody>
    @foreach($details as $d)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td>{{ $d->product->name }}</td>
            <td>Q. {{ number_format($d->price, 2) }}</td>
            <td>{{ number_format($d->quantity, 2) }}</td>
            <td>Q. {{ number_format($d->price * $d->quantity, 2) }}</td>
        </tr>
    @endforeach
    </tbody>
    <tfoot>
    <tr>
        <td colspan="2"><strong>Totales:</strong></td>
        <td><strong>Q. {{ number_format($details->sum('price'), 2) }}</strong></td>
        <td><strong>{{ number_format($details->sum('quantity'), 2) }}</strong></td>
        <td><strong>Q. {{ number_format($details->sum(function($d) { return $d->price * $d->quantity; }), 2) }}</strong>
        </td>
    </tr>
    </tfoot>
</table>


<table class="table-items">
    <thead>
    <tr>
        <th>Total</th>
        <th>Efectivo</th>
        <th>Cambio</th>
        <th>Descuento</th>
        <th>Estado</th>
        <th>Ingreso</th>
        <th>Modificado</th>
    </tr>
    </thead>
    <tbody>
    <tr>
        <td>{{ $sale->total }}</td>
        <td>{{ $sale->cash }}</td>
        <td>{{ $sale->change }}</td>
        <td>Q. {{ number_format($descuento, 2) }}</td>
        <td>{{ $statusTranslations[$sale->status] ?? $sale->status }}</td>
        <td>{{ \Carbon\Carbon::parse($sale->created_at)->format('d-m-Y H:i') }}</td>
        @if($sale->created_at != $sale->updated_at)
            <td>{{ \Carbon\Carbon::parse($sale->updated_at)->format('d-m-Y H:i') }}</td>
        @else
            <td>Sin cambios</td>
        @endif
    </tr>
    </tbody>
</table>
<br>

<div class="align">
    <span style="font-size: 10px">Usuario: <strong>{{ $usuario->name }}</strong></span>
    <span style="font-size: 10px">Fecha de Consulta: <strong>{{ \Carbon\Carbon::now()->format('H:i:s d-m-Y') }}</strong></span>
</div>

<section class="footer table-items">
    <table cellpadding="0" cellspacing="0" width="100%">
        <tr>
            <td width="20%">Sistema {{ $empresa->name }}</td>
            <td width="60%" class="text-center"></td>
            <td width="20%" class="text-center">Pág. <span class="pagenum"></span></td>
        </tr>
    </table>
</section>
<script type="text/php">
    @include('pdf.partials.pdf_script')
</script>

</body>

</html>

