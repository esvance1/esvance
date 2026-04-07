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
        Schema::create('drop_stats', function (Blueprint $table) {
            $table->id();
            $table->foreignId('random_item_id')->constrained();
            $table->integer('total_drops')->default(0); // ออกไปแล้วกี่ครั้ง
            $table->integer('total_attempts')->default(0); // สุ่มไปแล้วกี่ครั้ง
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('drop_stats');
    }
};
