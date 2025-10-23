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
    public static function getSellerOptions()
    {
        return static::owner()->pluck('cat_name', 'id');
    }
    
}