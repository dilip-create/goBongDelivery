<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tip extends Model
{
    protected $guarded = ['id'];

    public function getCurrencydata()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public function getCustomerdata()
    {
        return $this->belongsTo(Customer::class, 'cust_id');
    }

    public function getRiderdata()
    {
        return $this->belongsTo(Rider::class, 'rider_id');
    }
  
    public function getstorTranslation()
    {
        return $this->hasOne(StorTranslation::class, 'stor_id', 'stor_id')
            ->where('language_id', Language::where('code', app()->getLocale())->first()?->id);
    }


}
