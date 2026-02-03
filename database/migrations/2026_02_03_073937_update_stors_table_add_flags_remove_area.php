<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('stors', function (Blueprint $table) {
            // Add new columns after closetime
            $table->boolean('new_arrival')->default(true)->after('closetime');
            $table->boolean('super_promo')->default(false)->after('new_arrival');
            $table->boolean('international')->default(false)->after('super_promo');

            // Remove area column
            $table->dropColumn('area');
        });
    }

    public function down(): void
    {
        Schema::table('stors', function (Blueprint $table) {
            // Re-add area column
            $table->string('area')->nullable();

            // Drop newly added columns
            $table->dropColumn(['new_arrival', 'super_promo', 'international']);
        });
    }
};

