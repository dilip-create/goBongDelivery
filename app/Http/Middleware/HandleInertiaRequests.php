<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use App\Models\Cart;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that's loaded on the first page visit.
     *
     * @see https://inertiajs.com/server-side-setup#root-template
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determines the current asset version.
     *
     * @see https://inertiajs.com/asset-versioning
     */
    public function version(Request $request): ?string
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @see https://inertiajs.com/shared-data
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
    {
         $customerId = 1; // Dummy customer for now
        return array_merge(parent::share($request), [ 
                'auth.customer' => $request->session()->get('customerAuth'),
                // Lazily
                 'auth.user' => fn () => $request->user()
                ? $request->user()->only('id', 'name', 'phoneNumber', 'role')
                : null,

                'flash' => [
                    'greet' => fn () => $request->session()->get('greet')
                ],
                'appUrl' => config('app.url'),
                'translations' => function () {
                    // If you’re using Laravel localization like resources/lang/en/message.php
                    return __('message');
                },
                 // 🧮 Add global cart count
                'cartCount' => fn() => Cart::where('customer_id', $customerId)->sum('f_qty') ?? 0,
        ]);
          
    }
}
