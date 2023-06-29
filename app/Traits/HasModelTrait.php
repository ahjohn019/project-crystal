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

    public static function scopeSearchable($query, array $payload = null, array $hasModelForeign = null)
    {
        $searchable = $payload['searchable'] ?? null;

        if (!$searchable) {
            return HasModelTrait::searchableForeign($query, $payload, $hasModelForeign, true);
        }

        HasModelTrait::handleSearchableMain($query, $payload, $hasModelForeign);
    }

    public static function handleSearchableMain($query, array $payload, $hasModelForeign)
    {
        $searchable = $payload['searchable'];

        foreach ($searchable as $search) {
            $result = $query->where($search, 'like', '%' . $payload['keyword'] ?? null . '%');

            if (!$hasModelForeign) {
                return $result;
            }

            return HasModelTrait::searchableForeign($result, $payload, $hasModelForeign);
        }
    }


    public static function handleSearchableForeign($query, $payload, $foreignModelValue)
    {
        $keyword = $payload['keyword'] ?? null;

        foreach ($foreignModelValue as $attribute) {
            $query->where($attribute, 'like', '%' . $keyword . '%');
            $query->orWhere(
                $attribute,
                'like',
                '%' . $keyword . '%'
            );
        }
    }

    public static function searchableForeign($query, array $payload = null, $hasModelForeign = null, $excludeMainSearch = false)
    {
        if (!$hasModelForeign) {
            throw new BadRequestExceptions("Please Fill In The Foreign Model.", 400);
        }

        foreach ($hasModelForeign as $fModel) {
            $foreignModelValue = $payload['foreign_model'][$fModel] ?? null;

            if ($foreignModelValue) {
                if ($excludeMainSearch) {
                    $query->whereHas(
                        $fModel,
                        function ($q) use ($payload, $foreignModelValue) {
                            HasModelTrait::handleSearchableForeign($q, $payload, $foreignModelValue);
                        }
                    );
                }

                $query->orWhereHas(
                    $fModel,
                    function ($q) use ($payload, $foreignModelValue) {
                        HasModelTrait::handleSearchableForeign($q, $payload, $foreignModelValue);
                    }
                );
            }
        }
    }
}
