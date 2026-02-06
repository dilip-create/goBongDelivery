<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class StorOrder extends Model
{
    use SoftDeletes;
    protected $guarded = ['id'];

    public function stor_food_records()
    {
        return $this->belongsTo(StorFood::class, 'stor_food_id');
    }

    public function cartdetails()
    {
        return $this->belongsTo(Cart::class, 'cart_id');
    }

    public function getstor()
    {
        return $this->belongsTo(Stor::class, 'stor_id');
    }

    public function getShopName()
    {
        return $this->belongsTo(User::class, 'storLoginId');
    }

    public function getCustomerdata()
    {
        return $this->belongsTo(Customer::class, 'cust_id');
    }

    public function getRiderdata()
    {
        return $this->belongsTo(Rider::class, 'rider_id');
    }

    public function getCurrencydata()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }
    

}
