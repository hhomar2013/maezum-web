<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class market_items_variations extends Model
{
    use HasFactory;
    protected $guarded = [];
    public function item()
    {
        return $this->belongsTo(market_items::class);
    }
}
