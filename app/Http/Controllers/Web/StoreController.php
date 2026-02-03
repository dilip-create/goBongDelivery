<?php
namespace App\Http\Controllers\Web;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Inertia\Inertia;


use App\Models\Category;
use App\Models\CategoryTranslation;
use App\Models\Language;
use App\Models\Stor;


class StoreController extends Controller
{
    public function getSearchingBasedStorlistfun($encodedCategory)
    {
        $categoryName = base64_decode($encodedCategory);
        // dd($categoryName);

        $langId = Language::where('code', app()->getLocale())->first()?->id;

        // Find category by translation name
        $categoryTranslation = CategoryTranslation::where('language_id', $langId)
            ->where('cat_translation_name', 'LIKE', '%' . $categoryName . '%')
            ->first();


        if (!$categoryTranslation) {
            abort(404, 'Category not found');
        }

        $category = $categoryTranslation->getCategoryData; // relation from CategoryTranslation -> Category

        // Get stores for this category (adjust relation/column as per your DB)
        $stores = Stor::where('id', $category->stor_id) // or category_id if you have it
            ->with('translationforvuepage')
            ->get();

        return inertia('Stores/CategoryStores', [
            'category' => $categoryTranslation->cat_translation_name,
            'stores' => $stores,
        ]);
    }

}
