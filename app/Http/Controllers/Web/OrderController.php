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
use App\Models\Currency;
use App\Models\StorOrder;
use Session;
use Storage;

class OrderController extends Controller
{
    public function cancelOrder(Request $request)
    {
        $request->validate([
            'order_key' => 'required',
            'cancel_reason' => 'required|string',
        ]);

        StorOrder::where('order_key', $request->order_key)
            ->update([
                'order_status' => 'cancelled',
                'cancel_reason' => $request->cancel_reason,
            ]);

        
        return redirect()->route('CustomerAccount', ['orderKey' => base64_encode($request->order_key)]);
    }

}
