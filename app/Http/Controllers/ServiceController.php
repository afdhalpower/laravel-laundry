<?php

namespace App\Http\Controllers;

use App\Models\Service;
use Illuminate\Http\Request;

class ServiceController extends Controller
{
    public function index(Request $request)
    {
        $query = Service::query();

        if ($search = $request->search) {
            $query->where("nama", "like", "%{$search}%");
        }

        $services = $query->latest()->paginate(15);
        return view("services.index", compact("services"));
    }

    public function create()
    {
        return view("services.create");
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "nama" => "required|string|max:100",
            "tipe" => "required|in:kiloan,satuan",
            "harga" => "required|numeric|min:0",
            "estimasi_hari" => "required|integer|min:1",
        ]);

        Service::create($validated);

        return redirect()->route("services.index")
            ->with("success", "Layanan berhasil ditambahkan.");
    }

    public function edit(Service $service)
    {
        return view("services.edit", compact("service"));
    }

    public function update(Request $request, Service $service)
    {
        $validated = $request->validate([
            "nama" => "required|string|max:100",
            "tipe" => "required|in:kiloan,satuan",
            "harga" => "required|numeric|min:0",
            "estimasi_hari" => "required|integer|min:1",
        ]);

        $service->update($validated);

        return redirect()->route("services.index")
            ->with("success", "Layanan berhasil diupdate.");
    }

    public function destroy(Service $service)
    {
        if ($service->orderItems()->exists()) {
            return redirect()->route("services.index")
                ->with("error", "Layanan sudah digunakan di transaksi, tidak bisa dihapus.");
        }

        $service->delete();
        return redirect()->route("services.index")
            ->with("success", "Layanan berhasil dihapus.");
    }
}
