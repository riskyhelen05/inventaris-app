<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Helpers\ActivityLogger;

class ProductController extends Controller
{
    public function index(Request $request)
{
    $query = Product::with('category');

    // Search
    if ($request->filled('search')) {
        $query->where(function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%')
              ->orWhere('kode_barang', 'like', '%' . $request->search . '%');
        });
    }

    // Filter kategori
    if ($request->filled('category')) {
        $query->where('category_id', $request->category);
    }

    // Filter kondisi
    if ($request->filled('condition')) {
        $query->where('condition', $request->condition);
    }

    $products = $query->latest()->paginate(10)->withQueryString();

    return view('products.index', [
        'products' => $products,
        'categories' => Category::all(),

        'totalBarang' => Product::count(),
        'stokTersedia' => Product::sum('stock'),
        'stokHabis' => Product::where('stock', 0)->count(),
        'totalKategori' => Category::count(),
    ]);
}

    public function create()
    {
        return view('products.create', [
            'categories' => Category::all()
        ]);
    }

public function store(Request $request)
{
    $validated = $request->validate([
        'kode_barang' => 'required|unique:products,kode_barang',
        'name' => 'required',
        'category_id' => 'required|exists:categories,id',
        'stock' => 'required|integer|min:0',
        'location' => 'required',
        'condition' => 'required',
        'image' => 'nullable|image|mimes:jpg,png|max:2048',
    ]);

    try {

        DB::transaction(function () use ($request, &$validated) {

            if ($request->hasFile('image')) {
                $validated['image'] = $request
                    ->file('image')
                    ->store('products', 'public');
            }

            $product = Product::create($validated);

            ActivityLogger::createProduct($product->name);

        });

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil ditambahkan');

    } catch (\Throwable $e) {

        return back()->with('error', $e->getMessage());

    }
}

    public function edit(Product $product)
    {
        return view('products.edit', [
            'product' => $product,
            'categories' => Category::all()
        ]);
    }

public function update(Request $request, Product $product)
{
    $validated = $request->validate([
        'kode_barang' => 'required|unique:products,kode_barang,' . $product->id,
        'name' => 'required',
        'category_id' => 'required|exists:categories,id',
        'stock' => 'required|integer|min:0',
        'location' => 'required',
        'condition' => 'required',
        'image' => 'nullable|image|mimes:jpg,png|max:2048',
    ]);

    try {

        DB::transaction(function () use ($request, $product, &$validated) {

            $oldName = $product->name;

            if ($request->hasFile('image')) {

                if ($product->image) {
                    Storage::disk('public')->delete($product->image);
                }

                $validated['image'] = $request
                    ->file('image')
                    ->store('products', 'public');
            }

            $product->update($validated);

            ActivityLogger::updateProduct(
                $oldName,
                $product->name
            );

        });

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil diperbarui');

    } catch (\Throwable $e) {

        return back()->with('error', $e->getMessage());

    }
}

public function destroy(Product $product)
{
    try {

        DB::transaction(function () use ($product) {

            ActivityLogger::deleteProduct($product->name);

            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }

            $product->delete();

        });

        return redirect()
            ->route('products.index')
            ->with('success', 'Produk berhasil dihapus');

    } catch (\Throwable $e) {

        return back()->with('error', $e->getMessage());

    }
}
}