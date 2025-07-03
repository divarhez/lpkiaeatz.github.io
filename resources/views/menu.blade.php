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
  <section class="relative bg-gradient-to-br from-[#FFF6E9] via-[#FFF] to-[#FFE0B2] py-16 overflow-hidden">
    <div class="max-w-4xl mx-auto text-center px-6 relative z-10">
      <h1 class="text-5xl md:text-6xl font-extrabold text-[#FF914D] mb-4 drop-shadow-lg leading-tight">Temukan Kuliner Favoritmu di <span class="text-[#FF5E13]">LPKIA Eatz</span></h1>
      <p class="text-lg md:text-xl text-[#22223B] mb-8">Aneka makanan & minuman kampus, promo menarik, dan tenant pilihan. Pesan mudah, nikmati lezatnya!</p>
      <a href="#menu" class="inline-block bg-gradient-to-r from-[#FF914D] to-[#FF5E13] text-white font-bold rounded-full px-10 py-4 shadow-lg hover:scale-105 hover:from-[#FF5E13] hover:to-[#FF914D] transition-all duration-300 text-lg">Lihat Menu</a>
    </div>
  </section>
  <main class="max-w-6xl mx-auto px-6 py-12 flex-grow">

    @if (session('success'))
      <x-alert type="success">{{ session('success') }}</x-alert>
    @endif

    <form action="{{ route('menu.search') }}" method="GET" class="max-w-lg mx-auto mb-10">
      <div class="flex rounded-lg shadow overflow-hidden border border-[#FF914D]/30 bg-white mb-4">
        <input type="text" name="keyword" placeholder="Cari menu favoritmu..." value="{{ request('keyword') }}"
          class="w-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-[#FF914D] transition" />
        <button type="submit" class="bg-[#FF914D] hover:bg-[#FF5E13] text-white px-5 py-2 font-semibold transition">
          <i data-feather="search" class="w-5 h-5"></i>
        </button>
      </div>
      <div class="flex gap-3 justify-center mb-6">
        <select name="category" onchange="this.form.submit()" class="border rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#FF914D]">
          <option value="">Semua Kategori</option>
          @foreach($categories as $cat)
            <option value="{{ $cat }}" {{ request('category') == $cat ? 'selected' : '' }}>{{ $cat }}</option>
          @endforeach
        </select>
      </div>
    </form>

    <section id="menu" class="mb-16">
      <h2 class="text-4xl font-bold text-center text-[#FF914D] mb-10 drop-shadow">Menu Favorit</h2>
      @auth
        @if(auth()->user()->role === 'petugas')
          <div class="mb-6 text-right">
            <a href="{{ route('menu.create') }}" class="inline-block bg-[#FF914D] hover:bg-[#FF5E13] text-white font-bold px-6 py-2 rounded-full shadow transition">+ Tambah Menu</a>
          </div>
        @endif
      @endauth
      <div class="grid gap-10 grid-cols-1 sm:grid-cols-2 md:grid-cols-3">
        @foreach($menus as $menu)
        <article class="relative bg-white rounded-2xl shadow-xl hover:shadow-2xl hover:-translate-y-1 hover:scale-105 transition-all duration-300 p-6 flex flex-col border border-[#FFD6A5] group">
          @if(isset($menu->is_best_seller) && $menu->is_best_seller)
            <span class="absolute top-4 left-4 bg-yellow-400 text-white text-xs font-bold px-3 py-1 rounded-full shadow animate-bounce">Best Seller</span>
          @endif
          <img src="{{ $menu->image }}" alt="Gambar {{ $menu->name }}" loading="lazy" class="rounded-xl h-40 w-full object-cover mb-4 group-hover:scale-105 transition-transform duration-300" />
          <h3 class="text-lg font-bold text-[#FF914D] mb-1">{{ $menu->name }}</h3>
          <p class="text-gray-600 text-sm italic mb-3 line-clamp-3">{{ $menu->description }}</p>
          <div class="mt-auto flex items-center justify-between">
            <span class="text-base font-bold text-[#FF5E13] drop-shadow">Rp{{ number_format($menu->price, 0, ',', '.') }}</span>
            @if(isset($menu->promo) && $menu->promo)
              <span class="ml-2 bg-pink-500 text-white text-xs font-bold px-2 py-1 rounded-full animate-pulse">Promo</span>
            @endif
            <form action="{{ route('cart.add', $menu->id) }}" method="POST" class="add-to-cart-form shrink-0" aria-label="Tambah {{ $menu->name }} ke keranjang">
                @csrf
                <button type="submit" class="inline-flex items-center gap-2 bg-gradient-to-r from-[#FF914D] to-[#FF5E13] hover:from-[#FF5E13] hover:to-[#FF914D] text-white font-semibold rounded-full px-4 py-1.5 shadow transition-all duration-200">
                  <i data-feather="shopping-cart" class="w-4 h-4"></i> Tambah
                </button>
            </form>
          </div>
        </article>
        @endforeach
      </div>
    </section>

    <section id="tenant-list" class="mb-16">
      <h2 class="text-3xl font-bold text-center text-[#FF914D] mb-8 drop-shadow">Daftar Tenant</h2>
      <div class="grid gap-10 grid-cols-1 sm:grid-cols-2 md:grid-cols-3">
        @foreach($tenants ?? [] as $tenant)
        <a href="{{ route('tenant.show', $tenant->id) }}" class="block bg-white rounded-2xl shadow-xl p-6 border border-[#FFD6A5] hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">
          @if($tenant->logo)
            <img src="{{ asset('foto/' . $tenant->logo) }}" alt="Logo {{ $tenant->name }}" class="w-16 h-16 rounded-full mx-auto mb-3">
          @endif
          <h3 class="text-lg font-bold text-[#FF914D] text-center mb-1">{{ $tenant->name }}</h3>
          <p class="text-gray-600 text-center text-sm">{{ Str::limit($tenant->description, 60) }}</p>
        </a>
        @endforeach
      </div>
    </section>

    <section class="mb-10">
      <h2 class="text-3xl font-bold text-center text-[#FF914D] mb-8 drop-shadow">Promo & Event Kampus</h2>
      <div class="grid gap-8 grid-cols-1 md:grid-cols-2">
        <div class="bg-gradient-to-r from-[#FFE0B2] to-[#FFF6E9] rounded-2xl shadow-lg p-8 flex items-center gap-6 border border-[#FFD6A5]">
          <img src="https://img.freepik.com/free-vector/food-promotion-banner-template_23-2148986842.jpg?w=400" alt="Promo" class="w-28 h-28 rounded-xl object-cover">
          <div>
            <h3 class="text-xl font-bold text-[#FF914D] mb-1">Diskon 20% untuk Menu Spesial!</h3>
            <p class="text-gray-700 text-sm mb-1">Dapatkan diskon spesial untuk menu tertentu selama bulan ini. Jangan lewatkan!</p>
            <span class="inline-block bg-[#FF914D] text-white text-xs font-bold px-2 py-1 rounded-full mb-2">Berlaku s/d 31 Mei 2025</span>
            @auth
              <form action="#" method="POST" onsubmit="event.preventDefault(); alert('Promo berhasil digunakan! (simulasi)');">
                @csrf
                <button type="submit" class="mt-2 bg-gradient-to-r from-[#FF914D] to-[#FF5E13] hover:from-[#FF5E13] hover:to-[#FF914D] text-white font-bold px-6 py-2 rounded-full shadow transition">Gunakan Promo</button>
              </form>
            @else
              <a href="{{ route('login') }}" onclick="alert('Silakan login/daftar untuk menggunakan promo!')" class="mt-2 bg-gray-400 text-white font-bold px-6 py-2 rounded-full shadow cursor-not-allowed inline-block">Gunakan Promo</a>
            @endauth
          </div>
        </div>
        <div class="bg-gradient-to-r from-[#FFF6E9] to-[#FFE0B2] rounded-2xl shadow-lg p-8 flex items-center gap-6 border border-[#FFD6A5]">
          <img src="https://img.freepik.com/free-vector/food-delivery-concept-illustration_114360-2747.jpg?w=400" alt="Event" class="w-28 h-28 rounded-xl object-cover">
          <div>
            <h3 class="text-xl font-bold text-[#FF914D] mb-1">Event: Lomba Makan Cepat!</h3>
            <p class="text-gray-700 text-sm mb-1">Ikuti lomba makan cepat antar mahasiswa dan menangkan hadiah menarik!</p>
            <span class="inline-block bg-[#FF5E13] text-white text-xs font-bold px-2 py-1 rounded-full">Sabtu, 31 Mei 2025</span>
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
