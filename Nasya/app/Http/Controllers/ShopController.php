<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ShopController extends Controller
{
    public function index(Request $request)
{
    $categories = Category::all(); // Tambahkan baris ini
    $query = Product::with('categories');

    if ($request->has('category')) {
        $query->whereHas('categories', function($q) use ($request) {
            $q->where('slug', $request->category);
        });
    }

    $products = $query->get();

    // Pastikan 'categories' ikut dikirim ke view
    return view('shop.index', compact('products', 'categories'));
}
}
