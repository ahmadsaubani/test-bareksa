<?php


namespace App\Traits;

use Ramsey\Uuid\Uuid;

trait CreateUuid
{
    protected static function bootCreateUuid()
    {
        static::creating(function ($model) {
            $model->uuid = Uuid::uuid4()->toString();
        });
    }
}
