<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class items_variations extends Model
{
    use HasFactory;

    protected $guarded = [];
    public function item()
    {
        return $this->belongsTo(items::class,'item_id','id');
    }
}
