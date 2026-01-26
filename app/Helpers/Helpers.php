<?php

use App\Models\mysettings;
use Illuminate\Support\Facades\Auth;

if (!function_exists('getAppSetting')) {
    function getAppSetting($value = 'app_name')
    {

        $get_name = mysettings::get()->first();
        if ($get_name == null) {
            return null;
        }elseif($value == 'app_name'){
            if(app()->getLocale() == 'ar'){
                return $get_name->getTranslation($value,'ar');
            }else{
                return $get_name->getTranslation($value,'en');
            }
        }
        return $get_name->$value;
    }
}

if (!function_exists('getFirstLetterOfAuthenticatedUser')){
    function getFirstLetterOfAuthenticatedUser()
    {
        if (Auth::check()) {
            return strtoupper(substr(Auth::user()->name, 0, 1));
        }
        return null;
    }
}


if(!function_exists('paginationNumber')){
    function paginationNumber($number){
        if($number){
            return $number;
        }
        return 5;
    }
}



