<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            ["nama" => "Cuci Kering", "tipe" => "kiloan", "harga" => 5000, "estimasi_hari" => 2],
            ["nama" => "Cuci Kering Setrika", "tipe" => "kiloan", "harga" => 8000, "estimasi_hari" => 2],
            ["nama" => "Cuci Basah", "tipe" => "kiloan", "harga" => 4000, "estimasi_hari" => 1],
            ["nama" => "Setrika saja", "tipe" => "kiloan", "harga" => 5000, "estimasi_hari" => 1],
            ["nama" => "Baju/Kemeja", "tipe" => "satuan", "harga" => 10000, "estimasi_hari" => 2],
            ["nama" => "Celana", "tipe" => "satuan", "harga" => 8000, "estimasi_hari" => 2],
            ["nama" => "Selimut", "tipe" => "satuan", "harga" => 15000, "estimasi_hari" => 3],
            ["nama" => "Jas/Blazer", "tipe" => "satuan", "harga" => 25000, "estimasi_hari" => 3],
            ["nama" => "Bed Cover", "tipe" => "satuan", "harga" => 20000, "estimasi_hari" => 3],
            ["nama" => "Karpet", "tipe" => "kiloan", "harga" => 12000, "estimasi_hari" => 4],
        ];

        foreach ($services as $svc) {
            Service::create($svc);
        }

        $this->command->info("10 layanan berhasil dibuat.");
    }
}
