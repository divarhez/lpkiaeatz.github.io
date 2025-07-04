@extends('layouts.app')

@section('content')
<div class="container mx-auto px-2 sm:px-6 py-6 sm:py-12 max-w-full sm:max-w-4xl">
    <h2 class="text-2xl sm:text-3xl font-bold text-[#FF914D] mb-4 sm:mb-8 text-center">Manajemen Menu</h2>
    <form method="GET" action="" class="mb-6 sm:mb-8 max-w-xs mx-auto">
        <label class="block text-[#FF914D] font-semibold mb-1">Pilih Tenant</label>
        <select name="tenant_id" class="w-full px-4 py-2 border rounded-lg" onchange="this.form.submit()">
            <option value="">-- Pilih Tenant --</option>
            @foreach($tenants as $tenant)
                <option value="{{ $tenant->id }}" {{ request('tenant_id') == $tenant->id ? 'selected' : '' }}>{{ $tenant->name }}</option>
            @endforeach
        </select>
    </form>
    @if($selectedTenant)
        <div class="mb-4 sm:mb-6 text-right">
            <a href="{{ route('menu.create', ['tenant_id' => $selectedTenant->id]) }}" class="inline-block bg-[#FF914D] hover:bg-[#FF5E13] text-white font-bold px-4 sm:px-6 py-2 rounded-full shadow transition text-sm sm:text-base">+ Tambah Menu</a>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-xl shadow border border-[#FFD6A5] text-xs sm:text-sm">
                <thead>
                    <tr class="bg-[#FFF6E9] text-[#FF914D]">
                        <th class="py-2 sm:py-3 px-2 sm:px-4 text-left rounded-tl-xl">Nama Menu</th>
                        <th class="py-2 sm:py-3 px-2 sm:px-4 text-left">Deskripsi</th>
                        <th class="py-2 sm:py-3 px-2 sm:px-4 text-right">Harga</th>
                        <th class="py-2 sm:py-3 px-2 sm:px-4 text-center rounded-tr-xl">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($menus as $menu)
                        <tr class="border-b border-[#FFE0B2] hover:bg-orange-50 transition">
                            <td class="py-2 sm:py-3 px-2 sm:px-4 font-semibold text-[#FF914D] align-top w-1/5">{{ $menu->name }}</td>
                            <td class="py-2 sm:py-3 px-2 sm:px-4 text-gray-700 align-top w-2/5">{{ $menu->description }}</td>
                            <td class="py-2 sm:py-3 px-2 sm:px-4 text-right text-[#FF5E13] font-bold align-top w-1/6">Rp{{ number_format($menu->price,0,',','.') }}</td>
                            <td class="py-2 sm:py-3 px-2 sm:px-4 text-center align-top w-1/6">
                                <a href="{{ route('admin.menu.edit', $menu->id) }}" class="text-blue-600 hover:underline mr-2">Edit</a>
                                <form action="{{ route('admin.menu.delete', $menu->id) }}" method="POST" class="inline" onsubmit="return confirm('Yakin hapus menu ini?')">
                                    @csrf
                                    <button type="submit" class="text-red-600 hover:underline">Hapus</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="text-center text-gray-500 py-4 sm:py-6">Belum ada menu untuk tenant ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @else
        <div class="text-center text-gray-500">Silakan pilih tenant untuk mengelola menu.</div>
    @endif
</div>
@endsection
