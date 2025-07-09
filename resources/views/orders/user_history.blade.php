@extends('layouts.app')

@section('content')
<div class="container mx-auto px-2 sm:px-6 py-6 sm:py-12 max-w-full sm:max-w-3xl">
    <h2 class="text-2xl sm:text-3xl font-bold text-[#FF914D] mb-4 sm:mb-8 text-center">Riwayat Pembelian Saya</h2>
    @if($transactions->isEmpty())
        <div class="text-center text-gray-500">Belum ada riwayat pembelian.</div>
    @else
        <div class="space-y-4 sm:space-y-6">
            @foreach($transactions as $trx)
                <div class="bg-white rounded-xl shadow p-4 sm:p-6 border border-[#FFD6A5]">
                    <div class="flex flex-col sm:flex-row sm:justify-between mb-2 gap-1 sm:gap-0">
                        <span class="font-semibold text-[#FF914D]">Tanggal:</span>
                        <span>{{ $trx->created_at->format('d M Y H:i') }}</span>
                    </div>
                    <div class="mb-2">
                        <span class="font-semibold text-[#FF914D]">Total:</span>
                        <span>Rp{{ number_format($trx->total,0,',','.') }}</span>
                    </div>
                    <div>
                        <span class="font-semibold text-[#FF914D]">Item:</span>
                        <ul class="list-disc ml-4 sm:ml-6 text-sm sm:text-base">
                            @foreach($trx->items as $item)
                                <li>
                                    {{ $item->menu->name }} x{{ $item->quantity }}
                                    @if(is_null($item->rating))
                                        <form action="{{ route('transaction-items.rate', $item->id) }}" method="POST" class="inline-block ml-2">
                                            @csrf
                                            <label for="rating-{{ $item->id }}" class="text-xs text-gray-600">Beri rating:</label>
                                            <select name="rating" id="rating-{{ $item->id }}" class="border rounded px-1 py-0.5 text-xs">
                                                <option value="">-</option>
                                                @for($i=1; $i<=5; $i++)
                                                    <option value="{{ $i }}">{{ $i }}</option>
                                                @endfor
                                            </select>
                                            <button type="submit" class="bg-[#FF914D] text-white rounded px-2 py-0.5 text-xs ml-1">Kirim</button>
                                        </form>
                                    @else
                                        <span class="ml-2 text-green-600 text-xs">Rating: {{ $item->rating }}</span>
                                    @endif
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
