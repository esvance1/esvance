<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\RandomBox;
use App\Models\RandomItem;
use App\Models\Product;

class GachaSeeder extends Seeder
{
    public function run(): void
    {
        // 1. สร้างตู้สุ่ม 1 ตู้ (สุ่ม 10 ครั้ง การันตีออกของแรร์)
        $box = RandomBox::create([
            'name' => 'กล่องสุ่ม VIP S-Class',
            'price' => 299.00,
            'pity_limit' => 10,
            'icon' => '📦',
            'is_vip' => true,
        ]);

        // 2. ดึงสินค้าที่มีอยู่ในร้านมาใส่เป็นของรางวัล
        $products = Product::all();

        if($products->count() >= 3) {
            // รางวัลเกลือ (ออกง่าย 70%)
            RandomItem::create([
                'random_box_id' => $box->id,
                'product_id' => $products[2]->id,
                'weight' => 70,
                'rarity' => 'common',
            ]);

            // รางวัลดี (ออกปานกลาง 25%)
            RandomItem::create([
                'random_box_id' => $box->id,
                'product_id' => $products[1]->id,
                'weight' => 25,
                'rarity' => 'epic',
            ]);

            // รางวัลแรร์ (แจ็คพอต 5% - ถ้ากดจนครบ Pity จะการันตีแจกตัวนี้)
            RandomItem::create([
                'random_box_id' => $box->id,
                'product_id' => $products[0]->id,
                'weight' => 5,
                'rarity' => 'legendary',
            ]);
        }
    }
}
