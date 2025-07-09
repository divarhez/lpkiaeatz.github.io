{{-- Komponen Blade untuk card menu favorit --}}
<article class="relative bg-white rounded-2xl shadow-xl hover:shadow-2xl hover:-translate-y-1 hover:scale-105 transition-all duration-300 p-4 sm:p-6 flex flex-col border border-[#FFD6A5] group">
    <span class="absolute top-2 left-2 sm:top-4 sm:left-4 bg-yellow-400 text-white text-xs font-bold px-2 sm:px-3 py-1 rounded-full shadow animate-bounce">Best Seller</span>
    <img src="{{ asset('storage/' . $menu->image) }}" alt="Gambar {{ $menu->name }}" loading="lazy" class="rounded-xl h-28 sm:h-40 w-full object-cover mb-2 sm:mb-4 group-hover:scale-105 transition-transform duration-300" />
    <h3 class="text-base sm:text-lg font-bold text-[#FF914D] mb-1">{{ $menu->name }}</h3>
    <p class="text-gray-600 text-xs sm:text-sm italic mb-2 sm:mb-3 line-clamp-3">{{ $menu->description }}</p>
    <div class="mt-auto flex items-center justify-between">
        <span class="text-sm sm:text-base font-bold text-[#FF5E13] drop-shadow">Rp{{ number_format($menu->price, 0, ',', '.') }}</span>
        <span class="ml-2 bg-green-500 text-white text-xs font-bold px-2 py-1 rounded-full">Rating: {{ number_format($menu->avg_rating,1) }}</span>
    </div>
</article>
