<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RateHistory extends Model
{
    use HasFactory;

    protected $guarded = [];

    // 🚨 เติมบรรทัดนี้ลงไป เพื่อบอก Laravel ว่าตารางเราชื่อนี้เป๊ะๆ นะ (ไม่ต้องเปลี่ยนเป็น ies)
    protected $table = 'rate_history';
}
