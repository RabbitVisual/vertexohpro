<?php

namespace Modules\Core\Traits;

use Modules\Admin\Services\AuditService;

trait Auditable
{
    public static function bootAuditable()
    {
        static::created(function ($model) {
            app(AuditService::class)->log(
                'created',
                class_basename($model),
                'Created ' . class_basename($model),
                $model->toArray()
            );
        });

        static::updated(function ($model) {
            app(AuditService::class)->log(
                'updated',
                class_basename($model),
                'Updated ' . class_basename($model),
                [
                    'old' => $model->getOriginal(),
                    'new' => $model->getChanges(),
                ]
            );
        });

        static::deleted(function ($model) {
            app(AuditService::class)->log(
                'deleted',
                class_basename($model),
                'Deleted ' . class_basename($model),
                $model->toArray()
            );
        });
    }
}
