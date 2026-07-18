<?php

namespace Database\Seeders;

use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            "name" => "Admin Laundry",
            "email" => "admin@laundryku.com",
            "password" => bcrypt("password"),
        ]);

        // Default site settings for landing page
        $defaults = [
            "hero_title" => "Laundry Terpercaya di Kota Anda",
            "hero_subtitle" => "Kami siap membantu pakaian Anda bersih, wangi, dan rapi dengan layanan profesional.",
            "hero_cta_text" => "Pesan Sekarang",
            "hero_cta_url" => "https://wa.me/6281234567890",
            "about_title" => "Tentang LaundryKu",
            "about_content" => "LaundryKu adalah jasa laundry profesional yang melayani cuci kering, setrika, dan cuci express. Kami berkomitmen memberikan hasil terbaik untuk pakaian kesayangan Anda dengan pelayanan ramah dan harga terjangkau.",
            "whatsapp_number" => "6281234567890",
            "address" => "Jl. Contoh No. 123, Kota Anda",
            "footer_text" => "\u00a9 " . date("Y") . " LaundryKu. All rights reserved.",
        ];

        foreach ($defaults as $key => $value) {
            SiteSetting::set($key, $value);
        }

        $this->call([
            ServiceSeeder::class,
            CustomerSeeder::class,
        ]);
    }
}
