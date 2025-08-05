<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\TransactionsController;
use App\Http\Controllers\CategoriesController;

/**
 * Rotas públicas (login e registro)
 */
Route::middleware('guest')->group(function () {
    Route::post('/login', [LoginController::class, 'login']);
    Route::post('/register', [RegisterController::class, 'register']);
});

/**
 * Rotas protegidas (necessitam de token Sanctum)
 */
Route::middleware('auth:sanctum')->group(function () {
    // Transações CRUD
    Route::prefix('transactions')
        ->controller(TransactionsController::class)
        ->group(function () {
            Route::get('/', 'index');
            Route::get('/{id}', 'show');
            Route::post('/create', 'store');
            Route::put('/update/{id}', 'update');
            Route::delete('/delete/{id}', 'destroy');
        });

    // Reports
    Route::get('/report', [ReportController::class, 'index']);

    // Categories 
    Route::prefix("categories")->controller(CategoriesController::class)->group(function () {
        Route::get('/', 'index');
        Route::get('/{id}', 'show');
        Route::post('/create', 'store');
        Route::put('/update/{id}', 'update');
        Route::delete('/delete/{id}', 'destroy');
    });

    // Logout
    Route::post('/logout', function (Request $request) {
        $request->user()->tokens()->delete();
        return response()->json(['message' => 'Logout realizado']);
    });
});
