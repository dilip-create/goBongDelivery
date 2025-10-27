<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class StorFoodTranslation extends Model
{
     protected $guarded = ['id'];

     public function languages()
     {
          return $this->belongsTo(Language::class,  'language_id', 'id');
     }

     public function getFoodData()
     {
          return $this->belongsTo(StorFood::class, 'stor_food_id', 'id');
     }

     //modify query in table for show list of product acc to owner login
    public function scopeOwner(Builder $query)
    {
        $stordata = Stor::where('storLoginId', auth()->id())->first();
       
        if ($stordata) {
            $query = $query
                ->join('stor_foods', 'stor_foods.id', '=', 'stor_food_translations.stor_food_id')
                ->join('stors', 'stors.id', '=', 'stor_foods.stor_id')
                ->where('stors.id', $stordata->id)
                ->select('stor_food_translations.*');
        }
        return $query;
    }
}
