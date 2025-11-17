<?php
namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Customer;
use Session;
use Storage;

class AuthController extends Controller
{
    public function customerLogin(Request $request)
    {
        sleep(1);
       $fields = $request->validate([
                'phoneNumber' => ['required', 'numeric', 'min:9'],
       ]);
       
        $customerData = customer::where('phoneNumber', $request->phoneNumber)->first();
       
        if(!empty($customerData)){
            // dd($customerData);
            session::put('customerAuth', $customerData);

            return redirect()->intended('/')->with('greet' , 'Login Successfully!');
        }else{
            $newCustomer = Customer::create($fields);
            //Login
            session::put('customerAuth', $newCustomer);
            //Redirect
            return redirect()->route('/')->with('greet' , 'Welcome to Laravel inertia Vue JS !');
        }

        return back()->withErrors([
                'phoneNumber' => 'The provided credentails do not match our records!',
        ])->onlyInput('phoneNumber');
        
    }

    public function logout(Request $request)
    {
        session::forget('customerAuth');
        // $request->session()->invalidate();
        // $request->session()->regenerateToken();
        return redirect()->route('/');
    }

}
