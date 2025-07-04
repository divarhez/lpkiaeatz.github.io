@extends('layouts.app')

@section('content')
<div class="container mx-auto px-2 sm:px-6 py-6 sm:py-12 max-w-full sm:max-w-4xl">
    <h2 class="text-2xl sm:text-3xl font-bold text-[#FF914D] mb-4 sm:mb-8 text-center">Dashboard Admin</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-8 mb-6 sm:mb-10">
        <a href="{{ route('orders.history', ['filter' => 'day']) }}" class="block bg-white rounded-xl shadow p-4 sm:p-8 border border-[#FFD6A5] hover:shadow-amber-200 hover:-translate-y-2 hover:scale-105 transition-all duration-300 text-center">
            <div class="text-3xl sm:text-4xl mb-1 sm:mb-2">📊</div>
            <div class="font-bold text-base sm:text-lg text-[#FF914D]">Laporan Penjualan</div>
        </a>
        <a href="{{ route('tenant.index') }}" class="block bg-white rounded-xl shadow p-4 sm:p-8 border border-[#FFD6A5] hover:shadow-amber-200 hover:-translate-y-2 hover:scale-105 transition-all duration-300 text-center">
            <div class="text-3xl sm:text-4xl mb-1 sm:mb-2">🏪</div>
            <div class="font-bold text-base sm:text-lg text-[#FF914D]">Manajemen Tenant</div>
        </a>
        <a href="{{ route('admin.menu.management') }}" class="block bg-white rounded-xl shadow p-4 sm:p-8 border border-[#FFD6A5] hover:shadow-amber-200 hover:-translate-y-2 hover:scale-105 transition-all duration-300 text-center">
            <div class="text-3xl sm:text-4xl mb-1 sm:mb-2">🍔</div>
            <div class="font-bold text-base sm:text-lg text-[#FF914D]">Manajemen Menu</div>
        </a>
    </div>
</div>
@endsection
