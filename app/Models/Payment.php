<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = ['order_id', 'tgl_bayar', 'jumlah', 'metode', 'keterangan'];

    protected function casts(): array
    {
        return [
            'tgl_bayar' => 'date',
        ];
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
