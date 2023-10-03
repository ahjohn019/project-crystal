<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Services\DashboardService;

class DashboardController extends Controller
{
    //
    public function fetchAllPost()
    {
        $payload = DashboardService::allPost();
        return self::successResponse('data', $payload);
    }

    public function fetchCurrentPost()
    {
        $payload = DashboardService::currentPost();
        return self::successResponse('data', $payload);
    }

    public function fetchUserList()
    {
        $payload = DashboardService::userList();
        return self::successResponse('data', $payload);
    }

    public function fetchCurrentComment()
    {
        $payload = DashboardService::currentComment();
        return self::successResponse('data', $payload);
    }

    public function fetchMonthlyPost()
    {
        $payload = DashboardService::monthlyPost();
        return self::successResponse('data', $payload);
    }

    public function fetchTopCategory()
    {
        $payload = DashboardService::topCategory();
        return self::successResponse('data', $payload);
    }

    public function fetchHighestLikesByMonth()
    {
        $payload = DashboardService::highestLikeByMonth();
        return self::successResponse('data', $payload);
    }

    public function fetchHighestCommentByMonth()
    {
        $payload = DashboardService::highestCommentByMonth();
        return self::successResponse('data', $payload);
    }

    public function retrieveBarChartData()
    {
        $payload = DashboardService::retrieveBarChartData();
        return self::successResponse('data', $payload);
    }
}
