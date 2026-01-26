<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class VendorStatus extends Model
{
    use HasFactory;

    protected $fillable = [
        'vendor_id',
        'type',
        'content',
        'background_color',
        'expires_at',
    ];


    protected $casts = [
        'background_color' => 'array',
        'expires_at' => 'datetime',
    ];

    public function vendor()
    {
        return $this->belongsTo(Vendors::class);
    }


    public function scopeActive($query)
    {
        return $query->where('expires_at', '>', now());
    }

    protected function content(): \Illuminate\Database\Eloquent\Casts\Attribute
    {
        return \Illuminate\Database\Eloquent\Casts\Attribute::make(
            get: fn($value) => ($this->type !== 'text' && $value) ? asset('storage/' . $value) : $value,
        );
    }
}
