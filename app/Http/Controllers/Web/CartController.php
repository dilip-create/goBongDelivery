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
        $shippingCost = 10;
        $newCustomerDiscount = 20;

        $finalAmount = max(
            ($subTotal + $shippingCost - $newCustomerDiscount),
            0 // prevent negative total
        );


        return Inertia::render('Web/Cart', [
            'shipAddress' => $shipAddress,
            'storData' => $storData,
            'foodLists' => $foodLists,
             'summary' => [
                'sub_total' => $subTotal,
                'shipping_cost' => $shippingCost,
                'new_customer_discount' => -$newCustomerDiscount,
                'final_amount' => $finalAmount,
            ]
        ]);

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
