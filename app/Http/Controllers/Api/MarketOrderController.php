<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Models\MarketOrderHeader;
use App\Models\MarketOrderDetails;

class MarketOrderController extends Controller
{
    public function store(Request $request)
    {
        // 1. التحقق من البيانات المرسلة (إضافة variation_name)
        $validator = Validator::make($request->all(), [
            'customer_id'      => 'required|exists:users,id',
            'delivery_address' => 'required|string',
            'payment_method'   => 'required|string',
            'items'            => 'required|array|min:1',
            'items.*.product_id'   => 'required',
            'items.*.product_name' => 'required|string',
            'items.*.quantity'     => 'required|integer|min:1',
            'items.*.unit_price'   => 'required|numeric',
            'items.*.variation_name' => 'nullable|string', // الحقل الجديد
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        try {
            $order = DB::transaction(function () use ($request) {

                $totalPrice = 0;
                foreach ($request->items as $item) {
                    $totalPrice += $item['quantity'] * $item['unit_price'];
                }

                // 3. تخزين الهيدر
                $header = MarketOrderHeader::create([
                    'customer_id'      => $request->customer_id,
                    'total_price'      => $totalPrice,
                    'delivery_fees'    => $request->delivery_fees ?? 0,
                    'net_total'        => $totalPrice + ($request->delivery_fees ?? 0),
                    'payment_method'   => $request->payment_method,
                    'delivery_address' => $request->delivery_address,
                    'order_status'     => 'pending',
                    'payment_status'   => 'pending',
                ]);

                // 4. تخزين التفاصيل (إضافة الـ variation_name)
                foreach ($request->items as $item) {
                    MarketOrderDetails::create([
                        'order_header_id'  => $header->id,
                        'product_id'       => $item['product_id'],
                        'product_name_ar'  => $item['product_name'],
                        'variation_name'   => $item['variation_name'] ?? null, // تخزين الحجم هنا
                        'quantity'         => $item['quantity'],
                        'unit_price'       => $item['unit_price'],
                        'sub_total'        => $item['quantity'] * $item['unit_price'],
                    ]);
                }

                return $header;
            });

            return response()->json([
                'status'  => true,
                'message' => 'تم تسجيل الطلب بنجاح',
                'order_id' => $order->id
            ], 201);
        } catch (\Exception $e) {
            return response()->json([
                'status'  => false,
                'message' => 'حدث خطأ أثناء حفظ الطلب',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    // ميثود لجلب طلبات عميل معين
    public function getCustomerOrders($customerId)
    {
        $orders = MarketOrderHeader::with('details')
            ->where('customer_id', $customerId)
            ->orderBy('created_at', 'desc')
            ->get();

        return response()->json(['status' => true, 'data' => $orders]);
    }
}
