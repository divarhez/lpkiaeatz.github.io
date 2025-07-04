@extends('layouts.app')

@section('content')
<div class="container mx-auto px-2 sm:px-6 py-6 sm:py-12 max-w-full sm:max-w-4xl">
    <h2 class="text-2xl sm:text-3xl font-bold text-[#FF914D] mb-4 sm:mb-8 text-center">Laporan Penjualan
        <form method="GET" class="inline-block ml-2 sm:ml-4">
            <select name="filter" onchange="this.form.submit()" class="border rounded px-2 py-1">
                <option value="day" {{ $filter == 'day' ? 'selected' : '' }}>Per Hari</option>
                <option value="month" {{ $filter == 'month' ? 'selected' : '' }}>Per Bulan</option>
            </select>
        </form>
    </h2>
    @if($reports->isEmpty())
        <div class="text-center text-gray-500">Belum ada data penjualan.</div>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-xl shadow border border-[#FFD6A5] text-xs sm:text-base">
                <thead>
                    <tr class="bg-[#FFF6E9] text-[#FF914D]">
                        <th class="py-2 px-2 sm:px-4">Periode</th>
                        <th class="py-2 px-2 sm:px-4">Total Pesanan</th>
                        <th class="py-2 px-2 sm:px-4">Total Penjualan</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reports as $row)
                        <tr>
                            <td class="py-2 px-2 sm:px-4">{{ $row->period }}</td>
                            <td class="py-2 px-2 sm:px-4">{{ $row->total_orders }}</td>
                            <td class="py-2 px-2 sm:px-4">Rp{{ number_format($row->total_sales,0,',','.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
