<?php
use Illuminate\Support\Facades\Route;

use Inertia\inertia;
use App\Livewire\Website\HomePage;
use App\Http\Controllers\LanguageController;
// use App\Http\Controllers\AuthController;
use App\Http\Controllers\Web\HomeController;
use App\Http\Controllers\Web\StoreController;
use App\Http\Controllers\Web\FoodListingController;
use App\Http\Controllers\Web\CartController;
use App\Http\Controllers\Web\AuthController;
use App\Http\Controllers\Web\CheckoutController;
use App\Http\Controllers\Web\PaymentController;
use App\Http\Controllers\Web\OrderController;
use App\Models\Tip;
// Route::get('/', function () {
//     return view('welcome');
// });

// http://127.0.0.1:8000/livewire
    Route::get('/livewire', HomePage::class)->name('home');

    Route::get('lang', [LanguageController::class, 'change'])->name("change.lang");

//For Inertia START

Route::middleware('guest')->group(function (){
    
    Route::get('/', [HomeController::class, 'index'])->name('/');
    Route::get('/stores/{encodedCategory}', [StoreController::class, 'getSearchingBasedStorlistfun'])->name('stores.byCategory');

    Route::get('/menus/{storId}', [FoodListingController::class, 'showFoodList'])->name('food.list');
   
    Route::post('/cart/add', [FoodListingController::class, 'addToCart']);
    Route::get('/cart/{foodId}', [FoodListingController::class, 'getCartItem']);

    Route::get('/customerLogin', [AuthController::class, 'showLoginPage'])->name('customerLogin');
    Route::post('/customerLogin', [AuthController::class, 'customerLogin']);
});

    Route::get('/customerlogout', [AuthController::class, 'logout'])->name('customerlogout');
    Route::get('/CustomerAccount', [AuthController::class, 'getCustomerAccount'])->name('CustomerAccount');
    Route::post('/account/update', [AuthController::class, 'updateAccount'])->name('account.update');

    Route::get('/cart', [CartController::class, 'getCartList'])->name('cart');
    Route::delete('/cart/{id}', [CartController::class, 'destroy']);

    Route::get('/shipping/addressDetails', [AuthController::class, 'getAddressList'])->name('shipping.address.list');
    Route::post('/shipping/addressDetails/save', [AuthController::class, 'saveAddress'])->name('shipping.address.save');
    Route::delete('/shipping/addressDetails/{address}', [AuthController::class, 'deleteAddress'])->name('shipping.address.delete');

    Route::post('/checkout/save', [CheckoutController::class, 'submitOrder'])->name('save.checkout');
    Route::get('/cart/checkout/payment/{orderKey}', [PaymentController::class, 'paymentpage'])->name('checkout.payment.page');
    Route::post('/save/paymentslip', [PaymentController::class, 'savePaymentSlip'])->name('save.paymentslip');

    Route::post('/order/cancel', [OrderController::class, 'cancelOrder'])->name('order.cancel');
    Route::get('/myOrder/orderDetails/{orderKey}', [OrderController::class, 'orderDetailsPagefun'])->name('myOrder.orderDetails');
    Route::get('/myOrder/status/{orderKey}', [OrderController::class, 'orderStatus']);
    Route::get('/myOrder', [OrderController::class, 'orderlist'])->name('orderlist');

    Route::get('/check-tip/{orderKey}', function($orderKey) {
        $exists = Tip::where('order_key', $orderKey)->exists();
        return response()->json(['exists' => $exists]);
    });



    

 






















Route::middleware('guest')->group(function (){
    Route::inertia('/home', 'Home')->name('home');

    Route::inertia('/register', 'Auth/Register')->name('register');
    Route::post('/register', [AuthController::class, 'register']);

    Route::inertia('/login', 'Auth/Login')->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});


Route::middleware('auth')->group(function (){
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
    Route::inertia('/dashboard', 'Dashboard')->name('dashboard');

});

