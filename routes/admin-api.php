<?php

use App\Library\RoleTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\RefController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('auth')->middleware([])->group(
    function () {
        Route::post('/login', [AuthController::class, 'login']);
        Route::post('/register', [AuthController::class, 'register']);
        Route::post('/reset-password', [AuthController::class, 'resetPassword']);
        Route::post('/forgot-password', [AuthController::class, 'forgotPassword']);
    }
);

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('auth')->middleware([])->group(function () {
        Route::post('/profile', [AuthController::class, 'authProfile']);
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::post('/update-password', [AuthController::class, 'updatePassword']);
    });
});

// sanctum auth
Route::middleware(['auth:sanctum', 'role:' . RoleTag::SUPERADMIN . '|' . RoleTag::ADMIN])->group(function () {
    Route::prefix('admin')->group(function () {
        Route::get('/list', [AdminController::class, 'list'])->name('admin.list');
        Route::post('/store', [AdminController::class, 'store'])->name('admin.store');
        Route::get('/show/{id}', [AdminController::class, 'show'])->name('admin.show');
        Route::put('/update', [AdminController::class, 'update'])->name('admin.update');
        Route::delete('/delete/{id}', [AdminController::class, 'delete'])->name('admin.delete');
    });

    Route::prefix('banner')->group(function () {
        Route::get('/list', [BannerController::class, 'list'])->name('banner.list');
        Route::post('/store', [BannerController::class, 'store'])->name('banner.store');
        Route::get('/show/{id}', [BannerController::class, 'show'])->name('banner.show');
        Route::post('/update', [BannerController::class, 'update'])->name('banner.update');
        Route::delete('/delete/{id}', [BannerController::class, 'delete'])->name('banner.delete');
    });

    Route::prefix('post')->name('posts.')->group(function () {
        Route::get('/list', [PostController::class, 'list'])->name('list');
        Route::post('/store', [PostController::class, 'store'])->name('store');
        Route::get('/show/{id}', [PostController::class, 'show'])->name('show');
        Route::post('/update', [PostController::class, 'update'])->name('update');
        Route::delete('/delete/{id}', [PostController::class, 'delete'])->name('delete');
    });

    Route::prefix('dashboard')->name('dashboard.')->group(function () {
        Route::get('/all', [DashboardController::class, 'fetchAllPost'])->name('all');
        Route::get('/current', [DashboardController::class, 'fetchCurrentPost'])->name('current');
        Route::get('/current-comment', [DashboardController::class, 'fetchCurrentComment'])->name('current_comment');
        Route::get('/user-list', [DashboardController::class, 'fetchUserList'])->name('user_list');
        Route::get('/monthly-post', [DashboardController::class, 'fetchMonthlyPost'])->name('monthly_post');
        Route::get('/top-category', [DashboardController::class, 'fetchTopCategory'])->name('top_category');
        Route::get('/highest-likes-month', [DashboardController::class, 'fetchHighestLikesByMonth'])->name('highest_like_month');
        Route::get('/highest-comment-month', [DashboardController::class, 'fetchHighestCommentByMonth'])->name('highest_comment_month');
        Route::get('/bar-chart-data', [DashboardController::class, 'retrieveBarChartData'])->name('bar_chart_data');
    });

    Route::prefix('ref')->name('ref.')->group(function () {
        Route::get('/category', [RefController::class, 'category'])->name('category');
    });
});
