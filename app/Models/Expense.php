<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    use HasFactory;

    protected $fillable = ["judul", "deskripsi", "kategori", "jumlah", "tgl_pengeluaran", "user_id"];

    protected function casts(): array
    {
        return [
            "jumlah" => "decimal:0",
            "tgl_pengeluaran" => "date",
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
