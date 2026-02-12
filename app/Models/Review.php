<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Review extends Model
{
    protected $guarded = ['id'];

    public function getstorTranslation()
    {
        return $this->hasOne(StorTranslation::class, 'stor_id', 'stor_id')
            ->where('language_id', Language::where('code', app()->getLocale())->first()?->id);
    }

    public function getCustomerdata()
    {
        return $this->belongsTo(Customer::class, 'cust_id');
    }
}
