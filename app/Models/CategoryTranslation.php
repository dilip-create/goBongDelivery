<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class CategoryTranslation extends Model
{
    protected $guarded = ['id'];

    public function languages()
    {
        return $this->belongsTo(Language::class,  'language_id', 'id');
    }

    public function getCategoryData()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    //modify query in table for show list of product acc to owner login
    public function scopeOwner(Builder $query)
    {
        $stordata = Stor::where('storLoginId', auth()->id())->first();
       
        if ($stordata) {
            $query = $query
                ->join('categories', 'categories.id', '=', 'category_translations.category_id')
                ->join('stors', 'stors.id', '=', 'categories.stor_id')
                ->where('stors.id', $stordata->id)
                ->select('category_translations.*');
        }
        return $query;
    }

}
