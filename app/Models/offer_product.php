<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class offer_product extends Model
{
    use HasFactory;
    protected $table = 'offer_products';
    protected $guarded =[];


    public function offer(){
        return $this->belongsTo(Offers::class);
    }

    public function products(){
        return $this->belongsTo(Product::class);
    }

}
