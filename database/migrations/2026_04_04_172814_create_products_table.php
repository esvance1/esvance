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
            Schema::create('products', function (Blueprint $table) {
                $table->id();
                $table->string('name'); // ชื่อไอดี/สินค้า
                $table->text('description')->nullable(); // รายละเอียด
                $table->decimal('price', 8, 2); // ราคา
                $table->integer('stock')->default(1); // จำนวนสต๊อก
                $table->string('category')->default('general'); // หมวดหมู่ เช่น epic, bigtime
                $table->string('icon')->nullable(); // ไอคอน หรือ URL รูปภาพ
                $table->boolean('is_hot')->default(false); // สินค้าขายดีไหม (true/false)
                $table->timestamps();
            });
        }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
