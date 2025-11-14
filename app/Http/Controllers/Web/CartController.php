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
    // public function getCartCount()
    // {
    //     $customerId = 1; // dummy customer
    //     $count = Cart::where('customer_id', $customerId)->sum('f_qty');

    //     return response()->json(['count' => $count]);
    // }

}
