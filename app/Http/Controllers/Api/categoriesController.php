<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiResponseTrait;
use App\Models\Categories;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class categoriesController extends Controller
{
    use ApiResponseTrait;
    public function index(){
        $categories =  Categories::query()->get();
        $data = [];
        foreach ($categories as $category) {
            $data[] = [
                'id' => $category->id,
                'nameAr' => $category->getTranslation('name', 'ar'),
                'nameEn' => $category->getTranslation('name', 'en'),
                'image' => getAppSetting('app_mobile_link') . Storage::url($category->image),
            ];
        }
        return $this->apiRsponse($data,__('Data received'),200);
    }
}
