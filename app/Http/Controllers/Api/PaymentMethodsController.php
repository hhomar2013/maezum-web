<?php
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Support\Facades\Storage;

class PaymentMethodsController extends Controller
{
    use ApiResponseTrait;
    public function index()
    {
        $paymentMethods = PaymentMethod::query()->where('is_active',true)->latest('id')->take(4)->get();
        $data           = [];
        foreach ($paymentMethods as $method) {
            $data[] = [
                'id'        => $method->id,
                'name'      => $method->getTranslation('name', 'ar'),
                'code'      => $method->code,
                'provider'  => $method->provider,
                'image'     => $method->image ? getAppSetting('app_mobile_link') . Storage::url($method->image) : null,
                'config'    => json_encode($method->config),
            ];
        }
        return $this->apiRsponse($data, __('Data received'), 200);
    }
 
    public function show(){
           $paymentMethods = PaymentMethod::query()->where('is_active',true)->get();
        $data           = [];
        foreach ($paymentMethods as $method) {
            $data[] = [
                'id'        => $method->id,
                'name'      => $method->getTranslation('name', 'ar'),
                'code'      => $method->code,
                'provider'  => $method->provider,
                'image'     => $method->image ? getAppSetting('app_mobile_link') . Storage::url($method->image) : null,
                'config'    => json_encode($method->config),
            ];
        }
        return $this->apiRsponse($data, __('Data received'), 200);
    }

}
