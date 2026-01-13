<?php
namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Inertia\Inertia;
use App\Models\Cart;
use App\Models\Stor;
use App\Models\StorFood;
use App\Models\Language;
use Session;

class CartController extends Controller
{
   
    public function getCartList()
    {
        $customerId = session()->has('customerAuth') ? session('customerAuth')->id : session('guest_id');
        $cart = Cart::where('customer_id', $customerId)->first();
    
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


        
        return Inertia::render('Web/Cart', [
            'storData' => $storData,
            'foodLists' => $foodLists,
        ]);

    }

}
