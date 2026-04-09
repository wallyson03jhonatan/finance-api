<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\TransactionsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 * Public routes (register, login and forgot password) ...
 */
Route::middleware('guest')->group(function () {
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/register', [RegisterController::class, 'register']);
});

/**
 * Protected routes (using Sanctun token to access)
 */
Route::middleware('auth:sanctum')->group(function () {

    // Transactions
    Route::prefix('transactions')
        ->controller(TransactionsController::class)
        ->group(function () {
            Route::get('/', 'index');
            Route::get('/{id}', 'show');
            Route::post('/', 'store');
            Route::put('/{id}', 'update');
            Route::delete('/{id}', 'destroy');
        });

    // Reports
    Route::get('/report', [ReportController::class, 'index']);

    // Categories
    Route::prefix('categories')->controller(CategoriesController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
        Route::post('/', 'store');
        Route::put('/{id}', 'update');
        Route::delete('/{id}', 'destroy');
    });

    // Logout
    Route::post('/logout', function (Request $request) {
        $request->user()->tokens()->delete();

        return response()->json(['message' => 'Logout realizado']);
    });

    // Check auth
    Route::get('/me', fn(Request $request) => response()->json([
        'user' => $request->user(),
    ]));

    // Profile 
    Route::prefix('profile')->controller(ProfileController::class)->group(function () {
        Route::put('/info', 'updateInfo');
        Route::put('/password', 'updatePassword');
    });
});
