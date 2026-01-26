<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class items extends Model
{
    use HasFactory,HasTranslations;

    protected $guarded = [];
    protected $translatable = ['name'];
        // 🔗 الصنف ينتمي إلى شيف
        public function vendor()
        {
            return $this->belongsTo(Vendors::class);
        }

        // 🔗 الصنف ينتمي إلى قسم
        public function section()
        {
            return $this->belongsTo(sections::class);
        }

        // 🔗 الصنف يحتوي على Variations
        public function variations()
        {
            return $this->hasMany(items_variations::class,'item_id');
        }





}
