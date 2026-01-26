<?php

namespace App\Livewire\Setup\Orders;


use Livewire\Livewire;
use Livewire\Boradcast;
use Livewire\Component;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Broadcast;



class OrdersComponent extends Component
{

    public function sandOrder()
    {

        Broadcast::event('order.sent', ['orderId' => 15]);


        $this->dispatch('message',message: __('Done Save'));
    }

    public function render()
    {
        return view('livewire.setup.orders.orders-component')->extends('layouts.app');
    }
}
