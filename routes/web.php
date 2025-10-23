<?php
use Illuminate\Support\Facades\Route;

use Inertia\inertia;
use App\Livewire\Website\HomePage;
use App\Http\Controllers\LanguageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\Web\HomeController;

// Route::get('/', function () {
//     return view('welcome');
// });

// http://127.0.0.1:8000/livewire
Route::get('/livewire', HomePage::class)->name('home');

Route::get('lang', [LanguageController::class, 'change'])->name("change.lang");

//For Inertia START

Route::middleware('guest')->group(function (){
    
    Route::get('/', [HomeController::class, 'index'])->name('/');

   
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

