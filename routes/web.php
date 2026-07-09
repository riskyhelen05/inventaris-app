<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\BorrowingController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ActivityLogController;
use App\Http\Controllers\ReportController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {

    /*
    |--------------------------------------------------------------------------
    | Dashboard (Semua Role)
    |--------------------------------------------------------------------------
    */

    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/search', [DashboardController::class, 'search'])
        ->name('search');

    Route::get('/notifications', [DashboardController::class, 'notifications'])
        ->name('notifications');


    /*
    |--------------------------------------------------------------------------
    | Profile (Semua Role)
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
    | Admin Only
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:admin')->group(function () {

        Route::get('/activity-logs', [ActivityLogController::class, 'index'])
            ->name('activity.logs');

        Route::get('/activity', [ActivityLogController::class, 'index'])
            ->name('activity.index');
    });


    /*
    |--------------------------------------------------------------------------
    | Admin & Manager (Laporan)
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:admin|manager')->group(function () {

        Route::get('/reports', [ReportController::class, 'index'])
            ->name('reports.index');

        Route::get('/reports/pdf', [ReportController::class, 'exportPdf'])
            ->name('reports.pdf');

        Route::get('/reports/excel', [ReportController::class, 'exportExcel'])
            ->name('reports.excel');
    });


    /*
    |--------------------------------------------------------------------------
    | Admin & Staff (Master Data)
    |--------------------------------------------------------------------------
    */

    Route::middleware('role:admin|staff')->group(function () {

        Route::resource('categories', CategoryController::class);
    });

 /*
    |--------------------------------------------------------------------------
    | BORROWINGS
    |--------------------------------------------------------------------------
    */

    // ✅ HANYA USER bisa create
    Route::middleware('role:user')->group(function () {

        Route::get('/borrowings/create', [BorrowingController::class, 'create'])
            ->name('borrowings.create');

        Route::post('/borrowings', [BorrowingController::class, 'store'])
            ->name('borrowings.store');
    });

    // ✅ SEMUA ROLE bisa lihat
    Route::middleware('role:admin|staff|manager|user')->group(function () {

        Route::get('/borrowings', [BorrowingController::class, 'index'])
            ->name('borrowings.index');

        Route::get('/borrowings/{borrowing}', [BorrowingController::class, 'show'])
            ->name('borrowings.show');
    });

    // ✅ ADMIN & STAFF (approve dll)
    Route::middleware('role:admin|staff')->group(function () {

        Route::post('/borrowings/{id}/approve', [BorrowingController::class, 'approve'])
            ->name('borrowings.approve');

        Route::post('/borrowings/{id}/reject', [BorrowingController::class, 'reject'])
            ->name('borrowings.reject');

        Route::post('/borrowings/{id}/return', [BorrowingController::class, 'returnItem'])
            ->name('borrowings.return');
    });

Route::middleware('auth')->group(function () {

    // Semua role bisa lihat
    Route::get('/products', [ProductController::class, 'index'])
        ->name('products.index');

    Route::get('/products/{product}', [ProductController::class, 'show'])
        ->name('products.show');

    // Hanya admin & staff bisa kelola
    Route::middleware('role:admin|staff')->group(function () {

        Route::get('/products/create', [ProductController::class, 'create'])
            ->name('products.create');

        Route::post('/products', [ProductController::class, 'store'])
            ->name('products.store');

        Route::get('/products/{product}/edit', [ProductController::class, 'edit'])
            ->name('products.edit');

        Route::put('/products/{product}', [ProductController::class, 'update'])
            ->name('products.update');

        Route::delete('/products/{product}', [ProductController::class, 'destroy'])
            ->name('products.destroy');

        Route::get('/products/{product}/print-qr', [ProductController::class, 'printQr'])
            ->name('products.printQr');
    });

});
});

require __DIR__ . '/auth.php';