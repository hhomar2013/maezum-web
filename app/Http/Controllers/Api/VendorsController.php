<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Vendors;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VendorsController extends Controller
{
    use ApiResponseTrait;
    public $data = [];
    public function index()
    {
        $vendors = Vendors::query()
            ->where('status', 1)
            ->with('outOrders')
            // ->where('IsOnline',1)
            ->get();
        $data = [];
        foreach ($vendors as $vendor) {
            $data[] = [
                'id' => $vendor->id,
                'nameAr' => $vendor->getTranslation('name', 'ar'),
                'nameEn' => $vendor->getTranslation('name', 'en'),
                'phone' => $vendor->phone,
                'descriptionAr' => $vendor->getTranslation('description', 'ar'),
                'descriptionEn' => $vendor->getTranslation('description', 'en'),
                'IsOnline' => $vendor->IsOnline,
                'type' => $vendor->type,
                'logo' => getAppSetting('app_mobile_link') . Storage::url($vendor->logo),
                'is_online' => $vendor->IsOnline,
                'price' => $vendor->out_order_price
            ];
        }
        // foreach ($vendors->outOrders->where('status', 'paid') as $outOrder) {
        //     $data['outOrders'] = $outOrder ? [
        //         'vendor_id' => $outOrder->vendor_id,
        //         'customer_id' => $outOrder->cutomer_id,
        //     ] : [];
        // }

        return $this->apiRsponse($data, 'vendors', 200);
    }
}
