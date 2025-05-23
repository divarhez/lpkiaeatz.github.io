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
  </style>
</head>
<body class="bg-gray-50 min-h-screen flex flex-col font-sans text-gray-800">

  <header class="bg-white shadow sticky top-0 z-50">
    <div class="container mx-auto flex justify-between items-center py-4 px-6">
      <a href="#" class="text-3xl font-bold text-blue-700 hover:text-blue-900 transition">LPKIA Eatz</a>
      <nav>
        <ul class="flex space-x-6 text-gray-700 font-medium">
          <li><a href="#" class="hover:text-blue-700 transition">Home</a></li>
          <li><a href="#menu" class="hover:text-blue-700 transition">Menu</a></li>
          <li><a href="#tenant" class="hover:text-blue-700 transition">Tenant</a></li>
          <li><a href="{{ route('cart.show') }}" class="hover:text-blue-700 transition">Keranjang</a></li>
        </ul>
      </nav>
    </div>
  </header>

  <section class="bg-white py-20">
    <div class="container mx-auto max-w-4xl text-center px-6">
      <h1 class="text-5xl font-extrabold text-gray-900 mb-4">Selamat Datang di LPKIA Eatz</h1>
      <p class="text-lg text-gray-600 mb-8">Nikmati hidangan berkualitas dengan mudah dan cepat</p>
      <a href="#menu" class="inline-block bg-blue-700 text-white font-semibold rounded-md px-8 py-3 hover:bg-blue-800 transition">
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
      <h2 class="text-4xl font-semibold text-center text-gray-900 mb-12">Menu Favorit Kami</h2>

      <div class="grid gap-10 grid-cols-1 sm:grid-cols-2 md:grid-cols-3">
        @foreach($menus as $menu)
        <article class="bg-white rounded-lg shadow hover:shadow-lg transition p-6 flex flex-col">
          <img src="{{ $menu->image }}" alt="{{ $menu->name }}" loading="lazy" class="rounded-lg h-48 w-full object-cover mb-6" />
          <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $menu->name }}</h3>
          <p class="text-gray-700 text-sm italic mb-4 line-clamp-3">{{ $menu->description }}</p>
          <div class="mt-auto flex items-center justify-between">
            <span class="text-lg font-semibold text-blue-700">Rp{{ number_format($menu->price, 0, ',', '.') }}</span>
            <form action="{{ route('cart.add', $menu->id) }}" method="POST" class="shrink-0">
              @csrf
              <button type="submit" class="inline-flex items-center gap-2 bg-blue-700 hover:bg-blue-800 text-white font-semibold rounded-md px-4 py-2 transition">
                <i data-feather="shopping-cart" class="w-4 h-4"></i> Tambah
              </button>
            </form>
          </div>
        </article>
        @endforeach
      </div>
    </section>

    {{-- Section Tenant --}}
    <section id="tenant" class="mb-20">
      <h2 class="text-4xl font-semibold text-center text-gray-900 mb-12">Daftar Tenant Kami</h2>

      <div class="grid gap-10 grid-cols-1 sm:grid-cols-2 md:grid-cols-3">
        {{-- Contoh tenant hardcoded. Kamu bisa ganti dengan data dinamis dari controller --}}
        @foreach($tenants as $tenant)
        <div class="bg-white rounded-lg shadow flex flex-col items-center text-center p-6">
          <img src="{{ $tenant->logo }}" alt="{{ $tenant->name }}" class="w-24 h-24 object-contain mb-4" loading="lazy" />
          <h3 class="text-xl font-semibold text-gray-900 mb-2">{{ $tenant->name }}</h3>
          <p class="text-gray-600 text-sm line-clamp-3">{{ $tenant->description }}</p>
        </div>
        @endforeach
      </div>
    </section>

  </main>

  <footer class="bg-gray-100 text-center py-6 text-gray-600 font-medium border-t border-gray-200">
    &copy; 2024 LPKIA Eatz. All Rights Reserved.
  </footer>

  <script>
    feather.replace()
  </script>

</body>
</html>
