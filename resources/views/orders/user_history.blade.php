@extends('layouts.app')

@section('content')
<div class="container mx-auto px-6 py-12 max-w-3xl">
    <h2 class="text-3xl font-bold text-[#FF914D] mb-8 text-center">Riwayat Pembelian Saya</h2>
    @if($transactions->isEmpty())
        <div class="text-center text-gray-500">Belum ada riwayat pembelian.</div>
    @else
        <div class="space-y-6">
            @foreach($transactions as $trx)
                <div class="bg-white rounded-xl shadow p-6 border border-[#FFD6A5]">
                    <div class="flex justify-between mb-2">
                        <span class="font-semibold text-[#FF914D]">Tanggal:</span>
                        <span>{{ $trx->created_at->format('d M Y H:i') }}</span>
                    </div>
                    <div class="mb-2">
                        <span class="font-semibold text-[#FF914D]">Total:</span>
                        <span>Rp{{ number_format($trx->total,0,',','.') }}</span>
                    </div>
                    <div>
                        <span class="font-semibold text-[#FF914D]">Item:</span>
                        <ul class="list-disc ml-6">
                            @foreach($trx->items as $item)
                                <li>{{ $item->menu->name }} x{{ $item->quantity }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
