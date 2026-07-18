<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        $query = Customer::query();

        if ($search = $request->search) {
            $query->where("nama", "like", "%{$search}%")
                  ->orWhere("no_telp", "like", "%{$search}%");
        }

        $customers = $query->withCount("orders")
            ->latest()
            ->paginate(15);

        return view("customers.index", compact("customers"));
    }

    public function show(Customer $customer)
    {
        $customer->loadCount("orders");

        $orders = $customer->orders()
            ->with("customer")
            ->latest()
            ->paginate(15);

        return view("customers.show", compact("customer", "orders"));
    }

    public function create()
    {
        return view("customers.create");
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            "nama" => "required|string|max:100",
            "no_telp" => "required|string|max:20|unique:customers",
            "alamat" => "nullable|string",
        ]);

        Customer::create($validated);

        return redirect()->route("customers.index")
            ->with("success", "Pelanggan berhasil ditambahkan.");
    }

    public function edit(Customer $customer)
    {
        return view("customers.edit", compact("customer"));
    }

    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            "nama" => "required|string|max:100",
            "no_telp" => ["required", "string", "max:20", Rule::unique("customers")->ignore($customer->id)],
            "alamat" => "nullable|string",
        ]);

        $customer->update($validated);

        return redirect()->route("customers.index")
            ->with("success", "Pelanggan berhasil diupdate.");
    }

    public function destroy(Customer $customer)
    {
        if ($customer->orders()->exists()) {
            return redirect()->route("customers.index")
                ->with("error", "Pelanggan memiliki transaksi aktif, tidak bisa dihapus.");
        }

        $customer->delete();
        return redirect()->route("customers.index")
            ->with("success", "Pelanggan berhasil dihapus.");
    }
}
