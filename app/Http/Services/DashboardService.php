<?php

namespace App\Http\Services;

use DB;
use Carbon\Carbon;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Collection;

class DashboardService
{
    public static function allPost()
    {
        $postQuery = Post::all();

        return ['posts' => $postQuery];
    }

    public static function currentPost()
    {
        $postQuery = Post::whereDate('created_at', Carbon::today());
        $posts = $postQuery->get();
        $totalPost = $postQuery->count();
        $totalLikes = $postQuery->sum('likes');

        return ['posts' => $posts, 'total' => $totalPost, 'total_likes' => $totalLikes];
    }

    public static function userList()
    {
        $userQuery = User::role(User::USER);

        $user = $userQuery->get();
        $totalUser = $userQuery->count();

        return ['user' => $user, 'total' => $totalUser];
    }

    public static function currentComment()
    {
        $commentQuery = Comment::whereDate('created_at', Carbon::today());

        $comments = $commentQuery->get();
        $totalComments = $commentQuery->count();

        return ['comments' => $comments, 'total_comments' => $totalComments];
    }

    public static function monthlyPost()
    {
        $postQuery = Post::whereMonth('created_at', Carbon::now()->month);

        $getMonthlyPost = $postQuery->get();
        $getMonthlyPostCount = $postQuery->count();

        return ['monthly_post' => $getMonthlyPost, 'monthly_count' => $getMonthlyPostCount];
    }

    public static function topCategory()
    {
        $highestCount = Post::query()
            ->select(DB::raw('COUNT(*) as total'))
            ->groupBy('category_id')
            ->orderByDesc('total')
            ->value('total');

        $topCategoriesInfo = Post::query()
            ->select('category_id', DB::raw('COUNT(*) as total'))
            ->with('category')
            ->groupBy('category_id')
            ->having('total', '=', $highestCount)
            ->get();

        return ['top_category' => $topCategoriesInfo, 'highest' => $highestCount];
    }

    public static function highestLikeByMonth()
    {
        $postQuery = Post::whereMonth('created_at', Carbon::now()->month);
        $getHighestLikesCount = $postQuery->max('likes');

        return ['likes' => $getHighestLikesCount];
    }

    public static function highestCommentByMonth()
    {
        $commentQuery = Comment::whereMonth('created_at', Carbon::now()->month);

        $groupWithComment = $commentQuery->select(DB::raw('COUNT(*) as total'))
            ->where('commentable_type', 'App\Models\Post')
            ->groupBy('commentable_id');

        $maxNumberComment = $groupWithComment->orderByDesc('total')->value('total');

        return ['comments' => $maxNumberComment];
    }

    public static function retrieveBarChartData()
    {
        $postQuery = Post::query();
        $monthListInit = [];
        $restructuredMonthInit = [];

        Collection::make(range(1, 12))->map(function ($monthNumber) use (&$monthListInit) {
            $monthName = Carbon::createFromDate(null, $monthNumber, 1)->format("F");
            $monthListInit[$monthName] = 0;
        })->all();

        $totalPostByMonth = $postQuery
            ->selectRaw('COUNT(*) as total, MONTHNAME(created_at) as month_name')
            ->groupByRaw('MONTHNAME(created_at)');

        $totalPostByMonth = $totalPostByMonth->pluck('total', 'month_name')->toArray();

        foreach ($monthListInit as $monthName => $defaultValue) {
            $restructuredMonthInit[$monthName] = $totalPostByMonth[$monthName] ?? 0;
        }

        return ["data" => $restructuredMonthInit];
    }
}
