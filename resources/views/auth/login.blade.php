<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Login - LPKIA Eatz</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-br from-[#FFF6E9] via-[#FFF] to-[#FFE0B2] min-h-screen flex items-center justify-center py-12">
    <div class="w-full max-w-md mx-auto bg-white rounded-2xl shadow-xl p-10 border border-[#FFD6A5]">
        <h2 class="text-3xl font-extrabold text-center text-[#FF914D] mb-8">Login</h2>
        @if(session('error'))
            <div class="mb-4 text-red-600 text-center">{{ session('error') }}</div>
        @endif
        <form method="POST" action="{{ route('login') }}" class="space-y-6">
            @csrf
            <div>
                <label for="email" class="block text-[#FF914D] font-semibold mb-1">Email</label>
                <input id="email" type="email" name="email" value="{{ old('email') }}"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#FF914D] @error('email') border-red-500 @enderror"
                    required autofocus>
                @error('email')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div>
                <label for="password" class="block text-[#FF914D] font-semibold mb-1">Password</label>
                <input id="password" type="password" name="password"
                    class="w-full px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#FF914D] @error('password') border-red-500 @enderror"
                    required>
                @error('password')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>
            <div class="flex items-center justify-between">
                <div>
                    <input type="checkbox" name="remember" id="remember" {{ old('remember') ? 'checked' : '' }}>
                    <label for="remember" class="text-sm text-gray-600">Ingat Saya</label>
                </div>
                <a class="text-sm text-[#FF914D] hover:underline" href="{{ route('password.request') }}">
                    Lupa Password?
                </a>
            </div>
            <button type="submit"
                class="w-full bg-gradient-to-r from-[#FF914D] to-[#FF5E13] hover:from-[#FF5E13] hover:to-[#FF914D] text-white font-bold py-2 px-4 rounded-full shadow-lg transition text-lg">
                Login
            </button>
        </form>
        <div class="mt-6 text-center text-sm text-gray-600">
            Belum punya akun? <a href="{{ route('register') }}" class="text-[#FF914D] hover:underline font-bold">Daftar</a>
        </div>
    </div>
</body>
</html>
