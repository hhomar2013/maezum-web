<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductsController extends Controller
{
    use ApiResponseTrait;
    public function index()
    {
        $products = Product::query()
            ->with(['variants', 'categories', 'addons'])
            ->OrderBy('category_id')
            ->where('status', 1)->get();
        $data = [];
        foreach ($products as $product) {
            $data[] = [
                'id' => $product->id,
                'nameAr' => $product->getTranslation('name', 'ar'),
                'image' => getAppSetting('app_mobile_link') . "storage/" . $product->image,
                'price' => $product->price,
                'currency' => getAppSetting('current_currency'),
                'categories' => $product->categories,
                'variants' => $product->variants,
                'addons' => $product->addons,
            ];
        }
        return $this->apiRsponse($data, __('Data received'), 200);
    }

    public function show($id)
    {

        $products = Product::query()
            ->with(['variants', 'categories', 'addons'])
            ->where('status', 1)->where('category_id', '=', $id)->get();
        if ($products) {
            $data = [];
            foreach ($products as $product) {
                $data[] = [
                    'id' => $product->id,
                    'nameAr' => $product->getTranslation('name', 'ar'),
                    'nameEn' => $product->getTranslation('name', 'en'),
                    'image' => $product->image != null ?
                     getAppSetting('app_mobile_link') . Storage::url($product->image)
                     : asset('images/logo-1.png'),
                    'price' => $product->price,
                    'categories' => $product->categories,
                    'variants' => $product->variants,
                    'addons' => $product->addons,
                ];
            }
            return $this->apiRsponse($data, __('Data received'), 200);
        } else {
            return $this->apiRsponse(null, __('Product not found'), 404);
        }
    }


}
