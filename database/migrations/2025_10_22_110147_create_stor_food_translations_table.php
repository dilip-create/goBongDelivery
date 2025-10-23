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
        Schema::create('stor_food_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\StorFood::class)->constrained()->cascadeOnDelete();
            $table->foreignIdFor(\App\Models\Language::class)->constrained()->cascadeOnDelete();
            $table->string('food_translation_name')->nullable();
            $table->longText('food_desc')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stor_food_translations');
    }
};
