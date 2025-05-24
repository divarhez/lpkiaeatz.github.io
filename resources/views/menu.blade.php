<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>LPKIA Eatz</title>
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/feather-icons"></script>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"/>
  <style>
    .line-clamp-3 {
      display: -webkit-box;
      -webkit-line-clamp: 3;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }
    ::-webkit-scrollbar {
      width: 8px;
      background: #f1f1f1;
    }
    ::-webkit-scrollbar-thumb {
      background: #cbd5e1;
      border-radius: 8px;
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
          <li><a href="#menu" class="hover:text-amber-500 transition">Menu</a></li>
          <li><a href="#promo" class="hover:text-amber-500 transition">Promo</a></li>
          <li>
            <a href="{{ route('cart.show') }}" class="hover:text-amber-500 transition flex items-center gap-1">
              <i data-feather="shopping-cart" class="w-5 h-5"></i> Keranjang
            </a>
          </li>
          @auth
            <li>
              <form action="{{ route('logout') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="hover:text-red-500 transition">Logout</button>
              </form>
            </li>
          @else
            <li>
              <a href="{{ route('login') }}" class="hover:text-blue-500 transition">Login</a>
            </li>
          @endauth
        </ul>
      </nav>
    </div>
  </header>
  <section class="relative bg-gradient-to-br from-orange-50 via-white to-amber-100 py-16 overflow-hidden">
    <div class="container mx-auto max-w-3xl text-center px-6 relative z-10">
      <h1 class="text-5xl font-extrabold text-orange-700 mb-3 drop-shadow-lg">Temukan Kuliner Favoritmu di <span class="text-amber-500">LPKIA Eatz</span></h1>
      <p class="text-lg text-gray-700 mb-6">Aneka makanan & minuman kampus, promo menarik, dan tenant pilihan. Pesan mudah, nikmati lezatnya!</p>
      <a href="#menu" class="inline-block bg-gradient-to-r from-amber-500 to-orange-400 text-white font-bold rounded-full px-8 py-3 shadow-lg hover:scale-105 hover:from-orange-500 hover:to-amber-400 transition-all duration-300">
        Lihat Menu
      </a>
    </div>
  </section>

  <main class="container mx-auto px-6 py-12 flex-grow max-w-5xl">

    @if (session('success'))
      <div class="mb-8 max-w-2xl mx-auto text-center bg-green-100 border border-green-400 text-green-700 rounded-md px-6 py-4 shadow">
        {{ session('success') }}
      </div>
    @endif

    <form action="{{ route('menu.search') }}" method="GET" class="max-w-lg mx-auto mb-10">
      <div class="flex rounded-lg shadow overflow-hidden border border-blue-200 bg-white">
        <input type="text" name="keyword" placeholder="Cari menu favoritmu..." value="{{ request('keyword') }}"
          class="w-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 transition" />
        <button type="submit" class="bg-blue-700 hover:bg-blue-800 text-white px-5 py-2 font-semibold transition">
          <i data-feather="search" class="w-5 h-5"></i>
        </button>
      </div>
    </form>

    <section id="menu" class="mb-10">
      <h2 class="text-3xl font-bold text-center text-orange-800 mb-8 drop-shadow">Menu Favorit</h2>
      <div class="grid gap-8 grid-cols-1 sm:grid-cols-2 md:grid-cols-3">
        @foreach($menus as $menu)
        <article class="relative bg-white rounded-xl shadow-lg hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 p-5 flex flex-col border border-orange-100 group">
          @if(isset($menu->is_best_seller) && $menu->is_best_seller)
            <span class="absolute top-4 left-4 bg-yellow-400 text-white text-xs font-bold px-3 py-1 rounded-full shadow animate-bounce">Best Seller</span>
          @endif
          <img src="{{ $menu->image }}" alt="{{ $menu->name }}" loading="lazy" class="rounded-lg h-40 w-full object-cover mb-4 group-hover:scale-105 transition-transform duration-300" />
          <h3 class="text-lg font-bold text-orange-900 mb-1">{{ $menu->name }}</h3>
          <p class="text-gray-600 text-sm italic mb-3 line-clamp-3">{{ $menu->description }}</p>
          <div class="mt-auto flex items-center justify-between">
            <span class="text-base font-bold text-amber-500 drop-shadow">Rp{{ number_format($menu->price, 0, ',', '.') }}</span>
            @if(isset($menu->promo) && $menu->promo)
              <span class="ml-2 bg-pink-500 text-white text-xs font-bold px-2 py-1 rounded-full animate-pulse">Promo</span>
            @endif
            <form action="{{ route('cart.add', $menu->id) }}" method="POST" class="shrink-0">
                @csrf
                <button type="submit" class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-700 to-blue-500 hover:from-blue-800 hover:to-blue-600 text-white font-semibold rounded-full px-4 py-1.5 shadow transition-all duration-200">
                  <i data-feather="shopping-cart" class="w-4 h-4"></i> Tambah
                </button>
            </form>
          </div>
        </article>
        @endforeach
      </div>
    </section>

    <section id="tenant-list" class="mb-10">
      <h2 class="text-2xl font-bold text-center text-orange-700 mb-6 drop-shadow">Daftar Tenant</h2>
      <div class="grid gap-8 grid-cols-1 sm:grid-cols-2 md:grid-cols-3">
        <a href="{{ route('tenant.show', 1) }}" class="block bg-white rounded-xl shadow-lg p-6 border border-orange-100 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">
          <img src="https://img.icons8.com/color/96/000000/food-bar.png" alt="Warung Si Ibi" class="w-16 h-16 rounded-full mx-auto mb-3">
          <h3 class="text-lg font-bold text-orange-700 text-center mb-1">Warung Si Ibi</h3>
          <p class="text-gray-600 text-center text-sm">Aneka makanan rumahan & minuman segar</p>
        </a>
        <a href="{{ route('tenant.show', 2) }}" class="block bg-white rounded-xl shadow-lg p-6 border border-orange-100 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">
          <img src="https://img.icons8.com/color/96/000000/chocolate-bar.png" alt="Coklat Belgia" class="w-16 h-16 rounded-full mx-auto mb-3">
          <h3 class="text-lg font-bold text-orange-700 text-center mb-1">Coklat Belgia</h3>
          <p class="text-gray-600 text-center text-sm">Coklat premium, dessert, dan minuman coklat</p>
        </a>
        <a href="{{ route('tenant.show', 3) }}" class="block bg-white rounded-xl shadow-lg p-6 border border-orange-100 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">
          <img src="https://img.icons8.com/color/96/000000/fried-rice.png" alt="Nasgor Mas Jawa" class="w-16 h-16 rounded-full mx-auto mb-3">
          <h3 class="text-lg font-bold text-orange-700 text-center mb-1">Nasgor Mas Jawa</h3>
          <p class="text-gray-600 text-center text-sm">Nasi goreng khas Jawa, mie goreng, dan lauk</p>
        </a>
      </div>
    </section>

    <section class="mb-10">
      <h2 class="text-2xl font-bold text-center text-orange-700 mb-6 drop-shadow">Promo & Event Kampus</h2>
      <div class="grid gap-6 grid-cols-1 md:grid-cols-2">
        <div class="bg-gradient-to-r from-amber-100 to-orange-50 rounded-xl shadow-lg p-6 flex items-center gap-4 border border-amber-200">
          <img src="https://img.freepik.com/free-vector/food-promotion-banner-template_23-2148986842.jpg?w=400" alt="Promo" class="w-24 h-24 rounded-lg object-cover">
          <div>
            <h3 class="text-lg font-bold text-amber-700 mb-1">Diskon 20% untuk Menu Spesial!</h3>
            <p class="text-gray-700 text-sm mb-1">Dapatkan diskon spesial untuk menu tertentu selama bulan ini. Jangan lewatkan!</p>
            <span class="inline-block bg-orange-500 text-white text-xs font-bold px-2 py-1 rounded-full">Berlaku s/d 31 Mei 2025</span>
          </div>
        </div>
        <div class="bg-gradient-to-r from-orange-50 to-amber-100 rounded-xl shadow-lg p-6 flex items-center gap-4 border border-orange-100">
          <img src="https://img.freepik.com/free-vector/food-delivery-concept-illustration_114360-2747.jpg?w=400" alt="Event" class="w-24 h-24 rounded-lg object-cover">
          <div>
            <h3 class="text-lg font-bold text-orange-700 mb-1">Event: Lomba Makan Cepat!</h3>
            <p class="text-gray-700 text-sm mb-1">Ikuti lomba makan cepat antar mahasiswa dan menangkan hadiah menarik!</p>
            <span class="inline-block bg-orange-700 text-white text-xs font-bold px-2 py-1 rounded-full">Sabtu, 31 Mei 2025</span>
          </div>
        </div>
      </div>
    </section>
  </main>

  <footer class="bg-white/90 border-t border-orange-200 text-orange-700 p-4 text-center mt-10 shadow-inner">
    &copy; {{ date('Y') }} <span class="font-bold">LPKIA Eatz</span>. All Rights Reserved.
  </footer>

  <script>
    feather.replace()
  </script>
</body>
</html>
