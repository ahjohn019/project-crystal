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

        $postQuery = Post::query();
        $totalPosts = $postQuery->get();
        $postCount = $postQuery->count();

        return ['posts' => $totalPosts, 'counts' => $postCount];
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
        $months = collect(range(1, 12))->map(function ($monthNumber) {
            return Carbon::createFromDate(null, $monthNumber, 1)->format("F");
        })->toArray();

        $totalPostByMonth = Post::query()
            ->selectRaw('MONTHNAME(created_at) as month_name')
            ->selectRaw('COUNT(*) as total')
            ->groupByRaw('MONTHNAME(created_at)')
            ->pluck('total', 'month_name')
            ->all();

        $restructuredMonthInit = array_fill_keys($months, 0);
        $restructuredMonthInit = array_replace($restructuredMonthInit, $totalPostByMonth);

        return ["data" => $restructuredMonthInit];
    }
}
