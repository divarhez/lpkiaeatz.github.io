<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - LPKIA Eatz</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <link rel="icon" href="/favicon.ico">
    <style>
      .line-clamp-2 {
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
      }
    </style>
</head>
<body class="bg-gradient-to-br from-orange-50 via-white to-amber-100 min-h-screen flex flex-col font-sans text-gray-800">
  <header class="bg-white/90 shadow sticky top-0 z-50 border-b border-orange-200">
    <div class="container mx-auto flex justify-between items-center py-4 px-6">
      <a href="/" class="text-3xl font-extrabold text-orange-600 tracking-wide hover:scale-105 transition-transform flex items-center gap-2">
        <img src="https://img.icons8.com/fluency/48/restaurant-table.png" class="w-10 h-10" alt="Logo" />
        LPKIA Eatz
      </a>
      <nav>
        <ul class="flex space-x-6 text-orange-700 font-semibold">
          <li><a href="/" class="hover:text-amber-500 transition">Home</a></li>
          <li><a href="/tenants" class="hover:text-amber-500 transition">Tenant</a></li>
          <li><a href="{{ route('menu.index') }}#menu" class="hover:text-amber-500 transition">Menu</a></li>
          <li><a href="#promo" class="hover:text-amber-500 transition">Promo</a></li>
          @auth
              <li><a href="{{ route('orders.history') }}" class="hover:text-amber-500 transition">Riwayat Pesanan</a></li>
          @endauth
        </ul>
      </nav>
    </div>
  </header>
  <main class="container mx-auto px-6 py-12 flex-grow max-w-4xl">
    <h1 class="text-4xl font-extrabold text-[#FF914D] mb-10 text-center drop-shadow">Keranjang Belanja</h1>
    @if(session('success'))
      <x-alert type="success">{{ session('success') }}</x-alert>
    @endif
    @if(session('error'))
      <x-alert type="error">{{ session('error') }}</x-alert>
    @endif
    @if(count($cart) > 0)
    <form action="{{ route('checkout') }}" method="POST" id="checkout-form">
      @csrf
      <div class="overflow-x-auto rounded-2xl shadow-xl bg-white border border-[#FFD6A5]">
        <table class="min-w-full divide-y divide-[#FFD6A5] text-xs sm:text-base">
          <thead>
            <tr>
              <th class="py-3 px-6 bg-[#FF914D] text-white font-bold rounded-tl-2xl">Gambar</th>
              <th class="py-3 px-6 bg-[#FF914D] text-white font-bold">Nama</th>
              <th class="py-3 px-6 bg-[#FF914D] text-white font-bold">Harga</th>
              <th class="py-3 px-6 bg-[#FF914D] text-white font-bold">Jumlah</th>
              <th class="py-3 px-6 bg-[#FF914D] text-white font-bold">Subtotal</th>
              <th class="py-3 px-6 bg-[#FF914D] text-white font-bold rounded-tr-2xl">Aksi</th>
            </tr>
          </thead>
          <tbody>
            @foreach($cart as $id => $item)
            <tr class="border-b border-[#FFD6A5]">
              <td class="py-3 px-6"><img src="{{ asset('storage/' . $item['image']) }}" alt="Gambar {{ $item['name'] }}" class="w-16 h-16 rounded-xl object-cover" loading="lazy"></td>
              <td class="py-3 px-6 font-semibold text-[#FF914D]">{{ $item['name'] }}</td>
              <td class="py-3 px-6 text-[#FF5E13] font-bold">Rp{{ number_format($item['price'],0,',','.') }}</td>
              <td class="py-3 px-6">
                <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center gap-2 update-cart-form" data-id="{{ $id }}">
                  @csrf
                  <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="w-12 sm:w-16 border rounded px-2 py-2 sm:py-1 text-center quantity-input text-base sm:text-lg" aria-label="Jumlah {{ $item['name'] }}">
                  <button type="submit" class="bg-[#FF914D] hover:bg-[#FF5E13] text-white px-3 py-1 rounded" aria-label="Update jumlah {{ $item['name'] }}">Update</button>
                </form>
              </td>
              <td class="py-3 px-6 text-[#FF5E13] font-bold">Rp{{ number_format($item['price'] * $item['quantity'],0,',','.') }}</td>
              <td class="py-3 px-6">
                <a href="{{ route('cart.remove', $id) }}" class="text-red-600 hover:underline font-bold" aria-label="Hapus {{ $item['name'] }} dari keranjang">Hapus</a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="mb-6">
        <label class="block text-[#FF914D] font-semibold mb-2">Metode Pembayaran</label>
        <select name="payment_method" id="payment_method" class="w-full px-4 py-2 border rounded-lg" required>
          <option value="cash">Cash (Tunai)</option>
          <option value="qris">QRIS</option>
        </select>
      </div>
      <div class="mb-6" id="qris-section" style="display:none;">
        <label class="block text-[#FF914D] font-semibold mb-2">Scan QRIS untuk pembayaran</label>
        <div class="flex flex-col items-center">
          <img src="{{ asset('storage/qris.png') }}" alt="QRIS" class="w-48 h-48 object-contain border rounded-lg shadow mb-2">
          <span class="text-xs text-gray-500">Silakan scan QR code di atas menggunakan aplikasi pembayaran Anda.</span>
        </div>
      </div>
      <div class="mb-6">
        <label class="block text-[#FF914D] font-semibold mb-2">Voucher</label>
        <select name="voucher_code" class="w-full px-4 py-2 border rounded-lg">
          <option value="">-- Pilih Voucher --</option>
          @if(isset($vouchers))
            @foreach($vouchers as $voucher)
              <option value="{{ $voucher->code }}">{{ $voucher->code }} - {{ $voucher->description }}
                @if($voucher->type == 'percent')
                  ({{ $voucher->discount }}%)
                @else
                  (Rp{{ number_format($voucher->discount,0,',','.') }})
                @endif
              </option>
            @endforeach
          @endif
        </select>
      </div>
      <div class="text-right mt-8">
        <x-button class="w-full text-base sm:text-lg py-3 sm:py-4" type="submit">Checkout</x-button>
      </div>
    </form>
    @else
      <p class="text-center text-gray-500">Keranjang belanja kosong.</p>
    @endif
  </main>
  <footer class="bg-white/90 border-t border-orange-200 text-orange-700 p-3 sm:p-4 text-center mt-6 sm:mt-10 shadow-inner">
    &copy; 2025 <span class="font-bold">LPKIA Eatz</span>
  </footer>
  <script>feather.replace()</script>
  <script>
document.addEventListener('DOMContentLoaded', function() {
  document.querySelectorAll('.update-cart-form').forEach(form => {
    form.addEventListener('submit', function(e) {
      e.preventDefault();
      const action = this.action;
      const formData = new FormData(this);
      fetch(action, {
        method: 'POST',
        headers: {
          'X-Requested-With': 'XMLHttpRequest',
          'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: formData
      })
      .then(res => res.json())
      .then(data => {
        if(data.success && data.cart) {
          // Update subtotal dan total di tabel
          const id = this.getAttribute('data-id');
          const row = this.closest('tr');
          row.querySelector('input[name="quantity"]').value = data.cart[id].quantity;
          row.querySelectorAll('td')[4].textContent = 'Rp' + (data.cart[id].price * data.cart[id].quantity).toLocaleString('id-ID');
          // Update total
          let total = 0;
          Object.values(data.cart).forEach(item => {
            total += item.price * item.quantity;
          });
          let totalCell = document.getElementById('cart-total');
          if (!totalCell) {
            totalCell = document.createElement('div');
            totalCell.id = 'cart-total';
            document.querySelector('.text-right.mt-8').appendChild(totalCell);
          }
          totalCell.innerHTML = '<span class="font-bold text-lg">Total: Rp' + total.toLocaleString('id-ID') + '</span>';
        }
      });
    });
  });
});
</script>
  <script>
        document.addEventListener('DOMContentLoaded', function() {
          const select = document.getElementById('payment_method');
          const qrisSection = document.getElementById('qris-section');
          if(select && qrisSection) {
            select.addEventListener('change', function() {
              if(this.value === 'qris') {
                qrisSection.style.display = '';
              } else {
                qrisSection.style.display = 'none';
              }
            });
            // Tampilkan jika reload dan qris sudah terpilih
            if(select.value === 'qris') qrisSection.style.display = '';
          }
        });
      </script>
</body>
</html>
