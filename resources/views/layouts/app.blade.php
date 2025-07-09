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
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    <meta name="description" content="LPKIA Eatz - Temukan kuliner favorit, promo, dan tenant pilihan di kampus LPKIA.">
    <meta name="keywords" content="LPKIA, Eatz, makanan, minuman, kampus, menu, promo, tenant">
    <meta name="author" content="LPKIA Eatz Team">
    <style>
      /* Style kustom dipindahkan ke resources/css/custom.css */
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
    <header class="bg-white/90 shadow sticky top-0 z-50 border-b border-[#FFD6A5] w-full">
        <div class="max-w-7xl mx-auto flex justify-between items-center py-3 px-2 sm:px-6 w-full overflow-x-auto relative">
            <a href="/" class="text-2xl md:text-3xl font-extrabold text-[#FF914D] tracking-wide flex items-center gap-2 min-w-0 hover:scale-105 transition-transform">
                <img src="https://img.icons8.com/fluency/48/restaurant-table.png" class="w-10 h-10" alt="Logo" />
                LPKIA Eatz
            </a>
            <nav class="hidden md:flex gap-6 items-center">
                <a href="/" class="text-[#FF914D] font-semibold hover:text-[#FF5E13] transition">Home</a>
                <a href="/tenants" class="text-[#FF914D] font-semibold hover:text-[#FF5E13] transition">Tenant</a>
                @auth
                @if(auth()->user()->role === 'petugas')
                <a href="{{ route('admin.dashboard') }}" class="text-[#FF914D] font-semibold hover:text-green-600 transition">Dashboard Admin</a>
                @endif
                <a href="{{ route('orders.history') }}" class="text-[#FF914D] font-semibold hover:text-amber-500 transition">Riwayat Pesanan</a>
                @endauth
                <a href="{{ route('cart.show') }}" class="text-[#FF914D] font-semibold hover:text-[#FF5E13] transition flex items-center gap-1">
                    <i data-feather="shopping-cart" class="w-5 h-5"></i> Keranjang
                </a>
                @auth
                <a href="{{ route('profile.show') }}" class="text-[#FF914D] font-semibold hover:text-blue-500 transition flex items-center gap-1">
                    <i data-feather="user" class="w-5 h-5"></i> Profil
                </a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-[#FF914D] font-semibold hover:text-red-500 transition">Logout</button>
                </form>
                @else
                <a href="{{ route('login') }}" class="text-[#FF914D] font-semibold hover:text-blue-500 transition flex items-center gap-1">
                    <i data-feather="user" class="w-5 h-5"></i> Profil
                </a>
                @endauth
            </nav>
            <!-- Hamburger button for mobile -->
            <button id="navbar-toggle" class="md:hidden ml-2 p-2 rounded focus:outline-none focus:ring-2 focus:ring-[#FF914D] transition duration-200 hover:bg-orange-50 z-50" aria-label="Buka menu">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-[#FF914D]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            <!-- Overlay for mobile menu -->
            <div id="navbar-overlay" class="fixed inset-0 bg-black/40 z-40 hidden md:hidden transition-opacity duration-300"></div>
            <nav id="mobile-menu" class="md:hidden fixed top-0 left-0 w-3/4 max-w-xs h-full bg-white shadow-2xl z-50 p-6 transition-transform -translate-x-full">
                <a href="/" class="block text-[#FF914D] font-semibold mb-4">Home</a>
                <a href="/tenants" class="block text-[#FF914D] font-semibold mb-4">Tenant</a>
                @auth
                @if(auth()->user()->role === 'petugas')
                <a href="{{ route('admin.dashboard') }}" class="block text-[#FF914D] font-semibold mb-4 hover:text-green-600">Dashboard Admin</a>
                @endif
                <a href="{{ route('orders.history') }}" class="block text-[#FF914D] font-semibold mb-4">Riwayat Pesanan</a>
                @endauth
                <a href="{{ route('cart.show') }}" class="block text-[#FF914D] font-semibold mb-4 flex items-center gap-1">
                    <i data-feather="shopping-cart" class="w-5 h-5"></i> Keranjang
                </a>
                @auth
                <a href="{{ route('profile.show') }}" class="block text-[#FF914D] font-semibold mb-4 flex items-center gap-1">
                    <i data-feather="user" class="w-5 h-5"></i> Profil
                </a>
                <form action="{{ route('logout') }}" method="POST" class="inline">
                    @csrf
                    <button type="submit" class="text-[#FF914D] font-semibold hover:text-red-500 transition">Logout</button>
                </form>
                @else
                <a href="{{ route('login') }}" class="block text-[#FF914D] font-semibold mb-4 flex items-center gap-1">
                    <i data-feather="user" class="w-5 h-5"></i> Profil
                </a>
                @endauth
            </nav>
        </div>
    </header>
    <main class="flex-grow w-full max-w-full overflow-x-auto">
        @yield('content')
    </main>
    <footer class="bg-white/90 border-t border-[#FFD6A5] text-[#FF914D] p-4 text-center mt-10 shadow-inner">
        &copy; {{ date('Y') }} <span class="font-bold">LPKIA Eatz</span>. All Rights Reserved.
    </footer>
    <div id="toast" class="fixed top-6 right-6 z-50 hidden bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg font-semibold text-lg animate__animated transition-all duration-300"></div>
    <script>
    // AJAX add to cart
    function showToast(msg, color = 'bg-green-500') {
        const toast = document.getElementById('toast');
        toast.textContent = msg;
        toast.className = `fixed top-6 right-6 z-50 ${color} text-white px-6 py-3 rounded-lg shadow-lg font-semibold text-lg animate__animated animate__fadeInDown transition-all duration-300`;
        toast.style.display = 'block';
        setTimeout(() => {
            toast.classList.remove('animate__fadeInDown');
            toast.classList.add('animate__fadeOutUp');
            setTimeout(() => { toast.style.display = 'none'; toast.className = ''; }, 900);
        }, 1800);
    }
    document.addEventListener('DOMContentLoaded', function() {
        const toggle = document.getElementById('navbar-toggle');
        const menu = document.getElementById('navbar-menu');
        const overlay = document.getElementById('navbar-overlay');
        window.closeMenu = function() {
            menu.classList.remove('scale-100', 'opacity-100');
            menu.classList.add('scale-95', 'opacity-0');
            setTimeout(() => menu.classList.add('hidden'), 300);
            overlay.classList.remove('opacity-100');
            setTimeout(() => overlay.classList.add('hidden'), 300);
        }
        function openMenu() {
            menu.classList.remove('hidden');
            menu.classList.add('scale-100', 'opacity-100');
            menu.classList.remove('scale-95', 'opacity-0');
            overlay.classList.remove('hidden');
            setTimeout(() => overlay.classList.add('opacity-100'), 10);
        }
        if(toggle && menu && overlay) {
            toggle.addEventListener('click', function() {
                if(menu.classList.contains('hidden')) {
                    openMenu();
                } else {
                    closeMenu();
                }
            });
            overlay.addEventListener('click', closeMenu);
            // Close menu on resize to desktop
            window.addEventListener('resize', function() {
                if(window.innerWidth >= 768) {
                    menu.classList.add('hidden');
                    overlay.classList.add('hidden');
                }
            });
        }
        document.querySelectorAll('.add-to-cart-form').forEach(form => {
            form.addEventListener('submit', function(e) {
                e.preventDefault();
                const action = this.action;
                const formData = new FormData(this);
                const btn = this.querySelector('button[type="submit"]');
                let spinner;
                if(btn) {
                    spinner = document.createElement('span');
                    spinner.className = 'ml-2 animate-spin border-2 border-white border-t-transparent rounded-full w-4 h-4 inline-block align-middle';
                    btn.appendChild(spinner);
                    btn.disabled = true;
                }
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
                .catch(() => showToast('Gagal menambah ke keranjang', 'bg-red-500'))
                .finally(() => {
                    if(btn && spinner) {
                        btn.disabled = false;
                        btn.removeChild(spinner);
                    }
                });
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
    @auth
        @if(auth()->user()->role === 'petugas')
            <div class="relative inline-block mr-4">
                <button id="notifBtn" class="relative focus:outline-none" aria-label="Notifikasi">
                    <i data-feather="bell" class="w-7 h-7 text-[#FF914D]"></i>
                    @php $unread = auth()->user()->unreadNotifications->count(); @endphp
                    @if($unread > 0)
                        <span class="absolute -top-1 -right-1 bg-red-500 text-white text-xs rounded-full px-1.5 py-0.5">{{ $unread }}</span>
                    @endif
                </button>
                <div id="notifDropdown" class="hidden absolute right-0 mt-2 w-80 bg-white border border-[#FFD6A5] rounded-lg shadow-lg z-50 max-h-96 overflow-y-auto">
                    <div class="p-3 font-bold text-[#FF914D] border-b">Notifikasi Pesanan Masuk</div>
                    @forelse(auth()->user()->unreadNotifications as $notif)
                        <div class="px-4 py-2 border-b hover:bg-orange-50">
                            <div class="text-sm">Pesanan baru dari user ID: <b>{{ $notif->data['user_id'] }}</b></div>
                            <div class="text-xs text-gray-500">Total: Rp{{ number_format($notif->data['total'],0,',','.') }}</div>
                            <div class="text-xs text-gray-400">{{ \Carbon\Carbon::parse($notif->data['created_at'])->diffForHumans() }}</div>
                        </div>
                    @empty
                        <div class="px-4 py-4 text-center text-gray-400">Tidak ada notifikasi baru.</div>
                    @endforelse
                </div>
            </div>
            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const btn = document.getElementById('notifBtn');
                    const dropdown = document.getElementById('notifDropdown');
                    if(btn && dropdown) {
                        btn.addEventListener('click', function(e) {
                            e.stopPropagation();
                            dropdown.classList.toggle('hidden');
                        });
                        document.addEventListener('click', function() {
                            dropdown.classList.add('hidden');
                        });
                    }
                });
            </script>
        @endif
    @endauth
</body>
</html>
