<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $guarded = [];

    // 🚨 1. ผูกความสัมพันธ์กับตาราง User (รู้ว่าใครเป็นคนซื้อ)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // 🚨 2. ผูกความสัมพันธ์กับตาราง Product (รู้ว่าซื้อสินค้าตัวไหนไป)
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // 🚨 3. ผูกความสัมพันธ์กับตาราง Account (รู้ว่าได้ไอดีเกม/พาสเวิร์ดอะไรไป)
    public function account()
    {
        return $this->belongsTo(Account::class);
    }
}
