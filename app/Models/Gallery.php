<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    protected $fillable = ["photo", "caption", "is_active", "sort_order"];

    protected function casts(): array
    {
        return [
            "is_active" => "boolean",
            "sort_order" => "integer",
        ];
    }

    public function scopeActive($query)
    {
        return $query->where("is_active", true)->orderBy("sort_order");
    }
}
