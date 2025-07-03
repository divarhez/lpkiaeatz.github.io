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
                    @auth
                        <li><a href="{{ route('orders.history') }}" class="hover:text-amber-500 transition">Riwayat Pesanan</a></li>
                    @endauth
                    <li>
                        <a href="{{ route('cart.show') }}" class="hover:text-[#FF5E13] transition flex items-center gap-1">
                            <i data-feather="shopping-cart" class="w-5 h-5"></i> Keranjang
                        </a>
                    </li>
                    <li>
                        @auth
                            <a href="{{ route('profile.show') }}" class="hover:text-blue-500 transition flex items-center gap-1">
                                <i data-feather="user" class="w-5 h-5"></i> Profil
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="hover:text-blue-500 transition flex items-center gap-1">
                                <i data-feather="user" class="w-5 h-5"></i> Profil
                            </a>
                        @endauth
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
                    @auth
                        @if(auth()->user()->role === 'petugas')
                            <li><a href="{{ route('admin.dashboard') }}" class="hover:text-[#FF5E13] transition font-bold">Dashboard Admin</a></li>
                        @endif
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
    <div id="toast" class="fixed top-6 right-6 z-50 hidden bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg font-semibold text-lg animate__animated"></div>
    <script>
    // AJAX add to cart
    function showToast(msg, color = 'bg-green-500') {
        const toast = document.getElementById('toast');
        toast.textContent = msg;
        toast.className = `fixed top-6 right-6 z-50 ${color} text-white px-6 py-3 rounded-lg shadow-lg font-semibold text-lg animate__animated animate__fadeInDown`;
        toast.style.display = 'block';
        setTimeout(() => {
            toast.classList.remove('animate__fadeInDown');
            toast.classList.add('animate__fadeOutUp');
            setTimeout(() => { toast.style.display = 'none'; toast.className = ''; }, 900);
        }, 1800);
    }
    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('.add-to-cart-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const action = this.action;
                const formData = new FormData(this);
                fetch(action, {
                    method: 'POST',
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: formData
                })
                .then(res => res.json())
                .then(data => {
                    if(data.success) {
                        showToast(data.success, 'bg-green-500');
                    } else if(data.error) {
                        showToast(data.error, 'bg-red-500');
                    }
                })
                .catch(() => showToast('Gagal menambah ke keranjang', 'bg-red-500'));
            });
        });
    });
    </script>
    <script>feather.replace()</script>
    @auth
        @if(auth()->user()->role === 'petugas' && request()->routeIs('admin.dashboard'))
            <style>
                header, footer, .flex.space-x-6, .flex.items-center.gap-2, .hover\:text-amber-500, .hover\:text-[#FF5E13] { display: none !important; }
                main.flex-grow { margin: 0 auto; }
            </style>
        @endif
    @endauth
    @if(session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow mb-4 text-center max-w-xl mx-auto mt-6">
            {{ session('error') }}
        </div>
    @endif
</body>
</html>
