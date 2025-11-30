<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // 1. LIST PRODUK (Admin)
    public function index()
    {
        $products = Product::with('category')->latest()->paginate(10);
        return view('admin.products.index', compact('products'));
    }

    // 2. FORM TAMBAH
    public function create()
    {
        $categories = Category::all();
        return view('admin.products.create', compact('categories'));
    }

    // 3. SIMPAN DATA (Store)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'category_id' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048', // Max 2MB
        ]);

        // Upload Gambar
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'category_id' => $request->category_id,
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    // 4. FORM EDIT
    public function edit(Product $product)
    {
        $categories = Category::all();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    // 5. UPDATE DATA
    public function update(Request $request, Product $product)
    {
        $request->validate([
            'name' => 'required',
            'price' => 'required|numeric',
            'stock' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $data = $request->all();
        $data['slug'] = Str::slug($request->name);

        // Cek jika ada upload gambar baru
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika bukan URL dummy
            if ($product->image && !Str::startsWith($product->image, 'http')) {
                Storage::disk('public')->delete($product->image);
            }
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    // 6. HAPUS DATA
    public function destroy(Product $product)
    {
        // Hapus gambar dari storage
        if ($product->image && !Str::startsWith($product->image, 'http')) {
            Storage::disk('public')->delete($product->image);
        }
        
        $product->delete();
        return redirect()->route('admin.products.index')->with('success', 'Produk dihapus!');
    }
}