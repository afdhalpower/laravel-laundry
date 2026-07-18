<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::orderBy("sort_order")->paginate(10);
        return view("admin.testimonials.index", compact("testimonials"));
    }

    public function create()
    {
        return view("admin.testimonials.create");
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            "customer_name" => "required|max:255",
            "content" => "required",
            "rating" => "required|integer|min:1|max:5",
            "photo" => "nullable|image|mimes:jpg,jpeg,png,webp|max:2048",
            "is_active" => "nullable|boolean",
            "sort_order" => "nullable|integer|min:0",
        ]);

        if ($request->hasFile("photo")) {
            $data["photo"] = $request->file("photo")->store("testimonials", "public");
        }

        $data["is_active"] = $request->boolean("is_active");

        Testimonial::create($data);

        return redirect()->route("admin.testimonials.index")
            ->with("success", "Testimoni berhasil ditambahkan.");
    }

    public function edit(Testimonial $testimonial)
    {
        return view("admin.testimonials.edit", compact("testimonial"));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $data = $request->validate([
            "customer_name" => "required|max:255",
            "content" => "required",
            "rating" => "required|integer|min:1|max:5",
            "photo" => "nullable|image|mimes:jpg,jpeg,png,webp|max:2048",
            "is_active" => "nullable|boolean",
            "sort_order" => "nullable|integer|min:0",
        ]);

        if ($request->hasFile("photo")) {
            $data["photo"] = $request->file("photo")->store("testimonials", "public");
        }

        $data["is_active"] = $request->boolean("is_active");

        $testimonial->update($data);

        return redirect()->route("admin.testimonials.index")
            ->with("success", "Testimoni berhasil diubah.");
    }

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();
        return redirect()->route("admin.testimonials.index")
            ->with("success", "Testimoni berhasil dihapus.");
    }
}
