@extends('layouts.app')

@section('content')
<div class="container mx-auto py-8">
    <h1 class="text-3xl font-bold text-blue-800 mb-8">Daftar Tenant</h1>
    <div class="grid gap-8 grid-cols-1 sm:grid-cols-2 md:grid-cols-3">
        @forelse($tenants as $tenant)
            <a href="{{ route('tenant.show', $tenant->id) }}" class="block bg-white rounded-xl shadow-lg p-6 border border-blue-100 hover:shadow-2xl hover:-translate-y-1 transition-all duration-300">
                @if($tenant->logo)
                    <img src="{{ asset('foto/' . $tenant->logo) }}" alt="Logo {{ $tenant->name }}" class="w-16 h-16 rounded-full mx-auto mb-3">
                @endif
                <h2 class="text-xl font-bold text-blue-700 text-center mb-1">{{ $tenant->name }}</h2>
                <p class="text-gray-600 text-center text-sm">{{ Str::limit($tenant->description, 60) }}</p>
            </a>
        @empty
            <p class="col-span-3 text-center text-gray-500">Belum ada tenant terdaftar.</p>
        @endforelse
    </div>
</div>
@endsection
