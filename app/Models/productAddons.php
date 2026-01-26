<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class productAddons extends Model
{
    use HasFactory;
    protected $table = 'product_addons';
    protected $fillable = ['product_id','addon_id'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function addons(){
        return $this->belongsTo(addons::class ,'addon_id');
    }
}

