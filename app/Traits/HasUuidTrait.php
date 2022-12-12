<?php

namespace App\Traits;

use Ramsey\Uuid\Uuid;

trait HasUuidTrait
{
    protected static function bootHasUuidTrait()
    {
        static::creating(function ($model) {

            if (!$model->id) {
                $model->id = (string)Uuid::uuid4();
            }
        });
    }

    public static function findByUuidOrFail($uuid)
    {
        return self::whereUuid($uuid)->firstOrFail();
    }

    /**
     * Eloquent scope to look for a given UUID
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  String                                $uuid  The UUID to search for
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithUuid($query, $uuid)
    {
        return $query->where('id', $uuid);
    }

    /**
     * Eloquent scope to look for multiple given UUIDs
     *
     * @param  \Illuminate\Database\Eloquent\Builder $query
     * @param  Array                                 $uuids  The UUIDs to search for
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeWithUuids($query, Array $uuids): \Illuminate\Database\Eloquent\Builder
    {
        return $query->whereIn('id', $uuids);
    }

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName(): string
    {
        return 'id';
    }
}
