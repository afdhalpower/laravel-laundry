<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Testimonial extends Model
{
    protected $fillable = [
        "customer_name", "content", "rating",
        "photo", "is_active", "sort_order"
    ];

    protected function casts(): array
    {
        return [
            "is_active" => "boolean",
            "rating" => "integer",
            "sort_order" => "integer",
        ];
    }

    public function scopeActive($query)
    {
        return $query->where("is_active", true)->orderBy("sort_order");
    }
}
