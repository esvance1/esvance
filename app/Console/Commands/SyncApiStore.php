<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\WichxShopApi;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\Http;

class SyncApiStore extends Command
{
    // ชื่อคำสั่งสำหรับเรียกใช้บอท
    protected $signature = 'api:sync-store';

    // คำอธิบาย
    protected $description = 'ซิงค์สต๊อกสินค้าและสถานะเคลมจาก API อัตโนมัติ';

    public function handle(WichxShopApi $api)
    {
        $this->info('🤖 บอทกำลังเริ่มทำงาน: ดึงข้อมูลจาก API...');

        // -----------------------------------------
        // 1. ซิงค์สต๊อกสินค้า
        // -----------------------------------------
        $this->info('📦 กำลังเช็คสต๊อก...');
        $apiResponse = $api->getProducts();

        if (isset($apiResponse['success']) && $apiResponse['success']) {
            $stockCount = 0;
            foreach ($apiResponse['data'] as $apiItem) {
                $product = Product::where('api_product_id', $apiItem['id'])->first();
                // อัปเดตเฉพาะตัวที่สต๊อกไม่ตรงกัน (ประหยัดพลังงาน Database)
                if ($product && $product->stock !== $apiItem['stock']) {
                    $product->update(['stock' => $apiItem['stock']]);
                    $stockCount++;
                }
            }
            $this->info("✅ อัปเดตสต๊อกสำเร็จ: $stockCount รายการ");
        } else {
            $this->error('❌ ดึงข้อมูลสต๊อกล้มเหลว!');
        }

        // -----------------------------------------
        // 2. ซิงค์สถานะการเคลม
        // -----------------------------------------
        $this->info('🔄 กำลังเช็คสถานะงานเคลม (PENDING)...');
        $pendingOrders = Order::where('api_claim_status', 'PENDING')->whereNotNull('api_order_id')->get();
        $claimCount = 0;

        foreach ($pendingOrders as $order) {
            $res = Http::withHeaders(['x-api-key' => env('WICHXSHOP_API_KEY')])
                    ->get(env('WICHXSHOP_API_URL')."/store/history/{$order->api_order_id}")->json();

            if (isset($res['success']) && $res['success']) {
                $newStatus = $res['data']['claimStatus'];

                if ($newStatus !== $order->api_claim_status) {
                    $order->update(['api_claim_status' => $newStatus]);
                    $claimCount++;
                }
            }
        }
        $this->info("✅ อัปเดตสถานะเคลมให้ลูกค้าสำเร็จ: $claimCount รายการ");

        $this->info('🏁 บอททำงานเสร็จสมบูรณ์!');
    }
}
