<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class cheef_order_items extends Model
{
    use HasFactory;
    protected $guarded = [];

    public function orderHead()
    {
        return $this->belongsTo(cheef_order_head::class, 'order_head_id')->with('customer');
    }

    public function item()
    {
        return $this->belongsTo(items::class, 'item_id');
    }

    public function variations()
    {
        return $this->hasMany(items_variations::class, 'item_variation_id');
    }
}
