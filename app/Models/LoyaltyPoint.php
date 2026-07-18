<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class LoyaltyPoint extends Model
{
    use HasFactory;

    protected $fillable = ["customer_id", "points", "type", "keterangan", "source_type", "source_id"];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class);
    }

    public function source(): MorphTo
    {
        return $this->morphTo();
    }
}
