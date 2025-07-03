@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-12 max-w-4xl">
    <h2 class="text-3xl font-bold text-[#FF914D] mb-8 text-center">Dashboard Admin</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-10">
        <a href="{{ route('stok-makanan.index') }}" class="block bg-white rounded-xl shadow p-8 border border-[#FFD6A5] hover:shadow-amber-200 hover:-translate-y-2 hover:scale-105 transition-all duration-300 text-center">
            <div class="text-4xl mb-2">🍱</div>
            <div class="font-bold text-lg text-[#FF914D]">Manajemen Stok Makanan</div>
        </a>
        <a href="{{ route('orders.history', ['filter' => 'day']) }}" class="block bg-white rounded-xl shadow p-8 border border-[#FFD6A5] hover:shadow-amber-200 hover:-translate-y-2 hover:scale-105 transition-all duration-300 text-center">
            <div class="text-4xl mb-2">📊</div>
            <div class="font-bold text-lg text-[#FF914D]">Laporan Penjualan</div>
        </a>
        <a href="{{ route('tenant.index') }}" class="block bg-white rounded-xl shadow p-8 border border-[#FFD6A5] hover:shadow-amber-200 hover:-translate-y-2 hover:scale-105 transition-all duration-300 text-center">
            <div class="text-4xl mb-2">🏪</div>
            <div class="font-bold text-lg text-[#FF914D]">Manajemen Tenant</div>
        </a>
        <a href="{{ route('menu.index') }}" class="block bg-white rounded-xl shadow p-8 border border-[#FFD6A5] hover:shadow-amber-200 hover:-translate-y-2 hover:scale-105 transition-all duration-300 text-center">
            <div class="text-4xl mb-2">🍔</div>
            <div class="font-bold text-lg text-[#FF914D]">Manajemen Menu</div>
        </a>
    </div>
</div>
@endsection
