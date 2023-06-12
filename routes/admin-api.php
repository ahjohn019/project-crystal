<?php

use App\Library\RoleTag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\BannerController;

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

    Route::prefix('post')->group(function () {
        Route::get('/list', [PostController::class, 'list'])->name('posts.list');
        Route::post('/store', [PostController::class, 'store'])->name('posts.store');
        Route::get('/show/{id}', [PostController::class, 'show'])->name('posts.show');
        Route::post('/update', [PostController::class, 'update'])->name('posts.update');
        Route::delete('/delete/{id}', [PostController::class, 'delete'])->name('posts.delete');
    });
});
