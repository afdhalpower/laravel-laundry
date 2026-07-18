<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Loggable;

class Service extends Model
{
    use HasFactory, Loggable;

    protected $fillable = ['nama', 'tipe', 'harga', 'estimasi_hari'];

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
