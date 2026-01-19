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

class PaymentController extends Controller
{

    public function index($orderKey, Request $request)
    {
        $customerId = $request->session()->get('customerAuth')->id;
        $OrderData = StorOrder::select('*')->where([
            'cust_id'=> $customerId,
            'order_key'=> $orderKey,
            'order_status'=> 'pending',
            'payment_status'=> 'pending' ])->first();

       
        if(empty($OrderData)){
            return redirect()->route('/');
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
                            ->where('order_status', 'pending')
                            ->where('payment_status', 'pending')
                            ->get();

        // dd($foodLists);

        return Inertia::render('Web/PaymentPage', [
            'OrderData' => $OrderData,
            'shipAddress' => $shipAddress,
            'storData' => $storData,
            'foodLists' => $foodLists,
            'currencyData' => $currencyData
            
        ]);

    }


}
