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
    <header class="bg-white/90 shadow sticky top-0 z-50 border-b border-[#FFD6A5] w-full">
        <div class="max-w-7xl mx-auto flex justify-between items-center py-4 px-2 sm:px-6 w-full overflow-x-auto relative">
            <a href="/" class="text-2xl md:text-3xl font-extrabold text-[#FF914D] tracking-wide flex items-center gap-2 min-w-0">
                <img src="https://img.icons8.com/fluency/48/restaurant-table.png" class="w-10 h-10" alt="Logo" />
                LPKIA Eatz
            </a>
            <!-- Hamburger button for mobile -->
            <button id="navbar-toggle" class="md:hidden ml-2 p-2 rounded focus:outline-none focus:ring-2 focus:ring-[#FF914D] transition duration-200 hover:bg-orange-50 z-50" aria-label="Buka menu">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 text-[#FF914D]" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
            <!-- Overlay for mobile menu -->
            <div id="navbar-overlay" class="fixed inset-0 bg-black/40 z-40 hidden md:hidden transition-opacity duration-300"></div>
            <nav class="w-full">
                <ul id="navbar-menu" class="hidden md:flex flex-col md:flex-row text-base md:text-base font-semibold items-start md:items-center bg-white md:bg-transparent fixed md:static top-0 left-0 w-full md:w-auto h-auto md:h-auto shadow-2xl md:shadow-none z-50 p-0 md:p-0 transition-all duration-300 origin-top scale-95 md:scale-100 opacity-0 md:opacity-100 divide-y divide-orange-100 md:divide-y-0">
                    <li class="w-full"><a href="/" class="block px-6 py-3 text-[#FF914D] hover:bg-orange-50 hover:text-[#FF5E13] transition w-full" onclick="closeMenu()">Home</a></li>
                    <li class="w-full"><a href="/tenants" class="block px-6 py-3 text-[#FF914D] hover:bg-orange-50 hover:text-[#FF5E13] transition w-full" onclick="closeMenu()">Tenant</a></li>
                    <li class="w-full"><a href="{{ route('menu.index') }}#menu" class="block px-6 py-3 text-[#FF914D] hover:bg-orange-50 hover:text-[#FF5E13] transition w-full" onclick="closeMenu()">Menu</a></li>
                    <li class="w-full"><a href="#promo" class="block px-6 py-3 text-[#FF914D] hover:bg-orange-50 hover:text-[#FF5E13] transition w-full" onclick="closeMenu()">Promo</a></li>
                    @auth
                        <li class="w-full"><a href="{{ route('orders.history') }}" class="block px-6 py-3 text-[#FF914D] hover:bg-orange-50 hover:text-amber-500 transition w-full" onclick="closeMenu()">Riwayat Pesanan</a></li>
                    @endauth
                    <li class="w-full">
                        <a href="{{ route('cart.show') }}" class="block px-6 py-3 text-[#FF914D] hover:bg-orange-50 hover:text-[#FF5E13] transition w-full flex items-center gap-1" onclick="closeMenu()">
                            <i data-feather="shopping-cart" class="w-5 h-5"></i> Keranjang
                        </a>
                    </li>
                    <li class="w-full">
                        @auth
                            <a href="{{ route('profile.show') }}" class="block px-6 py-3 text-[#FF914D] hover:bg-orange-50 hover:text-blue-500 transition w-full flex items-center gap-1" onclick="closeMenu()">
                                <i data-feather="user" class="w-5 h-5"></i> Profil
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="block px-6 py-3 text-[#FF914D] hover:bg-orange-50 hover:text-blue-500 transition w-full flex items-center gap-1" onclick="closeMenu()">
                                <i data-feather="user" class="w-5 h-5"></i> Profil
                            </a>
                        @endauth
                    </li>
                    @auth
                        <li class="w-full">
                            <form action="{{ route('logout') }}" method="POST" class="inline w-full" onclick="closeMenu()">
                                @csrf
                                <button type="submit" class="block px-6 py-3 text-[#FF914D] hover:bg-orange-50 hover:text-red-500 transition w-full text-left">Logout</button>
                            </form>
                        </li>
                    @else
                        <li class="w-full">
                            <a href="{{ route('login') }}" class="block px-6 py-3 text-[#FF914D] hover:bg-orange-50 hover:text-blue-500 transition w-full" onclick="closeMenu()">Login</a>
                        </li>
                    @endauth
                    @auth
                        @if(auth()->user()->role === 'petugas')
                            <li class="w-full"><a href="{{ route('admin.dashboard') }}" class="block px-6 py-3 text-[#FF914D] hover:bg-orange-50 hover:text-[#FF5E13] transition w-full font-bold" onclick="closeMenu()">Dashboard Admin</a></li>
                        @endif
                    @endauth
                </ul>
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
</body>
</html>
