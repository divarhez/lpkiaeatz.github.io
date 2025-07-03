@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-12 max-w-4xl">
    <h2 class="text-3xl font-bold text-[#FF914D] mb-8 text-center">Manajemen Stok Makanan</h2>
    <a href="{{ route('stok-makanan.create') }}" class="mb-4 inline-block bg-[#FF914D] hover:bg-[#FF5E13] text-white px-6 py-2 rounded-full font-bold shadow">+ Tambah Stok</a>
    <!-- Daftar stok makanan -->
    <div class="bg-white rounded-xl shadow p-6 border border-[#FFD6A5]">
        <div class="text-center text-gray-500">Daftar stok makanan akan tampil di sini.</div>
    </div>
</div>
@endsection
