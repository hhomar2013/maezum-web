<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory ,HasTranslations;
    protected $translatable = ['name', 'description'];
    protected $guarded =[];

    public function variants(): HasMany
    {
        return $this->hasMany(Variant::class)->with('attribute');
    }

      public function variations()
    {
        return $this->hasMany(product_variations::class);
    }

    /**
     * Get the categories that owns the Product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function categories(): BelongsTo
    {
        return $this->belongsTo(Categories::class, 'category_id');
    }

    public function addons(): HasMany
    {
        return $this->hasMany(productAddons::class, 'product_id')->with('addons');
    }


    public function extras(): HasMany
    {
        return $this->hasMany(product_extra::class, 'product_id');
    }


    public function offers()
    {
        return $this->belongsToMany(offers::class, 'offer_products', 'product_id', 'offer_id');
    }
    public function offersProduct(): BelongsTo
    {
        return $this->belongsTo(offer_product::class,'product_id');
    }


}
