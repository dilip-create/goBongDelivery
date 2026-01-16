<?php
namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Inertia\Inertia;
use App\Models\Cart;
use App\Models\Customer;
use App\Models\Stor;
use App\Models\StorFood;
use App\Models\Language;
use App\Models\DeliveryAddress;
use App\Models\DeliveryCharge;
use App\Models\StorOrder;
use Session;

class CheckoutController extends Controller
{
    public function submitOrder(Request $request)
    {
        // dd("ssssss");
        $customerId = session()->has('customerAuth') ? session('customerAuth')->id : session('guest_id');

        $cartItems = Cart::where('customer_id', $customerId)
            ->where('order_status', 0)
            ->where('food_cart_status', 1)
            ->get();

        if ($cartItems->isEmpty()) {
            return redirect()->route('/');
        }

        $orderKey = $this->generateOrderKey();
        $address = DeliveryAddress::where('cust_id', $customerId)->where('status', 1)->first();
        $customer = Customer::find($customerId);
        $stor = Stor::find($cartItems->first()->stor_id);

        $distance = $this->distanceInKm(
            $stor->stor_lat,
            $stor->stor_long,
            $customer->lat,
            $customer->long
        );

        foreach ($cartItems as $cart) {
            $food = StorFood::find($cart->stor_food_id);

            $quantity = $cart->f_qty;
            $costPrice = $food->cost_price * $quantity;
            $subTotal = $food->selling_price * $quantity;

            /** Delivery calculation **/
            if ($stor->cuisine === 'Laundry') {

                $DeliveryChargeTbl = DeliveryCharge::where('delivery_type', 'Laundry')->where('active_plan', 1)->first();
                $delivery = $this->laundryDeliveryCharge($distance);
                $shippingCharge = 0;
                $riderCharge = $delivery['rider_charge'];
            } else {
                $DeliveryChargeTbl = DeliveryCharge::where('delivery_type', 'food')->where('active_plan', 1)->first();
                $shippingCharge = $this->calculateShippingCharge(2.0);
                $riderCharge = $this->calculateRiderCharge($distance);
            }

            /** Own charge **/
            $ownChargeStor = $subTotal - $costPrice;
            $ownChargeRider = $shippingCharge / 2;

            $totalPayAmount = $subTotal + $shippingCharge;

            StorOrder::create([
                'stor_id' => $stor->id,
                'storLoginId' => $stor->storLoginId,
                'stor_food_id' => $food->id,
                'cart_id' => $cart->id,
                'cust_id' => $customerId,
                'address_id' => $address->id,
                'order_key' => $orderKey,
                'quantity' => $quantity,
                'subTotal' => $subTotal,
                'new_customer_discount' => $DeliveryChargeTbl->new_customer_discount ?? 0,
                'discount_offer' => $DeliveryChargeTbl->discount_offer ?? 0,
                'cost_price' => $costPrice,
                'distance_between_shop_customer' => $distance,
                'shipping_charge' => $shippingCharge,
                'rider_charge' => $riderCharge,
                'own_charge' => $ownChargeStor + $ownChargeRider,
                'totalPayAmount' => $totalPayAmount,
                'currency' => $food->currency_id ?? 'THB',
                'currency_symbol' => '฿',
                'order_status' => 'pending',
                'special_instructions' => $request->special_instructions,
                'latitude' => $customer->lat,
                'longitude' => $customer->long,
            ]);

            $cart->update(['order_status' => 1, 'food_cart_status' => 0,]);
        }

        return redirect()->route('payment.page', ['order_key' => $orderKey]);
    }
    
    // Order Key Generator (BNG-0001)
    private function generateOrderKey()
    {
        $lastOrder = StorOrder::orderBy('id', 'desc')->first();

        if (!$lastOrder) {
            return 'BNG-0001';
        }

        $number = (int) str_replace('BNG-', '', $lastOrder->order_key);
        return 'BNG-' . str_pad($number + 1, 4, '0', STR_PAD_LEFT);
    }


    // Distance Calculation (Haversine – backup for Google API)
    private function distanceInKm($lat1, $lon1, $lat2, $lon2)
    {
        // $earthRadius = 6371;

        // $dLat = deg2rad($lat2 - $lat1);
        // $dLon = deg2rad($lon2 - $lon1);

        // $a = sin($dLat / 2) ** 2 +
        //     cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
        //     sin($dLon / 2) ** 2;

        // $c = 2 * asin(sqrt($a));

        // return round($earthRadius * $c, 3);
        return 2.0;
    }


    // Delivery Charge Rules (Normal Orders)
    private function calculateShippingCharge($distance)
    {

        if ($distance <= 0.5) {
            return 0;
        }

        if ($distance <= 2) {
            return 20;
        }

        return round($distance * 10); // 2.1km → 21, 2.5km → 25
    }

    // Rider Charge Calculation
    private function calculateRiderCharge($distance)
    {
        return round($distance * 5, 2); // 1km = 5 bhat
    }


    // Laundry Delivery Logic (IMPORTANT)
    private function laundryDeliveryCharge($distance)
    {
        // Laundry:
        // customer pays 0
        // rider gets 20 bhat per km
        return [
            'shipping_charge' => 0,
            'rider_charge' => round($distance * 20, 2),
        ];
    }

    



}
