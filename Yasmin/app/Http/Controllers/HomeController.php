<?php
// app/Http/Controllers/HomeController.php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        $products = Product::with(['user', 'category'])
                    ->where('status', 'tersedia')
                    ->latest()
                    ->take(8)
                    ->get();
        
        return view('home', compact('categories', 'products'));
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
        $category = $request->input('category');
        
        $products = Product::with(['user', 'category'])
                    ->where('status', 'tersedia')
                    ->when($query, function($q) use ($query) {
                        return $q->where('name', 'like', "%{$query}%")
                                ->orWhere('description', 'like', "%{$query}%");
                    })
                    ->when($category, function($q) use ($category) {
                        return $q->where('category_id', $category);
                    })
                    ->paginate(12);
        
        $categories = Category::all();
        
        return view('products.index', compact('products', 'categories'));
    }
}