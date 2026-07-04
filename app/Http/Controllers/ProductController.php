<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
    $query = Product::with('category');

    if ($request->search) {
        $query->where(function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%')
              ->orWhere('kode_barang', 'like', '%' . $request->search . '%');
        });
    }

    $products = $query->paginate(10)->withQueryString();

    return view('products.index', compact('products'));
    }

    public function create()
    {
    $categories = Category::all();
    return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
    $request->validate([
        'kode_barang' => 'required|unique:products',
        'name' => 'required',
        'category_id' => 'required',
        'stock' => 'required|integer',
        'location' => 'required',
        'condition' => 'required',
        'image' => 'nullable|image'
    ]);

    $data = $request->all();

    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')->store('products', 'public');
    }

    Product::create($data);

    return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(Product $product)
    {
    $categories = Category::all();
    return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
    $request->validate([
        'kode_barang' => 'required|unique:products,kode_barang,' . $product->id,
        'name' => 'required',
        'category_id' => 'required',
        'stock' => 'required|integer',
        'location' => 'required',
        'condition' => 'required',
        'image' => 'nullable|image'
    ]);

    $data = $request->all();

    if ($request->hasFile('image')) {
        $data['image'] = $request->file('image')->store('products', 'public');
    }

    $product->update($data);

    return redirect()->route('products.index')->with('success', 'Produk berhasil diupdate');
    }

    public function destroy(Product $product)
    {
    $product->delete();

    return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus');
    }
}
