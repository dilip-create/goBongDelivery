<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Casts\Attribute;

class StorFood extends Model
{
    use SoftDeletes;
    protected $guarded = ['id'];
    protected $table = 'stor_foods';

    public function getCategoryData()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
