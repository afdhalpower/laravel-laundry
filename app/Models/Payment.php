<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    protected $fillable = ["order_id", "tgl_bayar", "jumlah", "metode", "keterangan"];

    protected function casts(): array
    {
        return [
            "jumlah" => "decimal:0",
            "tgl_bayar" => "date",
        ];
    }

    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class);
    }
}
