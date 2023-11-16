<?php

namespace App\Http\Services;

use App\Models\ConfigPopularity;

class PostService
{
    public static function calculatePopularity($currentEngagement, $type)
    {
        $latestPopluarity = ConfigPopularity::where('type', $type)
            ->orderBy('maximum_value', 'DESC')
            ->firstOrThrowError();

        $maximumEngagement = $latestPopluarity->maximum_value;

        $calculatePopularity = round(($currentEngagement / $maximumEngagement), 2);

        $calculatePopularityPercentage = $calculatePopularity * ConfigPopularity::FULL_PERCENTAGE;
        $resultPercentagePopularity = round($calculatePopularityPercentage, 2);

        if ($currentEngagement > $maximumEngagement) {
            $resultPercentagePopularity = ConfigPopularity::FULL_PERCENTAGE;
        }

        return ['popularity' => $calculatePopularity, 'popularity_percentage' => $resultPercentagePopularity];
    }

    public static function fetchPopularityGrade($currentEngagement)
    {
        $latestPopluarity = ConfigPopularity::where(function ($query) use ($currentEngagement) {
            $query->where('minimum_value', '<=', $currentEngagement);
            $query->where('maximum_value', '>=', $currentEngagement);
        })
            ->firstOrThrowError();

        $removeUnderscore = str_replace('_', ' ', $latestPopluarity->grade);
        $result = ucwords(strtolower($removeUnderscore));

        return $result;
    }
}
