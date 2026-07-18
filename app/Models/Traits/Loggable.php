<?php

namespace App\Models\Traits;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;

trait Loggable
{
    protected static function bootLoggable(): void
    {
        static::created(function (Model $model) {
            static::logActivity($model, 'created', null, $model->toArray());
        });

        static::updated(function (Model $model) {
            $old = $model->getOriginal();
            $new = $model->getChanges();
            static::logActivity($model, 'updated', $old, $new);
        });

        static::deleted(function (Model $model) {
            $old = $model->getOriginal();
            static::logActivity($model, 'deleted', $old, null);
        });
    }

    protected static function logActivity(Model $model, string $action, ?array $old = null, ?array $new = null): void
    {
        $actor = auth()->user();

        $description = static::generateDescription($model, $action);

        ActivityLog::log($actor, $action, $model, $description, $old, $new);
    }

    protected static function generateDescription(Model $model, string $action): string
    {
        $modelName = class_basename($model);
        $identifier = $model->name ?? $model->nama ?? $model->no_order ?? $model->id;

        return match ($action) {
            'created' => "{$modelName} baru dibuat: {$identifier}",
            'updated' => "{$modelName} diubah: {$identifier}",
            'deleted' => "{$modelName} dihapus: {$identifier}",
            default => "{$modelName} {$action}: {$identifier}",
        };
    }
}
