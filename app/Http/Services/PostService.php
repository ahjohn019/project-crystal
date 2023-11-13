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

        $calculatePopularity = ($currentEngagement / $maximumEngagement) * ConfigPopularity::FULL_PERCENTAGE;
        $resultPopularity = round($calculatePopularity, 2);

        if ($currentEngagement > $maximumEngagement) {
            $resultPopularity = ConfigPopularity::FULL_PERCENTAGE;
        }

        return $resultPopularity;
    }
}
