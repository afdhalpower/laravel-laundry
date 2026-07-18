<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\Loggable;

class Customer extends Model
{
    use HasFactory, Loggable;

    protected $fillable = ['nama', 'no_telp', 'alamat'];

    protected $appends = ['poin', 'total_transaksi'];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function loyaltyPoints()
    {
        return $this->hasMany(LoyaltyPoint::class);
    }

    /**
     * Earn loyalty points when order is completed.
     * 1 point per Rp 1,000 (or 10 points per Rp 10,000).
     */
    public function earnPoints(Order $order): void
    {
        $pointsEarned = floor($order->total_harga / 1000);

        if ($pointsEarned > 0) {
            LoyaltyPoint::create([
                "customer_id" => $this->id,
                "points" => $pointsEarned,
                "type" => "earned",
                "keterangan" => "Transaksi #" . $order->no_order,
                "source_type" => Order::class,
                "source_id" => $order->id,
            ]);

            $this->increment("poin", $pointsEarned);
        }
    }

    /**
     * Redeem loyalty points for discount.
     * 100 points = Rp 5,000 discount.
     */
    public function redeemPoints(int $points, Order $order): int
    {
        if ($this->poin < $points) {
            throw new \Exception("Poin tidak mencukupi. Tersedia: " . $this->poin);
        }

        $discount = floor($points / 100) * 5000;

        if ($discount > $order->total_harga) {
            $discount = $order->total_harga;
            $points = ceil($discount / 5000) * 100;
        }

        LoyaltyPoint::create([
            "customer_id" => $this->id,
            "points" => -$points,
            "type" => "redeemed",
            "keterangan" => "Redeem untuk transaksi #" . $order->no_order . " (diskon Rp " . number_format($discount, 0, ",", ".") . ")",
            "source_type" => Order::class,
            "source_id" => $order->id,
        ]);

        $this->decrement("poin", $points);
        $order->decrement("total_harga", $discount);

        return $discount;
    }

    public function getPoinAttribute(): int
    {
        return $this->attributes["poin"] ?? 0;
    }

    public function getTotalTransaksiAttribute(): int
    {
        return $this->orders()->count();
    }
}
