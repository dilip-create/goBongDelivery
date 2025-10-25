<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

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
}
