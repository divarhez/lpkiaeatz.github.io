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
  <main class="container mx-auto px-6 py-12 flex-grow max-w-4xl">
    <h1 class="text-4xl font-extrabold text-[#FF914D] mb-10 text-center drop-shadow">Keranjang Belanja</h1>
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
      <div class="overflow-x-auto rounded-2xl shadow-xl bg-white border border-[#FFD6A5]">
        <table class="min-w-full divide-y divide-[#FFD6A5]">
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
              <td class="py-3 px-6"><img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="w-16 h-16 rounded-xl object-cover"></td>
              <td class="py-3 px-6 font-semibold text-[#FF914D]">{{ $item['name'] }}</td>
              <td class="py-3 px-6 text-[#FF5E13] font-bold">Rp{{ number_format($item['price'],0,',','.') }}</td>
              <td class="py-3 px-6">
                <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center gap-2">
                  @csrf
                  <input type="number" name="quantity" value="{{ $item['quantity'] }}" min="1" class="w-16 border rounded px-2 py-1 text-center">
                  <button type="submit" class="bg-[#FF914D] hover:bg-[#FF5E13] text-white px-3 py-1 rounded">Update</button>
                </form>
              </td>
              <td class="py-3 px-6 text-[#FF5E13] font-bold">Rp{{ number_format($item['price'] * $item['quantity'],0,',','.') }}</td>
              <td class="py-3 px-6">
                <a href="{{ route('cart.remove', $id) }}" class="text-red-600 hover:underline font-bold">Hapus</a>
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
      </div>
      <div class="text-right mt-8">
        <button type="submit" class="bg-gradient-to-r from-[#FF914D] to-[#FF5E13] text-white font-bold px-10 py-3 rounded-full shadow-lg hover:scale-105 transition text-lg">Checkout</button>
      </div>
    </form>
    @else
      <p class="text-center text-gray-500">Keranjang belanja kosong.</p>
    @endif
  </main>
  <footer class="bg-white/90 border-t border-orange-200 text-orange-700 p-4 text-center mt-10 shadow-inner">
    &copy; 2025 <span class="font-bold">LPKIA Eatz</span>
  </footer>
  <script>feather.replace()</script>
</body>
</html>
