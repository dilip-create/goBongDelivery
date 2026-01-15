<?php
namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Inertia\Inertia;
use App\Models\Customer;
use App\Models\Cart;
use App\Models\DeliveryAddress;
use Session;
use Storage;

class AuthController extends Controller
{
    public function showLoginPage()
    {
        session(['url.intended' => url()->previous()]);
        return inertia('Web/Auth/customerLogin');
    }

    public function customerLogin(Request $request)
    {
        sleep(1);
       $fields = $request->validate([
                'phoneNumber' => ['required', 'numeric', 'min:9'],
       ]);
       
        $customerData = Customer::where('phoneNumber', $request->phoneNumber)->first();
       
        if(!empty($customerData)){
            // dd($customerData);
            session::put('customerAuth', $customerData);
            //clear previous cart item
            Cart::where('customer_id', $customerData->id)->delete();
            // Update Guestid with customer START
            if (session()->has('guest_id')) {
                Cart::where('customer_id', session('guest_id'))->update(['customer_id' => $customerData->id]);

                session()->forget('guest_id');
            }
            // Update Guestid with customer END

            return redirect()->intended('/')->with('greet' , 'Login Successfully!');
        }else{
            $newCustomer = Customer::create($fields);
            //Login
            session::put('customerAuth', $newCustomer);
            //Redirect
            return redirect()->intended('/')->with('greet', 'Welcome to Laravel Inertia Vue JS!');
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

    
    public function getCustomerAccount(Request $request)
    {
        $customerId = $request->session()->get('customerAuth')->id;
        $customer = Customer::find($customerId);
        // dd($customer);
        return Inertia::render('Web/Auth/CustomerAccount', [
            'customer' => $customer
        ]);
    }

    public function updateAccount(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phoneNumber' => 'required|digits_between:8,10',
            'picture' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $customer = Customer::find($request->id);
        // Update text fields
        $customer->name = $request->name;
        $customer->phoneNumber = $request->phoneNumber;

        // Update picture only if new image uploaded
        if ($request->hasFile('picture')) {
            $path = $request->file('picture')->store('customers', 'public');
            $customer->picture = $path;
        }
        $customer->save();
        $msg = __('message.Profile updated Successfully!');
        return back()->with('greet', $msg);
    }

    public function getAddressList(Request $request)
    {
        $customerId = $request->session()->get('customerAuth')->id ?? 0;

        if (!$customerId) {
            return redirect()->route('customerLogin');
        }

        return Inertia::render('Web/Auth/ShippingAddress', [
            'addressLists' => DeliveryAddress::where('cust_id', $customerId)->get(),
        ]);
    }

    public function saveAddress(Request $request)
    {
        $customerId = $request->session()->get('customerAuth')->id;

        $data = $request->validate([
            'id'       => 'nullable|exists:delivery_addresses,id',
            'address'  => 'required|string|max:255',
            'landmark' => 'nullable|string|max:500',
        ]);

        /** 🔴 Step 1: Set all addresses of this customer to status = 0 */
        DeliveryAddress::where('cust_id', $customerId)->update([
            'status' => 0,
        ]);

        /** 🟢 Step 2: Update or Create */
        DeliveryAddress::updateOrCreate(
            [
                'id' => $data['id'] ?? null,
            ],
            [
                'cust_id'  => $customerId,
                'address'  => $data['address'],
                'landmark' => $data['landmark'],
                'status'   => 1, // active address
            ]
        );
         return redirect()->back()->with('success', 'Address saved successfully');
    }

    public function deleteAddress(Request $request, DeliveryAddress $address)
    {
        $customerId = $request->session()->get('customerAuth')->id;

        // Security check
        if ($address->cust_id !== $customerId) {
            abort(403);
        }

        $wasActive = $address->status === 1;

        $address->delete();

        // If deleted address was active, set latest address as active
        if ($wasActive) {
            DeliveryAddress::where('cust_id', $customerId)
                ->latest()
                ->first()?->update(['status' => 1]);
        }

        return redirect()->back()->with('success', 'Address deleted successfully');
    }


    

}
