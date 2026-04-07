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
    Schema::table('orders', function (Blueprint $table) {
        $table->string('api_order_id')->nullable()->after('id'); // ID ออร์เดอร์จาก WichxShop
        $table->string('api_claim_status')->default('NOT_CLAIMED')->after('api_order_id'); // สถานะเคลมจากต้นทาง
    });
}
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('orders', function (Blueprint $table) {
            //
        });
    }
};
