<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Menu;

class MenuSeeder extends Seeder
{
    public function run()
    {
        Menu::create([
            'name' => 'Nasi Goreng',
            'category' => 'Makanan',
            'description' => 'Nasi goreng dengan ayam dan sayuran.',
            'price' => 15000,
            'image' => 'https://example.com/nasi-goreng.jpg'
        ]);

        Menu::create([
            'name' => 'Mie Goreng',
            'category' => 'Makanan',
            'description' => 'Mie goreng dengan telur dan sayuran.',
            'price' => 12000,
            'image' => 'https://example.com/mie-goreng.jpg'
        ]);

        // Tambahkan menu lainnya sesuai kebutuhan
    }
}
