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
    Schema::table('products', function (Blueprint $table) {
        $table->string('api_product_id')->nullable()->after('id'); // รหัสสินค้าจากร้านต้นทาง
        $table->boolean('is_api_product')->default(false)->after('api_product_id'); // เช็คว่าเป็นของ API ไหม
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            //
        });
    }
};
