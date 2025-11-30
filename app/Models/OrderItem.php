<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = ['order_id', 'product_id', 'quantity', 'price'];

    // Item terhubung ke produk (untuk ambil nama/gambar kue)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
    
    // Item milik order tertentu
    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}