<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\VendorStatusResource;
use App\Models\Faq;
use App\Models\main_tips;
use App\Models\mysettings;
use App\Models\PaymentMethod;
use App\Models\sliders;
use App\Models\Stores;
use App\Models\Vendors;
use App\Models\VendorStatus;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HomePageSectionsController extends Controller
{
    use ApiResponseTrait;


    public  function __construct()
    {
        config('app.locale', 'ar');
    }

    public function vendorStatus()
    {
        $vendorsWithStatuses = Vendors::with(['statuses' => fn($q) => $q->active()])
            ->whereHas('statuses', fn($q) => $q->active())
            ->get();
        return VendorStatusResource::collection($vendorsWithStatuses);
    } //vendorStatus


    public function sliders()
    {
        $sliders  = sliders::query()->where('status', 1)->get();
        $data = [];
        foreach ($sliders as $slider) {
            $data[] = [
                'id' => $slider->id,
                'image' => getAppSetting('app_mobile_link') . Storage::url($slider->image),
                'url' => $slider->url,
                'status' => $slider->status,
            ];
        }
        return $data;
    } //sliders

    public function tips()
    {
        $tips = main_tips::query()->with(['subTips'])->get();
        $data = [];
        $data['tip_title'][] = [
            'name_ar' => "لمحه عن" . ' ' . getAppSetting('app_name'),
            'name_en' => "Tips of " . ' ' . getAppSetting('app_name'),
        ];
        foreach ($tips as $tip) {
            $data['tips'][] = [
                'id' => $tip->id,
                'title' => $tip->title,
                'image' => getAppSetting('app_mobile_link') . Storage::url($tip->image),
                'sub_tips' => $tip->subTips->map(function ($subTip) {
                    return [
                        'id' => $subTip->id,
                        'type' => $subTip->type,
                        'content' => $subTip->type === 'file' ? getAppSetting('app_mobile_link') . $subTip->content : $subTip->content,
                        'hex_color' => $subTip->hex_color,
                    ];
                }),
                'subTips_count' => $tip->subTips->count(),
            ];
        }
        return $data;
    } //tips


    public $mySettings;
    public function AppSettings()
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
                'logo' => $appSettings->app_mobile_link . 'storage/' . $appSettings->app_logo,
                'favicon' => $appSettings->app_mobile_link . 'storage/' .  $appSettings->app_favicon,
                'api_link' => $appSettings->app_mobile_link,
            ];
            return $this->mySettings;
        }
    } //AppSettings


    public function stores()
    {
        $stores = Stores::query()->where('status', 1)->limit(6)->get();
        $data = [];
        $data['store_title'][] = [
            'name_ar' => "المتاجر",
            'name_en' => "Stores",
        ];
        foreach ($stores as $store) {
            $data['stores'][] = [
                'id' => $store->id,
                'nameAr' => $store->getTranslation('name', 'ar'),
                'nameEn' => $store->getTranslation('name', 'en'),
                'phone' => $store->phone,
                'descriptionAr' => $store->getTranslation('description', 'ar'),
                'descriptionEn' => $store->getTranslation('description', 'en'),
                'logo' => getAppSetting('app_mobile_link') . Storage::url($store->logo),
                'status' => $store->status,
            ];
        }
        return $data;
    } //Stores

    public function vendors()
    {
        $vendors = Vendors::query()
            ->where('status', 1)
            ->with('outOrders')
            // ->where('IsOnline',1)
            ->get();
        $data = [];
        $data['vendors_title'][] = [
            'name_ar' => __('Vendors'),
            'name_en' => 'Chefs & Kitchens'
        ];
        foreach ($vendors as $vendor) {
            $data['vendors'][] = [
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
        return $data;
    } //Vendors


    public function faq()
    {
        $faqs = Faq::query()->limit(2)->get();
        $data = [];
        $data['faq_title'][] = [
            'name_ar' => __('FAQ'),
            'name_en' => 'FAQ',
        ];
        foreach ($faqs as $faq) {
            $data['faqs'][] = [
                'id' => $faq->id,
                'question' => $faq->question,
                'answer' => $faq->answer,
            ];
        }
        return $data;
    } //FAQ


    public function paymentMethods()
    {
        $paymentMethods = PaymentMethod::query()->where('is_active', true)->latest('id')->take(4)->get();
        $data           = [];
        $data['payment_methods_title'][] = [
            'name_ar' => __('Payment Methods'),
            'name_en' => 'Payment Methods',
        ];
        foreach ($paymentMethods as $method) {
            $data['paymentMethods'][] = [
                'id'        => $method->id,
                'name'      => $method->getTranslation('name', 'ar'),
                'code'      => $method->code,
                'provider'  => $method->provider,
                'image'     => $method->image ? getAppSetting('app_mobile_link') . Storage::url($method->image) : null,
                'config'    => json_encode($method->config),
            ];
        }
        return $data;
    }

    public function allFaq()
    {
        $faqs = Faq::query()->get();
        $data = [];
        $data['faq_title'][] = [
            'name_ar' => __('FAQ'),
            'name_en' => 'FAQ',
        ];
        foreach ($faqs as $faq) {
            $data['all_faqs'][] = [
                'id' => $faq->id,
                'question' => $faq->question,
                'answer' => $faq->answer,
            ];
        }
        return $data;
    }
    public function index()
    {
        $data = [];
        $data['sliders'] = $this->sliders();
        $data['tips'] = $this->tips();
        $data['stores'] = $this->stores();
        $data['vendors'] = $this->vendors();
        $data['faq'] = $this->faq();
        $data['all_faq'] = $this->allFaq();
        $data['paymentMethods'] = $this->paymentMethods();
        $data['vendorStatus'] = $this->vendorStatus();
        return $this->apiRsponse($data, __('Data received'), 200);
    }
}
