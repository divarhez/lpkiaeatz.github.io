<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'LPKIA Eatz') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/feather-icons"></script>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&display=swap" rel="stylesheet">
    <style>
      body { font-family: 'Montserrat', sans-serif; }
      .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
      }
      ::-webkit-scrollbar {
        width: 8px;
        background: #f1f1f1;
      }
      ::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 8px;
      }
    </style>
</head>
<body class="bg-gradient-to-br from-[#FFF6E9] via-[#FFF] to-[#FFE0B2] min-h-screen flex flex-col text-[#22223B]">
    <header class="bg-white/90 shadow sticky top-0 z-50 border-b border-[#FFD6A5]">
        <div class="max-w-7xl mx-auto flex justify-between items-center py-4 px-6">
            <a href="/" class="text-2xl md:text-3xl font-extrabold text-[#FF914D] tracking-wide flex items-center gap-2">
                <img src="https://img.icons8.com/fluency/48/restaurant-table.png" class="w-10 h-10" alt="Logo" />
                LPKIA Eatz
            </a>
            <nav>
                <ul class="flex space-x-6 text-[#FF914D] font-semibold items-center">
                    <li><a href="/" class="hover:text-[#FF5E13] transition">Home</a></li>
                    <li><a href="/tenants" class="hover:text-[#FF5E13] transition">Tenant</a></li>
                    <li><a href="{{ route('menu.index') }}#menu" class="hover:text-[#FF5E13] transition">Menu</a></li>
                    <li><a href="#promo" class="hover:text-[#FF5E13] transition">Promo</a></li>
                    <li>
                        <a href="{{ route('cart.show') }}" class="hover:text-[#FF5E13] transition flex items-center gap-1">
                            <i data-feather="shopping-cart" class="w-5 h-5"></i> Keranjang
                        </a>
                    </li>
                    @auth
                        <li>
                            <form action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="hover:text-red-500 transition">Logout</button>
                            </form>
                        </li>
                    @else
                        <li>
                            <a href="{{ route('login') }}" class="hover:text-blue-500 transition">Login</a>
                        </li>
                    @endauth
                </ul>
            </nav>
        </div>
    </header>
    <main class="flex-grow">
        @yield('content')
    </main>
    <footer class="bg-white/90 border-t border-[#FFD6A5] text-[#FF914D] p-4 text-center mt-10 shadow-inner">
        &copy; {{ date('Y') }} <span class="font-bold">LPKIA Eatz</span>. All Rights Reserved.
    </footer>
    <script>feather.replace()</script>
</body>
</html>
