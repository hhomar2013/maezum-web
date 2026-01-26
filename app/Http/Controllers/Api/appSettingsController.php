<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\mysettings;
use Illuminate\Http\Request;

class appSettingsController extends Controller
{
    use ApiResponseTrait;
    public $mySettings;
    public function index(Request $request)
    {
        $appSettings = mysettings::query()->first();
        if ($appSettings) {
            $this->mySettings = [
                'nameAr' => $appSettings->getTranslation('app_name', 'ar'),
                'nameEn' => $appSettings->getTranslation('app_name', 'en'),
                'email' => $appSettings->app_email,
                'phone' => $appSettings->app_phone,
                'country' => $appSettings->app_country,
                'current_currency' => $appSettings->current_currency,
               'logo' => $appSettings->app_mobile_link . 'storage/'. $appSettings->app_logo,
                'favicon' => $appSettings->app_mobile_link . 'storage/'.  $appSettings->app_favicon,
                'api_link' => $appSettings->app_mobile_link,
            ];
            return $this->apiRsponse( $this->mySettings, 'appSettings', 200);
        }

    }
}
