<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Offers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class offersController extends Controller
{
        use ApiResponseTrait;

    public function index()
    {
        $offers = Offers::query()->where('status','=',1)->get();
        $data = [];
        foreach ($offers as $offer) {
            $data[] = [
                'id' => $offer->id,
                'nameAr' => $offer->getTranslation('name', 'ar'),
                'nameEn' => $offer->getTranslation('name', 'en'),
                'description' => $offer->getTranslation('description', 'ar'),
                'image' => getAppSetting('app_mobile_link') . Storage::url($offer->image),
                'start_date' => $offer->start_date,
                'end_date' => $offer->end_date,
            ];
        }

        return $this->apiRsponse($offers ? $data : [], __('Data received'), 200);

    }
}
