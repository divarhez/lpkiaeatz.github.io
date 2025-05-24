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
        </ul>
      </nav>
    </div>
  </header>
  <main class="container mx-auto p-6 flex-grow">
    <h1 class="text-3xl font-extrabold text-orange-700 mb-8 text-center drop-shadow">Keranjang Belanja</h1>
    @if(session('success'))
      <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow mb-4 text-center" role="alert">
        {{ session('success') }}
      </div>
    @endif
    @if(session('error'))
      <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow mb-4 text-center" role="alert">
        {{ session('error') }}
      </div>
    @endif
    @if(count($cart) > 0)
    <form action="{{ route('checkout') }}" method="POST" id="checkout-form">
      @csrf
      <div class="overflow-x-auto rounded-xl shadow-lg bg-white border border-orange-100">
        <table class="min-w-full divide-y divide-orange-100">
          <thead>
            <tr>
              <th class="py-3 px-6 bg-orange-600 text-white font-bold rounded-tl-xl">Gambar</th>
              <th class="py-3 px-6 bg-orange-600 text-white font-bold">Nama</th>
              <th class="py-3 px-6 bg-orange-600 text-white font-bold">Harga</th>
              <th class="py-3 px-6 bg-orange-600 text-white font-bold">Jumlah</th>
              <th class="py-3 px-6 bg-orange-600 text-white font-bold">Subtotal</th>
              <th class="py-3 px-6 bg-orange-600 text-white font-bold rounded-tr-xl">Aksi</th>
            </tr>
          </thead>
          <tbody class="bg-white">
            @php $total = 0; @endphp
            @foreach($cart as $id => $item)
            @php $subtotal = $item['price'] * $item['quantity']; $total += $subtotal; @endphp
            <tr class="border-b border-orange-100 hover:bg-orange-50 transition">
              <td class="py-4 px-6">
                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="h-16 w-16 object-cover rounded-lg border border-orange-100 shadow" />
              </td>
              <td class="py-4 px-6 font-semibold text-orange-900 flex items-center gap-2">
                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 10h16M4 14h16M4 18h16" /></svg>
                {{ $item['name'] }}
              </td>
              <td class="py-4 px-6 text-orange-700 font-bold">Rp{{ number_format($item['price'],0,",",".") }}</td>
              <td class="py-4 px-6">
                <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center gap-2">
                  @csrf
                  <input type="number" name="quantity" min="1" value="{{ $item['quantity'] }}" class="w-16 border border-orange-200 rounded-lg py-1 px-2 text-center focus:ring-2 focus:ring-orange-400 transition" />
                  <button type="submit" class="bg-orange-600 hover:bg-orange-700 text-white px-3 py-1 rounded-lg font-semibold shadow transition">Update</button>
                </form>
              </td>
              <td class="py-4 px-6 text-orange-700 font-bold">Rp{{ number_format($subtotal,0,",",".") }}</td>
              <td class="py-4 px-6">
                <a href="{{ route('cart.remove', $id) }}" class="text-red-600 hover:text-red-800 font-bold text-2xl transition-transform hover:scale-125" title="Hapus">&#10005;</a>
              </td>
            </tr>
            @endforeach
            <tr>
              <td colspan="4" class="text-right font-bold py-4 px-6 bg-orange-50 text-orange-900 rounded-bl-xl">Total</td>
              <td colspan="2" class="font-bold py-4 px-6 bg-orange-50 text-orange-900 rounded-br-xl">Rp{{ number_format($total,0,",",".") }}</td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="mt-8 flex justify-end">
        <button type="submit" class="bg-gradient-to-r from-amber-400 to-orange-500 hover:from-orange-500 hover:to-amber-400 text-white font-bold px-8 py-3 rounded-full shadow-lg text-lg flex items-center gap-2 transition-all duration-200 hover:scale-105 focus:outline-none" id="checkout-btn">
          <span id="checkout-text">Checkout</span>
          <svg id="loading-spinner" class="hidden animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
          </svg>
        </button>
      </div>
    </form>
    <script>
      document.getElementById('checkout-form').addEventListener('submit', function() {
        document.getElementById('checkout-text').style.display = 'none';
        document.getElementById('loading-spinner').classList.remove('hidden');
      });
    </script>
    @else
    <div class="max-w-md mx-auto mt-16 bg-white rounded-2xl shadow-xl border border-orange-100 p-10 flex flex-col items-center">
      <svg class="w-20 h-20 text-orange-200 mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.35 2.7A2 2 0 007.48 19h8.04a2 2 0 001.83-1.3L17 13M7 13V6h10v7"></path>
      </svg>
      <p class="text-center text-gray-600 text-xl mb-2">Keranjang belanja masih kosong.</p>
      <a href="{{ route('menu.index') }}" class="mt-4 bg-orange-600 hover:bg-orange-700 text-white font-semibold px-6 py-2 rounded-lg shadow transition">Kembali ke Menu</a>
    </div>
    @endif
  </main>
  <footer class="bg-white/90 border-t border-orange-200 text-orange-700 p-4 text-center mt-10 shadow-inner">
    &copy; 2025 <span class="font-bold">LPKIA Eatz</span>
  </footer>
  <script>feather.replace()</script>
</body>
</html>
