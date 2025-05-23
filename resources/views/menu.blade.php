<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>LPKIA Eatz</title>
  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="https://unpkg.com/feather-icons"></script>
  <style>
    .line-clamp-3 {
      display: -webkit-box;
      -webkit-line-clamp: 3;
      -webkit-box-orient: vertical;
      overflow: hidden;
    }
    /* Custom scrollbar */
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
<body class="bg-gradient-to-br from-blue-50 via-white to-blue-100 min-h-screen flex flex-col font-sans text-gray-800">

  <header class="bg-gradient-to-r from-blue-700 via-blue-600 to-blue-500 shadow-lg sticky top-0 z-50 transition-all duration-300">
    <div class="container mx-auto flex justify-between items-center py-4 px-6">
      <a href="#" class="text-3xl font-extrabold text-white drop-shadow-lg tracking-wide hover:scale-105 transition-transform">LPKIA Eatz</a>
      <nav>
        <ul class="flex space-x-6 text-white font-medium">
          <li><a href="#" class="hover:text-yellow-300 transition">Home</a></li>
          <li><a href="#menu" class="hover:text-yellow-300 transition">Menu</a></li>
          <li><a href="#tenant" class="hover:text-yellow-300 transition">Tenant</a></li>
          <li>
            <a href="{{ route('cart.show') }}" class="hover:text-yellow-300 transition flex items-center gap-1">
              <i data-feather="shopping-cart" class="w-5 h-5"></i> Keranjang
            </a>
          </li>
        </ul>
      </nav>
    </div>
  </header>

  <form action="{{ route('menu.search') }}" method="GET" class="max-w-lg mx-auto mb-8 mt-8">
    <div class="flex rounded-lg shadow overflow-hidden border border-blue-200 bg-white">
      <input type="text" name="keyword" placeholder="Cari menu favoritmu..." value="{{ request('keyword') }}"
        class="w-full px-4 py-2 focus:outline-none focus:ring-2 focus:ring-blue-400 transition" />
      <button type="submit" class="bg-blue-700 hover:bg-blue-800 text-white px-5 py-2 font-semibold transition">
        <i data-feather="search" class="w-5 h-5"></i>
      </button>
    </div>
  </form>

  <section class="relative bg-gradient-to-br from-blue-100 via-white to-blue-200 py-20 overflow-hidden">
    <div class="absolute -top-10 -left-10 w-72 h-72 bg-blue-200 rounded-full opacity-30 blur-2xl"></div>
    <div class="absolute -bottom-16 -right-16 w-96 h-96 bg-yellow-100 rounded-full opacity-40 blur-2xl"></div>
    <div class="container mx-auto max-w-4xl text-center px-6 relative z-10">
      <h1 class="text-5xl font-extrabold text-blue-800 mb-4 drop-shadow-lg">Selamat Datang di <span class="text-yellow-500">LPKIA Eatz</span></h1>
      <p class="text-lg text-gray-700 mb-8">Nikmati hidangan berkualitas dengan mudah dan cepat</p>
      <a href="#menu" class="inline-block bg-gradient-to-r from-yellow-400 to-yellow-500 text-blue-900 font-bold rounded-full px-10 py-4 shadow-lg hover:scale-105 hover:from-yellow-500 hover:to-yellow-400 transition-all duration-300">
        Jelajahi Menu Kami
      </a>
    </div>
  </section>

  <main class="container mx-auto px-6 py-16 flex-grow max-w-7xl">

    @if (session('success'))
      <div class="mb-8 max-w-3xl mx-auto text-center bg-green-100 border border-green-400 text-green-700 rounded-md px-6 py-4 shadow">
        {{ session('success') }}
      </div>
    @endif

    {{-- Section Menu --}}
    <section id="menu" class="mb-20">
      <h2 class="text-4xl font-bold text-center text-blue-800 mb-12 drop-shadow">Menu Favorit Kami</h2>

      <div class="grid gap-10 grid-cols-1 sm:grid-cols-2 md:grid-cols-3">
        @foreach($menus as $menu)
        <article class="relative bg-white rounded-2xl shadow-xl hover:shadow-2xl hover:-translate-y-1 transition-all duration-300 p-6 flex flex-col border border-blue-100 group">
          @if(isset($menu->is_best_seller) && $menu->is_best_seller)
            <span class="absolute top-4 left-4 bg-yellow-400 text-white text-xs font-bold px-3 py-1 rounded-full shadow">Best Seller</span>
          @endif
          <img src="{{ $menu->image }}" alt="{{ $menu->name }}" loading="lazy" class="rounded-xl h-48 w-full object-cover mb-6 group-hover:scale-105 transition-transform duration-300" />
          <h3 class="text-xl font-bold text-blue-900 mb-2">{{ $menu->name }}</h3>
          <p class="text-gray-700 text-sm italic mb-4 line-clamp-3">{{ $menu->description }}</p>
          <div class="mt-auto flex items-center justify-between">
            <span class="text-lg font-bold text-yellow-500 drop-shadow">Rp{{ number_format($menu->price, 0, ',', '.') }}</span>
            <form action="{{ route('cart.add', $menu->id) }}" method="POST" class="shrink-0">
              @csrf
              <button type="submit" class="inline-flex items-center gap-2 bg-gradient-to-r from-blue-700 to-blue-500 hover:from-blue-800 hover:to-blue-600 text-white font-semibold rounded-full px-5 py-2 shadow transition-all duration-200">
                <i data-feather="shopping-cart" class="w-4 h-4"></i> Tambah
              </button>
            </form>
          </div>
        </article>
        @endforeach
      </div>
    </section>

  </main>

  <footer class="bg-gradient-to-r from-blue-700 via-blue-600 to-blue-500 text-center py-8 text-white font-medium border-t border-blue-200 mt-10">
    <div class="flex justify-center gap-6 mb-2">
      <a href="#" class="hover:text-yellow-300 transition"><i data-feather="instagram"></i></a>
      <a href="#" class="hover:text-yellow-300 transition"><i data-feather="facebook"></i></a>
      <a href="#" class="hover:text-yellow-300 transition"><i data-feather="twitter"></i></a>
    </div>
    &copy; 2024 <span class="font-bold">LPKIA Eatz</span>. All Rights Reserved.
  </footer>

  <script>
    feather.replace()
  </script>

</body>
</html>
