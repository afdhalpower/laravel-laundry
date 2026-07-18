<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    public function run(): void
    {
        $customers = [
            ["nama" => "Budi Santoso", "no_telp" => "081234567890", "alamat" => "Jl. Merdeka No. 10, Jakarta"],
            ["nama" => "Siti Rahmawati", "no_telp" => "082345678901", "alamat" => "Jl. Sudirman No. 25, Bandung"],
            ["nama" => "Ahmad Hidayat", "no_telp" => "083456789012", "alamat" => "Jl. Gatot Subroto No. 5, Surabaya"],
            ["nama" => "Dewi Lestari", "no_telp" => "084567890123", "alamat" => "Jl. Diponegoro No. 12, Yogyakarta"],
            ["nama" => "Rudi Hermawan", "no_telp" => "085678901234", "alamat" => "Jl. Pahlawan No. 8, Semarang"],
            ["nama" => "Nurul Aini", "no_telp" => "086789012345", "alamat" => "Jl. Cendana No. 3, Malang"],
            ["nama" => "Agus Prasetyo", "no_telp" => "087890123456", "alamat" => "Jl. Kenanga No. 15, Solo"],
            ["nama" => "Rina Wulandari", "no_telp" => "088901234567", "alamat" => "Jl. Melati No. 7, Denpasar"],
            ["nama" => "Bayu Saputra", "no_telp" => "089012345678", "alamat" => "Jl. Anggrek No. 20, Medan"],
            ["nama" => "Fitri Handayani", "no_telp" => "080123456789", "alamat" => "Jl. Mawar No. 9, Makassar"],
        ];

        foreach ($customers as $c) {
            Customer::create($c);
        }

        $this->command->info("10 pelanggan berhasil dibuat.");
    }
}
