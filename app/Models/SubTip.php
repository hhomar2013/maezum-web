<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubTip extends Model
{
    use HasFactory;
    protected $fillable = ['main_tip_id', 'type', 'content','hex_color'];
    protected $casts = [
        'hex_color' => 'array',
    ];

    public function mainTip()
    {
        return $this->belongsTo(main_tips::class,'main_tip_id','id');
    }
}
