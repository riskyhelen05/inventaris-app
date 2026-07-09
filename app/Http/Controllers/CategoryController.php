<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\ActivityLogger;

class CategoryController extends Controller
{
    public function __construct()
    {
        // hanya admin & staff
        $this->middleware('role:admin|staff');
    }

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

        // Filter jumlah produk (AMAN tanpa having)
        if ($request->filled('product_filter')) {

            if ($request->product_filter === 'empty') {
                $query->doesntHave('products');
            }

            if ($request->product_filter === 'used') {
                $query->has('products');
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
     * Form tambah
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Simpan
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
     * Update
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
     * Hapus
     */
    public function destroy(Category $category)
    {
        if ($category->products()->exists()) {
            return back()->with(
                'error',
                'Kategori tidak dapat dihapus karena masih digunakan.'
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