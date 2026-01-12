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
        $cart = Cart::where('customer_id', $customerId)->get();

        // dd($cart);
        return Inertia::render('Web/Cart', [
          
         
            'carts' => $cart,
           
            
        ]);

    }

}
