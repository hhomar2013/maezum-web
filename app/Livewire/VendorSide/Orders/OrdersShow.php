<?php

namespace App\Livewire\VendorSide\Orders;

use App\Models\cheef_order_items;
use Livewire\Component;

class OrdersShow extends Component
{

    public $orderId;
    public $order;
    public $orderHead;
    public $status_id;
    public $status = [
        'pending' => 'قيد المراجعة',
        'confirmed' => 'تم التأكيد',
        'preparing' => 'قيد التحضير',
        'out_for_delivery' => 'خرج للتوصيل',
        'delivered' => 'تم التسليم',
        'cancelled' => 'ملغي',
    ];

    public function back()
    {
        return redirect()->route('vendors.orders');
    }

    public function changeStatus()
    {
        $this->orderHead->update(['status' => $this->status_id]);
        $this->dispatch('message', message: __('Done Update'));
    }

    public function mount($orderId)
    {
        $this->orderId = $orderId;
        $this->order = cheef_order_items::query()->where('order_head_id', $orderId)->get();
        $this->orderHead = $this->order->first()->orderHead->load('customer');
        $this->status_id = $this->orderHead->status;
    }

    public function render()
    {

        return view('livewire.vendor-side.orders.orders-show')->extends('layouts.app');
    }
}
