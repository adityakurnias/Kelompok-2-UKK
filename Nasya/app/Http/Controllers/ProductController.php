<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();
        $query = Product::with('categories')->latest();

        if ($request->has('category') && $request->category != '') {
            $query->whereHas('categories', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $products = $query->paginate(8);
        return view('products.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        $product->load('categories');
        return view('products.show', compact('product'));
    }

    public function create()
    {
        $categories = \App\Models\Category::all(); // Ambil semua dari database
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'required|image|max:2048',
            'categories' => 'nullable|array', // Harus 'categories' sesuai Blade
        ]);

        $product = new Product();
        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;

        if ($request->hasFile('image')) {
            $product->image = $request->file('image')->store('products', 'public');
        }

        $product->save();

        if ($request->has('categories')) {
            $product->categories()->attach($request->categories);
        }

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambah!');
    }

    public function edit(Product $product)
    {
        $categories = Category::all();
        // Pastikan file ada di resources/views/products/edit.blade.php
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'image' => 'nullable|image|max:2048',
            'categories' => 'nullable|array',
        ]);

        $product->name = $request->name;
        $product->description = $request->description;
        $product->price = $request->price;
        $product->stock = $request->stock;

        if ($request->hasFile('image')) {
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            $product->image = $request->file('image')->store('products', 'public');
        }

        $product->save();

        // Memperbaiki error "Incorrect integer value" (Gambar 5 & 7)
        // sync() akan menerima array ID dari checkbox di Blade
        $product->categories()->sync($request->categories ?? []);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    public function destroy(Product $product)
{
    // Hapus foto jika ada
    if ($product->image) {
        Storage::disk('public')->delete($product->image);
    }

    $product->delete();
    return redirect()->route('admin.products.index')->with('success', 'Produk berhasil dihapus!');
}
}
