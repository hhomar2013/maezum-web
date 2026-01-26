<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class PaymentMethod extends Model
{
    use HasFactory, HasTranslations;
    protected $fillable = ['name', 'code', 'provider','image',  'is_active', 'config'];
    public $translatable = ['name'];
    protected $casts = [
        'is_active' => 'boolean',
        'config'    => 'array',
    ];
}
