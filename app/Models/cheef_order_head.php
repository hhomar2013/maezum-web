<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cheef_order_head extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo(customers::class, 'customer_id');
    }

    public function items()
{
    return $this->hasMany(cheef_order_items::class ,'order_head_id' , 'id');
}


    public function paymentMethod()
    {
        return $this->belongsTo(paymentMethod::class, 'payment_method_id');
    }

    public function vendor()
    {
        return $this->belongsTo(vendors::class, 'vendor_id');
    }


}
