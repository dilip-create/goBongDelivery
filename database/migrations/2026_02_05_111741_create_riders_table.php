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
        Schema::create('riders', function (Blueprint $table) {
            $table->id();
            $table->string('riderLoginId')->nullable();
            $table->string('riderBoyId')->nullable();
            $table->string('name')->nullable();
            $table->string('mobile')->nullable();
            $table->string('plate_number')->nullable();
            $table->string('address')->nullable();
            $table->string('location')->nullable();
            $table->string('lat')->nullable();
            $table->string('long')->nullable();
            $table->string('status')->default(true);
            $table->string('available_for_delivery')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riders');
    }
};
