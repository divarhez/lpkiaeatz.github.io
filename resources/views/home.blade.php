@extends('layouts.app')

@section('content')
<div class="container mx-auto px-2 sm:px-6 py-6 sm:py-12 flex-grow max-w-full sm:max-w-3xl">
    <div class="bg-white/90 rounded-xl shadow-lg border border-orange-100 p-4 sm:p-8 text-center">
        <h1 class="text-2xl sm:text-4xl font-extrabold text-orange-700 mb-2 sm:mb-4 drop-shadow">Selamat Datang di LPKIA Eatz</h1>
        @if (session('status'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow mb-4" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <p class="text-base sm:text-lg text-gray-700 mb-4 sm:mb-6">Platform pemesanan makanan & minuman kampus dengan berbagai tenant dan promo menarik.</p>
        <a href="{{ route('tenant.index') }}" class="inline-block bg-gradient-to-r from-amber-500 to-orange-400 text-white font-bold rounded-full px-6 sm:px-8 py-2 sm:py-3 shadow-lg hover:scale-105 hover:from-orange-500 hover:to-amber-400 transition-all duration-300 text-base sm:text-lg">Lihat Menu</a>
    </div>
</div>
@endsection
