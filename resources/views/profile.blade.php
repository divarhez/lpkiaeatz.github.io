@extends('layouts.app')

@section('content')
<div class="min-h-screen flex items-center justify-center bg-gradient-to-br from-[#FFF6E9] via-[#FFF] to-[#FFE0B2] py-12">
    <div class="w-full max-w-lg mx-auto bg-white rounded-2xl shadow-xl p-10 border border-[#FFD6A5]">
        <h2 class="text-3xl font-extrabold text-center text-[#FF914D] mb-8">Profil Saya</h2>
        @if(session('success'))
            <div class="mb-4 bg-green-100 border border-green-400 text-green-700 rounded-md px-6 py-3 text-center font-semibold shadow animate__animated animate__fadeInDown">
                {{ session('success') }}
            </div>
        @endif
        @if($errors->any())
            <div class="mb-4 bg-red-100 border border-red-400 text-red-700 rounded-md px-6 py-3 text-center font-semibold shadow animate__animated animate__fadeInDown">
                <ul class="list-disc list-inside text-left inline-block">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <form method="POST" action="{{ route('profile.update') }}" class="space-y-6">
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
            <button type="submit" class="w-full bg-gradient-to-r from-[#FF914D] to-[#FF5E13] hover:from-[#FF5E13] hover:to-[#FF914D] text-white font-bold py-2 px-4 rounded-full shadow-lg transition text-lg">Simpan Perubahan</button>
        </form>
    </div>
</div>
@endsection
