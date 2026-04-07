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
        Schema::create('accounts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete(); // ไอดีนี้คือสินค้าตัวไหน
            $table->string('game_username'); // ไอดีเกม
            $table->text('game_password'); // รหัสผ่าน (จะถูกเข้ารหัสระดับสูง)
            $table->enum('status', ['available', 'sold'])->default('available'); // ว่าง / ขายแล้ว
            $table->timestamp('sold_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('accounts');
    }
};
