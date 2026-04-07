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
        Schema::create('rate_history', function (Blueprint $table) {
            $table->id();
            $table->foreignId('random_box_id')->constrained();
            $table->foreignId('random_item_id')->constrained();
            $table->integer('old_weight');
            $table->integer('new_weight');
            $table->foreignId('changed_by')->constrained('users'); // ใครเป็นคนแก้
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rate_histories');
    }
};
