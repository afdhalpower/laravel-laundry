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

        $order = Order::findOrFail($validated["order_id"]);
        if ($order->status === "selesai") {
            return redirect()->route("orders.show", $order)
                ->with("error", "Transaksi sudah selesai, tidak bisa menambah pembayaran.");
        }

        Payment::create($validated);

        $order = Order::findOrFail($validated["order_id"]);
        $this->autoUpdateStatus($order);

        return redirect()->route("orders.show", $validated["order_id"])
            ->with("success", "Pembayaran berhasil dicatat.");
    }

    public function update(Request $request, Payment $payment)
    {
        if ($payment->order->status === "selesai") {
            return redirect()->route("orders.show", $payment->order_id)
                ->with("error", "Transaksi sudah selesai, tidak bisa mengubah pembayaran.");
        }

        $validated = $request->validate([
            "tgl_bayar" => "required|date",
            "jumlah" => "required|numeric|min:1",
            "metode" => "required|in:tunai,transfer",
            "keterangan" => "nullable|string|max:255",
        ]);

        $payment->update($validated);

        // Auto-update status setelah edit payment
        $this->autoUpdateStatus($payment->order);

        return redirect()->route("orders.show", $payment->order_id)
            ->with("success", "Pembayaran berhasil diupdate.");
    }

    public function destroy(Payment $payment)
    {
        if ($payment->order->status === "selesai") {
            return redirect()->route("orders.show", $payment->order_id)
                ->with("error", "Transaksi sudah selesai, tidak bisa menghapus pembayaran.");
        }

        $orderId = $payment->order_id;
        $payment->delete();

        return redirect()->route("orders.show", $orderId)
            ->with("success", "Pembayaran berhasil dihapus.");
    }

    /**
     * Auto-update order status: jika lunas dan belum diantar/selesai, maju ke diantar.
     */
    private function autoUpdateStatus(Order $order)
    {
        $totalBayar = $order->payments()->sum("jumlah");
        if ($totalBayar >= $order->total_harga && !in_array($order->status, ["diantar", "selesai"])) {
            $order->update(["status" => "diantar"]);
        }
    }
}
