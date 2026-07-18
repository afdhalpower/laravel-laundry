<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use Illuminate\Http\Request;

class LandingSettingController extends Controller
{
    public function index()
    {
        $settings = SiteSetting::allAsArray();
        return view("admin.landing-settings.index", compact("settings"));
    }

    public function update(Request $request)
    {
        $fields = [
            "hero_title", "hero_subtitle", "hero_cta_text", "hero_cta_url",
            "about_title", "about_content", "about_image",
            "whatsapp_number", "address", "map_embed_url",
            "facebook_url", "instagram_url", "footer_text",
        ];

        foreach ($fields as $field) {
            if ($request->has($field)) {
                SiteSetting::set($field, $request->$field);
            }
        }

        return redirect()->route("admin.landing-settings.index")
            ->with("success", "Pengaturan landing page berhasil disimpan.");
    }
}
