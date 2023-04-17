<?php
namespace App\Http\Traits;

trait CreatedUpdatedBy
{
    public static function bootCreatedUpdatedBy()
    {
        $user = auth()->user();

        static::creating(function ($model) use ($user) {
            if (!$model->isDirty('created_by')) {
                $model->created_by = $user->username;
            }

            if (!$model->isDirty('updated_by')) {
                $model->updated_by = $user->username;
            }
        });

        static::updating(function ($model) use ($user) {
            if (!$model->isDirty('updated_by')) {
                $model->updated_by = $user->username;
            }
        });
    }
}
