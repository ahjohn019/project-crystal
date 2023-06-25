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

    public static function scopeSearchable($query, array $payload = null)
    {
        $keyword = isset($payload['keyword']) ? $payload['keyword'] : null;
        $searchable = isset($payload['searchable']) ? $payload['searchable'] : null;

        if ($searchable) {
            foreach ($searchable as $search) {
                return $query->where($search, 'like', '%' . $keyword . '%');
            }
        }
    }

    public static function scopeSearchableForeign($query, array $payload = null, $foreignModel = null)
    {
        return $query->orWhereHas($foreignModel, function ($q) use ($payload, $foreignModel) {
            $foreignAttributes = isset($payload['foreign_model']) ? $payload['foreign_model'][$foreignModel] : null;
            $keyword = isset($payload['keyword']) ? $payload['keyword'] : null;

            foreach ($foreignAttributes as $attribute) {
                $q->where($attribute, 'like', '%' . $keyword . '%');
                $q->orWhere($attribute, 'like', '%' . $keyword . '%');
            }
        });
    }
}
