<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Models\Traits\Loggable;

class Order extends Model
{
    use HasFactory, SoftDeletes, Loggable;

    protected $fillable = [
        'no_order', 'customer_id', 'tgl_masuk', 'tgl_selesai',
        'status', 'total_harga', 'catatan'
    ];

    protected function casts(): array
    {
        return [
            'tgl_masuk' => 'date',
            'tgl_selesai' => 'date',
        ];
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function getStatusLabelAttribute()
    {
        $labels = [
            'diterima' => 'Diterima',
            'dicuci' => 'Dicuci',
            'dikeringkan' => 'Dikeringkan',
            'disetrika' => 'Disetrika',
            'dilipat' => 'Dilipat',
            'siap' => 'Siap',
            'diantar' => 'Diantar',
            'selesai' => 'Selesai',
        ];
        return $labels[$this->status] ?? $this->status;
    }

    public function getStatusColorAttribute()
    {
        $colors = [
            'diterima' => 'secondary',
            'dicuci' => 'info',
            'dikeringkan' => 'primary',
            'disetrika' => 'warning',
            'dilipat' => 'info',
            'siap' => 'success',
            'diantar' => 'primary',
            'selesai' => 'success',
        ];
        return $colors[$this->status] ?? 'secondary';
    }
}
