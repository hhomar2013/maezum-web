<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;
    protected $fillable = [
    'id',
    'question',
    'answer',
];

    protected $casts = [
        'id' => 'integer',
    ];
    public function getRouteKeyName()
    {
        return 'id';
    }
}
