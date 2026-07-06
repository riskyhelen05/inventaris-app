<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ActivityLogController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard
    |--------------------------------------------------------------------------
    */
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    /*
    |--------------------------------------------------------------------------
    | Role
    |--------------------------------------------------------------------------
    */
    Route::middleware('role:admin')->group(function () {
        Route::get('/admin', fn() => 'Admin Only');
    });

    Route::middleware('role:staff')->group(function () {
        Route::get('/staff', fn() => 'Staff Only');
    });

    Route::middleware('role:manager')->group(function () {
        Route::get('/manager', fn() => 'Manager Only');
    });

    /*
    |--------------------------------------------------------------------------
    | Profile
    |--------------------------------------------------------------------------
    */
    Route::get('/profile', [ProfileController::class, 'edit'])
        ->name('profile.edit');

    Route::patch('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');

    Route::delete('/profile', [ProfileController::class, 'destroy'])
        ->name('profile.destroy');

    /*
    |--------------------------------------------------------------------------
    | Products
    |--------------------------------------------------------------------------
    */
    Route::resource('products', ProductController::class);

    /*
    |--------------------------------------------------------------------------
    | Categories
    |--------------------------------------------------------------------------
    */
    Route::resource('categories', CategoryController::class);

    /*
    |--------------------------------------------------------------------------
    | Borrowings
    |--------------------------------------------------------------------------
    */
    Route::resource('borrowings', BorrowingController::class);

    Route::post('/borrowings/{id}/approve', [BorrowingController::class, 'approve'])
        ->name('borrowings.approve');

    Route::post('/borrowings/{id}/reject', [BorrowingController::class, 'reject'])
        ->name('borrowings.reject');

    Route::post('/borrowings/{id}/return', [BorrowingController::class, 'returnItem'])
        ->name('borrowings.return');

    /*
    |--------------------------------------------------------------------------
    | Activity Logs
    |--------------------------------------------------------------------------
    */
    Route::get('/activity-logs', [ActivityLogController::class, 'index'])
        ->name('activity.logs');
});

require __DIR__.'/auth.php';