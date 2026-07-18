<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Package extends Model
{
    use HasFactory;

    protected $fillable = ["nama", "deskripsi", "berat_kg", "harga", "aktif"];

    protected function casts(): array
    {
        return [
            "berat_kg" => "decimal:2",
            "harga" => "decimal:0",
            "aktif" => "boolean",
        ];
    }
}
