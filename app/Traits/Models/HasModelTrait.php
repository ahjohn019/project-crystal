<?php

namespace App\Traits\Models;

use App\Exceptions\BadRequestExceptions;

trait HasModelTrait
{
    public static function scopeFirstOrThrowError($query, String $message = 'The selected data is invalid', $status = 400)
    {
        return $query->firstOr(function () use ($message, $status) {
            throw new BadRequestExceptions($message, $status);
        });
    }
}
