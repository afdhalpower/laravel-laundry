<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $totalPelanggan = Customer::count();
        $pelangganBaru = Customer::whereMonth("created_at", now()->month)->count();
        $orderHariIni = Order::whereDate("tgl_masuk", today())->count();
        $orderProses = Order::whereNotIn("status", ["selesai", "diantar"])->count();
        $orderSiap = Order::where("status", "siap")->count();

        $pendapatanHariIni = Payment::whereDate("tgl_bayar", today())->sum("jumlah");
        $pendapatanBulanIni = Payment::whereMonth("tgl_bayar", now()->month)
            ->whereYear("tgl_bayar", now()->year)
            ->sum("jumlah");

        $ordersTerbaru = Order::with("customer")
            ->latest()
            ->take(5)
            ->get();

        // 7 days chart
        $chartLabels = [];
        $chartData = [];
        for ($i = 6; $i >= 0; $i--) {
            $date = today()->subDays($i);
            $chartLabels[] = $date->format("d M");
            $total = Payment::whereDate("tgl_bayar", $date)->sum("jumlah");
            $chartData[] = (float) $total;
        }

        return view("dashboard", compact(
            "totalPelanggan", "pelangganBaru", "orderHariIni", "orderProses",
            "orderSiap", "pendapatanHariIni", "pendapatanBulanIni",
            "ordersTerbaru", "chartLabels", "chartData"
        ));
    }
}
