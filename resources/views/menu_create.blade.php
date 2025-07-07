@extends('layouts.app')

@section('content')
<div class="container mx-auto px-2 sm:px-6 py-6 sm:py-12 flex-grow max-w-full sm:max-w-xl">
    <div class="bg-white/90 rounded-xl shadow-lg border border-orange-100 p-4 sm:p-8">
        <h2 class="text-2xl sm:text-3xl font-extrabold text-orange-700 mb-4 sm:mb-6 drop-shadow">
            {{ isset($menu) ? 'Edit Menu' : 'Tambah Menu Baru' }}
        </h2>
        @if ($errors->any())
            <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ isset($menu) ? route('admin.menu.update', $menu->id) : route('menu.store') }}" enctype="multipart/form-data">
            @csrf
            @if(isset($menu))
                <!-- Untuk update, pakai POST ke route update -->
            @endif
            <div class="mb-4">
                <label class="block text-[#FF914D] font-semibold mb-1">Tenant</label>
                <select name="tenant_id" class="w-full px-4 py-2 border rounded-lg" required>
                    <option value="">-- Pilih Tenant --</option>
                    @foreach($tenants as $tenant)
                        <option value="{{ $tenant->id }}" {{ (old('tenant_id', $selectedTenant ?? ($menu->tenant_id ?? null)) == $tenant->id) ? 'selected' : '' }}>{{ $tenant->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-[#FF914D] font-semibold mb-1">Nama Menu</label>
                <input type="text" name="name" class="w-full px-4 py-2 border rounded-lg" required value="{{ old('name', $menu->name ?? '') }}">
            </div>
            <div class="mb-4">
                <label class="block text-[#FF914D] font-semibold mb-1">Deskripsi</label>
                <textarea name="description" class="w-full px-4 py-2 border rounded-lg resize-none" required>{{ old('description', $menu->description ?? '') }}</textarea>
            </div>
            <div class="mb-4">
                <label class="block text-[#FF914D] font-semibold mb-1">Harga</label>
                <input type="number" name="price" class="w-full px-4 py-2 border rounded-lg" required value="{{ old('price', $menu->price ?? '') }}" inputmode="numeric" autocomplete="off">
            </div>
            <div class="mb-4">
                <label class="block text-[#FF914D] font-semibold mb-1">Gambar</label>
                <input type="file" name="image" class="w-full" {{ isset($menu) ? '' : 'required' }}>
            </div>
            <div class="mb-4">
                <label class="block text-[#FF914D] font-semibold mb-1">Kategori</label>
                <select name="category" class="w-full px-4 py-2 border rounded-lg" required>
                    <option value="">-- Pilih Kategori --</option>
                    <option value="Makanan" {{ old('category', $menu->category ?? '') == 'Makanan' ? 'selected' : '' }}>Makanan</option>
                    <option value="Minuman" {{ old('category', $menu->category ?? '') == 'Minuman' ? 'selected' : '' }}>Minuman</option>
                    <option value="Snack" {{ old('category', $menu->category ?? '') == 'Snack' ? 'selected' : '' }}>Snack</option>
                    <option value="Lainnya" {{ old('category', $menu->category ?? '') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>
            <button type="submit" id="menu-form-submit" class="w-full sm:w-auto bg-[#FF914D] hover:bg-[#FF5E13] text-white px-6 py-2 rounded-full font-bold shadow mt-2 flex items-center justify-center gap-2 disabled:opacity-60 disabled:cursor-not-allowed transition-all duration-200" aria-label="{{ isset($menu) ? 'Update' : 'Simpan' }}">
                <span id="menu-form-btn-text">{{ isset($menu) ? 'Update' : 'Simpan' }}</span>
                <svg id="menu-form-spinner" class="hidden animate-spin h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8z"></path></svg>
            </button>
        </form>
    </div>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('form');
    const submitBtn = document.getElementById('menu-form-submit');
    const btnText = document.getElementById('menu-form-btn-text');
    const spinner = document.getElementById('menu-form-spinner');
    if(form && submitBtn && btnText && spinner) {
        form.addEventListener('submit', function() {
            submitBtn.disabled = true;
            btnText.textContent = 'Menyimpan...';
            spinner.classList.remove('hidden');
        });
    }
});
</script>
@endsection
