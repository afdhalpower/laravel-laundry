<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Service;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with("customer");

        if ($search = $request->search) {
            $query->where("no_order", "like", "%{$search}%")
                  ->orWhereHas("customer", fn($q) => $q->where("nama", "like", "%{$search}%"));
        }

        if ($status = $request->status) {
            $query->where("status", $status);
        }

        $orders = $query->latest()->paginate(15);
        return view("orders.index", compact("orders"));
    }

    public function create()
    {
        $customers = Customer::orderBy("nama")->get();
        $services = Service::orderBy("nama")->get();
        return view("orders.create", compact("customers", "services"));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "customer_id" => "required|exists:customers,id",
            "tgl_masuk" => "required|date",
            "catatan" => "nullable|string",
            "total_harga" => "required|numeric|min:0",
            "items" => "required|array|min:1",
            "items.*.service_id" => "required|exists:services,id",
            "items.*.berat" => "nullable|numeric|min:0.5",
            "items.*.jumlah" => "nullable|integer|min:1",
            "items.*.harga" => "required|numeric|min:0",
            "items.*.subtotal" => "required|numeric|min:0",
        ]);

        try {
            DB::beginTransaction();

            // Generate no_order unik
            $noOrder = "LND" . date("ymd") . str_pad(Order::withTrashed()->whereDate("created_at", today())->count() + 1, 3, "0", STR_PAD_LEFT);

            $order = Order::create([
                "no_order" => $noOrder,
                "customer_id" => $validated["customer_id"],
                "tgl_masuk" => $validated["tgl_masuk"],
                "total_harga" => $validated["total_harga"],
                "catatan" => $validated["catatan"] ?? null,
                "status" => "diterima",
            ]);

            foreach ($validated["items"] as $item) {
                $service = Service::findOrFail($item["service_id"]);
                OrderItem::create([
                    "order_id" => $order->id,
                    "service_id" => $item["service_id"],
                    "jenis" => $service->tipe,
                    "berat" => $service->tipe === "kiloan" ? ($item["berat"] ?? 0) : null,
                    "jumlah" => $service->tipe === "satuan" ? ($item["jumlah"] ?? 1) : 1,
                    "harga_satuan" => $item["harga"],
                    "subtotal" => $item["subtotal"],
                ]);
            }

            DB::commit();

            return redirect()->route("orders.show", $order)
                ->with("success", "Transaksi #{$noOrder} berhasil dibuat.");

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with("error", "Gagal membuat transaksi: " . $e->getMessage())
                ->withInput();
        }
    }

    public function show(Order $order)
    {
        $order->load(["customer", "items.service", "payments"]);
        return view("orders.show", compact("order"));
    }

    public function edit(Order $order)
    {
        $customers = Customer::orderBy("nama")->get();
        $services = Service::orderBy("nama")->get();
        return view("orders.edit", compact("order", "customers", "services"));
    }

    public function update(Request $request, Order $order)
    {
        if ($order->status === "selesai") {
            return redirect()->route("orders.show", $order)
                ->with("error", "Transaksi sudah selesai, status tidak bisa diubah lagi.");
        }

        $validated = $request->validate([
            "customer_id" => "required|exists:customers,id",
            "status" => "required|in:diterima,dicuci,dikeringkan,disetrika,dilipat,siap,diantar,selesai",
            "tgl_masuk" => "required|date",
            "tgl_selesai" => "nullable|date",
            "catatan" => "nullable|string",
        ]);

        $order->update($validated);

        return redirect()->route("orders.show", $order)
            ->with("success", "Status transaksi berhasil diupdate.");
    }

    public function destroy(Order $order)
    {
        $order->delete();
        return redirect()->route("orders.index")
            ->with("success", "Transaksi berhasil dihapus.");
    }

    public function payment(Order $order)
    {
        $order->load("payments");
        return view("orders.payment", compact("order"));
    }

    public function invoice(Order $order)
    {
        $order->load(["customer", "items.service", "payments"]);
        return view("orders.invoice", compact("order"));
    }

    public function trash()
    {
        $orders = Order::onlyTrashed()
            ->with("customer")
            ->latest("deleted_at")
            ->paginate(15);

        return view("orders.trash", compact("orders"));
    }

    public function restore($id)
    {
        $order = Order::onlyTrashed()->findOrFail($id);
        $order->restore();

        return redirect()->route("orders.trash")
            ->with("success", "Order berhasil direstore.");
    }

}