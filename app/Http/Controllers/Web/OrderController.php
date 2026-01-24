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
        // ✅ Set timezone
        date_default_timezone_set('Asia/Phnom_Penh');

        $order = StorOrder::where('order_key', base64_decode($orderKey))->firstOrFail();

        // Example: minutes delivery
        $estimatedMinutes = $order->distance_between_shop_customer*10;

        // Delivery started time (store once in DB)
        if (!$order->delivery_started_at && $order->assign_status === 'onthewayToDeliver') {
            $order->delivery_started_at = now();
            $order->save();
        }

        $remainingSeconds = null;

        if ($order->delivery_started_at) {
            $startedAt = Carbon::parse($order->delivery_started_at, 'Asia/Phnom_Penh');
            $now = Carbon::now('Asia/Phnom_Penh');

            $totalSeconds = (int) ($estimatedMinutes * 60);
            $passedSeconds = (int) $startedAt->diffInSeconds($now);

            $remainingSeconds = max($totalSeconds - $passedSeconds, 0);
        }

        return response()->json([
            'assign_status' => $order->assign_status,
            'payment_status' => $order->payment_status,
            'order_status' => $order->order_status,
            'is_today' => Carbon::parse($order->order_date, 'Asia/Phnom_Penh')->isToday(),
            'remaining_seconds' => $remainingSeconds,
            'timezone' => 'Asia/Phnom_Penh',
            'distance'       => (float) $order->distance_between_shop_customer,
            'order_date'     => $order->order_date,
            
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
        //  dd($OrderData);
        return Inertia::render('Web/OrderDetailsPage', [
            'OrderRecords' => $OrderData,
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
                'assign_status' => 'cancelled',
                'cancel_reason' => $request->cancel_reason,
            ]);

        return redirect()->route('myOrder.orderDetails', ['orderKey' => base64_encode($request->order_key)]);
    }

    


}
