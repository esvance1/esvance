<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RandomItem extends Model
{
    use HasFactory;

    protected $guarded = [];

    // 🚨 เติมฟังก์ชันนี้ลงไปครับ เพื่อบอกว่าไอเทมชิ้นนี้เชื่อมกับ Product ตัวไหน
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
