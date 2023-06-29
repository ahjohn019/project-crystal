<?php

namespace App\Traits;

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
        $keyword = $payload['keyword'] ?? null;
        $searchable = $payload['searchable'] ?? null;

        if ($searchable) {
            foreach ($searchable as $search) {
                return $query->where($search, 'like', '%' . $keyword . '%');
            }
        }
    }

    public static function scopeSearchableForeign($query, array $payload = null, $foreignModel = null)
    {
        if (!$foreignModel) {
            throw new BadRequestExceptions("Please Fill In The Foreign Model.", 400);
        }

        foreach ($foreignModel as $fModel) {
            $foreignModelValue = $payload['foreign_model'][$fModel] ?? null;

            if ($foreignModelValue) {
                $query->orWhereHas(
                    $fModel,
                    function ($q) use ($payload, $foreignModelValue) {
                        $keyword = $payload['keyword'] ?? null;

                        foreach ($foreignModelValue as $attribute) {
                            $q->where($attribute, 'like', '%' . $keyword . '%');
                            $q->orWhere(
                                $attribute,
                                'like',
                                '%' . $keyword . '%'
                            );
                        }
                    }
                );
            }
        }
    }
}
