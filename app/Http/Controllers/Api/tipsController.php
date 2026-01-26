<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\main_tips;
use Illuminate\Support\Facades\Storage;

class tipsController extends Controller
{

    use ApiResponseTrait;


    public function index()
    {

        $tips = main_tips::query()->with(['subTips'])->get();
        $data = [];
       
        foreach ($tips as $tip) {
            $data['tips'][] = [
                'id' => $tip->id,
                'title' => $tip->title,
                'image' => getAppSetting('app_mobile_link') . Storage::url($tip->image),
                'sub_tips' => $tip->subTips->map(function ($subTip) {
                    return [
                        'id' => $subTip->id,
                        'type' => $subTip->type,
                        'content' => $subTip->type === 'file' ? getAppSetting('app_mobile_link') . Storage::url($subTip->content) : $subTip->content,
                        'hex_color' => $subTip->hex_color,
                    ];
                }),
                'subTips_count' => $tip->subTips->count(),
            ];
        }
        return $this->apiRsponse($data, 'tips', 200);
    }
}
