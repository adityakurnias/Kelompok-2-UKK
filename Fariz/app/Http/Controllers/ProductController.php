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
        $query = Product::latest();

        if ($request->has('category') && $request->category != '') {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $products = $query->paginate(8);
        return view('products.index', compact('products', 'categories'));
    }

    public function create() 
    {
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    // FUNGSI SHOW (Wajib ada biar gak error Call to undefined method)
    public function show(Product $product) 
    {
        return view('products.show', compact('product'));
    }

    public function store(Request $request) 
{
    $validatedData = $request->validate([
        'name'        => 'required|string|max:255',
        'price'       => 'required|numeric|min:0',
        'stock'       => 'required|integer|min:0',
        'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    ]);

    // PAKSA BIKIN KATEGORI ID 1 DULU BIAR GAK ERROR LAGI
    \App\Models\Category::firstOrCreate(
        ['id' => 1], 
        ['name' => 'General', 'slug' => 'general']
    );

    $validatedData['category_id'] = 1;

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('products', 'public');
        $validatedData['image'] = $imagePath;
    }

    Product::create($validatedData);
    return redirect()->route('products.index')->with('success', 'Produk berhasil ditambah!');
}

    public function edit(Product $product) 
    {
        $categories = Category::all();
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product) 
    {
        $validatedData = $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'nullable|exists:categories,id', // Diubah jadi nullable
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
            'image'       => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($product->image) {
                Storage::disk('public')->delete($product->image);
            }
            $imagePath = $request->file('image')->store('products', 'public');
            $validatedData['image'] = $imagePath;
        }

        $product->update($validatedData);
        return redirect()->route('products.index')->with('success', 'Produk berhasil diupdate!');
    }

    public function destroy(Product $product) 
    {
        if ($product->image) {
            Storage::disk('public')->delete($product->image);
        }
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Produk dihapus!');
    }
}