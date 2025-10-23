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
        Schema::create('stor_foods', function (Blueprint $table) {
            $table->id();
            $table->string('storLoginId')->nullable();
            $table->string('stor_id')->nullable();
            $table->string('category_id')->nullable();
            $table->string('food_name')->nullable();
            $table->string('food_img')->nullable();
            $table->string('cost_price')->nullable();
            $table->string('selling_price')->nullable();
            $table->string('currency_id')->nullable();
            $table->string('ordering')->nullable();
            $table->string('trending_status')->default(true);
            $table->string('status')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stor_foods');
    }
};
