<x-admin-layout>
    <x-slot:title>Detail Order #{{ $order->id }}</x-slot>

    <div class="mb-6">
        <a href="{{ route('admin.orders.index') }}" class="text-gray-400 hover:text-secondary mb-4 inline-block">
            <i class="fa-solid fa-arrow-left"></i> Kembali ke List Order
        </a>
        <h1 class="text-3xl font-bold text-accent">Detail Pesanan #{{ $order->id }}</h1>
        <p class="text-gray-500">Dipesan pada {{ $order->created_at->format('d F Y, H:i') }}</p>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
        
        <div class="lg:col-span-2 space-y-6">
            <div class="bg-[#2a2a2a] p-6 rounded-xl border border-secondary/20 shadow-xl">
                <h3 class="text-xl font-bold text-accent mb-4 border-b border-gray-700 pb-2">Item Dibeli</h3>
                @foreach($order->items as $item)
                    <div class="flex items-center gap-4 py-3 border-b border-gray-700 last:border-0">
                      <img src="{{ Str::startsWith($item->product->image, 'http') ? $item->product->image : asset('storage/' . $item->product->image) }}" 
     class="w-16 h-16 object-cover rounded border border-gray-600">
                        <div class="flex-1">
                            <h4 class="text-white font-bold">{{ $item->product->name }}</h4>
                            <p class="text-secondary text-sm">Rp {{ number_format($item->price, 0, ',', '.') }} x {{ $item->quantity }}</p>
                        </div>
                        <div class="text-white font-bold">
                            Rp {{ number_format($item->price * $item->quantity, 0, ',', '.') }}
                        </div>
                    </div>
                @endforeach
                <div class="flex justify-between mt-4 text-xl font-bold text-accent">
                    <span>Total Transaksi</span>
                    <span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
            </div>
        </div>

        <div class="space-y-6">
            
            <div class="bg-[#2a2a2a] p-6 rounded-xl border border-secondary/20 shadow-xl">
                <h3 class="text-lg font-bold text-accent mb-4"><i class="fa-solid fa-truck"></i> Info Pengiriman</h3>
                
                <div class="space-y-3 text-gray-300">
                    <div>
                        <label class="text-xs text-gray-500 uppercase">Penerima</label>
                        <p class="font-bold text-white">{{ $order->customer_name }}</p>
                    </div>
                    <div>
                        <label class="text-xs text-gray-500 uppercase">WhatsApp</label>
                        <p class="font-bold text-white flex items-center gap-2">
                            {{ $order->customer_phone }}
                            <a href="https://wa.me/{{ $order->customer_phone }}" target="_blank" class="text-green-500 hover:text-green-400"><i class="fa-brands fa-whatsapp"></i> Chat</a>
                        </p>
                    </div>
                    <div class="bg-[#333] p-3 rounded border border-gray-600">
                        <label class="text-xs text-gray-500 uppercase">Alamat Lengkap</label>
                        <p class="text-white mt-1">{{ $order->shipping_address }}</p>
                    </div>
                </div>
            </div>

            <div class="bg-[#2a2a2a] p-6 rounded-xl border border-secondary/20 shadow-xl">
                <h3 class="text-lg font-bold text-accent mb-4"><i class="fa-solid fa-list-check"></i> Update Status</h3>
                
                <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
                    @csrf
                    @method('PATCH')
                    
                    <label class="text-xs text-gray-500 uppercase">Ganti Status:</label>
                    <select name="status" class="w-full bg-[#333] text-white p-3 rounded border border-gray-600 mt-2 mb-4 focus:outline-none focus:border-secondary">
                        <option value="pending" {{ $order->status == 'pending' ? 'selected' : '' }}>Pending</option>
                        <option value="processed" {{ $order->status == 'processed' ? 'selected' : '' }}>Diproses (Sedang Dibuat)</option>
                        <option value="on_delivery" {{ $order->status == 'on_delivery' ? 'selected' : '' }}>Sedang Diantar Kurir</option>
                        <option value="delivered" {{ $order->status == 'delivered' ? 'selected' : '' }}>Sampai Tujuan</option>
                        <option value="completed" {{ $order->status == 'completed' ? 'selected' : '' }}>Selesai</option>
                        <option value="cancelled" {{ $order->status == 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>

                    <button type="submit" class="w-full bg-secondary text-white font-bold py-3 rounded hover:bg-secondary-dark transition shadow-lg">
                        Update Status
                    </button>
                </form>
            </div>

        </div>
    </div>
</x-admin-layout>