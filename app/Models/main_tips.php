<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class main_tips extends Model
{
    use HasFactory;

      protected $fillable = [
        'title',
        'sub_tips',
         'image',
    ];

    protected $casts = [
        'sub_tips' => 'array',
    ];

     public function subTips()
    {
        return $this->hasMany(SubTip::class,'main_tip_id','id');
    }

}
