<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\cheef_out_order;
use Illuminate\Http\Request;

class cheefOutOrderController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth:sanctum');
    }

    public function index(Request $request)
    {
        $userId = $request->user('api')->id;
        $vendorId = $request->vendorId;
        $cheef_out_order = cheef_out_order::query()
            ->where('customer_id', $userId)
            ->where('vendor_id', $vendorId)
            ->where('status', 'paid')
            ->with('vendor', 'paymentMethod')->get();
        $data = [];
        foreach ($cheef_out_order as $val) {
            $data[] =  [
                'id' => $val->vendor->id,
                'name_ar' => $val->vendor->getTranslation('name', 'ar'),
                'name_en' => $val->vendor->getTranslation('name', 'en'),
                'phone' => $val->vendor->phone,
            ];
        }
        return response()->json([
            'status' => 'success',
            'message' => 'Cheef Out Order',
            'data' => $data
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'vendor_id' => 'required',
            'customer_id' => 'required',
            'payment_method_id' => 'required',
            'total_price' => 'required',
            'status' => 'required',
        ]);

        $cheef_out_order = cheef_out_order::create($request->all());
        if ($cheef_out_order) {
            return response()->json([
                'status' => 'success',
                'message' => 'Cheef Out Order Created',
                'data' => $cheef_out_order
            ]);
        }
        return response()->json([
            'status' => 'error',
            'message' => 'Cheef Out Order Not Created',
            'data' => $cheef_out_order
        ], 500);
    }
}
