<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Borrowing;
use App\Models\User;

class DashboardController extends Controller
{
    public function index()
    {
    return view('dashboard', [
        'totalProducts' => Product::count(),
        'totalStock' => Product::sum('stock'),
        'totalBorrowed' => Borrowing::where('status', 'borrowed')->count(),
        'totalUsers' => User::count(),
    ]);
    }
}
