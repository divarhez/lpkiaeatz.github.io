@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-12 max-w-2xl">
    <h2 class="text-3xl font-bold text-[#FF914D] mb-8 text-center">Tambah Stok Makanan</h2>
    <form method="POST" action="{{ route('stok-makanan.store') }}">
        @csrf
        <!-- Form input stok makanan -->
        <div class="mb-4">
            <label class="block text-[#FF914D] font-semibold mb-1">Nama Makanan</label>
            <input type="text" name="name" class="w-full px-4 py-2 border rounded-lg" required>
        </div>
        <div class="mb-4">
            <label class="block text-[#FF914D] font-semibold mb-1">Jumlah Stok</label>
            <input type="number" name="stock" class="w-full px-4 py-2 border rounded-lg" required>
        </div>
        <button type="submit" class="bg-[#FF914D] hover:bg-[#FF5E13] text-white px-6 py-2 rounded-full font-bold shadow">Simpan</button>
    </form>
</div>
@endsection
