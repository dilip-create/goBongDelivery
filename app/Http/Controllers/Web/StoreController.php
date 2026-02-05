<?php
namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Inertia\Inertia;

use App\Models\CategoryTranslation;
use App\Models\Category;
use App\Models\StorFoodTranslation;
use App\Models\StorFood;
use App\Models\Stor;
use App\Models\Language;
use Carbon\Carbon;


class StoreController extends Controller
{
    


    public function getSearchingBasedStorlistfun($encodedCategory)
    {
        $langId = 1;
        $title  = base64_decode($encodedCategory);
        $keyword = strtolower($title);

        /* =========== CASE 1: All stores============ */
        if (strtolower($title) == 'all') {

            $stores = Stor::orderBy('openStatus', 'desc')
                ->with('translationforvuepage')
                ->get();

            return inertia('Web/SearchingStores', [
                'keyword' => $title,
                'stors'   => $stores,
            ]);
        }


        /* ============CASE 2: New & Pro============= */
        if (strtolower($title) == 'new&pro') {

            $stores = Stor::where('created_at', '>=', Carbon::now()->subDays(60))
                ->with('translationforvuepage')
                ->orderBy('openStatus', 'desc')
                ->get();

            return inertia('Web/SearchingStores', [
                'keyword' => $title,
                'stors'   => $stores,
            ]);
        }

        /* =========== CASE 3: International Food============ */
        if (strtolower($title) == 'international') {

            $stores = Stor::where('international', '1')
                ->with('translationforvuepage')
                ->orderBy('openStatus', 'desc')
                ->get();

            return inertia('Web/SearchingStores', [
                'keyword' => $title,
                'stors'   => $stores,
            ]);
        }

        /* =========== CASE 4: 24*7 Stores Filters only stores open ≥ 10 hours============ */
        if (strtolower($title) == 'store24') {

            $stores = Stor::whereRaw("
                                        (
                                            CASE 
                                                WHEN closetime >= opentime 
                                                THEN TIME_TO_SEC(TIMEDIFF(closetime, opentime))
                                                ELSE TIME_TO_SEC(TIMEDIFF(ADDTIME(closetime, '24:00:00'), opentime))
                                            END
                                        ) >= 36000
                                    ")
                ->with('translationforvuepage')
                ->orderBy('openStatus', 'desc')
                ->get();

            return inertia('Web/SearchingStores', [
                'keyword' => $title,
                'stors'   => $stores,
            ]);
        }

        /* =============CASE 3: Keyword search=============== */
        $keyword = str_replace(['&', ',', '-'], ' ', $keyword);
        $words = array_filter(explode(' ', $keyword));

        $storeIds = collect();

        // 1) Search from Categories
        $categoryIds = CategoryTranslation::where('language_id', $langId)
            ->where(function ($q) use ($words) {
                foreach ($words as $word) {
                    $q->orWhere('cat_translation_name', 'LIKE', "%$word%")
                    ->orWhere('cat_desc', 'LIKE', "%$word%");
                }
            })
            ->pluck('category_id');

        if ($categoryIds->isNotEmpty()) {
            $storeIds = $storeIds->merge(
                Category::whereIn('id', $categoryIds)->pluck('stor_id')->filter()
            );
        }

        // 2) Search from Foods
        $storFoodIds = StorFoodTranslation::where('language_id', $langId)
            ->where(function ($q) use ($words) {
                foreach ($words as $word) {
                    $q->orWhere('food_translation_name', 'LIKE', "%$word%")
                    ->orWhere('food_desc', 'LIKE', "%$word%");
                }
            })
            ->pluck('stor_food_id');

        if ($storFoodIds->isNotEmpty()) {
            $storeIds = $storeIds->merge(
                StorFood::whereIn('id', $storFoodIds)->pluck('stor_id')->filter()
            );
        }

        $storeIds = $storeIds->unique()->values();

        $stores = Stor::whereIn('id', $storeIds)
            ->with('translationforvuepage')
            ->orderBy('id', 'desc')
            ->get();

        return inertia('Web/SearchingStores', [
            'keyword' => $title,
            'stors'   => $stores,
        ]);
    }



}
