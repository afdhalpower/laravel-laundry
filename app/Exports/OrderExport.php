<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\Exportable;

class OrderExport implements FromQuery, WithHeadings, WithMapping
{
    use Exportable;

    protected $from;
    protected $to;

    public function __construct($from, $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public function query()
    {
        return Order::query()
            ->with(["customer", "items.service", "payments"])
            ->whereBetween("tgl_masuk", [$this->from, $this->to])
            ->orderBy("tgl_masuk");
    }

    public function headings(): array
    {
        return ["No. Order", "Pelanggan", "Tanggal Masuk", "Status", "Total Harga", "Dibayar"];
    }

    public function map($order): array
    {
        return [
            $order->no_order,
            $order->customer->nama ?? "-",
            $order->tgl_masuk->format("d/m/Y"),
            ucfirst($order->status),
            (float) $order->total_harga,
            (float) $order->payments->sum("jumlah"),
        ];
    }
}
