<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product; // ต้องเรียกใช้ Model ด้วย

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            'name' => 'ไอดี PES Full Epic',
            'description' => 'ทีมฟูลตำนาน 11 ตัวจริง',
            'price' => 1290.00,
            'stock' => 5,
            'category' => 'epic',
            'icon' => '⚽',
            'is_hot' => true,
        ]);

        Product::create([
            'name' => 'Messi Big Time',
            'description' => 'แถมทอง 2,000 Coins',
            'price' => 450.00,
            'stock' => 10,
            'category' => 'bigtime',
            'icon' => '🇦🇷',
            'is_hot' => false,
        ]);

        Product::create([
            'name' => 'Starter 10,000 Coins',
            'description' => 'ดองทองไว้เปิดตู้ใหม่',
            'price' => 199.00,
            'stock' => 50,
            'category' => 'starter',
            'icon' => '🪙',
            'is_hot' => true,
        ]);

        Product::create([
            'name' => 'Ronaldinho Milan',
            'description' => 'ตำนานเอซีมิลาน หายาก',
            'price' => 890.00,
            'stock' => 1,
            'category' => 'epic',
            'icon' => '🇧🇷',
            'is_hot' => false,
        ]);
    }
}
