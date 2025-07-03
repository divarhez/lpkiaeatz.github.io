@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-[#FFF6E9] via-[#FFF] to-[#FFE0B2] py-12">
    <div class="w-full max-w-md mx-auto bg-white rounded-2xl shadow-xl p-10 border border-[#FFD6A5]">
        <h2 class="text-3xl font-extrabold text-center text-[#FF914D] mb-8">Register</h2>
        <form method="POST" action="{{ route('register') }}" class="space-y-6">
            @csrf
            <div>
                <label for="name" class="block text-[#FF914D] font-semibold mb-1">Nama</label>
                <input id="name" type="text" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#FF914D] @error('name') border-red-500 @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>
                @error('name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="email" class="block text-[#FF914D] font-semibold mb-1">Email</label>
                <input id="email" type="email" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#FF914D] @error('email') border-red-500 @enderror" name="email" value="{{ old('email') }}" required autocomplete="email">
                @error('email')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="password" class="block text-[#FF914D] font-semibold mb-1">Password</label>
                <input id="password" type="password" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#FF914D] @error('password') border-red-500 @enderror" name="password" required autocomplete="new-password">
                @error('password')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="password-confirm" class="block text-[#FF914D] font-semibold mb-1">Konfirmasi Password</label>
                <input id="password-confirm" type="password" class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#FF914D]" name="password_confirmation" required autocomplete="new-password">
            </div>
            <div>
                <label for="role" class="block text-[#FF914D] font-semibold mb-1">Role</label>
                <select id="role" class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-[#FF914D] @error('role') border-red-500 @enderror" name="role" required>
                    <option value="">-- Pilih Role --</option>
                    <option value="mahasiswa" {{ old('role') == 'mahasiswa' ? 'selected' : '' }}>Mahasiswa</option>
                    <option value="petugas" {{ old('role') == 'petugas' ? 'selected' : '' }}>Petugas</option>
                </select>
                @error('role')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <button type="submit" class="w-full bg-gradient-to-r from-[#FF914D] to-[#FF5E13] hover:from-[#FF5E13] hover:to-[#FF914D] text-white font-bold py-2 px-4 rounded-full shadow-lg transition text-lg">Register</button>
        </form>
        <div class="mt-6 text-center text-sm text-gray-600">
            Sudah punya akun? <a href="{{ route('login') }}" class="text-[#FF914D] hover:underline font-bold">Login</a>
        </div>
    </div>
</div>
@endsection
