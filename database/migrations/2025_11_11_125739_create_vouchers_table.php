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
        Schema::create('vouchers', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->enum('type', ['fixed', 'percent'])->default('fixed'); // discount type
            $table->decimal('value', 10, 2); // discount amount or percent
            $table->decimal('min_order_amount', 10, 2)->nullable(); // optional minimum
            $table->integer('max_uses')->default(0); // 0 = unlimited
            $table->integer('used_count')->default(0);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->tinyInteger('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vouchers');
    }
};
