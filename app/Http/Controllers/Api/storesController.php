<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Models\Stores;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class storesController extends Controller
{
    use ApiResponseTrait;
    public function index()
    {
        $stores = Stores::query()->where('status',1)->limit(6)->get();
        $data = [];
            foreach ($stores as $store) {
                $data[] = [
                    'id' => $store->id,
                    'nameAr' => $store->getTranslation('name','ar'),
                    'nameEn' => $store->getTranslation('name','en'),
                    'phone' => $store->phone,
                    'descriptionAr' => $store->getTranslation('description','ar'),
                    'descriptionEn' => $store->getTranslation('description','en'),
                    'logo' => getAppSetting('app_mobile_link'). Storage::url($store->logo),
                    'status' => $store->status,
                ];
            }

        return $this->apiRsponse($data ,__('Data Stores received'),200);
    }
}
