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
        Schema::create('tips', function (Blueprint $table) {
            $table->id();
            $table->string('order_key')->nullable();
            $table->string('stor_id')->nullable();
            $table->string('cust_id')->nullable();
            $table->string('rider_id')->nullable();
            $table->string('amount')->nullable();
            $table->string('desc')->nullable();
            $table->string('currency_id')->nullable();
            $table->string('TransactionId')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('payment_status')->default('pending');
            $table->longText('response_all')->nullable();
            $table->longText('attach_slip')->nullable();
            $table->string('payment_time')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tips');
    }
};
