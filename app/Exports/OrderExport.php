<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrderExport implements FromCollection, WithHeadings, WithMapping
{
    protected $from;
    protected $to;

    public function __construct($from, $to)
    {
        $this->from = $from;
        $this->to = $to;
    }

    public function collection()
    {
        return Order::with(["customer", "items.service", "payments"])
            ->whereBetween("tgl_masuk", [$this->from, $this->to])
            ->orderBy("tgl_masuk")
            ->get();
    }

    public function headings(): array
    {
        return [
            "No. Order",
            "Pelanggan",
            "Tanggal Masuk",
            "Tanggal Selesai",
            "Status",
            "Total Harga",
            "Dibayar",
            "Sisa",
            "Catatan",
        ];
    }

    public function map($order): array
    {
        $totalBayar = $order->payments->sum("jumlah");
        $sisa = $order->total_harga - $totalBayar;

        return [
            $order->no_order,
            $order->customer->nama ?? "-",
            $order->tgl_masuk->format("d/m/Y"),
            $order->tgl_selesai?->format("d/m/Y") ?? "-",
            ucfirst($order->status),
            (float) $order->total_harga,
            (float) $totalBayar,
            (float) max(0, $sisa),
            $order->catatan ?? "",
        ];
    }
}
