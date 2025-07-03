@extends('layouts.app')

@section('content')
<div class="bg-gradient-to-br from-[#FFF6E9] via-[#FFF] to-[#FFE0B2] min-h-screen flex flex-col">
    <div class="max-w-7xl mx-auto px-6 py-16">
        <div class="flex items-center justify-between mb-10">
            <h1 class="text-4xl md:text-5xl font-extrabold text-[#FF914D] drop-shadow">Daftar Tenant</h1>
            @auth
                @if(auth()->user()->role === 'petugas')
                    <a href="{{ route('tenant.create') }}" class="inline-block bg-gradient-to-r from-[#FF914D] to-[#FF5E13] text-white font-bold px-8 py-3 rounded-full shadow-lg hover:scale-105 transition-all duration-300">+ Tambah Tenant</a>
                @endif
            @endauth
        </div>
        <div class="grid gap-10 grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4">
            @forelse($tenants as $tenant)
                <a href="{{ route('tenant.show', $tenant->id) }}" class="group block bg-white rounded-3xl shadow-2xl p-8 border border-[#FFD6A5] hover:shadow-amber-200 hover:-translate-y-2 hover:scale-105 transition-all duration-300 cursor-pointer">
                    <div class="flex flex-col items-center">
                        <div class="w-24 h-24 rounded-full bg-orange-50 flex items-center justify-center mb-4 overflow-hidden border-4 border-[#FFD6A5] group-hover:scale-110 transition-transform duration-300">
                            @if($tenant->logo)
                                <img src="{{ asset('foto/' . $tenant->logo) }}" alt="Logo {{ $tenant->name }}" class="object-cover w-20 h-20 rounded-full" loading="lazy">
                            @else
                                <img src="https://img.icons8.com/color/96/000000/food-bar.png" alt="Tenant Default" class="w-16 h-16" loading="lazy">
                            @endif
                        </div>
                        <h2 class="text-xl font-extrabold text-[#FF914D] text-center mb-2 group-hover:text-[#FF5E13] transition">{{ $tenant->name }}</h2>
                        <p class="text-gray-600 text-center text-sm mb-2">{{ Str::limit($tenant->description, 60) }}</p>
                    </div>
                </a>
            @empty
                <p class="col-span-3 text-center text-gray-500">Belum ada tenant terdaftar.</p>
            @endforelse
        </div>
    </div>
</div>
@endsection
