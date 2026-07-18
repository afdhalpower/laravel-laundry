<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Invoice #{{ $order->no_order }}</title>
    <style>
        body { font-family: "Courier New", monospace; font-size: 12px; width: 80mm; margin: 0 auto; padding: 10px; }
        .header { text-align: center; margin-bottom: 15px; }
        .header h2 { margin: 0; font-size: 16px; }
        .header p { margin: 2px 0; font-size: 11px; color: #555; }
        .divider { border-top: 1px dashed #333; margin: 8px 0; }
        .info { margin-bottom: 10px; }
        .info div { display: flex; justify-content: space-between; font-size: 11px; }
        table { width: 100%; border-collapse: collapse; font-size: 11px; }
        th { border-bottom: 1px solid #333; padding: 3px 0; text-align: left; }
        td { padding: 2px 0; }
        .total { text-align: right; font-weight: bold; font-size: 14px; margin-top: 5px; }
        .footer { text-align: center; margin-top: 15px; font-size: 10px; color: #888; }
        .status { text-align: center; margin: 10px 0; }
        .status span { background: #333; color: #fff; padding: 3px 10px; font-size: 11px; }
        @media print { body { width: 100%; } .no-print { display: none; } }
    </style>
</head>
<body>
    <div class="no-print" style="text-align:center;margin-bottom:10px">
        <button onclick="window.print()" style="padding:8px 20px;cursor:pointer">Cetak</button>
    </div>

    <div class="header">
        <h2>LAUNDRYKU</h2>
        <p>Jl. Contoh No. 123, Kota</p>
        <p>Telp: 08xxxxxxxxxx</p>
    </div>

    <div class="divider"></div>

    <div class="info">
        <div><span>No. Invoice:</span><span>{{ $order->no_order }}</span></div>
        <div><span>Tanggal:</span><span>{{ $order->tgl_masuk->format("d/m/Y") }}</span></div>
        <div><span>Pelanggan:</span><span>{{ $order->customer->nama }}</span></div>
        <div><span>Status:</span><span>{{ strtoupper($order->status_label) }}</span></div>
    </div>

    <div class="divider"></div>

    <table>
        <thead>
            <tr><th>Item</th><th style="text-align:right">Harga</th></tr>
        </thead>
        <tbody>
            @foreach($order->items as $item)
            <tr>
                <td>
                    {{ $item->service->nama }}
                    @if($item->jenis == "kiloan")
                        ({{ $item->berat }} kg)
                    @else
                        ({{ $item->jumlah }}x)
                    @endif
                </td>
                <td style="text-align:right">Rp {{ number_format($item->subtotal, 0, ",", ".") }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <div class="divider"></div>

    <div class="total">
        TOTAL: Rp {{ number_format($order->total_harga, 0, ",", ".") }}
    </div>

    @php $dibayar = $order->payments->sum("jumlah"); @endphp
    @if($dibayar > 0)
        <div style="margin-top:5px;text-align:right;font-size:11px">
            Dibayar: Rp {{ number_format($dibayar, 0, ",", ".") }}<br>
            <strong>Sisa: Rp {{ number_format($order->total_harga - $dibayar, 0, ",", ".") }}</strong>
        </div>
    @endif

    @if($order->catatan)
        <div style="margin-top:8px;font-size:10px">Catatan: {{ $order->catatan }}</div>
    @endif

    <div class="divider"></div>

    @if($order->status == "siap" || $order->status == "selesai")
    <div class="status">
        <span>BARANG SUDAH SIAP / SELESAI</span>
    </div>
    @endif

    <div class="footer">
        <p>Terima kasih telah menggunakan layanan kami</p>
        <p>LaundryKu - &copy; {{ date("Y") }}</p>
    </div>
</body>
</html>
