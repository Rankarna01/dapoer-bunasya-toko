<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Struk #{{ $order->tracking_number }}</title>
    <style>
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            color: #000;
            width: 300px; /* Ukuran thermal printer */
            margin: 0 auto;
            padding: 10px;
            background: #fff;
        }
        .header, .footer { text-align: center; margin-bottom: 10px; }
        .header h2 { margin: 0; font-size: 16px; font-weight: bold; }
        .divider { border-top: 1px dashed #000; margin: 8px 0; }
        .item { display: flex; justify-content: space-between; margin-bottom: 4px; }
        .total-section { display: flex; justify-content: space-between; font-weight: bold; margin-top: 5px; }
        .btn-print {
            display: block;
            width: 100%;
            padding: 10px;
            background: #333;
            color: white;
            text-align: center;
            text-decoration: none;
            margin-top: 20px;
            font-family: sans-serif;
            cursor: pointer;
        }
        @media print {
            .btn-print, .no-print { display: none; }
            body { margin: 0; padding: 0; }
        }
    </style>
</head>
<body onload="window.print()">

    <div class="header">
        <h2>Dapoer Bunasya</h2>
        <p>Jl. Sisingamangaraja, Medan<br>Telp: 0858-3511-6946</p>
    </div>

    <div class="divider"></div>

    <div>
        <p>
            No: {{ $order->tracking_number }}<br>
            Tgl: {{ $order->created_at->format('d/m/Y H:i') }}<br>
            Kasir: {{ $order->user->name }}<br>
            Pelanggan: {{ $order->customer_name }}
        </p>
    </div>

    <div class="divider"></div>

    @foreach($order->items as $item)
    <div class="item">
        <span>{{ $item->quantity }}x {{ $item->product->name }}</span>
        <span>{{ number_format($item->price * $item->quantity, 0, ',', '.') }}</span>
    </div>
    @endforeach

    <div class="divider"></div>

    <div class="total-section">
        <span>TOTAL</span>
        <span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
    </div>
    <div class="item" style="margin-top: 5px;">
        <span>Bayar</span>
        <span>Rp {{ number_format($bayar, 0, ',', '.') }}</span>
    </div>
    <div class="item">
        <span>Kembali</span>
        <span>Rp {{ number_format($kembali, 0, ',', '.') }}</span>
    </div>

    <div class="divider"></div>

    <div class="footer">
        <p>Terima Kasih<br>Selamat Menikmati!</p>
    </div>

    <a href="{{ route('kasir.pos') }}" class="btn-print">Kembali ke POS</a>

</body>
</html>