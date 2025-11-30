<x-layout>
    <x-slot:title>Pembayaran - Dapoer Bunasya</x-slot>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>

    <div class="max-w-2xl mx-auto py-12 text-center">
        <div class="bg-[#2a2a2a] p-8 rounded-2xl border border-secondary/20 shadow-2xl">
            <div class="w-20 h-20 bg-secondary/20 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fa-regular fa-credit-card text-4xl text-secondary"></i>
            </div>
            
            <h1 class="text-3xl font-bold text-accent mb-2">Konfirmasi Pembayaran</h1>
            <p class="text-gray-400 mb-8">Order ID: #{{ $order->id }} | Total: Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>

            <button id="pay-button" class="bg-secondary text-white px-8 py-4 rounded-full font-bold text-lg hover:bg-secondary-dark transition shadow-[0_0_20px_rgba(141,110,99,0.5)] animate-pulse">
                BAYAR SEKARANG
            </button>
            
            <p class="text-xs text-gray-500 mt-6">Popup pembayaran aman by Midtrans akan muncul.</p>
        </div>
    </div>

    <script type="text/javascript">
        var payButton = document.getElementById('pay-button');
        payButton.addEventListener('click', function () {
            // Trigger snap popup. @TODO: Replace TRANSACTION_TOKEN_HERE with your transaction token
            window.snap.pay('{{ $snapToken }}', {
                onSuccess: function(result){
                    /* Anda bisa redirect ke halaman sukses */
                    alert("Pembayaran Berhasil!");
                    window.location.href = "/pesanan-saya"; 
                },
                onPending: function(result){
                    /* Menunggu pembayaran */
                    alert("Menunggu Pembayaran!");
                    window.location.href = "/pesanan-saya";
                },
                onError: function(result){
                    /* Pembayaran gagal */
                    alert("Pembayaran Gagal!");
                },
                onClose: function(){
                    /* User menutup popup tanpa bayar */
                    alert('Anda menutup popup sebelum menyelesaikan pembayaran');
                }
            })
        });
    </script>
</x-layout>