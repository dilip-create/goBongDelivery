<?php
namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Inertia\Inertia;
use App\Models\Stor;
use App\Models\Category;
use App\Models\StorFood;
use App\Models\Language;
use Session;

class FoodDetailController extends Controller
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
}
