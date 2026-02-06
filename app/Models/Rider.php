<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Rider extends Model
{
    protected $guarded = ['id'];

    public function riderLoginData()
    {
        return $this->belongsTo(User::class,  'riderLoginId', 'id');
    }

     //Created by dk for DeliveryBoy
    //  public function scopeOwner(Builder $query)
    //  {
    //      $deliveryboy = DeliveryBoy::where('riderLoginId', auth()->id())->first();
    //      if($deliveryboy){
    //          $query = $query->where('id', $deliveryboy->id);
    //      }
    //      return $query;
    //  }
     //Created by dk for DeliveryBoy
}
