<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class WichxShopApi
{
    protected $baseUrl;
    protected $apiKey;

    public function __construct()
    {
        $this->baseUrl = env('WICHXSHOP_API_URL');
        $this->apiKey = env('WICHXSHOP_API_KEY');
    }

    // แนบ Header ไปกับทุก Request
    protected function request()
    {
        return Http::withHeaders([
            'x-api-key' => $this->apiKey,
            'Accept' => 'application/json',
        ]);
    }

    // 1. เช็คยอดเงินคงเหลือ
    public function getBalance()
    {
        return $this->request()->get("{$this->baseUrl}/balance")->json();
    }

    // 2. ดึงรายการสินค้าทั้งหมด
    public function getProducts()
    {
        return $this->request()->get("{$this->baseUrl}/store/product")->json();
    }

    // 3. สั่งซื้อสินค้า
    public function buyProduct($productId, $quantity = 1)
    {
        return $this->request()->post("{$this->baseUrl}/store/buy", [
            'productId' => $productId,
            'quantity' => $quantity
        ])->json();
    }
    // 4. ขอเคลมสินค้า (ส่ง Order ID ของเว็บต้นทาง และเหตุผลไป)
    public function claimProduct($orderId, $reason)
    {
        return $this->request()->post("{$this->baseUrl}/store/claim/{$orderId}", [
            'reason' => $reason
        ])->json();
    }

    // 5. ดูประวัติการซื้อจากร้านต้นทาง (เผื่อแอดมินใช้เช็คสถานะเคลม)
    public function getHistory($page = 1, $perPage = 50)
    {
        return $this->request()->get("{$this->baseUrl}/store/history", [
            'page' => $page,
            'per_page' => $perPage
        ])->json();
    }

    // 6. ดึง OTP Netflix
    public function getNetflixOtp($email)
    {
        return $this->request()->get("{$this->baseUrl}/tools/netflix-otp", [
            'email' => $email
        ])->json();
    }

    // 7. ดึง OTP Rockstar
    public function getRockstarOtp($refreshToken, $clientId)
    {
        return $this->request()->get("{$this->baseUrl}/tools/rockstar-otp", [
            'refreshToken' => $refreshToken,
            'clientId' => $clientId
        ])->json();
    }

}
