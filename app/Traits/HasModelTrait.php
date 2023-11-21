<?php

namespace App\Traits;

use Illuminate\Support\Facades\App;
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
        $searchableMain = isset($payload['searchable']) ? $payload['searchable'] : null;

        collect($searchableMain)->map(function ($search) use ($query, $payload, $hasModelForeign) {
            $searchKeyword = '%' . $payload['keyword'] . '%';

            $searchMainResult = $query->where($search, 'like', $searchKeyword)
                ->orWhere($search, 'like', $searchKeyword);

            if ($hasModelForeign) {
                collect($hasModelForeign)->each(function ($foreign, $key) use ($searchMainResult,  $searchKeyword) {
                    $searchMainResult->orWhereHas($key, function ($query) use ($foreign, $searchKeyword) {
                        $query->where($foreign, 'like', $searchKeyword);
                    });
                });
            }

            return $searchMainResult;
        });
    }
}
