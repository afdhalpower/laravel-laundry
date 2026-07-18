<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <title>Label - {{ $order->no_order }}</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: "Inter", "Segoe UI", Arial, sans-serif;
            font-size: 11px;
            line-height: 1.4;
            color: #1a237e;
        }
        .label-container {
            width: 148mm; /* A5 width */
            min-height: 105mm; /* A5 height / 2 roughly */
            padding: 8mm;
            margin: 0 auto;
        }
        .label-box {
            border: 2px solid #1a237e;
            border-radius: 8px;
            padding: 12px;
            text-align: center;
            position: relative;
        }
        .label-box .brand {
            font-size: 16px;
            font-weight: 700;
            color: #1a237e;
            margin-bottom: 4px;
        }
        .label-box .brand i {
            font-style: normal;
        }
        .label-box .no-order {
            font-size: 22px;
            font-weight: 800;
            letter-spacing: 1px;
            color: #1a237e;
            margin: 6px 0;
        }
        .label-box .barcode-wrapper {
            margin: 8px auto;
            display: flex;
            justify-content: center;
        }
        .label-box .barcode-wrapper svg {
            max-width: 100%;
            height: auto;
        }
        .label-box .barcode-text {
            font-family: "Courier New", monospace;
            font-size: 14px;
            letter-spacing: 2px;
            color: #333;
            margin-top: 2px;
        }
        .label-box .info-row {
            display: flex;
            justify-content: space-between;
            margin-top: 8px;
            padding-top: 6px;
            border-top: 1px dashed #ccc;
            font-size: 10px;
        }
        .label-box .info-row .label-item {
            text-align: center;
            flex: 1;
        }
        .label-box .info-row .label-item .value {
            font-weight: 700;
            font-size: 12px;
            color: #1a237e;
        }
        .label-box .info-row .label-item .key {
            color: #6c757d;
            font-size: 8px;
            text-transform: uppercase;
        }
        .cut-line {
            text-align: center;
            margin: 4px 0;
            color: #adb5bd;
            font-size: 8px;
        }
        .cut-line span {
            letter-spacing: 4px;
        }
        @@media print {
            body { -webkit-print-color-adjust: exact; print-color-adjust: exact; }
            .no-print { display: none; }
        }
    </style>
</head>
<body>
    <div class="no-print" style="text-align:center;padding:10px;background:#f5f7fa;margin-bottom:10px">
        <button onclick="window.print()" style="padding:8px 24px;background:#1a237e;color:white;border:none;border-radius:6px;cursor:pointer;font-weight:600">
            <i>🖨</i> Cetak Label
        </button>
        <a href="{{ route("orders.show", $order) }}" style="padding:8px 24px;background:#6c757d;color:white;border:none;border-radius:6px;text-decoration:none;margin-left:8px;font-weight:600">
            Kembali
        </a>
    </div>

    <div class="label-container">
        <div class="label-box">
            <div class="brand">☁ LaundryKu</div>
            <div class="no-order">{{ $order->no_order }}</div>

            <div class="barcode-wrapper">
                @if(isset($barcodeSvg))
                    {!! $barcodeSvg !!}
                @else
                    <div class="barcode-text">{{ $order->no_order }}</div>
                @endif
            </div>

            <div class="info-row">
                <div class="label-item">
                    <div class="key">Pelanggan</div>
                    <div class="value">{{ $order->customer->nama }}</div>
                </div>
                <div class="label-item">
                    <div class="key">Tgl Masuk</div>
                    <div class="value">{{ $order->tgl_masuk->format("d/m/Y") }}</div>
                </div>
                <div class="label-item">
                    <div class="key">Qty Item</div>
                    <div class="value">{{ $order->items->sum("jumlah") }} item / {{ number_format($order->items->where("jenis", "kiloan")->sum("berat"), 1) }} kg</div>
                </div>
                <div class="label-item">
                    <div class="key">Total</div>
                    <div class="value">Rp {{ number_format($order->total_harga, 0, ",", ".") }}</div>
                </div>
            </div>
        </div>
        <div class="cut-line"><span>• • • • • • • • • • • • • • • • • • • •</span></div>
    </div>
</body>
</html>
