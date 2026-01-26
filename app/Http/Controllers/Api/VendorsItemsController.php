<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\items;
use Google\Cloud\Core\ApiHelperTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VendorsItemsController extends Controller
{
    use ApiResponseTrait;
    public function index($id)
    {
        $items = items::query()->where('section_id', $id)
            ->with(['variations', 'section'])->get();
        foreach ($items as $value) {
            $data[] = [
                'id' => $value->id,
                'vendor_id' => $value->vendor_id,
                'section_id' => $value->section_id,
                'nameAr' => $value->getTranslation('name', 'ar'),
                // 'nameEn' => $value->getTranslation('name', 'en'),
                'image' =>  getAppSetting('app_mobile_link') . Storage::url($value->image),
                'variations' => $value->variations,
            ];
        }
        if ($items) {
            return $this->apiRsponse($data, "Items Geted", 200);
        }
    }

    public function showAll($id)
    {
        $data = [];

        $items = items::query()->where('vendor_id', $id)
            ->with(['variations', 'section'])->get();

        foreach ($items as $value) {
            $data[] = [
                'id' => $value->id,
                'vendor_id' => $value->vendor_id,
                'section_id' => $value->section_id,
                'nameAr' => $value->getTranslation('name', 'ar'),
                // 'nameEn' => $value->getTranslation('name', 'en'),
                'image' =>  getAppSetting('app_mobile_link') . Storage::url($value->image),
                'variations' => $value->variations,
            ];
        }


        // $data = $items;
        if ($items) {
            return $this->apiRsponse($data, "Done Show All Items", 200);
        }
    }
}
