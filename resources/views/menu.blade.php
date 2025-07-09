@extends('layouts.app')

@section('content')
  <section class="relative bg-gradient-to-br from-[#FFF6E9] via-[#FFF] to-[#FFE0B2] py-10 sm:py-20 overflow-hidden">
    <div class="max-w-4xl mx-auto text-center px-2 sm:px-6 relative z-10">
      <h1 class="text-3xl sm:text-5xl md:text-6xl font-extrabold text-[#FF914D] mb-4 sm:mb-6 drop-shadow-lg leading-tight">Temukan Kuliner Favoritmu di <span class="text-[#FF5E13]">LPKIA Eatz</span></h1>
      <p class="text-lg sm:text-xl md:text-2xl text-[#22223B] mb-6 sm:mb-10">Aneka makanan & minuman kampus, promo menarik, dan tenant pilihan. Pesan mudah, nikmati lezatnya!</p>
      <a href="/tenants" class="inline-block bg-gradient-to-r from-[#FF914D] to-[#FF5E13] text-white font-bold rounded-full px-8 sm:px-12 py-4 sm:py-5 shadow-lg hover:scale-105 hover:from-[#FF5E13] hover:to-[#FF914D] transition-all duration-300 text-lg sm:text-xl">Lihat Menu</a>
    </div>
  </section>
  <main class="max-w-6xl mx-auto px-2 sm:px-6 py-8 sm:py-16 flex-grow">

    @if (session('success'))
      <x-alert type="success">{{ session('success') }}</x-alert>
    @endif

    <form action="{{ route('menu.search') }}" method="GET" class="max-w-lg mx-auto mb-12">
      <div class="flex rounded-lg shadow overflow-hidden border border-[#FF914D]/30 bg-white mb-4">
        <input type="text" name="keyword" placeholder="Cari menu favoritmu..." value="{{ request('keyword') }}"
          class="w-full px-4 py-3 focus:outline-none focus:ring-2 focus:ring-[#FF914D] transition text-base" />
        <button type="submit" class="bg-[#FF914D] hover:bg-[#FF5E13] text-white px-6 py-3 font-semibold transition">
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

    <section id="menu-favorit" class="mb-14 sm:mb-20">
      <h2 class="text-2xl sm:text-4xl font-bold text-center text-[#FF914D] mb-8 sm:mb-12 drop-shadow">Menu Favorit</h2>
      <div class="grid gap-8 sm:gap-12 grid-cols-1 sm:grid-cols-2 md:grid-cols-3">
        @forelse($favoriteMenus as $menu)
          <x-menu-card :menu="$menu" />
        @empty
        <div class="col-span-3 text-center text-gray-500">Belum ada menu favorit.</div>
        @endforelse
      </div>
    </section>

    <section class="mb-12 sm:mb-16">
      <h2 class="text-xl sm:text-3xl font-bold text-center text-[#FF914D] mb-8 sm:mb-10 drop-shadow">Promo & Event Kampus</h2>
      <div class="grid gap-6 sm:gap-10 grid-cols-1 md:grid-cols-2">
        <div class="bg-gradient-to-r from-[#FFE0B2] to-[#FFF6E9] rounded-2xl shadow-lg p-6 sm:p-10 flex flex-col sm:flex-row items-center gap-6 border border-[#FFD6A5]">
          <img src="https://img.freepik.com/free-vector/food-promotion-banner-template_23-2148986842.jpg?w=400" alt="Promo" class="w-24 h-24 sm:w-32 sm:h-32 rounded-xl object-cover mb-2 sm:mb-0">
          <div>
            <h3 class="text-xl font-bold text-[#FF914D] mb-2">Diskon 20% untuk Menu Spesial!</h3>
            <p class="text-gray-700 text-base mb-2">Dapatkan diskon spesial untuk menu tertentu selama bulan ini. Jangan lewatkan!</p>
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
        <div class="bg-gradient-to-r from-[#FFF6E9] to-[#FFE0B2] rounded-2xl shadow-lg p-6 sm:p-10 flex flex-col sm:flex-row items-center gap-6 border border-[#FFD6A5]">
          <img src="https://img.freepik.com/free-vector/food-delivery-concept-illustration_114360-2747.jpg?w=400" alt="Event" class="w-24 h-24 sm:w-32 sm:h-32 rounded-xl object-cover mb-2 sm:mb-0">
          <div>
            <h3 class="text-xl font-bold text-[#FF914D] mb-2">Event: Lomba Makan Cepat!</h3>
            <p class="text-gray-700 text-base mb-2">Ikuti lomba makan cepat antar mahasiswa dan menangkan hadiah menarik!</p>
            <span class="inline-block bg-[#FF5E13] text-white text-xs font-bold px-2 py-1 rounded-full">Sabtu, 31 Mei 2025</span>
          </div>
        </div>
      </div>
    </section>

  </main>
@endsection
