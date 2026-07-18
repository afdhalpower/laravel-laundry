<?php

namespace App\Http\Controllers;

use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function index(Request $request)
    {
        $query = Package::query();

        if ($search = $request->search) {
            $query->where("nama", "like", "%{$search}%");
        }

        $packages = $query->latest()->paginate(15);
        return view("packages.index", compact("packages"));
    }

    public function create()
    {
        return view("packages.create");
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "nama" => "required|string|max:100",
            "deskripsi" => "nullable|string",
            "berat_kg" => "required|numeric|min:0.1",
            "harga" => "required|numeric|min:0",
            "aktif" => "nullable|boolean",
        ]);

        $validated["aktif"] = $request->boolean("aktif", true);

        Package::create($validated);

        return redirect()->route("packages.index")
            ->with("success", "Paket berhasil ditambahkan.");
    }

    public function edit(Package $package)
    {
        return view("packages.edit", compact("package"));
    }

    public function update(Request $request, Package $package)
    {
        $validated = $request->validate([
            "nama" => "required|string|max:100",
            "deskripsi" => "nullable|string",
            "berat_kg" => "required|numeric|min:0.1",
            "harga" => "required|numeric|min:0",
            "aktif" => "nullable|boolean",
        ]);

        $validated["aktif"] = $request->boolean("aktif", true);

        $package->update($validated);

        return redirect()->route("packages.index")
            ->with("success", "Paket berhasil diupdate.");
    }

    public function destroy(Package $package)
    {
        $package->delete();
        return redirect()->route("packages.index")
            ->with("success", "Paket berhasil dihapus.");
    }
}
