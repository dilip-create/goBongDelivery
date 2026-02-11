<?php
namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Inertia\Inertia;
use App\Models\Currency;
use App\Models\StorOrder;
use App\Models\Tip;
use Session;
use Storage;

class TipPaymentController extends Controller
{
    public function tipspaymentpage($tipAmount, $tipDesc, $orderKey, Request $request)
    {
        $tipAmount= base64_decode($tipAmount);
        $desc= base64_decode($tipDesc);
        $orderKey= base64_decode($orderKey);
        // dd($orderKey);
        $customerId = $request->session()->get('customerAuth')->id;
        $OrderData = StorOrder::select('*')->where([
            'cust_id'=> $customerId,
            'order_key'=> $orderKey])->first();
        //  dd($OrderData);
        if(empty($OrderData)){
            return redirect()->route('customerLogin');
        }
        $currencyData = Currency::where('id', $OrderData->currency_id)->first();
        $exists = Tip::where('order_key', $orderKey)->exists();
        if(empty($exists)){

         Tip::create([
                'order_key' => $orderKey,
                'stor_id' => $OrderData->stor_id,
                'cust_id' => $customerId,
                'rider_id' => $OrderData->rider_id,
                'amount' => $tipAmount,
                'desc' => $desc,
                'currency_id' => $currencyData->id,
            ]);
        }
       
        return Inertia::render('Web/TipPaymentPage', [
            'OrderData' => $OrderData,
            'tipAmount' => $tipAmount,
            'tipDesc' => $tipDesc,
            'currencyData' => $currencyData
            
        ]);

    }

    public function saveTipPaymentSlip(Request $request)
    {
        // dd($request->all());
        $customerId = $request->session()->get('customerAuth')->id;
        $path = $request->file('avatar')
                ->store('tipsPaySlip', 'public');
        date_default_timezone_set('Asia/Phnom_Penh');
        $payment_time=date("Y-m-d h:i:s");
        Tip::where('order_key', $request->order_key)->update([
            'TransactionId'    => '',
            'payment_type' => 'online',
            'payment_time' => $payment_time,
            'payment_status' => 'awaiting verification',
            'response_all' => '',
            'attach_slip'     => $path,
        ]);

        return response()->json([
            'success' => true,
            'path' => $path,
        ]);


    }


}
