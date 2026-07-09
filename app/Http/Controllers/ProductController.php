<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Helpers\ActivityLogger;
use Barryvdh\DomPDF\Facade\Pdf;
use Endroid\QrCode\Builder\Builder;
use Endroid\QrCode\Writer\PngWriter;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

        // optional: kalau pakai policy
        // $this->authorizeResource(Product::class, 'product');
    }

    public function index(Request $request)
    {
        $query = Product::with('category');

        if ($request->filled('search')) {
    $search = $request->search;

    $query->where(function ($q) use ($search) {
        $q->where('name', 'like', "%{$search}%")
          ->orWhere('kode_barang', 'like', "%{$search}%")
          ->orWhereHas('category', function ($q2) use ($search) {
              $q2->where('name', 'like', "%{$search}%");
          });
    });
}

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('condition')) {
            $query->where('condition', $request->condition);
        }

        if ($request->stock) {
            if ($request->stock == 'available') {
                $query->where('stock', '>', 10);
            } elseif ($request->stock == 'low') {
                $query->whereBetween('stock', [1, 10]);
            } elseif ($request->stock == 'out') {
                $query->where('stock', 0);
            }
        }

        $products = $query->latest()->paginate(10)->withQueryString();

        return view('products.index', [
            'products' => $products,
            'categories' => Category::select('id','name')->get(),
        ]);
    }

    public function create()
    {
        return view('products.create', [
            'categories' => Category::select('id','name')->get()
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

            // upload dulu (di luar transaction)
            if ($request->hasFile('image')) {
                $validated['image'] = $request->file('image')->store('products', 'public');
            }

            DB::transaction(function () use (&$validated) {

                $product = Product::create($validated);

                ActivityLogger::createProduct($product->name);
            });

            return redirect()->route('products.index')->with('success', 'Produk berhasil ditambahkan');

        } catch (\Throwable $e) {

            // 🧹 rollback file kalau gagal
            if (!empty($validated['image'])) {
                Storage::disk('public')->delete($validated['image']);
            }

            return back()->with('error', $e->getMessage());
        }
    }

    public function edit(Product $product)
    {
        return view('products.edit', [
            'product' => $product,
            'categories' => Category::select('id','name')->get()
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

            $newImage = null;

            if ($request->hasFile('image')) {
                $newImage = $request->file('image')->store('products', 'public');
            }

            DB::transaction(function () use ($product, $validated, $newImage) {

                $old = $product->toArray();

                if ($newImage) {
                    if ($product->image) {
                        Storage::disk('public')->delete($product->image);
                    }
                    $validated['image'] = $newImage;
                }

                $product->update($validated);

                $new = $product->fresh()->toArray();

                ActivityLogger::log(
                    'update_product',
                    'Update produk: ' . $product->name,
                    [
                        'old_data' => $old,
                        'new_data' => $new,
                    ]
                );
            });

            return redirect()->route('products.index')->with('success', 'Produk berhasil diperbarui');

        } catch (\Throwable $e) {

            if ($newImage) {
                Storage::disk('public')->delete($newImage);
            }

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

            return redirect()->route('products.index')->with('success', 'Produk berhasil dihapus');

        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function show(Product $product)
    {
        $product->load('category'); // siap relasi
        return view('products.show', compact('product'));
    }

    public function printQr(Product $product)
    {
        $url = route('products.show', $product);

        $result = Builder::create()
            ->writer(new PngWriter())
            ->data($url)
            ->size(300)
            ->margin(10)
            ->build();

        $qr = base64_encode($result->getString());

        $pdf = Pdf::loadView('products.qr-pdf', [
            'product' => $product,
            'qr' => $qr,
            'url' => $url
        ]);

        return $pdf->download('QR-'.$product->kode_barang.'.pdf');
    }
}