<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class coupons extends Model
{
    use HasFactory ,HasTranslations;

    // protected $fillable = ['code', 'discount', 'valid_from', 'valid_to', 'usage_limit', 'used','image','description'];
    protected $translatable = ['description'];
    protected $guarded = [];

    public function users()
    {
        return $this->belongsToMany(User::class)->withTimestamps();
    }


    public function canBeUsedBy(User $user)
{
    // التحقق من صلاحية الكوبون
    if (!$this->isValid()) {
        return false;
    }

    // التحقق إذا كان العميل استخدم الكوبون قبل كده
    if ($this->users()->where('user_id', $user->id)->exists()) {
        return false;
    }

    // التحقق من عدد مرات الاستخدام
    if ($this->usage_limit !== null && $this->used >= $this->usage_limit) {
        return false;
    }

    return true;
}
}
