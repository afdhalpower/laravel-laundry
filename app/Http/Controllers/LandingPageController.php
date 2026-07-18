<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Order;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\Testimonial;
use Illuminate\Http\Request;

class LandingPageController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::allAsArray();
        $services = Service::orderBy("nama")->get();
        $testimonials = Testimonial::active()->get();
        $galleries = Gallery::active()->get();

        return view("landing.index", compact(
            "settings", "services", "testimonials", "galleries"
        ));
    }

    public function cekStatus(Request $request)
    {
        $settings = SiteSetting::allAsArray();
        $order = null;
        $notFound = false;

        if ($noOrder = $request->query("no_order")) {
            $order = Order::with(["customer", "items.service", "payments"])
                ->where("no_order", $noOrder)
                ->first();

            if (!$order) {
                $notFound = true;
            }
        }

        return view("landing.cek-status", compact(
            "settings", "order", "notFound"
        ));
    }
}
