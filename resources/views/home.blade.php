@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-[#FFF6E9] via-[#FFF] to-[#FFE0B2] py-10 sm:py-20">
    <div class="w-full max-w-full sm:max-w-3xl mx-auto bg-white/90 rounded-2xl shadow-xl border border-orange-100 p-6 sm:p-12 text-center">
        <h1 class="text-3xl sm:text-5xl font-extrabold text-orange-700 mb-4 sm:mb-8 drop-shadow">Selamat Datang di LPKIA Eatz</h1>
        @if (session('status'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow mb-6" role="alert">
                {{ session('status') }}
            </div>
        @endif
        <p class="text-lg sm:text-xl text-gray-700 mb-6 sm:mb-10">Platform pemesanan makanan & minuman kampus dengan berbagai tenant dan promo menarik.</p>
        <a href="{{ route('tenant.index') }}" class="inline-block bg-gradient-to-r from-amber-500 to-orange-400 text-white font-bold rounded-full px-8 sm:px-12 py-4 sm:py-5 shadow-lg hover:scale-105 hover:from-orange-500 hover:to-amber-400 transition-all duration-300 text-lg sm:text-xl">Lihat Menu</a>
    </div>
</div>
@endsection
