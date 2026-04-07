<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // เพิ่มช่อง usage_type ในตารางบัญชี เพื่อบอกว่าไอดีนี้เอาไว้ทำอะไร
        Schema::table('accounts', function (Blueprint $table) {
            $table->string('usage_type')->default('sale')->after('product_id');
        });

        // เพิ่มช่องเก็บตัวเลขสต็อกกาชา ในตารางสินค้า
        Schema::table('products', function (Blueprint $table) {
            $table->integer('stock_gacha')->default(0)->after('stock');
        });
    }

    public function down(): void
    {
        Schema::table('accounts', function (Blueprint $table) {
            $table->dropColumn('usage_type');
        });
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn('stock_gacha');
        });
    }
};
