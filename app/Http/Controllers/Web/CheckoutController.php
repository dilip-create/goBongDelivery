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
        // dd($request->all());
        $customerId = $request->session()->get('customerAuth')->id;
        $cartItems = Cart::where('customer_id', $customerId)->where('order_status', 0)->where('food_cart_status', 1)->get();
        if ($cartItems->isEmpty()) {
            return redirect()->route('/');
        }

        $orderKey = $this->generateOrderKey();
        $address = DeliveryAddress::where('cust_id', $customerId)->where('status', 1)->first();
        $customer = Customer::find($customerId);
        $stor = Stor::find($cartItems->first()->stor_id);
        date_default_timezone_set('Asia/Phnom_Penh');
        $order_date=date("Y-m-d h:i:s");

        foreach ($cartItems as $cart) {
            $food = StorFood::find($cart->stor_food_id);

            StorOrder::create([
                'stor_id' => $stor->id,
                'storLoginId' => $stor->storLoginId,
                'cust_id' => $customerId,
                'address_id' => $address->id,
                'order_key' => $orderKey,
                'stor_food_id' => $food->id,
                'cart_id' => $cart->id,
                'f_qty' => $cart->f_qty,
                'total_cost_price' => $request->total_cost_price,
                'subTotal' => $request->sub_total,
                'distance_between_shop_customer' => $request->distance,
                'minimum_order_diffrence' => $request->minimum_order_diffrence,
                'shipping_charge' => $request->shippingCharge,
                'rider_charge' => $request->shippingCharge/2 ?? 0,
                'owncharge_form_riderside' => $request->shippingCharge/2 ?? 0,
                'owncharge_form_storside' => $request->final_amount  -$request->total_cost_price -$request->shippingCharge,
                'new_customer_discount' => $request->new_customer_discount ?? 0,
                'discount_offer' => $request->discount_offer ?? 0,
                'totalPayAmount' => $request->final_amount,
                'currency_id' => $food->currency_id,
                'payment_type' => 'online',
                'order_date' => $order_date,
                'special_instructions' => $request->special_instructions,
                'latitude' => $address->lat,
                'longitude' => $address->long,
            ]);

            $cart->update(['order_status' => 1, 'food_cart_status' => 0,]);
        }

        return redirect()->route('checkout.payment.page', ['orderKey' => base64_encode($orderKey)]);
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

    



}
