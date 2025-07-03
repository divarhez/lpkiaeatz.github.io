@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-12 max-w-2xl">
    <h2 class="text-3xl font-bold text-[#FF914D] mb-8 text-center">Tambah Tenant</h2>

    @if ($errors->any())
        <div class="mb-4 p-4 bg-red-100 border border-red-400 text-red-700 rounded">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('tenant.store') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label class="block text-[#FF914D] font-semibold mb-1">Nama Tenant</label>
            <input type="text" name="name" class="w-full px-4 py-2 border rounded-lg" required>
        </div>
        <div class="mb-4">
            <label class="block text-[#FF914D] font-semibold mb-1">Deskripsi</label>
            <textarea name="description" class="w-full px-4 py-2 border rounded-lg" required></textarea>
        </div>
        <div class="mb-4">
            <label class="block text-[#FF914D] font-semibold mb-1">Logo (opsional)</label>
            <input type="file" name="logo" class="w-full">
        </div>
        <button type="submit" class="bg-[#FF914D] hover:bg-[#FF5E13] text-white px-6 py-2 rounded-full font-bold shadow">Simpan</button>
    </form>
</div>
@endsection
