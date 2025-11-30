<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // Kita gunakan guarded kosong agar semua field bisa diisi (lebih praktis untuk transaksi)
    protected $guarded = ['id'];

    // Pesanan milik User (bisa null jika guest/dihapus)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Pesanan punya banyak item kue
    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}