<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Borrowing;

class SearchController extends Controller
{
    public function index(Request $request)
    {
        $request->validate([
            'q' => 'required|string|min:2|max:50'
        ]);

        $q = $request->q;
        $result = [];

        // PRODUCT
        $products = Product::where('name', 'like', "%{$q}%")
            ->select('id','name')
            ->limit(5)
            ->get();

        foreach ($products as $item) {
            $result[] = [
                'type' => 'Product',
                'title' => $item->name,
                'url' => route('products.show', $item->id)
            ];
        }

        // CATEGORY
        $categories = Category::where('name', 'like', "%{$q}%")
            ->select('id','name')
            ->limit(5)
            ->get();

        foreach ($categories as $item) {
            $result[] = [
                'type' => 'Category',
                'title' => $item->name,
                'url' => route('categories.index', ['category' => $item->id])
            ];
        }

        // BORROWING (FIX QUERY)
        $borrowings = Borrowing::whereHas('user', function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%");
            })
            ->with('user:id,name')
            ->limit(5)
            ->get();

        foreach ($borrowings as $item) {
            $result[] = [
                'type' => 'Borrowing',
                'title' => $item->user->name,
                'url' => route('borrowings.show', $item->id)
            ];
        }

        return response()->json([
            'count' => count($result),
            'data' => $result
        ]);
    }
}