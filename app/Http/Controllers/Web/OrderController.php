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
use Carbon\Carbon;

class OrderController extends Controller
{

    public function orderStatus($orderKey)
    {
        $decodedKey = base64_decode($orderKey);

        $order = StorOrder::where('order_key', $decodedKey)->firstOrFail();

        $isToday = Carbon::parse($order->order_date)->isToday();

        return response()->json([
            'order_status'   => $order->order_status,
            'payment_status' => $order->payment_status,
            'assign_status'  => $order->assign_status,
            'distance'       => (float) $order->distance_between_shop_customer,
            'order_date'     => $order->order_date,
            'is_today'       => $isToday,
        ]);
    }

    public function orderDetailsPagefun($orderKey, Request $request)
    {
        $orderKey= base64_decode($orderKey);
        $customerId = $request->session()->get('customerAuth')->id;
        $OrderData = StorOrder::select('*')->where([
                                                'cust_id'=> $customerId,
                                                'order_key'=> $orderKey ])->first();
       
        if(empty($OrderData)){
            return redirect()->route('customerLogin');
        }
        $shipAddress = DeliveryAddress::where('id', $OrderData->address_id)->where('status', '1')->first();
        $storData = Stor::where('id', $OrderData->stor_id)->with('translationforvuepage')->first();
        $currencyData = Currency::where('id', $OrderData->currency_id)->first();
         
        $foodLists = StorOrder::with([
                                'stor_food_records.translationforvuepage',
                                'stor_food_records.getCurrencies',
                                'cartdetails'
                            ])
                            ->where('cust_id', $customerId)
                            ->where('order_key', $orderKey)
                            ->get();
        // dd($foodLists);

        return Inertia::render('Web/OrderDetailsPage', [
            'OrderData' => $OrderData,
            'shipAddress' => $shipAddress,
            'storData' => $storData,
            'foodLists' => $foodLists,
            'currencyData' => $currencyData
            
        ]);

    }

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
