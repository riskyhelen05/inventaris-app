<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\ActivityLogger;

class CategoryController extends Controller
{
    /**
     * Display kategori
     */
    public function index(Request $request)
    {
        $query = Category::withCount('products');

        // Search
        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // Filter jumlah produk
        if ($request->filled('product_filter')) {

            switch ($request->product_filter) {

                case 'empty':
                    $query->having('products_count', '=', 0);
                    break;

                case 'used':
                    $query->having('products_count', '>', 0);
                    break;
            }
        }

        // Sorting
        switch ($request->sort) {

            case 'az':
                $query->orderBy('name');
                break;

            case 'za':
                $query->orderByDesc('name');
                break;

            case 'oldest':
                $query->oldest();
                break;

            default:
                $query->latest();
                break;
        }

        $categories = $query
            ->paginate(10)
            ->withQueryString();

        return view('categories.index', compact('categories'));
    }

    /**
     * Form tambah kategori
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Simpan kategori
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:100|unique:categories,name'
        ]);

DB::transaction(function () use ($validated) {

    $category = Category::create($validated);

        ActivityLogger::createCategory($category->name);

});

        return redirect()
            ->route('categories.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Form edit
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update kategori
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'required|max:100|unique:categories,name,' . $category->id,
        ]);

DB::transaction(function () use ($validated, $category) {

    $oldName = $category->name;

$category->update($validated);

ActivityLogger::updateCategory($oldName, $category->name);

});

        return redirect()
            ->route('categories.index')
            ->with('success', 'Kategori berhasil diperbarui.');
    }

    /**
     * Hapus kategori
     */
    public function destroy(Category $category)
    {
        if ($category->products()->count() > 0) {
            return back()->with(
                'error',
                'Kategori tidak dapat dihapus karena masih digunakan oleh produk.'
            );
        }

DB::transaction(function () use ($category) {

    ActivityLogger::deleteCategory($category->name);

$category->delete();

});

        return redirect()
            ->route('categories.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}