<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Category extends Model
{
    protected $guarded = ['id'];
    

    //modify query in table for show list of product acc to owner login
    public function scopeOwner(Builder $query)
    {
        $stordata = Stor::where('storLoginId', auth()->id())->first();
        if($stordata){
           
            $query = $query->where('stor_id', $stordata->id);
        }
        return $query;
    }

    // acc to owner login show dropdown for select in Form
    // public static function getCategoryOptions()
    // {
    //     return static::owner()->pluck('cat_name', 'id');
    // }

    // acc to owner login show dropdown for select in Form
    public static function getCategoryOptions()
    {
        $locale = app()->getLocale();
        $langId = Language::where('code', $locale)->value('id');

        return static::owner()
            ->with(['translations' => function ($query) use ($langId) {
                $query->where('language_id', $langId);
            }])
            ->get()
            ->mapWithKeys(function ($category) {
                $translatedName = $category->translations->first()->cat_translation_name ?? $category->cat_name;
                return [$category->id => $translatedName];
            });
    }


    public function translations()
    {
        return $this->hasMany(CategoryTranslation::class);
    }

    
}