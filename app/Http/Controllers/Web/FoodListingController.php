<?php
namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Inertia\Inertia;
use App\Models\Stor;
use App\Models\Category;
use App\Models\StorFood;

class FoodListingController extends Controller
{
    public function showFoodList($storId)
    {   
        $stor_id = base64_decode($storId);
        $storData = Stor::where('id', $stor_id)->first();
        $trendingCategory = Category::where([
                                        'stor_id' => $stor_id,
                                        'trending_status' => '1',
                                        'cat_status' => '1',
                                            ])->orderBy('ordering', 'asc')->with(['translations'])->get();
        $foods = StorFood::where('stor_id', $stor_id)->get();
        // dd($trendingCategory);
        return Inertia::render('Web/FoodListing', [
            'stors' => $storData,
            'trendingCategory' => $trendingCategory,
            'foods' => $foods,
            
        ]);


    }
}
