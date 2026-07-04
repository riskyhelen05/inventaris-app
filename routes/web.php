<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BorrowingController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {

    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // ROLE BASED ACCESS
    Route::middleware(['role:admin'])->group(function () {
        Route::get('/admin', function () {
            return "Admin Only";
        });
    });

    Route::middleware(['role:staff'])->group(function () {
        Route::get('/staff', function () {
            return "Staff Only";
        });
    });

    Route::middleware(['role:manager'])->group(function () {
        Route::get('/manager', function () {
            return "Manager Only";
        });
    });

    // PROFILE
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::resource('products', ProductController::class);
    
    Route::post('/borrow', [BorrowingController::class, 'store'])->name('borrow.store');
    Route::post('/return/{id}', [BorrowingController::class, 'return'])->name('borrow.return');
});

require __DIR__.'/auth.php';