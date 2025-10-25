<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class StorFood extends Model
{
    use SoftDeletes;
    protected $guarded = ['id'];
    protected $table = 'stor_foods';

    public function getCategoryData()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

     //modify query in table for show list of product acc to owner login
    public function scopeOwner(Builder $query)
    {
        $stordata = Stor::where('storLoginId', auth()->id())->first();
       
        if ($stordata) {
            // $query = $query
            //     ->join('categories', 'categories.id', '=', 'stor_foods.category_id')
            //     ->join('stors', 'stors.id', '=', 'categories.stor_id')
            //     ->where('stors.id', $stordata->id)
            //     ->select('stor_foods.*');
                $query = $query->where('stor_id', $stordata->id);
        }
        return $query;
    }

    // acc to owner login show dropdown for select in Form
    public static function getFoodnameOptions()
    {
        $locale = app()->getLocale();
        $langId = Language::where('code', $locale)->value('id');

        return static::owner()
            ->with(['translations' => function ($query) use ($langId) {
                $query->where('language_id', $langId);
            }])
            ->get()
            ->mapWithKeys(function ($category) {
                $translatedName = $category->translations->first()->food_translation_name ?? $category->food_name;
                return [$category->id => $translatedName];
            });
    }

    public function translations()
    {
        return $this->hasMany(StorFoodTranslation::class);
    }
}
