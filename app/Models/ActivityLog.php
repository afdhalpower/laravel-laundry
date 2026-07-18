<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class ActivityLog extends Model
{
    const UPDATED_AT = null;

    protected $fillable = ["actor_type", "actor_id", "action", "subject_type", "subject_id", "description", "old_values", "new_values"];

    protected function casts(): array
    {
        return [
            "old_values" => "json",
            "new_values" => "json",
        ];
    }

    public function actor(): MorphTo
    {
        return $this->morphTo();
    }

    public function subject(): MorphTo
    {
        return $this->morphTo();
    }

    public static function log($actor, $action, $subject, $description = null, $old = null, $new = null): self
    {
        return self::create([
            "actor_type" => $actor ? get_class($actor) : null,
            "actor_id" => $actor?->id,
            "action" => $action,
            "subject_type" => get_class($subject),
            "subject_id" => $subject->id,
            "description" => $description,
            "old_values" => $old,
            "new_values" => $new,
        ]);
    }
}
