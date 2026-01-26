<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Foundation\Auth\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Spatie\Permission\Traits\HasRoles;


class Vendors extends Authenticatable
{
    use HasFactory, HasTranslations, Notifiable, HasRoles;
    protected $guarded = [];
    public $translatable = ['name', 'description'];

    public function outOrders()
    {
        return $this->hasMany(cheef_out_order::class, 'vendor_id', 'id');
    }

    public function statuses()
    {
        return $this->hasMany(VendorStatus::class, 'vendor_id');
    }
}
