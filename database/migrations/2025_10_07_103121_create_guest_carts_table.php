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
        Schema::create('guest_carts', function (Blueprint $table) {
            $table->id();
            $table->integer('user_id')->nullable();
            $table->integer('product_id')->nullable();
            $table->integer('variation_id')->nullable();
            $table->decimal('price',8,2)->nullable();
            $table->text('tax')->nullable();
            $table->integer('quantity')->nullable();
            $table->decimal('discount',8,2)->nullable();
            $table->integer('package_charge_id')->nullable();
            $table->text('post_data')->nullable();
            $table->integer('created_by')->nullable();
            $table->integer('update_by')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guest_carts');
    }
};
