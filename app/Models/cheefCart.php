<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cheefCart extends Model
{
    use HasFactory;
    protected $table    = 'cheef-carts';
    protected $fillable = [
        'customer_id',
        'item_id',
        'item_variation_id',
        'quantity',
        'price',
        'total',
    ];



    public function itemVariation()
    {
        return $this->belongsTo(items_variations::class, 'item_variation_id');
    }
    public function items()
    {
        return $this->belongsTo(items::class, 'item_id');
    }

    public function customer()
    {
        return $this->belongsTo(customers::class, 'customer_id');
    }




}
