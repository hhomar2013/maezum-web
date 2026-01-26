<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class product_extra extends Model
{
    use HasFactory;
    protected $table = 'product_extras';
    protected $fillable = ['product_id', 'options'];
    protected $casts = [
        'options' => 'array',
    ];


    public function products()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}
