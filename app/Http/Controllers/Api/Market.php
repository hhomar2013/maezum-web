<?php
namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\market_items;
use App\Models\Stores;

class Market extends Controller
{
    use ApiResponseTrait;
    public $items;
    public function index()
    {
        $market = Stores::all();
        return response()->json([
            'status'  => 'success',
            'message' => __('Data received'),
            'data'    => $market,
        ], 200);
    }

    public function items()
    {
        $items       = market_items::query()->get();
        $this->items = $items ? $items->map(function ($q) {
            return [
                'id'          => $q->id,
                'arName'      => $q->getTranslation('name', 'ar'),
                'enName'      => $q->getTranslation('name', 'en'),
                'category_id' => $q->category_id,
                'category_ar' => $q->category->getTranslation('name', 'ar'),
                'category_en' => $q->category->getTranslation('name', 'en'),
                'description' => $q->description,
                'price'       => $q->variations->first()->price,
                'image'       => $q->image ? asset('storage/' . $q->image) : null,
                'variations'  => $q->variations->map(function ($v) {
                    return [
                        'name'  => $v->name,
                        'price' => $v->price,
                    ];
                }),
            ];
        }) : [];
        return response()->json([
            'status'  => 'success',
            'message' => __('Data received'),
            'data'    => $this->items,
        ], 200);
    }
}
