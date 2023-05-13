<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\UserController;
use App\Http\Controllers\Web\AuthController;

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
Route::middleware(['auth:sanctum', 'permission:web'])->group(function () {
    Route::get('/user-test', [UserController::class, 'index']);
});
