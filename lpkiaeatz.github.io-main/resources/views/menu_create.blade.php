@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-12 flex-grow max-w-xl">
    <div class="bg-white/90 rounded-xl shadow-lg border border-orange-100 p-8">
        <h2 class="text-3xl font-extrabold text-orange-700 mb-6 drop-shadow">Tambah Menu Baru</h2>
        <form action="{{ route('menu.store') }}" method="POST" enctype="multipart/form-data" class="space-y-5">
            @csrf
            <div>
                <label class="block mb-1 font-semibold text-orange-700" for="name">Nama Menu</label>
                <input type="text" name="name" id="name" class="w-full border px-3 py-2 rounded focus:ring-2 focus:ring-orange-300" required>
            </div>
            <div>
                <label class="block mb-1 font-semibold text-orange-700" for="category">Kategori</label>
                <input type="text" name="category" id="category" class="w-full border px-3 py-2 rounded focus:ring-2 focus:ring-orange-300" required>
            </div>
            <div>
                <label class="block mb-1 font-semibold text-orange-700" for="description">Deskripsi</label>
                <textarea name="description" id="description" class="w-full border px-3 py-2 rounded focus:ring-2 focus:ring-orange-300" required></textarea>
            </div>
            <div>
                <label class="block mb-1 font-semibold text-orange-700" for="price">Harga</label>
                <input type="number" name="price" id="price" class="w-full border px-3 py-2 rounded focus:ring-2 focus:ring-orange-300" required>
            </div>
            <div>
                <label class="block mb-1 font-semibold text-orange-700" for="image">Gambar Menu (URL)</label>
                <input type="text" name="image" id="image" class="w-full border px-3 py-2 rounded focus:ring-2 focus:ring-orange-300" required>
            </div>
            <div class="flex gap-4 mt-6">
                <button type="submit" class="bg-orange-500 hover:bg-orange-600 text-white font-bold px-6 py-2 rounded-full shadow">Simpan</button>
                <a href="{{ route('menu.index') }}" class="text-orange-700 hover:underline font-semibold py-2">Batal</a>
            </div>
        </form>
    </div>
</div>
@endsection
