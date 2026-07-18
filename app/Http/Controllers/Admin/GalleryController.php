<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $galleries = Gallery::orderBy("sort_order")->paginate(12);
        return view("admin.galleries.index", compact("galleries"));
    }

    public function create()
    {
        return view("admin.galleries.create");
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            "photo" => "required|image|mimes:jpg,jpeg,png,webp|max:5120",
            "caption" => "nullable|max:255",
            "is_active" => "nullable|boolean",
            "sort_order" => "nullable|integer|min:0",
        ]);

        $data["photo"] = $request->file("photo")->store("galleries", "public");
        $data["is_active"] = $request->boolean("is_active");

        Gallery::create($data);

        return redirect()->route("admin.galleries.index")
            ->with("success", "Foto berhasil ditambahkan.");
    }

    public function edit(Gallery $gallery)
    {
        return view("admin.galleries.edit", compact("gallery"));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $data = $request->validate([
            "photo" => "nullable|image|mimes:jpg,jpeg,png,webp|max:5120",
            "caption" => "nullable|max:255",
            "is_active" => "nullable|boolean",
            "sort_order" => "nullable|integer|min:0",
        ]);

        if ($request->hasFile("photo")) {
            $data["photo"] = $request->file("photo")->store("galleries", "public");
        }

        $data["is_active"] = $request->boolean("is_active");

        $gallery->update($data);

        return redirect()->route("admin.galleries.index")
            ->with("success", "Foto berhasil diubah.");
    }

    public function destroy(Gallery $gallery)
    {
        $gallery->delete();
        return redirect()->route("admin.galleries.index")
            ->with("success", "Foto berhasil dihapus.");
    }
}
