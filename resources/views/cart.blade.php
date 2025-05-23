<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - Kantin Online LPKIA</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <style>
        /* Custom scrollbar for table */
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
<body class="bg-gradient-to-br from-blue-50 via-white to-blue-100 min-h-screen flex flex-col">

    <header class="bg-gradient-to-r from-blue-700 via-blue-600 to-blue-500 text-white shadow-lg p-4">
        <div class="container mx-auto flex justify-between items-center">
            <h1 class="text-2xl font-extrabold tracking-wide drop-shadow">Keranjang Belanja</h1>
            <a href="{{ route('menu.index') }}" class="bg-white text-blue-700 font-semibold px-4 py-2 rounded-lg shadow hover:bg-blue-50 hover:scale-105 transition-all duration-200">Kembali ke Menu</a>
        </div>
    </header>

    <main class="container mx-auto p-6 flex-grow">
        @if(session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded-lg shadow mb-4" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded-lg shadow mb-4" role="alert">
                {{ session('error') }}
            </div>
        @endif

        @if(count($cart) > 0)
        <form action="{{ route('checkout') }}" method="POST" id="checkout-form">
            @csrf
            <div class="overflow-x-auto rounded-xl shadow-lg bg-white border border-blue-100">
                <table class="min-w-full divide-y divide-blue-100">
                    <thead>
                        <tr>
                            <th class="py-3 px-6 bg-blue-700 text-white font-bold rounded-tl-xl">Gambar</th>
                            <th class="py-3 px-6 bg-blue-700 text-white font-bold">Nama</th>
                            <th class="py-3 px-6 bg-blue-700 text-white font-bold">Harga</th>
                            <th class="py-3 px-6 bg-blue-700 text-white font-bold">Jumlah</th>
                            <th class="py-3 px-6 bg-blue-700 text-white font-bold">Subtotal</th>
                            <th class="py-3 px-6 bg-blue-700 text-white font-bold rounded-tr-xl">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white">
                        @php $total = 0; @endphp
                        @foreach($cart as $id => $item)
                        @php $subtotal = $item['price'] * $item['quantity']; $total += $subtotal; @endphp
                        <tr class="border-b border-blue-100 hover:bg-blue-50 transition">
                            <td class="py-4 px-6">
                                <img src="{{ $item['image'] }}" alt="{{ $item['name'] }}" class="h-16 w-16 object-cover rounded-lg border border-blue-100 shadow" />
                            </td>
                            <td class="py-4 px-6 font-semibold text-blue-900">{{ $item['name'] }}</td>
                            <td class="py-4 px-6 text-blue-700 font-bold">Rp{{ number_format($item['price'],0,",",".") }}</td>
                            <td class="py-4 px-6">
                                <form action="{{ route('cart.update', $id) }}" method="POST" class="flex items-center gap-2">
                                    @csrf
                                    <input type="number" name="quantity" min="1" value="{{ $item['quantity'] }}" class="w-16 border border-blue-200 rounded-lg py-1 px-2 text-center focus:ring-2 focus:ring-blue-400 transition" />
                                    <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 rounded-lg font-semibold shadow transition">Update</button>
                                </form>
                            </td>
                            <td class="py-4 px-6 text-blue-700 font-bold">Rp{{ number_format($subtotal,0,",",".") }}</td>
                            <td class="py-4 px-6">
                                <a href="{{ route('cart.remove', $id) }}" class="text-red-600 hover:text-red-800 font-bold text-2xl transition-transform hover:scale-125" title="Hapus">&#10005;</a>
                            </td>
                        </tr>
                        @endforeach
                        <tr>
                            <td colspan="4" class="text-right font-bold py-4 px-6 bg-blue-50 text-blue-900 rounded-bl-xl">Total</td>
                            <td colspan="2" class="font-bold py-4 px-6 bg-blue-50 text-blue-900 rounded-br-xl">Rp{{ number_format($total,0,",",".") }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <div class="mt-8 flex justify-end">
                <button type="submit" class="bg-gradient-to-r from-yellow-400 to-yellow-500 hover:from-yellow-500 hover:to-yellow-400 text-blue-900 font-bold px-8 py-3 rounded-full shadow-lg text-lg flex items-center gap-2 transition-all duration-200 hover:scale-105 focus:outline-none" id="checkout-btn">
                    <span id="checkout-text">Checkout</span>
                    <svg id="loading-spinner" class="hidden animate-spin h-5 w-5 text-blue-900" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                    </svg>
                </button>
            </div>
        </form>
        <script>
            document.getElementById('checkout-form').addEventListener('submit', function() {
                document.getElementById('checkout-text').style.display = 'none';
                document.getElementById('loading-spinner').classList.remove('hidden');
            });
        </script>
        @else
        <div class="max-w-md mx-auto mt-16 bg-white rounded-2xl shadow-xl border border-blue-100 p-10 flex flex-col items-center">
            <svg class="w-20 h-20 text-blue-200 mb-4" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13l-1.35 2.7A2 2 0 007.48 19h8.04a2 2 0 001.83-1.3L17 13M7 13V6h10v7"></path>
            </svg>
            <p class="text-center text-gray-600 text-xl mb-2">Keranjang belanja masih kosong.</p>
            <a href="{{ route('menu.index') }}" class="mt-4 bg-blue-700 hover:bg-blue-800 text-white font-semibold px-6 py-2 rounded-lg shadow transition">Kembali ke Menu</a>
        </div>
        @endif
    </main>

    <footer class="bg-gradient-to-r from-blue-700 via-blue-600 to-blue-500 text-white p-4 text-center mt-10 shadow-inner">
        &copy; 2024 <span class="font-bold">Kantin Online LPKIA</span>
    </footer>

</body>
</html>
