<?php

namespace App\Http\Controllers;

use App\Exports\OrderExport;
use App\Models\Expense;
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



    public function profitLoss(Request $request)
    {
        $from = $request->from ? Carbon::parse($request->from) : today()->startOfMonth();
        $to = $request->to ? Carbon::parse($request->to) : today();

        // Revenue dari orders dalam range
        $orders = Order::whereBetween("tgl_masuk", [$from, $to])->get();
        $totalRevenue = $orders->sum("total_harga");
        $totalOrders = $orders->count();

        // Pengeluaran dalam range
        $expenses = Expense::whereBetween("tgl_pengeluaran", [$from, $to])->get();
        $totalExpenses = $expenses->sum("jumlah");

        $netProfit = $totalRevenue - $totalExpenses;
        $margin = $totalRevenue > 0 ? round(($netProfit / $totalRevenue) * 100, 1) : 0;

        // Group expenses by category for chart
        $expenseCategories = $expenses->groupBy("kategori")->map(fn($g) => $g->sum("jumlah"));
        $expCatLabels = $expenseCategories->keys()->toArray();
        $expCatValues = $expenseCategories->values()->toArray();

        // Daily revenue vs expense for chart
        $chartLabels = [];
        $chartRevenue = [];
        $chartExpense = [];
        $period = $from->copy();
        while ($period->lte($to)) {
            $dateKey = $period->format("Y-m-d");
            $chartLabels[] = $period->format("d M");

            $dayOrders = $orders->filter(fn($o) => $o->tgl_masuk->format("Y-m-d") === $dateKey);
            $chartRevenue[] = (float) $dayOrders->sum("total_harga");

            $dayExpense = $expenses->filter(fn($e) => $e->tgl_pengeluaran->format("Y-m-d") === $dateKey);
            $chartExpense[] = (float) $dayExpense->sum("jumlah");

            $period->addDay();
        }

        return view("reports.profit-loss", compact(
            "totalRevenue", "totalOrders", "totalExpenses", "netProfit", "margin",
            "expCatLabels", "expCatValues", "chartLabels", "chartRevenue", "chartExpense",
            "expenses", "from", "to"
        ));
    }

}