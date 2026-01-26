<?php

namespace App\Livewire\VendorSide\Orders;

use App\Models\cheef_order_head;
use Livewire\Component;

class OrdersComponent extends Component
{

    public $orders;
    public $currency;
    public $status = [
        'pending' => 'قيد المراجعة',
        'confirmed' => 'تم التأكيد',
        'preparing' => 'قيد التحضير',
        'out_for_delivery' => 'خرج للتوصيل',
        'delivered' => 'تم التسليم',
        'cancelled' => 'ملغي',
    ];
    public function mount()
    {
        $this->orders = cheef_order_head::query()
            ->with('customer', 'items')
            ->where('vendor_id', auth()->user()->id)->where('status', '!=', 'Unpaid')->get();
        $this->currency = getAppSetting('currency');
    }

    public function render()
    {

        return view('livewire.vendor-side.orders.orders-component')->extends('layouts.app');
    }
}
