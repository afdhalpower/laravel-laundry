<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            "order_id" => "required|exists:orders,id",
            "tgl_bayar" => "required|date",
            "jumlah" => "required|numeric|min:1",
            "metode" => "required|in:tunai,transfer",
            "keterangan" => "nullable|string|max:255",
        ]);

        Payment::create($validated);

        $order = Order::findOrFail($validated["order_id"]);

        // Auto-update status ke "diantar" jika lunas dan status masih dalam proses
        $totalBayar = $order->payments()->sum("jumlah") + $validated["jumlah"];
        if ($totalBayar >= $order->total_harga && in_array($order->status, ["siap"])) {
            $order->update(["status" => "diantar"]);
        }

        return redirect()->route("orders.show", $validated["order_id"])
            ->with("success", "Pembayaran berhasil dicatat.");
    }
}
