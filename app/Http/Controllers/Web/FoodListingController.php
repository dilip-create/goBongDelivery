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

class FoodListingController extends Controller
{
    public function showFoodList($storId)
    {   
        $stor_id = base64_decode($storId);
        $storData = Stor::where('id', $stor_id)->with('translationforvuepage')->first();
        $trendingCategory = Category::where([
                                'stor_id' => $stor_id,
                                'trending_status' => '1',    
                                'cat_status' => '1',
                            ])
                            ->orderBy('ordering', 'asc')
                            ->with('translationforvuepage') // load only single translation
                            ->get();
        $allCategories = Category::where([
                                'stor_id' => $stor_id,
                                'cat_status' => '1',
                            ])
                            ->orderBy('ordering', 'asc')
                            ->with('translationforvuepage') // load only single translation
                            ->get();

        $foods = StorFood::where('stor_id', $stor_id)->get();
        // dd($storData);
        return Inertia::render('Web/FoodListing', [
            'stors' => $storData,
            'trendingCategory' => $trendingCategory,
            'allCategories' => $allCategories,
            'foods' => $foods,
            
        ]);


    }
}
