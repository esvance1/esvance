<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RandomBox extends Model
{
    use HasFactory;

    protected $guarded = []; // ที่เราเพิ่งเติมไปเมื่อกี้

    // 👈 เติมฟังก์ชันนี้เข้าไปครับ เพื่อบอกว่า 1 ตู้ มีของรางวัลได้หลายชิ้น (hasMany)
    public function items()
    {
        return $this->hasMany(RandomItem::class);
    }
    protected static function booted()
    {
        static::deleting(function ($item) {
            // ก่อนจะลบไอเทมชิ้นนี้ ให้ไปเคลียร์ประวัติในตาราง drop_stats ก่อน
            DB::table('drop_stats')->where('random_item_id', $item->id)->delete();
        });
    }
}
