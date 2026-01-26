<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Api\ApiResponseTrait;
use App\Http\Controllers\Controller;
use App\Models\cheefCart;
use App\Models\cheef_order_head;
use App\Models\items;
use Google\Auth\Cache\Item;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class cheefCartController extends Controller
{
    use ApiResponseTrait;
    public function index(int $id)
    {
        $cheefCarts = cheefCart::query()->where('customer_id', $id)->with('itemVariation', 'items')->get();
        $data       = [];
        foreach ($cheefCarts as $cart) {
            $data[] = [
                'id'                => $cart->id,
                'item_id'           => $cart->item_id,
                'customer_id'       => $cart->customer_id,
                'item_variation_id' => $cart->item_variation_id,
                'quantity'          => $cart->quantity,
                'price'             => $cart->price,
                'total'             => $cart->total,
                'v_name'            => $cart->itemVariation->name,
                'name'              => $cart->items->name,
                'vendor_id'         => $cart->items->vendor_id,
                'image'             => $cart->items->image ? asset('storage/' . $cart->items->image) : null,
            ];
        }
        return $this->apiRsponse($data, __('Data received'), 200);
    }

    public function checkIfExist($customer_id, $item_variation_id)
    {
        return cheefCart::where(['customer_id' => $customer_id, 'item_variation_id' => $item_variation_id])->first();
    } //checkIfExist

    public function checkIfNotSameCheef($customer_id, $itemId)
    {
        $cheefCart = cheefCart::query()->where(['customer_id' => $customer_id])->with('items')->get();
        $item = items::query()->find($itemId);
        if ($cheefCart->count() == 0) {
            return false;
        } else {
            foreach ($cheefCart as $val) {
                if ($val->items->vendor_id == $item->vendor_id) {
                    return $cheefCart;
                } else {
                    return "notsame";
                }
            }
        }
    }



    public function ClrearCart($customer_id)
    {
        return cheefCart::where('customer_id', $customer_id)->delete();
    }

    public function store(Request $request)
    {
        $checkIfcheef = $this->checkIfNotSameCheef($request->customer_id, $request->item_id);
        // dd($checkIfcheef);
        if ($checkIfcheef == "notsame") {
            return $this->errorResponse(__('لا يمكن التعامل مع اكثر من شيف'), 400);
        } else {
            $exist = $this->checkIfExist($request->customer_id, $request->item_variation_id);
            if ($exist) {
                $exist->quantity += $request->quantity;
                $exist->total = $exist->price * $exist->quantity;
                $exist->save();
                Log::info($exist);
                return $this->apiRsponse($exist, __('Done Update'), 200);
            } else {
                $cart                    = new CheefCart();
                $cart->customer_id       = $request->customer_id;
                $cart->item_id           = $request->item_id;
                $cart->item_variation_id = $request->item_variation_id;
                $cart->quantity          = $request->quantity;
                $cart->price             = $request->price;
                $cart->total             = $request->price * $request->quantity;
                $cart->save();
                Log::info($cart);

                return $this->apiRsponse($cart, __('Done Save'), 200);
            }
        }
    }


    public function update(Request $request, int $id)
    {
        $cart           = CheefCart::findOrFail($id);
        $cart->quantity = $request->quantity;
        $cart->total    = $cart->price * $request->quantity;
        $cart->save();
        $data = $this->index($cart->customer_id)->original['data'];
        return response()->json(['message' => 'updated', 'data' => $data], 200);
    }

    public function destroy($id)
    {
        $cart = CheefCart::findOrFail($id);
        $cart->delete();
        return response()->json(['message' => 'deleted'], 200);
    }

    public function CreateOrder(Request $request)
    {
        $order = cheef_order_head::create([
            'customer_id'       => $request['customer_id'],
            'vendor_id'         => $request['vendor_id'],
            'total'             => $request['total'],
            'status'            => $request['status'] ?? 'Unpaid',
            'type'              => $request['type'] ?? '',
            'date_at'           => $request['date_at'],
            'time_at'           => $request['time_at'],
            'notes'             => $request['notes'],
            'payment_method_id' => $request['payment_method_id'] ?? 1,
            'address'           => $request['address'],
            'transaction_id'    => $request['transaction_id'],
        ]);

        foreach ($request['items'] as $item) {
            $order->items()->create([
                'item_id'           => $item['item_id'],
                'item_variation_id' => $item['item_variation_id'],
                'quantity'          => $item['quantity'],
                'price'             => $item['price'],
                'total'             => $item['total'],
            ]);
        }

        if ($order) {
            $this->ClrearCart($request['customer_id']);
        }

        return $this->apiRsponse($order, __('Order created successfully'), 201);
    }
}
