<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Stor extends Model
{
    use SoftDeletes;
    protected $guarded = ['id'];

    public function getshopManager()
    {
        return $this->belongsTo(User::class,  'storLoginId', 'id');
    }


    //For Translation code START
    protected $relationsToCascade = ['translations'];
    public function translations(): HasMany
    {
        return $this->hasMany(StorTranslation::class);
    }

    public function translationValue(): Attribute
    {
        return new Attribute(
            get: function () {
                return $this->translations()
                    ->where(['language_id' => Language::where('code', app()->getLocale())->first()?->id ?? 'en'])
                    ->get()->first();
            }
        );
    }
     //For Translation code END

    //Created by sushil sir for START
    public function scopeOwner(Builder $query)
    {
        $seller = User::where('id', auth()->id())->first();
        if($seller){
            $query = $query->where('storLoginId', $seller->id);
        }
        return $query;
    }

    public static function getRestaurantOptions()
    {
        return static::owner()->pluck('cuisine', 'id');
    }
     //Created by sushil sir for seller END


}
