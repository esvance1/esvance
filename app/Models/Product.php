<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    // อนุญาตให้บันทึกข้อมูลได้ทุกคอลัมน์ (รวมถึง is_visible ด้วย)
    protected $guarded = [];

    public function category() {
        return $this->belongsTo(Category::class);
    }

    // เผื่อใช้เช็คว่าสินค้านี้ไปอยู่ในตู้สุ่มไหนบ้าง
    public function gachaItems() {
        return $this->hasMany(RandomBoxItem::class);
    }
}
