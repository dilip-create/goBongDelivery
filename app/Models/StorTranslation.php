<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StorTranslation extends Model
{
     protected $guarded = ['id'];

    public function languages()
    {
        return $this->belongsTo(Language::class,  'language_id', 'id');
    }

    public function getstorData()
    {
        return $this->belongsTo(Stor::class,  'stor_id', 'id');
    }
}
