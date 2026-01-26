<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\sections;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\Storage;

class vendorCategoriesController extends Controller
{
    use ApiResponseTrait;
    public $data = [];
    public function index($id)
    {
        $vendor_categories = sections::where('vendor_id', $id)->get();
        foreach ($vendor_categories as $value) {
            $this->data[] = [
                'id'=> $value->id,
                'nameAr' => $value->getTranslation('name', 'ar'),
                // 'nameEn' => $value->getTranslation('name', 'en'),
                'image' =>  getAppSetting('app_mobile_link') . Storage::url($value->image),
            ];
        }

        return $this->apiRsponse($this->data, 'success vendors Categories', 200);
    }
}
