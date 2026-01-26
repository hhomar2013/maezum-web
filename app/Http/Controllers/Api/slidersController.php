<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\sliders;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class slidersController extends Controller
{

    use ApiResponseTrait;

    public function index()
    {
        $sliders  = sliders::query()->where('status', 1)->get();
        $data = [];
        foreach ($sliders as $slider) {
            $data[] = [
                'id' => $slider->id,
                'image' => $slider->image ? asset($slider->image) : null,
                'url' => $slider->url,
                'status' => $slider->status,
            ];
        }
        return $this->apiRsponse($data, __('Data Sliders received'), 200);
    }
}
