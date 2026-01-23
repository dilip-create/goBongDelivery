<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Session;

class CustomAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $path = $request->path();
        if(($path == 'customerLogin') && Session::get('customerAuth')
        // || (strpos($path, 'PasswordDetails') !== false && Session::has('customerAuth'))
        )
        {
            return redirect('/');
        }
        
        if(
            ($path == 'CustomerAccount' && !Session::get('customerAuth'))
           || ($path == 'cart' && !Session::get('customerAuth'))
           || ($path == 'shipping/addressDetails' && !Session::get('customerAuth'))
         || (strpos($path, 'cart/checkout/payment') !== false && !Session::has('customerAuth'))
         || (strpos($path, 'myOrder/orderDetails') !== false && !Session::has('customerAuth'))
         
        )
        {
            return redirect('/customerLogin');
        }
        return $next($request);
    }
}
