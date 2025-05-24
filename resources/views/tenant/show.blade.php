@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <div class="flex items-center mb-8">
        @if($tenant->logo)
            <img src="{{ asset('foto/' . $tenant->logo) }}" alt="Logo {{ $tenant->name }}" class="w-20 h-20 rounded-full mr-6">
        @endif
        <div>
            <h1 class="text-3xl font-bold text-orange-700 mb-1">{{ $tenant->name }}</h1>
            <p class="text-gray-600">{{ $tenant->description }}</p>
        </div>
    </div>
    <h2 class="text-2xl font-semibold text-orange-700 mb-4">Menu di {{ $tenant->name }}</h2>
    <div class="grid gap-8 grid-cols-1 sm:grid-cols-2 md:grid-cols-3">
        @forelse($tenant->menus as $menu)
            <div class="bg-white rounded-xl shadow-lg p-5 flex flex-col border border-orange-100">
                <img src="{{ $menu->image }}" alt="{{ $menu->name }}" class="w-full h-40 object-cover rounded mb-3">
                <h3 class="text-xl font-bold text-orange-800">{{ $menu->name }}</h3>
                <p class="text-gray-600 mb-2">{{ $menu->description }}</p>
                <div class="mt-auto flex justify-between items-center">
                    <span class="text-lg font-semibold text-amber-600">Rp{{ number_format($menu->price,0,',','.') }}</span>
                    <form action="{{ route('cart.add', $menu->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="bg-orange-600 hover:bg-orange-700 text-white px-4 py-1.5 rounded-full">Tambah</button>
                    </form>
                </div>
            </div>
        @empty
            <p class="col-span-3 text-center text-gray-500">Belum ada menu di tenant ini.</p>
        @endforelse
    </div>
</div>
@endsection
