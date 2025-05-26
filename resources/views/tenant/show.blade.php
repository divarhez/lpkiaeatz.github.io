@extends('layouts.app')

@section('content')
<div class="max-w-5xl mx-auto px-6 py-12 flex-grow">
    <div class="flex items-center mb-10">
        @if($tenant->logo)
            <img src="{{ asset('foto/' . $tenant->logo) }}" alt="Logo {{ $tenant->name }}" class="w-24 h-24 rounded-full mr-8 border-4 border-[#FFD6A5]">
        @endif
        <div>
            <h1 class="text-4xl font-extrabold text-[#FF914D] mb-2 drop-shadow">{{ $tenant->name }}</h1>
            <p class="text-gray-600 text-lg">{{ $tenant->description }}</p>
        </div>
    </div>
    <h2 class="text-2xl font-bold text-[#FF914D] mb-6">Menu di {{ $tenant->name }}</h2>
    <div class="grid gap-10 grid-cols-1 sm:grid-cols-2 md:grid-cols-3">
        @forelse($tenant->menus as $menu)
            <div class="bg-white rounded-2xl shadow-xl p-6 flex flex-col border border-[#FFD6A5]">
                <img src="{{ $menu->image }}" alt="{{ $menu->name }}" class="w-full h-40 object-cover rounded-xl mb-3">
                <h3 class="text-lg font-bold text-[#FF914D]">{{ $menu->name }}</h3>
                <p class="text-gray-600 mb-2">{{ $menu->description }}</p>
                <div class="mt-auto flex justify-between items-center">
                    <span class="text-lg font-semibold text-[#FF5E13]">Rp{{ number_format($menu->price,0,',','.') }}</span>
                    <form action="{{ route('cart.add', $menu->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-gradient-to-r from-[#FF914D] to-[#FF5E13] hover:from-[#FF5E13] hover:to-[#FF914D] text-white px-4 py-1.5 rounded-full font-semibold">Tambah</button>
                    </form>
                </div>
            </div>
        @empty
            <p class="col-span-3 text-center text-gray-500">Belum ada menu di tenant ini.</p>
        @endforelse
    </div>
</div>
@endsection
