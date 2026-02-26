<?php
namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Inertia\Inertia;
use App\Models\Cart;
use App\Models\Stor;
use App\Models\StorFood;
use App\Models\Language;
use App\Models\DeliveryAddress;
use App\Models\DeliveryCharge;
use App\Models\Customer;
use App\Models\StorOrder;
use Session;

class CartController extends Controller
{
   
    public function getCartList()
    {
        $customerId = session()->has('customerAuth') ? session('customerAuth')->id : session('guest_id');
        $cart = Cart::where('customer_id', $customerId)->where('order_status', '0')->where('food_cart_status', '1')->first();

        if(empty($cart)){
            return redirect()->route('/');
        }
        $shipAddress = DeliveryAddress::where('cust_id', $customerId)->where('status', '1')->first();
        $storData = Stor::where('id', $cart->stor_id)->with('translationforvuepage')->first();
        $customer = Customer::find($customerId);

        $distance = $this->distanceInKm(
            $storData->stor_lat,
            $storData->stor_long,
            $customer->lat,
            $customer->long
        );
        if ($storData->cuisine === 'Laundry') {

            $DeliveryChargeTbl = DeliveryCharge::where('delivery_type', 'Laundry')->where('active_plan', 1)->first();
            $shippingCharge = 0;
            
        } else {

            $DeliveryChargeTbl = DeliveryCharge::where('delivery_type', 'food')->where('active_plan', 1)->first();
            $shippingCharge = $this->calculateShippingCharge($distance);
            
        }

        $foodLists = StorFood::join('carts', 'stor_foods.id', '=', 'carts.stor_food_id')
            ->where('carts.customer_id', $customerId)
            ->where('carts.order_status', 0)
            ->where('carts.food_cart_status', 1)
            ->where('stor_foods.status', 1)
            ->with(['translationforvuepage', 'getCurrencies'])
            ->orderBy('carts.id', 'desc')
            ->select([
                'stor_foods.*',
                'carts.id as cart_id',
                'carts.f_qty',
                'carts.order_status',
                'carts.food_cart_status',
                'carts.created_at as cart_created_at',
            ])
            ->get();

        $subTotal = $foodLists->sum(function ($food) {
            return ($food->selling_price ?? 0) * ($food->f_qty ?? 1);
        });
        $total_cost_price = $foodLists->sum(function ($food) {
            return ($food->cost_price ?? 0) * ($food->f_qty ?? 1);
        });

        // if order amount less then 60 bhat START
        if($subTotal < 60 ){
            $minimum_order_diffrence = 60 - $subTotal;
        }else{
            $minimum_order_diffrence =  0;
        }


        // offer will be apply if order amount greater then 100 START
        $isNewCustomer = StorOrder::where('cust_id', $customerId)->exists();

        if($subTotal > 100){
            $discount_offer = $DeliveryChargeTbl->discount_offer ?? 0;
            if(empty($isNewCustomer)){
                $newCustomerDiscount = $DeliveryChargeTbl->new_customer_discount ?? 0;
            }else{
                $newCustomerDiscount =  0;
            }
            
            
        }else{
            $newCustomerDiscount =  0;
            $discount_offer =  0;
        }
        // offer will be apply if order amount greater then 100 START

        

        $finalAmount = max(
            ($subTotal + $shippingCharge + $minimum_order_diffrence - $newCustomerDiscount - $discount_offer),
            0 // prevent negative total
        );


        return Inertia::render('Web/Cart', [
            'shipAddress' => $shipAddress ?? '',
            'storData' => $storData,
            'foodLists' => $foodLists,
             'summary' => [
                'total_cost_price' => $total_cost_price,
                'sub_total' => $subTotal,
                'distance' => $distance,
                'shippingCharge' => $shippingCharge,
                'minimum_order_diffrence' => $minimum_order_diffrence,
                'new_customer_discount' => $newCustomerDiscount,
                'discount_offer' => $discount_offer,
                'final_amount' => $finalAmount,
            ]
        ]);

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
        return round($distance * 10); // 2.1km → 21, 2.5km → 25
    }

    public function destroy($id)
    {
        Cart::where('id', $id)->delete();
        $this->getCartList();
        return response()->json([
            'status' => true,
            'message' => 'This item deleted'
        ]);
        
    }


}
