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
        Schema::create('delivery_charges', function (Blueprint $table) {
            $table->id();
            $table->string('delivery_type')->nullable();
            $table->string('distance_in_km')->nullable();
            $table->string('new_customer_discount')->nullable();
            $table->string('discount_offer')->nullable();
            $table->string('shipping_charge')->nullable();
            $table->string('rider_charge')->nullable();
            $table->string('own_charge')->nullable();
            $table->integer('active_plan')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('delivery_charges');
    }
};
