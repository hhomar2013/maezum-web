<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class market_items extends Model
{
    use HasFactory, HasTranslations;
    protected $guarded = [];
    protected $translatable = ['name'];
    public function variations()
    {
        return $this->hasMany(market_items_variations::class);
    }
    public function category()
    {
        return $this->belongsTo(Categories::class);
    }

    public function getCategoryNameAttribute()
    {
        return $this->category->name;
    }
}
