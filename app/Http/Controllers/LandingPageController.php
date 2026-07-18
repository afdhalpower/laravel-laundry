<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use App\Models\Service;
use App\Models\SiteSetting;
use App\Models\Testimonial;

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
}
