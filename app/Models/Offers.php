<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Offers extends Model
{
    use HasFactory,HasTranslations;
    protected $guarded = [];
    protected $table = 'offers';
    public $translatable = ['name','description'];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'offer_products', 'offer_id', 'product_id');
    }

}
