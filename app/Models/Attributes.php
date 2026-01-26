<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
class Attributes extends Model
{
    use HasFactory;
    use HasTranslations;
    protected $fillable = ['name', 'status'];
    public $translatable = ['name'];



}
