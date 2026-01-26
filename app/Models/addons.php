<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class addons extends Model
{
    use HasFactory ,HasTranslations;
    protected $table = "addons";
    protected $fillable = ['name','price',];
    protected $translatable = ['name'];
    protected $casts = [
        'options' => 'array',
    ];


}

