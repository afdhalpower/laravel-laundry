<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $fillable = ['nama', 'tipe', 'harga', 'estimasi_hari'];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
