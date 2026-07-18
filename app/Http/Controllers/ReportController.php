<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $from = $request->from ? Carbon::parse($request->from) : today()->startOfMonth();
        $to = $request->to ? Carbon::parse($request->to) : today();

        $orders = Order::with("customer")
            ->whereBetween("tgl_masuk", [$from, $to])
            ->orderBy("tgl_masuk")
            ->get();

        $totalOrders = $orders->count();
        $totalRevenue = Payment::whereBetween("tgl_bayar", [$from, $to])->sum("jumlah");
        $avgOrder = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        // Chart data by date
        $chartLabels = [];
        $chartData = [];
        $period = $from->copy();
        while ($period->lte($to)) {
            $chartLabels[] = $period->format("d M");
            $total = Payment::whereDate("tgl_bayar", $period)->sum("jumlah");
            $chartData[] = (float) $total;
            $period->addDay();
        }

        return view("reports.index", compact(
            "orders", "totalOrders", "totalRevenue", "avgOrder",
            "chartLabels", "chartData", "from", "to"
        ));
    }
}
