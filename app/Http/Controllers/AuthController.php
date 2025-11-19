<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

use App\Models\User;
use Session;
use Auth;
use Storage;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        sleep(1);
        //  dd($request->avatar);
       $fields = $request->validate([
                'name' => ['required', 'max:255'],
                'email' => ['required', 'email', 'max:255', 'unique:users'],
                'phoneNumber' => ['required', 'numeric', 'unique:users'],
                'password'  => ['required', 'min:8', 'confirmed'],
                'avatar'  => ['file', 'nullable', 'max:500'],
       ]);

        if($request->hasFile('avatar')){
            $fields['role'] = Storage::disk('public')->put('avatars', $request->avatar);
        }

        $user = User::create($fields);
        //Login
        Auth::login($user);
        //Redirect
        return redirect()->route('dashboard')->with('greet' , 'Welcome to Laravel inertia Vue JS !');
    }

    public function login(Request $request)
    {
        sleep(1);
       $fields = $request->validate([
                // 'name' => ['required', 'max:255'],
                'phoneNumber' => ['required', 'numeric'],
                // 'email' => ['required', 'email', 'max:255'],
                'password'  => ['required', 'min:8'],
       ]);

        if(Auth::attempt($fields)){
            $request->session()->regenerate();

            return redirect()->intended('/dashboard')->with('greet' , 'Login Successfully!');
        }

        return back()->withErrors([
                'phoneNumber' => 'The provided credentails do not match our records!',
        ])->onlyInput('phoneNumber');
        
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('/');
    }
}
