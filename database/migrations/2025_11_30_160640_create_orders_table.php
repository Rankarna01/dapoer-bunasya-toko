<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
{
    Schema::create('orders', function (Blueprint $table) {
        $table->id();
        $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); // Bisa null jika guest (opsional) atau user terhapus
        
        // Informasi Pengiriman / Pelanggan
        $table->string('customer_name'); // Nama penerima (bisa beda dengan user akun)
        $table->string('customer_phone');
        $table->text('shipping_address');
        
        // Data Transaksi
        $table->decimal('total_price', 12, 2);
        $table->string('payment_method')->default('tunai'); // tunai, transfer, qris
        $table->string('payment_status')->default('pending'); // pending, paid, failed
        
        // Status Order
        // pending -> paid -> processed -> on_delivery -> delivered -> completed
        $table->string('status')->default('pending'); 
        
        // Tracking & Notes
        $table->string('tracking_number')->nullable(); // Resi atau kode unik
        $table->text('notes')->nullable(); // Catatan pembeli
        
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
