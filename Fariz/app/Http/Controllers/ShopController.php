<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ShopController extends Controller
{
    public function index(Request $request)
{
    // Ambil semua kategori buat filter di sidebar/header
    $categories = Category::all();
    
    // Ambil produk, kalau ada filter kategori, saring datanya
    $query = Product::with('category');

    if ($request->has('category')) {
        $query->whereHas('category', function($q) use ($request) {
            $q->where('slug', $request->category);
        });
    }

    $products = $query->get();

    return view('shop.index', compact('products', 'categories'));
}
}
