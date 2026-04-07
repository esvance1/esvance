<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Account extends Model
{
    protected $guarded = [];

    // 🛡️ อัปเกรดความปลอดภัย: ให้ Laravel เข้ารหัส Password ในฐานข้อมูลอัตโนมัติ!
    protected $casts = [
        'game_password' => 'encrypted',
    ];
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
