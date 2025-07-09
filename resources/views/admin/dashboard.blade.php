@extends('layouts.app')

@section('content')
<div class="container mx-auto px-2 sm:px-6 py-6 sm:py-12 max-w-full sm:max-w-4xl">
    <h2 class="text-2xl sm:text-3xl font-bold text-[#FF914D] mb-4 sm:mb-8 text-center">Dashboard Admin</h2>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-8 mb-6 sm:mb-10">
        <a href="{{ route('orders.history', ['filter' => 'day']) }}" class="block bg-white rounded-xl shadow p-4 sm:p-8 border border-[#FFD6A5] hover:shadow-amber-200 hover:-translate-y-2 hover:scale-105 transition-all duration-300 text-center">
            <div class="text-3xl sm:text-4xl mb-1 sm:mb-2">📊</div>
            <div class="font-bold text-base sm:text-lg text-[#FF914D]">Laporan Penjualan</div>
        </a>
        <a href="{{ route('tenant.index') }}" class="block bg-white rounded-xl shadow p-4 sm:p-8 border border-[#FFD6A5] hover:shadow-amber-200 hover:-translate-y-2 hover:scale-105 transition-all duration-300 text-center">
            <div class="text-3xl sm:text-4xl mb-1 sm:mb-2">🏪</div>
            <div class="font-bold text-base sm:text-lg text-[#FF914D]">Manajemen Tenant</div>
        </a>
        <a href="{{ route('admin.menu.management') }}" class="block bg-white rounded-xl shadow p-4 sm:p-8 border border-[#FFD6A5] hover:shadow-amber-200 hover:-translate-y-2 hover:scale-105 transition-all duration-300 text-center">
            <div class="text-3xl sm:text-4xl mb-1 sm:mb-2">🍔</div>
            <div class="font-bold text-base sm:text-lg text-[#FF914D]">Manajemen Menu</div>
        </a>
    </div>
    <div class="bg-white rounded-xl shadow p-4 sm:p-8 border border-[#FFD6A5] mb-8">
        <h3 class="text-xl font-bold text-[#FF914D] mb-4">Pesanan Masuk</h3>
        @php
            $orders = \App\Models\Transaction::whereIn('status', ['proses', 'selesai'])
                ->orderByDesc('created_at')->get();
        @endphp
        @if($orders->isEmpty())
            <div class="text-center text-gray-500">Belum ada pesanan masuk.</div>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full text-sm">
                    <thead>
                        <tr class="bg-[#FFF6E9] text-[#FF914D]">
                            <th class="py-2 px-2">Tanggal</th>
                            <th class="py-2 px-2">User</th>
                            <th class="py-2 px-2">Total</th>
                            <th class="py-2 px-2">Status</th>
                            <th class="py-2 px-2">Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orders as $order)
                        <tr>
                            <td class="py-2 px-2">{{ $order->created_at->format('d M Y H:i') }}</td>
                            <td class="py-2 px-2">{{ $order->user->name ?? '-' }}</td>
                            <td class="py-2 px-2">Rp{{ number_format($order->total,0,',','.') }}</td>
                            <td class="py-2 px-2">
                                <span class="inline-block px-2 py-1 rounded-full text-xs font-bold {{ $order->status == 'proses' ? 'bg-yellow-200 text-yellow-800' : ($order->status == 'selesai' ? 'bg-green-200 text-green-800' : 'bg-gray-200 text-gray-800') }}">
                                    {{ ucfirst($order->status) }}
                                </span>
                            </td>
                            <td class="py-2 px-2">
                                <form action="{{ route('transaction.updateStatus', $order->id) }}" method="POST" class="inline">
                                    @csrf
                                    <select name="status" class="border rounded px-2 py-1 text-xs">
                                        <option value="proses" {{ $order->status == 'proses' ? 'selected' : '' }}>Proses Masak</option>
                                        <option value="selesai" {{ $order->status == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                    </select>
                                    <button type="submit" class="ml-2 bg-[#FF914D] text-white px-3 py-1 rounded text-xs">Update</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
</div>
@endsection
