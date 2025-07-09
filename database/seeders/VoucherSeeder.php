<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Voucher;

class VoucherSeeder extends Seeder
{
    public function run(): void
    {
        Voucher::create([
            'code' => 'DISKON10',
            'description' => 'Diskon 10%',
            'discount' => 10,
            'type' => 'percent',
            'is_active' => true,
            'expired_at' => now()->addMonth(),
        ]);
        Voucher::create([
            'code' => 'POTONGAN5000',
            'description' => 'Potongan Rp5.000',
            'discount' => 5000,
            'type' => 'nominal',
            'is_active' => true,
            'expired_at' => now()->addMonth(),
        ]);
    }
}
