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
        Schema::create('stors', function (Blueprint $table) {
            $table->id();
            $table->string('storLoginId')->nullable();
            $table->string('area')->nullable();
            $table->string('stor_photo')->nullable();
            $table->string('stor_type')->nullable();
            $table->string('cuisine')->nullable(); 
            $table->string('stor_mobile')->nullable();
            $table->string('commission_type')->nullable();
            $table->string('shop_commission')->nullable();
            $table->string('opentime')->nullable();
            $table->string('closetime')->nullable();
            $table->string('stor_lat')->nullable();
            $table->string('stor_long')->nullable();
            $table->string('distance_from_office')->nullable();
            $table->string('openStatus')->default(true);
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stors');
    }
};
