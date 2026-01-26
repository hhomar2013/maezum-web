<?php
namespace App\Livewire\VendorSide;

use App\Models\cheef_order_head;
use App\Models\items;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class VendorsDashboardComponent extends Component
{
    public function render()
    {
        $totalItems  = items::where('vendor_id', Auth::user()->id)->count();
        $totalOrders = cheef_order_head::where('vendor_id', Auth::user()->id)
            ->where('status', '!=', 'Unpaid')
            ->count();
        return view('livewire.vendor-side.vendors-dashboard-component', ['totalItems' => $totalItems, 'totalOrders' => $totalOrders])->extends('layouts.app');
    }
}
