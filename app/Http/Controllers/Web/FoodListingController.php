<?php
namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Inertia\Inertia;
use App\Models\Stor;
use App\Models\Category;
use App\Models\StorFood;
use App\Models\Language;
use App\Models\Cart;
use Session;

class FoodListingController extends Controller
{
    
    public function showFoodList(Request $request, $storId)
    {
        $stor_id = base64_decode($storId);

        $storData = Stor::where('id', $stor_id)
            ->with('translationforvuepage')
            ->first();

        // Trending categories first
        $trendingCategory = Category::where([
                'stor_id' => $stor_id,
                'trending_status' => '1',
                'cat_status' => '1',
            ])
            ->orderBy('ordering', 'asc')
            ->with('translationforvuepage')
            ->get();

        // All active categories
        $allCategories = Category::where([
                'stor_id' => $stor_id,
                'trending_status' => '0',
                'cat_status' => '1',
            ])
            ->orderBy('ordering', 'asc')
            ->with('translationforvuepage')
            ->get();

        // Base food query
        $foodQuery = StorFood::where('stor_id', $stor_id)
            ->where('status', '1')
            ->with(['translationforvuepage', 'getCurrencies']);

        // Search filter
        if ($request->filled('search')) {
            $foodQuery->where(function ($q) use ($request) {
                $q->where('food_name', 'like', '%' . $request->search . '%')
                ->orWhereHas('translationforvuepage', function ($tq) use ($request) {
                    $tq->where('food_translation_name', 'like', '%' . $request->search . '%');
                });
            });
        }

        // Category filter (optional)
        if ($request->filled('category_id')) {
            $foodQuery->where('category_id', $request->category_id);
        }

        $foods = $foodQuery->get();

        // 🧠 Group foods by category
        $groupedFoods = [];

        // Trending categories first
        foreach ($trendingCategory as $cat) {
            $catFoods = $foods->where('category_id', $cat->id)->values();
            if ($catFoods->isNotEmpty()) {
                $groupedFoods[] = [
                    'category' => $cat,
                    'foods' => $catFoods,
                    'is_trending' => true,
                ];
            }
        }

        // Then normal categories
        foreach ($allCategories as $cat) {
            // skip trending categories to avoid duplication
            if ($cat->trending_status == '1') continue;

            $catFoods = $foods->where('category_id', $cat->id)->values();
            if ($catFoods->isNotEmpty()) {
                $groupedFoods[] = [
                    'category' => $cat,
                    'foods' => $catFoods,
                    'is_trending' => false,
                ];
            }
        }

        return Inertia::render('Web/FoodListing', [
            'stors' => $storData,
            'trendingCategory' => $trendingCategory,
            'allCategories' => $allCategories,
            'groupedFoods' => $groupedFoods,
            'filters' => [
                'search' => $request->search,
                'category_id' => $request->category_id,
            ],
        ]);
    }

    // Add to cart
    public function addToCart(Request $request)
    {
        // dd($request->all());
        $validated = $request->validate([
            'stor_id' => 'required|integer',
            'food_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
            'suggestion' => 'nullable|string',
        ]);

        if (!session()->has('guest_id') && !session()->has('customerAuth')) {
            session()->put('guest_id', random_int(100000, 999999));
        }
        $customerId = session()->has('customerAuth') ? session('customerAuth')->id : session('guest_id');


         // Check if customer already has cart items with another stor_id
        $differentStoreExists = Cart::where('customer_id', $customerId)
            ->where('stor_id', '!=', $validated['stor_id'])
            ->exists();

        // If another store's items exist, delete them first
        if ($differentStoreExists) {
            Cart::where('customer_id', $customerId)->delete();
        }

        // Now insert/update the item for current store
        // $cart = Cart::updateOrCreate(
        //     ['customer_id' => $customerId, 'stor_id' => $validated['stor_id'], 'stor_food_id' => $validated['food_id']],
        //     ['f_qty' => $validated['quantity'], 'suggetion' => $validated['suggestion']]
        // );

        $cart = Cart::updateOrCreate(
            [
                'customer_id'   => $customerId, 'stor_id' => $validated['stor_id'], 'stor_food_id'   => $validated['food_id'],
            ],
            [
                'f_qty'       => $validated['quantity'], 'suggetion'   => $validated['suggestion'],
            ]
        );

        return response()->json(['success' => true, 'cart' => $cart]);
    }

    // Fetch existing cart item
    public function getCartItem($foodId)
    {
        $customerId = 1;
        $cart = Cart::where('customer_id', $customerId)
                    ->where('stor_food_id', $foodId)
                    ->first();

        return response()->json(['cart' => $cart]);
    }



}
