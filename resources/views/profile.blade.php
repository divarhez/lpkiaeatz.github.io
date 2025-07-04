@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-[#FFF6E9] via-[#FFF] to-[#FFE0B2] py-6 sm:py-12">
    <div class="w-full max-w-full sm:max-w-lg mx-auto bg-white rounded-2xl shadow-xl p-4 sm:p-10 border border-[#FFD6A5]">
        <h2 class="text-2xl sm:text-3xl font-extrabold text-center text-[#FF914D] mb-6 sm:mb-8">Profil Saya</h2>
        @if(session('success'))
            <x-alert type="success">{{ session('success') }}</x-alert>
        @endif
        @if($errors->any())
            <x-alert type="error">
                <ul class="list-disc list-inside text-left inline-block">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </x-alert>
        @endif
        <form method="POST" action="{{ route('profile.update') }}" class="space-y-4 sm:space-y-6">
            @csrf
            <div>
                <label for="name" class="block text-[#FF914D] font-semibold mb-1">Nama</label>
                <input id="name" type="text" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#FF914D] @error('name') border-red-500 @enderror" name="name" value="{{ old('name', $user->name) }}" required autofocus>
                @error('name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="email" class="block text-[#FF914D] font-semibold mb-1">Email</label>
                <input id="email" type="email" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#FF914D] @error('email') border-red-500 @enderror" name="email" value="{{ old('email', $user->email) }}" required>
                @error('email')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="password" class="block text-[#FF914D] font-semibold mb-1">Password Baru <span class="text-gray-400 font-normal">(Opsional)</span></label>
                <input id="password" type="password" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#FF914D] @error('password') border-red-500 @enderror" name="password" autocomplete="new-password">
                @error('password')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="password_confirmation" class="block text-[#FF914D] font-semibold mb-1">Konfirmasi Password Baru</label>
                <input id="password_confirmation" type="password" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#FF914D]" name="password_confirmation" autocomplete="new-password">
            </div>
            <x-button class="w-full">Simpan Perubahan</x-button>
        </form>
    </div>
</div>
@endsection
