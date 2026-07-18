<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index(Request $request)
    {
        $query = Expense::with("user");

        if ($search = $request->search) {
            $query->where("judul", "like", "%{$search}%")
                  ->orWhere("deskripsi", "like", "%{$search}%");
        }

        if ($kategori = $request->kategori) {
            $query->where("kategori", $kategori);
        }

        $expenses = $query->latest()->paginate(15);
        return view("expenses.index", compact("expenses"));
    }

    public function create()
    {
        return view("expenses.create");
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "judul" => "required|string|max:200",
            "deskripsi" => "nullable|string",
            "kategori" => "required|in:deterjen,listrik,air,gaji,lainnya",
            "jumlah" => "required|numeric|min:0",
            "tgl_pengeluaran" => "required|date",
        ]);

        $validated["user_id"] = auth()->id();

        Expense::create($validated);

        return redirect()->route("expenses.index")
            ->with("success", "Pengeluaran berhasil dicatat.");
    }

    public function edit(Expense $expense)
    {
        return view("expenses.edit", compact("expense"));
    }

    public function update(Request $request, Expense $expense)
    {
        $validated = $request->validate([
            "judul" => "required|string|max:200",
            "deskripsi" => "nullable|string",
            "kategori" => "required|in:deterjen,listrik,air,gaji,lainnya",
            "jumlah" => "required|numeric|min:0",
            "tgl_pengeluaran" => "required|date",
        ]);

        $expense->update($validated);

        return redirect()->route("expenses.index")
            ->with("success", "Pengeluaran berhasil diupdate.");
    }

    public function destroy(Expense $expense)
    {
        $expense->delete();
        return redirect()->route("expenses.index")
            ->with("success", "Pengeluaran berhasil dihapus.");
    }
}
