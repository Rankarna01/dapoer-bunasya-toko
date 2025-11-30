<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class FrontController extends Controller
{
    public function index()
    {
        // Ambil 4 produk terbaru untuk ditampilkan di Home
        $products = Product::with('category')->latest()->take(4)->get();
        
        return view('front.home', compact('products'));
    }

    public function catalog(Request $request)
    {
        // Ambil data produk
        $query = Product::with('category');

        // 1. Logika Pencarian (Search)
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        // 2. Logika Filter Kategori
        if ($request->has('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        $products = $query->latest()->paginate(12); // Tampilkan 12 per halaman
        
        // Ambil semua kategori untuk menu filter
        $categories = \App\Models\Category::all();

        return view('front.catalog', compact('products', 'categories'));
    }
    
    public function detail(Product $product)
    {
        return view('front.detail', compact('product'));
    }
    
}