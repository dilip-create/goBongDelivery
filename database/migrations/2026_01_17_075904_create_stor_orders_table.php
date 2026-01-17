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
        Schema::create('stor_orders', function (Blueprint $table) {
            $table->id();
            $table->string('stor_id')->nullable();
            $table->string('storLoginId')->nullable();
            $table->string('cust_id')->nullable();
            $table->string('address_id')->nullable();
            $table->string('order_key')->nullable();
            $table->string('stor_food_id')->nullable();
            $table->string('cart_id')->nullable();
            $table->string('total_cost_price')->nullable();
            $table->string('subTotal')->nullable();
            $table->string('distance_between_shop_customer')->nullable();
            $table->string('minimum_order_diffrence')->nullable();
            $table->string('shipping_charge')->nullable();
            $table->string('rider_charge')->nullable();
            $table->string('owncharge_form_riderside')->nullable();
            $table->string('owncharge_form_storside')->nullable();
            $table->string('new_customer_discount')->nullable();
            $table->string('discount_offer')->nullable();
            $table->string('totalPayAmount')->nullable();
            $table->string('currency_id')->nullable();
            $table->string('TransactionId')->nullable();
            $table->string('payment_type')->nullable();
            $table->string('payment_status')->default('pending');
            $table->longText('response_all')->nullable();
            $table->longText('attach_slip')->nullable();
            $table->string('payment_time')->nullable();
            $table->string('gateway_name')->nullable();
            $table->string('order_status')->default('pending');
            $table->string('order_date')->nullable();
            $table->string('rider_id')->nullable();
            $table->longText('special_instructions')->nullable();
            $table->enum('assign_status', ['pending', 'assigntoRider', 'acceptedbyRider', 'riderGoingToStor', 'arrivedatstor', 'onthewayToDeliver', 'arrivedatLocation', 'delivered', 'cancelled'])->default('pending');
            $table->longText('cancel_reason')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stor_orders');
    }
};
