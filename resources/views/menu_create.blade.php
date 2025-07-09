@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-[#FFF6E9] via-[#FFF] to-[#FFE0B2] py-10 sm:py-20">
    <div class="w-full max-w-full sm:max-w-xl mx-auto bg-white/90 rounded-2xl shadow-xl border border-orange-100 p-6 sm:p-12">
        <h2 class="text-2xl sm:text-3xl font-extrabold text-orange-700 mb-6 sm:mb-8 drop-shadow">
            {{ isset($menu) ? 'Edit Menu' : 'Tambah Menu Baru' }}
        </h2>
        @if ($errors->any())
            <div class="mb-6 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ isset($menu) ? route('admin.menu.update', $menu->id) : route('menu.store') }}" enctype="multipart/form-data" class="space-y-5 sm:space-y-7">
            @csrf
            @if(isset($menu))
                <!-- Untuk update, pakai POST ke route update -->
            @endif
            <div>
                <label class="block text-[#FF914D] font-semibold mb-2">Tenant</label>
                <select name="tenant_id" class="w-full px-4 py-3 border rounded-lg" required>
                    <option value="">-- Pilih Tenant --</option>
                    @foreach($tenants as $tenant)
                        <option value="{{ $tenant->id }}" {{ (old('tenant_id', $selectedTenant ?? ($menu->tenant_id ?? null)) == $tenant->id) ? 'selected' : '' }}>{{ $tenant->name }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-[#FF914D] font-semibold mb-2">Nama Menu</label>
                <input type="text" name="name" class="w-full px-4 py-3 border rounded-lg" required value="{{ old('name', $menu->name ?? '') }}">
            </div>
            <div>
                <label class="block text-[#FF914D] font-semibold mb-2">Deskripsi</label>
                <textarea name="description" class="w-full px-4 py-3 border rounded-lg resize-none" required>{{ old('description', $menu->description ?? '') }}</textarea>
            </div>
            <div>
                <label class="block text-[#FF914D] font-semibold mb-2">Harga</label>
                <input type="number" name="price" class="w-full px-4 py-3 border rounded-lg" required value="{{ old('price', $menu->price ?? '') }}" inputmode="numeric" autocomplete="off">
            </div>
            <div>
                <label class="block text-[#FF914D] font-semibold mb-2">Gambar</label>
                <input type="file" name="image" class="w-full" {{ isset($menu) ? '' : 'required' }}>
            </div>
            <div>
                <label class="block text-[#FF914D] font-semibold mb-2">Kategori</label>
                <select name="category" class="w-full px-4 py-3 border rounded-lg" required>
                    <option value="">-- Pilih Kategori --</option>
                    <option value="Makanan" {{ old('category', $menu->category ?? '') == 'Makanan' ? 'selected' : '' }}>Makanan</option>
                    <option value="Minuman" {{ old('category', $menu->category ?? '') == 'Minuman' ? 'selected' : '' }}>Minuman</option>
                    <option value="Snack" {{ old('category', $menu->category ?? '') == 'Snack' ? 'selected' : '' }}>Snack</option>
                    <option value="Lainnya" {{ old('category', $menu->category ?? '') == 'Lainnya' ? 'selected' : '' }}>Lainnya</option>
                </select>
            </div>
            <button type="submit" id="menu-form-submit" class="w-full sm:w-auto bg-[#FF914D] hover:bg-[#FF5E13] text-white px-8 py-3 rounded-full font-bold shadow mt-2 flex items-center justify-center gap-2 disabled:opacity-60 disabled:cursor-not-allowed transition-all duration-200 text-lg" aria-label="{{ isset($menu) ? 'Update' : 'Simpan' }}">
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
