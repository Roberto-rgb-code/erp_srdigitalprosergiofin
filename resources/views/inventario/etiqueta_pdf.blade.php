@php
    $barcode = new \Milon\Barcode\DNS1D();
@endphp
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Etiqueta de Inventario</title>
    <style>
        @page { margin: 0; }
        html, body {
            margin: 0;
            padding: 0;
            height: 100%;
            width: 100%;
        }
        body {
            min-height: 100vh;
            min-width: 100vw;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .etiqueta {
            /* border: 1px solid #888;   <-- quita o comenta esta línea */
            border: none;
            border-radius: 10px;
            width: 300px;
            padding: 15px 10px;
            text-align: center;
            margin: 0 auto;
            background: #fff;
            box-shadow: none;
        }
        .serie {
            font-size: 18px;
            font-weight: bold;
            margin: 10px 0 5px 0;
        }
        .producto {
            font-size: 14px;
            color: #555;
            margin-bottom: 10px;
        }
        .barcode {
            margin: 10px 0;
        }
    </style>
</head>
<body>
    <div class="etiqueta">
        <div class="producto">{{ $producto->producto }}</div>
        <div class="serie">Serie: {{ $stockUnit->numero_serie }}</div>
        <div class="barcode">
            {!! $barcode->getBarcodeHTML($stockUnit->codigo_barras, 'C128', 2, 50) !!}
        </div>
        <div style="font-size:12px;">SKU: {{ $producto->sku }}</div>
    </div>
</body>
</html>
