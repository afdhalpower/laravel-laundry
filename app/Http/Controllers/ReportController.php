<?php

namespace App\Http\Controllers;

use App\Exports\OrderExport;
use App\Models\Order;
use App\Models\Payment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

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

        // Revenue dihitung dari orders dalam range tgl_masuk, bukan dari payment date
        $orderIds = $orders->pluck('id');
        $payments = Payment::whereIn('order_id', $orderIds)->get();
        $totalRevenue = $payments->sum('jumlah');

        $avgOrder = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        // Chart data by date — revenue dari orders yang tgl_masuk pada tanggal tersebut
        $chartLabels = [];
        $chartData = [];
        $paymentsByOrderId = $payments->groupBy('order_id');
        $period = $from->copy();
        while ($period->lte($to)) {
            $chartLabels[] = $period->format("d M");
            $dateKey = $period->format('Y-m-d');
            $dayOrders = $orders->filter(fn($o) => $o->tgl_masuk->format('Y-m-d') === $dateKey);
            $total = 0;
            foreach ($dayOrders as $order) {
                $total += ($paymentsByOrderId->get($order->id) ?? collect())->sum('jumlah');
            }
            $chartData[] = (float) $total;
            $period->addDay();
        }

        return view("reports.index", compact(
            "orders", "totalOrders", "totalRevenue", "avgOrder",
            "chartLabels", "chartData", "from", "to"
        ));
    }


    public function export(Request $request)
    {
        $from = $request->from ? Carbon::parse($request->from) : today()->startOfMonth();
        $to = $request->to ? Carbon::parse($request->to) : today();

        return Excel::download(new OrderExport($from, $to), "laporan-laundry-{$from->format("Y-m-d")}-{$to->format("Y-m-d")}.xlsx");
    }

}