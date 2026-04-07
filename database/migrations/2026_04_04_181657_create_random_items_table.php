<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('random_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('random_box_id')->constrained()->cascadeOnDelete();

            // 🚨 1. เติม ->nullable() เข้าไปตรงนี้ เพื่อให้ระบบ "เกลือ" ทำงานได้ (ไม่ต้องโยงกับสินค้า)
            $table->foreignId('product_id')->nullable()->constrained()->cascadeOnDelete();

            $table->integer('weight');
            $table->string('rarity')->default('common');

            // 🚨 2. เพิ่มบรรทัดนี้ลงไป เพื่อรองรับปุ่ม เปิด/ปิด ของรางวัลในหน้าแอดมิน
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('random_items');
    }
};
